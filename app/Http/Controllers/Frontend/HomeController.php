<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Auth\Plan;
use App\Models\Auth\Package;
use App\Models\Auth\User;
/**
 * Class HomeController.
 */
class HomeController extends Controller
{
    /**
     * @return \Illuminate\View\View
     */
    public function index()
    {
        return view('frontend.index');
    }

    public function privacyAr()
    {
        return view('frontend.ar-privace-policy');
    }

    public function privacyEn()
    {
        return view('frontend.en-privace-policy');
    }

    function applePayment($price)
    {
        // $marchant_id = 800000001155;
        $marchant_id = 79436896546;
        // live mode: "entityId=8acda4ca83ceb2a10183ef0f0fbd566f"
        // test mode: "entityId=8ac7a4c980447ded01804683885c0897"
        $user = auth()->user();
        // $url = "https://eu-test.oppwa.com/v1/checkouts";
        $url = "https://eu-prod.oppwa.com/v1/checkouts";
        $data = "entityId=8acda4ca83ceb2a10183ef0f0fbd566f" .
            "&amount=$price" .
            "&currency=SAR" .
            "&paymentType=DB" .
            // "&testMode=EXTERNAL" .
            "&merchantTransactionId=" . $marchant_id .time() . "" .
            "&billing.street1= Althwora ST" .
            "&billing.city=jaddah" .
            "&billing.state= city" .
            "&billing.country=SA" .
            "&billing.postcode=123456" ;


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjZGE0Y2E4M2NlYjJhMTAxODNlZjBlNTdkMTU2NjV8UHh6Y2JYNkJuYQ=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        return view('frontend.apple-payment', ["response" => $responseData, "price" => $price]);
    }

    function madaPayment($price,$plan_id,$plan_type,$user_id)
    {
        // $marchant_id = 800000001155;
        $marchant_id = 79436896546;
        // live mode: "entityId=8acda4ca83ceb2a10183ef0fb9325679"
        // test mode: "entityId=8ac7a4c980447ded01804683f748089b"

        $user = auth()->user();
        // $url = "https://eu-test.oppwa.com/v1/checkouts";
        $url = "https://eu-prod.oppwa.com/v1/checkouts";
        $data = "entityId=8acda4ca83ceb2a10183ef0fb9325679" .
            "&amount=$price" .
            "&currency=SAR" .
            "&paymentType=DB" .
            // "&testMode=EXTERNAL" .
            "&merchantTransactionId=" . $marchant_id.time() . "" .
            "&billing.street1= Althwora ST" .
            "&billing.city=jaddah" .
            "&billing.state= city" .
            "&billing.country=SA" .
            "&billing.postcode=123456" .
            "&customer.email=test@gmail.com".
            "&customer.givenName=test".
            
            "&customParameters[planId]=" . $plan_id . "" .
            "&customParameters[userId]=" . $user_id . "" .
            "&customParameters[planType]=" . $plan_type . "" .
            
            "&customer.surname=test" ;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjZGE0Y2E4M2NlYjJhMTAxODNlZjBlNTdkMTU2NjV8UHh6Y2JYNkJuYQ=='
        ));
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        // dd($responseData);
        return view('frontend.mada-payment', ["response" => $responseData, "price" => $price]);
    }


    function payment($price,$plan_id,$plan_type,$user_id)
    {

        return $this->request($price,$plan_id,$plan_type,$user_id);
    }

    // Payment Function:
    // url tutorial: https://wordpresshyperpay.docs.oppwa.com/tutorials/integration-guide
    // COPYandPAY
    function request($price,$plan_id,$plan_type,$user_id)
    {
       // $marchant_id = 800000001155;
       $marchant_id = 79436896546;
       // live mode: "entityId=8acda4ca83ceb2a10183ef0f0fbd566f"
       // test mode: "entityId=8ac7a4c980447ded01804683885c0897"
       //$url = "https://eu-test.oppwa.com/v1/checkouts";
       $url = "https://eu-prod.oppwa.com/v1/checkouts";
       $data = "entityId=8acda4ca83ceb2a10183ef0f0fbd566f" .
           "&amount=$price" .
           "&currency=SAR" .
           "&paymentType=DB" .
        //    "&testMode=EXTERNAL" .
           "&merchantTransactionId=" . $marchant_id.time() . "" .
           "&billing.street1= Althwora ST" .
           "&billing.city=jaddah" .
           "&billing.state= city" .
           "&billing.country=SA".
           "&billing.postcode=123456" .
           "&customer.email=test@gmail.com".
           "&customer.givenName=test".
           
           "&customParameters[planId]=" . $plan_id . "" .
           "&customParameters[userId]=" . $user_id . "" .
           "&customParameters[planType]=" . $plan_type . "" .
           
           "&customer.surname=test" ;

       $ch = curl_init();
       curl_setopt($ch, CURLOPT_URL, $url);
       curl_setopt($ch, CURLOPT_HTTPHEADER, array(
           'Authorization:Bearer OGFjZGE0Y2E4M2NlYjJhMTAxODNlZjBlNTdkMTU2NjV8UHh6Y2JYNkJuYQ=='
       ));
       curl_setopt($ch, CURLOPT_POST, 1);
       curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
       curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
       curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
       $responseData = curl_exec($ch);
       if (curl_errno($ch)) {
           return curl_error($ch);
       }
       curl_close($ch);



        return view('frontend.payment', [
            "response" => $responseData, "price" => $price ,"plan_id" => $plan_id,"plan_type" => $plan_type
        ]);
    }

    function checkMadaStatus(Request $request)
    {

        $url = "https://eu-prod.oppwa.com/v1/checkouts/$request->id/payment";
        // $url = "https://eu-test.oppwa.com/v1/checkouts/$request->id/payment";

        $url .= "?entityId=8acda4ca83ceb2a10183ef0fb9325679";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjZGE0Y2E4M2NlYjJhMTAxODNlZjBlNTdkMTU2NjV8UHh6Y2JYNkJuYQ=='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);
        $response_data = json_decode($responseData);

        if( $response_data->result->code == "000.000.000" ||
          $response_data->result->code == "000.000.100" ||
          $response_data->result->code == "000.100.112" ||
          $response_data->result->code == "000.100.110" 
           ){

            // if( $response_data->result->code == "000.100.112   000.100.110" ){

                $plan = Plan::find($response_data->customParameters->planId);
                $storage = ( (int)$plan->storage + (int)$plan->free_storage ) * 1073741824 ;//to cnvert form GB to bytes
                
                $data =[
                    'price' => $response_data->amount,
                    'size_bytes' => $storage
                ] ;
    
                $package = Package::updateOrCreate(["user_id" => $response_data->customParameters->userId], $data);
    
                if (isset($response_data->customParameters->planId)) {
                    $user = User::find($response_data->customParameters->userId);
                    $user->plan_id = $response_data->customParameters->planId;
                    $user->save();
                }
            }
        return view('frontend.after_payment', ["responseData" => $responseData]);
    }

    function checkStatus(Request $request)
    {
        $url = "https://eu-prod.oppwa.com/v1/checkouts/$request->id/payment";
        // $url = "https://eu-test.oppwa.com/v1/checkouts/$request->id/payment";

        $url .= "?entityId=8acda4ca83ceb2a10183ef0f0fbd566f";


        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization:Bearer OGFjZGE0Y2E4M2NlYjJhMTAxODNlZjBlNTdkMTU2NjV8UHh6Y2JYNkJuYQ=='
        ));
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'GET');
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true); // this should be set to true in production
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $responseData = curl_exec($ch);
        if (curl_errno($ch)) {
            return curl_error($ch);
        }
        curl_close($ch);

        $response_data = json_decode($responseData);
        if( $response_data->result->code == "000.000.000" || $response_data->result->code == "000.000.100" ){
        // if( $response_data->result->code == "000.100.112" ){

            $plan = Plan::find($response_data->customParameters->planId);
            $storage = ( (int)$plan->storage + (int)$plan->free_storage ) * 1073741824 ;//to cnvert form GB to bytes
            
            $data =[
                'price' => $response_data->amount,
                'size_bytes' => $storage
            ] ;

            $package = Package::updateOrCreate(["user_id" => $response_data->customParameters->userId], $data);
            if (isset($response_data->customParameters->planId)) {
                $user = User::find($response_data->customParameters->userId);
                $user->plan_id = $response_data->customParameters->planId;
                $user->save();
            }

        }
       
        return view('frontend.after_payment', ["responseData" => $responseData]);
    }
}
