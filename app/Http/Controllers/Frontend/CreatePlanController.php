<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Number;
use App\Repositories\Frontend\Auth\UserRepository;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Http\Request;
use PayPal\Api\Currency;
use PayPal\Api\MerchantPreferences;
use PayPal\Api\Patch;
use PayPal\Api\PatchRequest;
use PayPal\Api\PaymentDefinition;
use PayPal\Api\Plan;
use PayPal\Auth\OAuthTokenCredential;
use PayPal\Common\PayPalModel;
use PayPal\Rest\ApiContext;

/**
 * Class CreatePlanController.
 */
class CreatePlanController extends Controller
{
    private $_api_context;

    /**
     * CreatePlanController constructor.
     */
    public function __construct()
    {
        /** setup PayPal api context **/
        $paypal_conf = \Config::get('paypal');
        $this->_api_context = new ApiContext(new OAuthTokenCredential($paypal_conf['client_id'], $paypal_conf['secret']));
        $this->_api_context->setConfig($paypal_conf['settings']);
    }

    /**
     * @return string
     */
    public function index()
    {
        $plan = new Plan();

        $plan->setName('True Number Plan')
            ->setDescription('Regular Plan')
            ->setType('INFINITE');


        $trialPaymentDefinition = new PaymentDefinition();
        $trialPaymentDefinition->setName('3 days Trial')
            ->setType('TRIAL')
            ->setFrequency('DAY')
            ->setFrequencyInterval("3")
            ->setCycles("1")
            ->setAmount(new Currency(array('value' => 1, 'currency' => 'USD')));


        $paymentDefinition = new PaymentDefinition();
        $paymentDefinition->setName('Regular Payment')
            ->setType('REGULAR')
            ->setFrequency('MONTH')
            ->setFrequencyInterval(1)
            ->setCycles(0)
            ->setAmount(new Currency(array('value' => 19.22, 'currency' => 'USD')));

        $merchantPreferences = new MerchantPreferences();
        $baseUrl = url('/');
        $merchantPreferences->setReturnUrl("$baseUrl/billing-success")
            ->setCancelUrl("$baseUrl/billing-cancel")
            ->setAutoBillAmount("yes")
            ->setInitialFailAmountAction("CONTINUE")
            ->setMaxFailAttempts("0");

        $plan->setMerchantPreferences($merchantPreferences);

        $plan->setPaymentDefinitions(array($paymentDefinition, $trialPaymentDefinition));

        try {
            $output = $plan->create($this->_api_context);
        } catch (\Exception $ex) {
            return $ex->getMessage();
        }

        if (isset($output)) {
            try {
                $plan = Plan::get($output->id, $this->_api_context);
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }

            try {
                $patch = new Patch();
                $value = new PayPalModel('{
                       "state":"ACTIVE"
                     }');
                $patch->setOp('replace')
                    ->setPath('/')
                    ->setValue($value);
                $patchRequest = new PatchRequest();
                $patchRequest->addPatch($patch);
                $plan->update($patchRequest, $this->_api_context);
                $planUpdated = Plan::get($plan->getId(), $this->_api_context);
            } catch (\Exception $ex) {
                return $ex->getMessage();
            }

            dd($planUpdated);
        }
    }
}
