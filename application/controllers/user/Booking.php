<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Booking extends CI_Controller {

   public $data;
   public $app_id = "1459459be8b3a186d7149dd8f49541";
   public $secretKey = "65e2043ddc2a9274637cc9e9c8889ba067f4d8e0";
   public $endpoint = "https://test.cashfree.com";
   public function __construct() {

        parent::__construct();
                  if(empty($this->session->userdata('id'))){
          redirect(base_url());
          }
        $this->data['theme'] = 'user';
        $this->data['model'] = 'home';
        $this->data['base_url'] = base_url();

			  $this->load->helper('custom_language');
        $this->load->helper('push_notifications');

        $this->load->model('booking_model','booking');
        $this->load->model('api_model','api');

        $this->load->helper('user_timezone_helper');$user_id = $this->session->userdata('id');
        $this->data['user_id'] = $user_id;
				$this->load->helper('subscription_helper');
       


         $this->data['secret_key'] = '';

         $this->data['publishable_key'] = '';

         $this->data['website_logo_front'] ='assets/img/logo.png';

         $publishable_key='';
         $secret_key='';
         $live_publishable_key='';
         $live_secret_key='';
         $stripe_option='';


          $query = $this->db->query("select * from system_settings WHERE status = 1");
          $result = $query->result_array();
          if(!empty($result))
          {
              foreach($result as $data){

                  if($data['key'] == 'website_name'){
                  $this->website_name = $data['value'];
                  }


                  if($data['key'] == 'secret_key'){

                    $secret_key = $data['value'];

                  }

                  if($data['key'] == 'publishable_key'){

                    $publishable_key = $data['value'];

                  }

                  if($data['key'] == 'live_secret_key'){

                    $live_secret_key = $data['value'];

                  }

                  if($data['key'] == 'live_publishable_key'){

                    $live_publishable_key = $data['value'];

                  }

                  if($data['key'] == 'stripe_option'){

                    $stripe_option = $data['value'];

                   } 
                  
                  if($data['key'] == 'logo_front'){
                      $this->data['website_logo_front'] =  $data['value'];
                  }

              }
          }


          if(@$stripe_option == 1){

          $this->data['publishable_key'] = $publishable_key;

          $this->data['secret_key']      = $secret_key;

        }

        if(@$stripe_option == 2){

          $this->data['publishable_key'] = $live_publishable_key;

          $this->data['secret_key']      = $live_secret_key;

        }


          $config['publishable_key'] =  $this->data['publishable_key'];

          $config['secret_key'] = $this->data['secret_key'];

          $this->load->library('stripe',$config);
          

           if(!$this->session->userdata('id'))
          {
            redirect(base_url());
          }




    }

	public function index()
	{

		redirect(base_url('book-service'));
	}

    public function book_service(){
      removeTag($this->input->post());
      $time = $this->input->post('booking_time');
      $booking_time = explode('-',$time);
      $start_time = strtotime($booking_time[0]);
      $end_time = strtotime($booking_time[1]);
      $from_time = date('G:i:s',($start_time));
      $to_time = date('G:i:s',($end_time));

      $inputs = array();
      $service_id = $this->input->post('service_id'); // Package ID
      $records = $this->booking->get_service($service_id);
      $inputs['service_id'] = $service_id;
      $inputs['provider_id'] = $this->input->post('provider_id');
      $inputs['user_id'] = $this->session->userdata('id');
      $inputs['provider_id'] = $this->input->post('provider_id');

   
      $inputs['token'] = 'old type';
      $inputs['service_id'] = $service_id;
      $inputs['provider_id'] = $this->input->post('provider_id');
      $inputs['user_id'] = $this->session->userdata('id');
      $inputs['amount'] = $records['service_amount'];
      $inputs['service_date'] = date('Y-m-d',strtotime($this->input->post('booking_date')));
      $inputs['location'] = $this->input->post('service_location');
      $inputs['latitude'] = $this->input->post('service_latitude');
      $inputs['longitude'] = $this->input->post('service_longitude');
      $inputs['from_time'] = $from_time;
      $inputs['to_time'] = $to_time;
      $inputs['notes'] = $this->input->post('notes');
      $inputs['args'] = 'no response that field ld flow';
      $inputs['payment_status'] = 1;
      $result = $this->booking->booking_success($inputs);

      if($result !=''){
          $userData=$this->session->userdata();
          $serviceData['service']=$this->db->where('id',$service_id)->from('services')->get()->row_array();
          //print_r($result);
          //print_r($userData);
          //echo base_url();
          //print_r($serviceData['service']['service_amount']); 
          $api_url = $this->endpoint."/api/v1/order/create";
          $cf_request = array();
          $cf_request["appId"] = $this->app_id;
          $cf_request["secretKey"] = $this->secretKey;
          $cf_request["orderId"] = $result; 
          $cf_request["orderAmount"] = $serviceData['service']['service_amount'];
          $cf_request["orderNote"] = "Subscription";
          $cf_request["customerPhone"] = $userData['mobileno'];
          $cf_request["customerName"] = $userData['name'];
          $cf_request["customerEmail"] = $userData['email'];
          $cf_request["returnUrl"] = base_url()."user/booking/order_status/?order_id=".$result;
          $cf_request["notifyUrl"] = base_url()."service/booking_notify";

          $timeout = 10;
          
          $request_string = "";
          foreach($cf_request as $key=>$value) {
            $request_string .= $key.'='.rawurlencode($value).'&';
          }
          $ch = curl_init();
          curl_setopt($ch, CURLOPT_URL,"$api_url?");
          curl_setopt($ch,CURLOPT_POST, count($cf_request));
          curl_setopt($ch,CURLOPT_POSTFIELDS, $request_string);
          curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
          curl_setopt($ch, CURLOPT_TIMEOUT, $timeout);
          $curl_result=curl_exec ($ch);
          curl_close ($ch);

          $jsonResponse = json_decode($curl_result);
          //print_r($jsonResponse);
          if ($jsonResponse->{'status'} == "OK") {
            $paymentLink = $jsonResponse->{"paymentLink"};
            //print_r($paymentLink);
            //Send this payment link to customer over email/SMS OR redirect to this link on browser
          } else {
            $message = 'Payment Method Not Working';
          } 
          

          }else{
        $message= 'Sorry, something went wrong';
        $this->session->set_flashdata('error_message',$message);
      }
      echo json_encode(['success'=>true,'msg'=>$result,'paymentUrl'=>$paymentLink]);exit;
   
  }


  public function booking_service_submit(){
if($this->input->post()){
if($this->input->post('txStatus')=='SUCCESS'){
$this->load->model('Wallet_model');
$type = $this->session->userdata('usertype');
if($type=='provider'){
$typeVal = 1;
}else{
$typeVal = 2;
}

// echo "<pre>"; print_r($this->session->userdata()); exit;
// $inputs = array();
// $service_id = $this->input->get('service_id'); // Package ID
// $records = $this->booking->get_service($service_id);
// $inputs['service_id'] = $service_id;
// $inputs['provider_id'] = $this->input->get('provider_id');
// $inputs['user_id'] = $this->session->userdata('id');
// $inputs['token'] = 'old type';
// $inputs['service_id'] = $service_id;
// $inputs['amount'] = $records['service_amount'];
// $inputs['service_date'] = date('Y-m-d',strtotime($this->input->get('booking_date')));
// $inputs['location'] = $this->input->get('service_location');
// $inputs['latitude'] = $this->input->get('service_latitude');
// $inputs['longitude'] = $this->input->get('service_longitude');
// $inputs['from_time'] = $from_time;
// $inputs['to_time'] = $to_time;
// $inputs['notes'] = $this->input->get('notes');
// $inputs['args'] = 'no response that field ld flow';
// $inputs['payment_status'] = 1;
// $result = $this->booking->booking_success($inputs);

// if($result !=''){
//   $userData=$this->session->userdata();
//   $serviceData['service']=$this->db->where('id',$service_id)->from('services')->get()->row_array();
// }
$this->session->set_flashdata('success_message','Payment has been successfully done');
redirect(base_url().'user-bookings');
}
else{
$this->session->set_flashdata('error_message','Payment not done');
echo "<pre>"; print_r($this->input->post());
redirect(base_url().'user-bookings');
}
}else{
  $secretKey = "48a401703d4f6f03fd4ff5da44689d582776e650";
$data = [
//"token" => $this->input->post('tokenId'),
"appId" => $this->input->get('appId'),
"orderId" => $this->input->get('orderid'),
"orderAmount" => $this->input->get('final_gig_amount'),
"returnUrl" => $this->input->get('returnUrl'),
"orderCurrency" => $this->input->get('currency'),
"orderNote" => $this->input->get('notes'),
"customerName" => $this->input->get('customerName'),
"customerPhone" => $this->input->get('customerPhone'),
"customerEmail" => $this->input->get('customerEmail'),
"notifyUrl" => $this->input->get('notifyUrl'),
];
//echo json_encode($data); exit;
// get secret key from your config
ksort($data);
$signatureData = "";
foreach ($data as $key => $value){
$signatureData .= $key.$value;
}
$signature = hash_hmac('sha256', $signatureData, $secretKey,true);
$signature = base64_encode($signature);
$data['signature'] = $signature;
echo json_encode($signature);

}
  }




  public function order_status(){
    $data = $this->input->get();
    $order_id = $data['order_id'];
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://test.cashfree.com/api/v1/order/info/status",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS => "appId=$this->app_id&secretKey=$this->secretKey&orderId=$order_id",
    CURLOPT_HTTPHEADER => array(
        "cache-control: no-cache",
        "content-type: application/x-www-form-urlencoded"
    ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
    echo "cURL Error #:" . $err;
    } else {
      
      $response = json_decode($response);
      //print_r($response);
      if($response->status=="OK"){
        $booking_data = $this->db->where('id',$order_id)->from('book_service')->get()->row_array();
        if($response->orderStatus="PAID"){
          $booking_data['payment_status'] = 4;
          $booking_data['pay_mode'] = $response->paymentMode;
        }else{
          $booking_data['payment_status'] =3;
          $booking_data['pay_mode'] = $response->paymentMode;
        }
        $result = $this->booking->booking_update($booking_data);
        //print_r($result);
          $this->data['user']=$this->session->userdata();
          $this->data['service']=$this->db->where('id',$result['service_id'])->from('services')->get()->row_array();
          $body=$this->load->view('user/email/service_email',$this->data,true);
          $phpmail_config=settingValue('mail_config');
          if(isset($phpmail_config)&&!empty($phpmail_config)){
            if($phpmail_config=="phpmail"){
              $from_email=settingValue('email_address');
            }else{
              $from_email=settingValue('smtp_email_address');
            }
          }
        $this->load->library('email');
        if(!empty($from_email)&&isset($from_email)){
          $mail = $this->email
          ->from($from_email)
          ->to($this->session->userdata('email'))
          ->subject('Service Booking')
          ->message($body)
          ->send();
         }
        $message= 'You have booked successfully';

        $token=$this->session->userdata('chat_token');
        /*history entry*/
        $this->api->history_update_new_payment($order_id,$token);
  
        /*history entry*/
        $data=$this->api->get_book_info_b($result);
        $device_token=$this->api->get_device_info_multiple($data['provider_id'],1);
                
        $user_name=$this->api->get_user_info($data['user_id'],2);
    
        $provider_token=$this->api->get_user_info($data['provider_id'],1);
        $text=$user_name['name']." has booked your Service";
        $this->send_push_notification($token,$result,1,$msg=$text);
        $this->session->set_flashdata('success_message',$message);

      }
    } 
    redirect('/user-bookings', 'refresh'); 
  }

  /*stripe booking method OLD METHOD*/
	

  public function stripe_payment(){

  	$time = $this->input->post('booking_time');
  	$booking_time = explode('-',$time);
  	$start_time = strtotime($booking_time[0]);
  	$end_time = strtotime($booking_time[1]);
  	$from_time = date('G:i:s',($start_time));
  	$to_time = date('G:i:s',($end_time));

    $inputs = array();
    $service_id = $this->input->post('service_id'); // Package ID
    $records = $this->booking->get_service($service_id);
    $inputs['service_id'] = $service_id;
    $inputs['provider_id'] = $this->input->post('provider_id');
    $inputs['user_id'] = $this->session->userdata('id');
    $inputs['provider_id'] = $this->input->post('provider_id');


    $inputs['token'] = $this->input->post('tokenid');
     $charges_array = array();
     $amount = (!empty($records['service_amount']))?$records['service_amount']:2;
     $amount = ($amount *100);
     $charges_array['amount']       = $amount;
     $charges_array['currency']     = 'USD';
     $charges_array['description']  = (!empty($records['service_amount']))?$records['service_amount']:'Booking';
     $charges_array['source']       = 'tok_visa';


     $result = $this->stripe->stripe_charges($charges_array);

     
     $result = json_decode($result,true);
      if(empty($result['error'])){
        $inputs['token'] = $result['id'];
        $inputs['service_id'] = $service_id;
        $inputs['provider_id'] = $this->input->post('provider_id');
        $inputs['user_id'] = $this->session->userdata('id');
        $inputs['amount'] = $records['service_amount'];
        $inputs['service_date'] = date('Y-m-d',strtotime($this->input->post('booking_date')));
        $inputs['location'] = $this->input->post('service_location');
        $inputs['latitude'] = $this->input->post('service_latitude');
        $inputs['longitude'] = $this->input->post('service_longitude');
        $inputs['from_time'] = $from_time;
        $inputs['to_time'] = $to_time;
        $inputs['notes'] = $this->input->post('notes');
        $inputs['args'] = json_encode($result);
        $result = $this->booking->booking_success($inputs);
    if($result !=''){


			$message= 'You have booked successfully';

             $token=$this->session->userdata('chat_token');
             
             $data=$this->api->get_book_info_b($result);
             $device_token=$this->api->get_device_info_multiple($data['provider_id'],1);
                     
             $user_name=$this->api->get_user_info($data['user_id'],2);
         
             $provider_token=$this->api->get_user_info($data['provider_id'],1);

             
             $text=$user_name['name']." has booked your Service";
             $this->send_push_notification($token,$result,1,$msg=$text);
         

		  $this->session->set_flashdata('success_message',$message);
          }else{
			$message= 'Sorry, something went wrong';
		  $this->session->set_flashdata('error_message',$message);
    }
      }else{
        $inputs['token'] = 'Issue - token_already_used';
        $message= 'Sorry, something went wrong';
        $this->session->set_flashdata('error_message',$message);
      }

    echo json_encode($result);
  }

  /*stripe booking method OLD METHOD*/


  public function stripe_payments(){
    $inputs = array();
    $sub_id = $this->input->post('sub_id'); // Package ID
    $records = $this->subscription->get_subscription($sub_id);
    $inputs['subscription_id'] = $sub_id;
    $inputs['user_id'] = $this->session->userdata('id');
   
      
        $inputs['token'] = 'Free subscription';
        $inputs['args'] = '';
    $result = $this->subscription->subscription_success($inputs);
    if($result){
      $message= 'You have been subscribed';
      $this->session->set_flashdata('success_message',$message);
          }else{
      $message= 'Sorry, something went wrong';
      $this->session->set_flashdata('error_message',$message);
    }
     
    echo json_encode($result);
  }

  /*push notification*/

  public function send_push_notification($token,$service_id,$type,$msg){

              $data=$this->api->get_book_info($service_id);
              if(!empty($data)){
              if($type==1){
               $device_tokens=$this->api->get_device_info_multiple($data['provider_id'],1); 
             }else{
               $device_tokens=$this->api->get_device_info_multiple($data['user_id'],2); 
             }
             if($type ==2){
              $user_info=$this->api->get_user_info($data['user_id'],$type);

            }else{
               $user_info=$this->api->get_user_info($data['provider_id'],$type);
            }
           


            /*insert notification*/
            $msg=ucfirst(strtolower($msg));
            if(!empty($user_info['token'])){
                  $this->api->insert_notification($token,$user_info['token'],$msg);
            }
        
            $title=$data['service_title'];
           

            if (!empty($device_tokens)) {
              foreach ($device_tokens as $key => $device) {
                          if(!empty($device['device_type']) && !empty($device['device_id'])){
                          
                          if(strtolower($device['device_type'])=='android'){
                          
                          $notify_structure=array(
                          'title' => $title,
                          'message' => $msg,
                          'image' => 'test22',
                          'action' => 'test222',
                          'action_destination' => 'test222',
                          );
                          
                          sendFCMMessage($notify_structure,$device['device_id']);  
                          
                          }
                          
                          if(strtolower($device['device_type']=='ios')){
                          $notify_structure= array(
                          'alert' => $msg,
                          'sound' => 'default',
                          'badge' => 0,
                          );
                          
                          
                          sendApnsMessage($notify_structure,$device['device_id']);  
                          
                          }
                          }
              }
             
            }


/*apns push notification*/
}else{
     $this->token_error();
}
}
    



}
