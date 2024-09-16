<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use Cashfree\Cashfree;
use Cashfree\Model\CreateOrderRequest;
use Cashfree\Model\CustomerDetails;
use Cashfree\Model\OrderMeta;
/**
 * 
 */
class PaymentGateWay extends Controller
{
	
  public function Index(){
  	return view('welcome');
  } 

  public function InitialPayment(Request $request){
  	$validate = $request->validate([
  		'name'=>'required|min:3',
  		'email'=>'required',
  		'phone'=>'required',
  		'amount'=>'required'
  	]);
    Cashfree::$XClientId = "13764729ed596674a0f96e06f3746731";
    Cashfree::$XClientSecret = "1f4ee1fd095fcd3cfa702f0c91389c8adca03b5a";
    Cashfree::$XEnvironment = Cashfree::$SANDBOX;
    // Cashfree::$XEnvironment = Cashfree::$PRODUCTION;
    $cashfree= new Cashfree();

    $x_api_version = "2023-08-01";
    $order_id= 'inv_'.date('YmdHis');
    $order_amount=$validate['amount'];
    $order_note="Learn Code Zone";
    $customerID="customer_".rand(11111,99999);
    $customer_phone=$validate['phone'];
    $customer_email=$validate['email'];
    $customer_name=$validate['name'];

    $return_url="http://127.0.0.1:8000/success/".$order_id;

    $create_orders_request= new CreateOrderRequest();
    $create_orders_request->setOrderId($order_id);
    $create_orders_request->setOrderAmount($order_amount);
    $create_orders_request->setOrderCurrency('INR');

     $customer_details= new CustomerDetails();
     $customer_details->setCustomerId($customerID);
     $customer_details->setCustomerPhone($customer_phone);
     $customer_details->setCustomerEmail($customer_email);
     $customer_details->setCustomerName($customer_name);

     $create_orders_request->setCustomerDetails($customer_details);

     $order_meta= new OrderMeta();
     $order_meta->setReturnUrl($return_url);
     $create_orders_request->setOrderMeta($order_meta);

     try{
     	$result = $cashfree->PGCreateOrder($x_api_version, $create_orders_request);
     	$payment_session_id= $result[0]['payment_session_id'];
     	return view('payment-page',compact('payment_session_id'));

     }catch(Exception $e){
     	echo "Exception: ".$e->getMessage();
     }

  }

  public function PaymentSuccess($orderId){
    $url= "https://sandbox.cashfree.com/pg/orders/$orderId";
    // $url= "https://api.cashfree.com/pg/orders/$orderId";
        $ch= curl_init();           
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 20); // Adjusted timeout value to 20 seconds
        curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "GET");
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        curl_setopt($ch, CURLOPT_HTTPHEADER, [
            'Accept: application/json',
            'x-api-version: 2023-08-01',
            'Content-Type: application/json',
            'x-client-id: 13764729ed596674a0f96e06f3746731',
            'x-client-secret: 1f4ee1fd095fcd3cfa702f0c91389c8adca03b5a'
        ]);
    
        // Execute cURL request
        $results = curl_exec($ch);
    
        // Check for errors
        if (curl_errno($ch)) {
            $error_msg = curl_error($ch);
            curl_close($ch);
            return back()->withErrors('cURL Error: ' . $error_msg);
        }
    
        // Get the HTTP response code
        $returnCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
    
        // Decode the JSON response
        $response = json_decode($results, true);

      return view('payment-success',compact('response'));
  }
}