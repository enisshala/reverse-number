<?php

namespace App\Http\Controllers\Frontend;

use App\CancellationRequest;
use App\Events\Frontend\Auth\UserRegistered;
use App\Http\Controllers\Controller;
use App\Mail\Backend\SendRequestApproved;
use App\Mail\Frontend\WelcomeUser;
use App\Models\Auth\User;
use App\Number;
use App\Repositories\Frontend\Auth\UserRepository;
use App\UserSearch;
use App\UserSubscription;
use Auth;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use PayPal\Api\Agreement;
use PayPal\Api\AgreementStateDescriptor;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\Payer;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;
use Twilio\Rest\Client;
use Illuminate\Support\Facades\Mail;

/**
 * Class CreateAccountController.
 */
class CreateAccountController extends Controller
{
    private $_api_context;
    use RegistersUsers;

    /**
     * @var UserRepository
     */
    protected $userRepository;

    /**
     * RegisterController constructor.
     *
     * @param UserRepository $userRepository
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.create-account');
    }


    /**
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Throwable
     */
    public function create(Request $request)
    {
        abort_unless(config('access.registration'), 404);
        $user = $this->userRepository->create($request->only('first_name', 'last_name', 'email', 'password'));

        auth()->login($user);

        event(new UserRegistered($user));

        // Create new agreement
        $agreement = new Agreement();
        $agreement->setName('True Number Regular Agreement')
            ->setDescription('Basic Agreement')
            ->setStartDate(date_format(date_timestamp_set(new \DateTime(), strtotime('+10 seconds')), 'c'));

        // Set plan id
        $plan = new Plan();
        $plan->setId($request->plan_id);
        $merchantPreferences = new MerchantPreferences();
        $baseUrl = url('/');
        $merchantPreferences->setReturnUrl("$baseUrl/billing-success?plan_id=" . $request->plan_id . "&user_id=" . $user->id . "&nr_search=" . $request->nr_search)
            ->setCancelUrl("$baseUrl/billing-cancel");
        $agreement->setOverrideMerchantPreferences($merchantPreferences);
        $agreement->setPlan($plan);

        // Add payer type
        $payer = new Payer();
        $payer->setPaymentMethod('paypal');

        $agreement->setPayer($payer);

        try {
            // Create agreement
            $agreement = $agreement->create($this->_api_context);
            // Extract approval URL to redirect user
            $approvalUrl = $agreement->getApprovalLink();

            return redirect()->away($approvalUrl);

        } catch (\Exception $ex) {
            echo $ex->getCode();
            $ex->getMessage();
            die($ex);
        }

    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function executeAgreement()
    {
        // ## Approval Status
        $token = $_GET['token'];
        $plan_id = $_GET['plan_id'];
        $user_id = $_GET['user_id'];

        $agreement = new Agreement();
        try {
            // ## Execute Agreement
            // Execute the agreement by passing in the token
            $agreement->execute($token, $this->_api_context);

            // Make a get call to retrieve the executed agreement details
            try {
                $agreement = Agreement::get($agreement->getId(), $this->_api_context);
                $user_subscription = new UserSubscription();
                $user_subscription->user_id = $user_id;
                $user_subscription->plan_id = $plan_id;
                $user_subscription->agreement_id = $agreement->getId();

                $user_subscription->save();

                $user = User::where('id', $user_id)->first();
                Mail::to($user->email)->send(new WelcomeUser($user));

            } catch (\Exception $ex) {
                $ex->getMessage();
            }

        } catch (\Exception $ex) {
            $ex->getMessage();
        }

        if (isset($_GET['nr_search'])) {
            $nr_search = Number::where('phone_no', $_GET['nr_search'])->first();
            if (!isset($nr_search)) {

                $sid = config('twilio.twilio_account_sid');
                $token = config('twilio.twilio_auth_token');

                $twilio = new Client($sid, $token);

                try {
                    $number_exists = $twilio->lookups->v1->phoneNumbers($_GET['nr_search'])
                        ->fetch();
                } catch (\Exception $e) {
                    $phone_data = null;
                }

                if (isset($number_exists)) {
                    if ($number_exists->countryCode == 'US' || $number_exists->countryCode == 'CA') {
                        $phone_number = $twilio->lookups->v1->phoneNumbers($_GET['nr_search'])
                            ->fetch(array(
                                    "addOns" => "whitepages_pro_caller_id_true_number",
                                )
                            );
                        $number_addon = $phone_number->addOns;

                        $the_number = new Number();
                        $the_number->phone_no = $_GET['nr_search'];
                        $the_number->phone_data = $number_addon['results']['whitepages_pro_caller_id_true_number']['result'];
                        $the_number->country = 1;
                        $the_number->save();

                        $usr_search = new UserSearch();
                        $usr_search->user_id = Auth::id();
                        $usr_search->number_id = $the_number->id;
                        $usr_search->phone_no = $_GET['nr_search'];
                        $usr_search->save();

                        $phone_data = $the_number->phone_data;
                    } else {
                        $handle = curl_init();
                        $url = "https://lookups.twilio.com/v1/PhoneNumbers/" . $_GET['nr_search'] . "?Type=caller-name&Type=carrier";

                        // Set the url
                        curl_setopt($handle, CURLOPT_URL, $url);
                        // Set the result output to be a string.
                        curl_setopt($handle, CURLOPT_RETURNTRANSFER, true);
                        curl_setopt($handle, CURLOPT_USERPWD, "$sid:$token");
                        $output = curl_exec($handle);
                        curl_close($handle);

                        $data = json_decode($output);
//                            dd($data);

                        $the_number = new Number();
                        $the_number->phone_no = $_GET['nr_search'];
                        $the_number->phone_data = array(
                            'phone_number' => $_GET['nr_search'],
                            'warnings' => [],
                            'historical_addresses' => [],
                            'alternate_phones' => [],
                            'error' => $data->carrier->error_code,
                            'is_commercial' => '',
                            'associated_people' => [],
                            'country_calling_code' => [],
                            'belongs_to' => [array(
                                'age_range' => null,
                                'name' => ($data->caller_name ? $data->caller_name : null),
                                'firstname' => null,
                                'middlename' => null,
                                'lastname' => null,
                                'industry' => null,
                                'alternate_names' => [],
                                'gender' => null,
                                'link_to_phone_start_date' => null,
                            )],
                            'is_valid' => true,
                            'line_type' => $data->carrier->type,
                            'carrier' => $data->carrier->name,
                            'current_addresses' => [array(
                                'city' => '',
                                'lat_long' => [array(
                                    'latitude' => null,
                                    'longitude' => null,
                                    'accuracy' => null,
                                )],
                                'is_active' => true,
                                'location_type' => '',
                                'street_line_2' => null,
                                'link_to_person_start_date' => null,
                                'street_line_1' => '',
                                'postal_code' => '',
                                'delivery_point' => '',
                                'country_code' => $data->country_code,
                                'state_code' => '',
                                'id' => '',
                                'zip4' => '',
                            )],
                            'id' => '',
                            'is_prepaid' => '',
                        );

                        $the_number->country = 0;
                        $the_number->save();

                        $usr_search = new UserSearch();
                        $usr_search->user_id = Auth::id();
                        $usr_search->number_id = $the_number->id;
                        $usr_search->phone_no = $_GET['nr_search'];
                        $usr_search->save();

                        $phone_data = $the_number->phone_data;
                    }
                } else {
                    $phone_data = null;
                }
            } else {
                $phone_data = $nr_search->phone_data;

                $usr_search = new UserSearch();
                $usr_search->user_id = Auth::id();
                $usr_search->number_id = $nr_search->id;
                $usr_search->phone_no = $_GET['nr_search'];
                $usr_search->save();
        }
    }

return view('frontend.user.billing-success', compact('agreement', 'phone_data'));
}


/**
 * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
 */
public
function executeCancel()
{
    $token = $_GET['token'];
    return view('frontend.user.billing-cancel', compact('token'));
}


/**
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 */
public
function subscriptionCancel(Request $request)
{
    try {
        $userAgreement = Agreement::get($request->agreement_id, $this->_api_context);
    } catch (\Exception $ex) {
        return response()->json([
            "success" => false,
            "status" => "Error",
        ], 200);
    }

    //Create an Agreement State Descriptor, explaining the reason to suspend.
    $agreementStateDescriptor = new AgreementStateDescriptor();
    $agreementStateDescriptor->setNote("User canceling the agreement");

    try {
        $userAgreement->cancel($agreementStateDescriptor, $this->_api_context);
        // Lets get the updated Agreement Object
        $agreement = Agreement::get($userAgreement->getId(), $this->_api_context);
        if ($agreement->state == "Cancelled") {
            $user_subscription = UserSubscription::where('user_id', $request->user_id)->first();
            $user_subscription->delete();
            $user_subscription = CancellationRequest::where('user_id', $request->user_id)->first();
            $user_subscription->delete();
            return response()->json([
                "success" => true,
                "status" => "Success",
            ], 200);
        }

    } catch (\Exception $ex) {
        return response()->json([
            "success" => false,
            "status" => "Error",
        ], 200);
    }
}


/**
 * @param Request $request
 * @return \Illuminate\Http\JsonResponse
 * @throws \Exception
 */
public
function createSubscription(Request $request)
{

    // Create new agreement
    $agreement = new Agreement();
    $agreement->setName('True Number Regular Agreement')
        ->setDescription('Basic Agreement')
        ->setStartDate(date_format(date_timestamp_set(new \DateTime(), strtotime('+20 seconds')), 'c'));

    // Set plan id
    $plan = new Plan();
    $plan->setId($request->plan_id);
    $merchantPreferences = new MerchantPreferences();
    $baseUrl = url('/');
    $merchantPreferences->setReturnUrl("$baseUrl/billing-success?plan_id=" . $request->plan_id . "&user_id=" . $request->user_id)
        ->setCancelUrl("$baseUrl/billing-cancel");
    $agreement->setOverrideMerchantPreferences($merchantPreferences);
    $agreement->setPlan($plan);

    // Add payer type
    $payer = new Payer();
    $payer->setPaymentMethod('paypal');

    $agreement->setPayer($payer);

    try {
        // Create agreement
        $agreement = $agreement->create($this->_api_context);
        // Extract approval URL to redirect user
        $approvalUrl = $agreement->getApprovalLink();

        return response()->json([
            "success" => true,
            "status" => "Success",
            "approvalUrl" => $approvalUrl,
        ], 200);

    } catch (\Exception $ex) {
        return response()->json([
            "success" => false,
            "status" => "Error",
        ], 200);
    }
}
}
