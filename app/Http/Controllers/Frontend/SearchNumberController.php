<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Number;
use App\UserSearch;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Twilio\Rest\Client;

/**
 * Class SearchNumberController.
 */
class SearchNumberController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Twilio\Exceptions\ConfigurationException
     */
    public function search(Request $request)
    {
        if (\Auth::check()) {
            $user = \Auth::user();
            if ($user->subscription !== null) {
//                determinate user location
//                if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
//                    $ip = $_SERVER['HTTP_CLIENT_IP'];
//                } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
//                    $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
//                } else {
//                    $ip = $_SERVER['REMOTE_ADDR'];
//                }
//                $access_key = \Config::get('ipstack.api_key');
//
//                $ch = curl_init('http://api.ipstack.com/' . $ip . '?access_key=' . $access_key . '');
//                curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
//
//                $json = curl_exec($ch);
//                curl_close($ch);
//
//                $api_result = json_decode($json, true);

                $number = Number::where('phone_no', $request->number)->first();
                if (!isset($number)) {

                    $sid = config('twilio.twilio_account_sid');
                    $token = config('twilio.twilio_auth_token');

                    $twilio = new Client($sid, $token);

                    try {
                        $number_exists = $twilio->lookups->v1->phoneNumbers($request->number)
                            ->fetch();
                    } catch (\Exception $e) {
                        return response()->json([
                            "success" => false,
                            "logged_in" => true,
                            "has_subscription" => true,
                            "phone_data" => '',
                            "status" => "Fail",
                        ], 200);
                    }

                    if (isset($number_exists)) {
                        if ($number_exists->countryCode == 'US' || $number_exists->countryCode == 'CA') {
                            $phone_number = $twilio->lookups->v1->phoneNumbers($request->number)
                                ->fetch(array(
                                        "addOns" => "whitepages_pro_caller_id_true_number",
                                    )
                                );
                            $number_addon = $phone_number->addOns;

                            $the_number = new Number();
                            $the_number->phone_no = $request->number;
                            $the_number->phone_data = $number_addon['results']['whitepages_pro_caller_id_true_number']['result'];
                            $the_number->country = 1;
                            $the_number->save();

                            $usr_search = new UserSearch();
                            $usr_search->user_id = Auth::id();
                            $usr_search->number_id = $the_number->id;
                            $usr_search->phone_no = $request->number;
                            $usr_search->save();

                            return response()->json([
                                "success" => true,
                                "logged_in" => true,
                                "has_subscription" => true,
                                "phone_data" => $the_number->phone_data,
                                "status" => "Success",
                            ], 200);
                        } else {
                            $handle = curl_init();
                            $url = "https://lookups.twilio.com/v1/PhoneNumbers/" . $request->number . "?Type=caller-name&Type=carrier";

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
                            $the_number->phone_no = $request->number;
                            $the_number->phone_data = array(
                                'phone_number' => $request->number,
                                'warnings' => [],
                                'historical_addresses' => [],
                                'alternate_phones' => [],
                                'error' => $data->carrier->error_code,
                                'is_commercial' => null,
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
                                'current_addresses' => [],
                                'id' => '',
                                'is_prepaid' => '',
                            );

                            $the_number->country = 1;
                            $the_number->save();

                            $usr_search = new UserSearch();
                            $usr_search->user_id = Auth::id();
                            $usr_search->number_id = $the_number->id;
                            $usr_search->phone_no = $request->number;
                            $usr_search->save();

                            return response()->json([
                                "success" => true,
                                "logged_in" => true,
                                "has_subscription" => true,
                                "phone_data" => $the_number->phone_data,
                                "status" => "Success",
                            ], 200);
                        }
                    }
                } else {

                    $usr_search = new UserSearch();
                    $usr_search->user_id = Auth::id();
                    $usr_search->number_id = $number->id;
                    $usr_search->phone_no = $request->number;
                    $usr_search->save();

                    return response()->json([
                        "success" => true,
                        "logged_in" => true,
                        "has_subscription" => true,
                        "phone_data" => $number->phone_data,
                        "status" => "Success",
                    ], 200);
                }

//            dump($number_carrier->carrier);
//            dump($number_caller->callerName);
//            dd($number_exists);

            } else {
                return response()->json([
                    "success" => true,
                    "logged_in" => true,
                    "has_subscription" => false,
                    "phone_data" => '',
                    "status" => "Success",
                ], 200);
            }
        } else {
            return response()->json([
                "success" => true,
                "logged_in" => false,
                "has_subscription" => false,
                "phone_data" => $request->number,
                "status" => "Success",
            ], 200);
        }
    }
}
