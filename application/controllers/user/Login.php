<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

 public $data;

 public function __construct() {

  parent::__construct();
  $this->data['theme']     = 'user';
  $this->data['module']    = 'login';
  $this->data['page']     = '';
  $this->data['base_url'] = base_url();
  $this->load->helper('user_timezone_helper');
  $this->load->model('user_login_model','user_login');
  $this->load->library('session');
  $this->data['csrf'] = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
  );
}


public function index()
{
 $this->data['page'] = 'index';
 $this->load->vars($this->data);
 $this->load->view($this->data['theme'].'/template');
}

public function registration()
{

 $this->data['page'] = 'add_service';
 $this->load->vars($this->data);
 $this->load->view($this->data['theme'].'/template');
}
public function login()
{
  $mobile = $this->input->post('mobile');
  $countryCode = $this->input->post('country_code');
  $is_available_mobile = $this->user_login->check_mobile_no($mobile);
  $is_available_mobileuser = $this->user_login->check_user_mobileno($mobile);
  $user_details = $this->user_login->get_user_details($mobile);
  $provider_details = $this->user_login->get_provider_details($mobile);
  if($is_available_mobile == 1 && $is_available_mobileuser == 0)         
  {
    $session_data = array( 
      'id' => $provider_details['id'],
      'chat_token' => $provider_details['token'],
      'name'  => $this->input->post('userName'), 
      'email'     => $this->input->post('userEmail'), 
      'mobileno' => $mobile,
      'usertype' => 'provider'
    ); 
    $this->session->set_userdata($session_data); 
    echo 1;
    
  }
  elseif($is_available_mobile == 0 && $is_available_mobileuser == 1) 
  {
   $session_data = array(
     'id' => $user_details['id'], 
     'chat_token' => $user_details['token'],
     'name'  => $this->input->post('userName'), 
     'email'     => $this->input->post('userEmail'), 
     'mobileno' => $mobile,
     'usertype' => 'user'
   );

   $this->session->set_userdata($session_data); 
   echo 2;
 }
 else
 {
  $this->session->set_flashdata('error_message','Wrong login credentials.');
  echo 3;
}}
public function insert_user(){
  $mobile = $this->input->post('mobile');
  $email = $this->input->post('email');
  $name = $this->input->post('username');

  $user_details['mobileno'] = $this->input->post('mobile');
  $user_details['email'] = $this->input->post('email');
  $user_details['name'] = $this->input->post('username');
  $user_details['country_code'] = $this->input->post('country_code');

  $is_available = $this->user_login->check_user_emailid($email);
  $is_available_mobileno = $this->user_login->check_user_mobileno($mobile);
  $is_available_provider = $this->user_login->check_provider_email($email);
  $is_available_mobile_provider = $this->user_login->check_mobile_no($mobile);
  if($is_available == 0 && $is_available_mobileno == 0 && $is_available_provider == 0 && $is_available_mobile_provider == 0)         
  {
    $result = $this->user_login->user_signup($user_details);

    echo 1;
    
  }

  else
  {
    $this->session->set_flashdata('error_message','Something Went wrong.');
    echo 2;
  }

}

public function logout()
{ 

 if($this->session->userdata('usertype')=="provider"){
  $login_details=array(
    'last_logout'=>date('Y-m-d H:i:s'),
    'is_online'=>2
  );
  $this->db->where('id',$this->session->userdata('id'))->update('providers',$login_details);
}
$this->session->sess_destroy();
redirect(base_url());
}

public function user_dashboard()
{
 $this->data['page'] = 'user_dashboard';
 $this->load->vars($this->data);
 $this->load->view($this->data['theme'].'/template');
}




public function get_category()
{
  $this->db->where('status',1);
  $query=$this->db->get('categories');
  $result= $query->result();
  $data=array();
  foreach($result as $r)
  {
    $data['value']=$r->id;
    $data['label']=$r->category_name;
    $json[]=$data;
  }
  echo json_encode($json);
}

public function email_chk()
{
  $user_data =$this->input->post();
  $input['email']=$user_data['userEmail'];
  $is_available = $this->user_login->otp_check_email($input);
  $is_available_user = $this->user_login->otp_check_uemail($input);  
  if ($is_available > 0 || $is_available_user > 0) {
    $isAvailable = FALSE;
  } else {
    $isAvailable = TRUE;
  }
  echo json_encode(
    array(
      'valid' => $isAvailable
    ));
}

public function email_chk_user()
{
  $user_data =$this->input->post();

  $input['email']=$user_data['userEmail'];
  $is_available = $this->user_login->otp_check_uemail($input);  
  $is_available_provider = $this->user_login->otp_check_email($input);
  if ($is_available > 0 ||$is_available_provider >0) {
    $isAvailable = FALSE;
  } else {
    $isAvailable = TRUE;
  }
  echo json_encode(
    array(
      'valid' => $isAvailable
    ));
}

public function mobileno_chk()
{
  $user_data =$this->input->post();

  if($user_data['checked'] == 0)
  {
    $input['mobileno']=$user_data['userMobile'];
    $input['countryCode']=$user_data['countryCode'];
    $is_available_mobile = $this->user_login->check_mobile_no($input);
    $is_available_mobileuser = $this->user_login->check_user_mobileno($input); 

    if ($is_available_mobile > 0 || $is_available_mobileuser > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }
  elseif ($user_data['checked'] == 1) 
  {
    $input['mobileno']=$user_data['userMobile'];
    $input['countryCode']=$user_data['countryCode'];
    $is_available_mobile = $this->user_login->check_mobile_no($input);

    if ($is_available_mobile > 0) {
      $isAvailable = TRUE;
    } else {
      $isAvailable = FALSE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }
}

public function mobileCheck(){
  $user_data =$this->input->post();
  $input['mobileno']=$user_data['userMobile'];
  $input['countryCode']=$user_data['countryCode'];
  $is_available_mobile = $this->user_login->check_mobile_no($input);
  if ($is_available_mobile > 0) {
    $isAvailable = TRUE;
  } else {
    $isAvailable = FALSE;
  }
  echo json_encode(
    array(
      'valid' => $isAvailable
    ));
  
}

public function check_mobile_existing(){
  $user_data =$this->input->post(); 
  $input['mobileno']=$user_data['userMobile'];
  $input['countryCode']=$user_data['countryCode'];

  if($user_data['userMobile']){
   $is_available_mobile = $this->user_login->check_mobile_no($input);
   if ($is_available_mobile > 0) {
    $isAvailable = 1;
    $mode=1;
  } else {
    $is_available_mobileuser = $this->user_login->check_user_mobileno($input); 
    if($is_available_mobileuser>0){
     $isAvailable = 1;
     $mode=2;
   }else{
     $isAvailable = 2;
     $mode=2;
   }
 }
 echo json_encode(
  [
    'data' => $isAvailable,
    'mode'=>$mode
  ]);

}
}

public function mobileno_chk_user()
{
  $user_data =$this->input->post();

  if($user_data['checked'] == 0)
  {
    $input['mobileno']=$user_data['userMobile'];
    $input['countryCode']=$user_data['countryCode'];
    $is_available_mobile = $this->user_login->check_mobile_no($input);
    $is_available_mobileuser = $this->user_login->check_user_mobileno($input); 

    if ($is_available_mobile > 0 || $is_available_mobileuser > 0) {
      $isAvailable = FALSE;
    } else {
      $isAvailable = TRUE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }
  elseif ($user_data['checked'] == 1) 
  {
    $input['mobileno']=$user_data['userMobile'];
    $input['countryCode']=$user_data['countryCode']; 
    $is_available_mobileuser = $this->user_login->check_user_mobileno($input); 

    if ($is_available_mobileuser > 0) {
      $isAvailable = TRUE;
    } else {
      $isAvailable = FALSE;
    }
    echo json_encode(
      array(
        'valid' => $isAvailable
      ));
  }
}

/*resend otp*/
public function re_send_otp_user(){
  extract($_POST);
  $user_type=$this->user_login->get_user_type($mobile_no,$country_code);
  if(($_SERVER['HTTP_HOST']=='https') || ($_SERVER['HTTP_HOST']=='http')){
        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
      }else{
        $api_key = 'default_otp';
      }
   $default_otp=settingValue($api_key);
      if($default_otp==1){
        $otp ='1234';
      }else{
        $otp = rand(1000,9999);
      }
  $message= $otp.' is your OTP at Axzora. This is valid for 5 minutes.'; 
  $user_data['otp']=$otp;
  error_reporting(0);
  // $key=settingValue('sms_key');
  // $secret_key=settingValue('sms_secret_key');
  // $sender_id=settingValue('sms_sender_id');
  // require_once('vendor/nexmo/src/NexmoMessage.php');
  // $nexmo_sms = new NexmoMessage($key,$secret_key);
  // $result = $nexmo_sms->sendText($country_code.$mobile_no,$sender_id,$message);
  //$this->session->set_tempdata('otp', '$user_data', 300);
  $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://2factor.in/API/V1/".$api_key."/SMS/".$mobile_no."/".$otp,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => array(
      "content-type: application/x-www-form-urlencoded"
    ),
  ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);

  $otp_data=array(
    'endtime'=>time()+300,
    'mobile_number'=>$mobile_no,
    'country_code'=>$country_code,
    'otp'=>$otp,
    'created_at'=>date('Y-m-d H:i:s'),
  );


  /*check OTP*/

  $check_otp_table=$this->user_login->isset_mobile_otp($mobile_no,$country_code,$otp_data);

  echo $check_otp_table;

  /*find mobile user type*/

}

/*resend otp*/
public function re_send_otp_provider(){
  extract($_POST);
  $user_type=$this->user_login->get_user_type($mobile_no,$country_code);
if(($_SERVER['HTTP_HOST']=='https') || ($_SERVER['HTTP_HOST']=='http')){
        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
      }else{
        $api_key = 'default_otp';
      }
 $default_otp=settingValue($api_key);
      if($default_otp==1){
        $otp ='1234';
      }else{
        $otp = rand(1000,9999);
      }
  $message= $otp.' is your OTP at Axzora. This is valid for 5 minutes.'; 
  $user_data['otp']=$otp;
  error_reporting(0);
  // $key=settingValue('sms_key');
  // $secret_key=settingValue('sms_secret_key');
  // $sender_id=settingValue('sms_sender_id');
  // require_once('vendor/nexmo/src/NexmoMessage.php');
  // $nexmo_sms = new NexmoMessage($key,$secret_key);
  // $result = $nexmo_sms->sendText($country_code.$mobile_no,$sender_id,$message);
  // $this->session->set_tempdata('otp', '$user_data', 300);
    $curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://2factor.in/API/V1/".$api_key."/SMS/".$mobile_no."/".$otp,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 30,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "GET",
    CURLOPT_POSTFIELDS => "",
    CURLOPT_HTTPHEADER => array(
      "content-type: application/x-www-form-urlencoded"
    ),
  ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);




  $otp_data=array(
    'endtime'=>time()+300,
    'mobile_number'=>$mobile_no,
    'country_code'=>$country_code,
    'otp'=>$otp,
    'created_at'=>date('Y-m-d H:i:s'),
  );


  /*check OTP*/

  $check_otp_table=$this->user_login->isset_mobile_otp($mobile_no,$country_code,$otp_data);


  echo $check_otp_table;


}

public  function send_otp_request(){
// https://2factor.in/API/V1/523977b1-cfcd-11ea-9fa5-0200cd936042/SMS/8143222351/12345/register_provider 
$user_data = $this->input->post();
  if(!empty($user_data['mobileno']) && !empty($user_data['email'])){
    $is_available = $this->user_login->otp_check_email($user_data);
    $is_available_mobile = $this->user_login->otp_check_mobile_no($user_data);
    if($is_available == 0 ){
     if($is_available_mobile == 0){
      if(($_SERVER['HTTP_HOST']=='https') || ($_SERVER['HTTP_HOST']=='http')){
        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
      }else{
        $api_key = 'default_otp';
      }
      $default_otp=settingValue($api_key);
      if($default_otp==1){
        $otp ='1234';
      }else{
        $otp = rand(1000,9999);
      }
      $message= $otp.' is your OTP at Axzora. This is valid for 5 minutes.'; 
      $user_data['otp']=$otp;
      error_reporting(0);
      // $key=settingValue('sms_key');
      // $secret_key=settingValue('sms_secret_key');
      // $sender_id=settingValue('sms_sender_id');
      // require_once('vendor/nexmo/src/NexmoMessage.php');
      // $nexmo_sms = new NexmoMessage($key,$secret_key);
      // $result = $nexmo_sms->sendText($user_data['countryCode'].$user_data['mobileno'],$sender_id,$message);
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://2factor.in/API/V1/".$api_key."/SMS/".$user_data['mobileno']."/".$otp,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
      $this->db->where('country_code', $user_data['countryCode']);
      $this->db->where('mobile_number', $user_data['mobileno']);
      $this->db->where('status', 1);
      $save_otp=$this->db->update('mobile_otp', array('status'=>0));
      $this->session->set_tempdata('otp', '$user_data', 300);
      $otp_data=array(
        'endtime'=>time()+300,
        'mobile_number'=>$user_data['mobileno'],
        'country_code'=>$user_data['countryCode'],
        'otp'=>$otp,
        'created_at'=>date('Y-m-d H:i:s')
      );
      $save_otp = $this->user_login->save_otp($otp_data);
      echo json_encode(array('response'=>'ok','result'=>'true','msg'=>'OTP has sent successfully'));
    }
    else{
      echo json_encode(array('response'=>'error','result'=>'mobile','msg'=>'Mobile number is already exists'));
    }
  }
  else{
    echo json_encode(array('response'=>'error','result'=>'email','msg'=>'Email is already exists'));
  }
}
elseif(!empty($user_data['mobileno'])){
  $is_available = $this->user_login->otp_check_email($user_data);
  $is_available_mobile = $this->user_login->otp_check_mobile_no($user_data);
  if($is_available_mobile == 1){
    if(($_SERVER['HTTP_HOST']=='https') || ($_SERVER['HTTP_HOST']=='http')){
        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
      }else{
        $api_key = 'default_otp';
      }
  $default_otp=settingValue($api_key);
      if($default_otp==1){
        $otp ='1234';
      }else{
        $otp = rand(1000,9999);
      }

     $message= $otp.' is your OTP at Axzora. This is valid for 5 minutes.';  
    $user_data['otp']=$otp;

    error_reporting(0);
    // $key=settingValue('sms_key');
    // $secret_key=settingValue('sms_secret_key');
    // $sender_id=settingValue('sms_sender_id');
    // require_once('vendor/nexmo/src/NexmoMessage.php');
    // $nexmo_sms = new NexmoMessage($key,$secret_key);
    // $result = $nexmo_sms->sendText($user_data['countryCode'].$user_data['mobileno'],$sender_id,$message);
    //$this->session->set_tempdata('otp', '$user_data', 300);
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://2factor.in/API/V1/".$api_key."/SMS/".$user_data['mobileno']."/".$otp,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $this->db->where('country_code', $user_data['countryCode']);
    $this->db->where('mobile_number', $user_data['mobileno']);
    $this->db->where('status', 1);
    $save_otp=$this->db->update('mobile_otp', array('status'=>0));
    $otp_data=array(
      'endtime'=>time()+300,
      'mobile_number'=>$user_data['mobileno'],
      'country_code'=>$user_data['countryCode'],
      'otp'=>$otp,
      'created_at'=>date('Y-m-d H:i:s')
    );
    $save_otp = $this->user_login->save_otp($otp_data);
    echo json_encode(array('response'=>'ok','result'=>'true','msg'=>'OTP has sent successfully'));
  }else{
    echo json_encode(array('response'=>'error','result'=>'mobile','msg'=>'Mobile number does not exists'));
  }}}

public  function send_otp_request_user(){
  $user_data = $this->input->post();
  if(!empty($user_data['mobileno']) && !empty($user_data['email'])){
    $is_available = $this->user_login->otp_check_uemail($user_data);
    $is_available_mobile = $this->user_login->otp_check_mobile_no_user($user_data);
    if($is_available == 0 ){
     if($is_available_mobile == 0){
      if(($_SERVER['HTTP_HOST']=='https') || ($_SERVER['HTTP_HOST']=='http')){
        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
      }else{
        $api_key = 'default_otp';
      }
      $default_otp=settingValue($api_key);
      if($default_otp==1){
        $otp ='1234';
      }else{
        $otp = rand(1000,9999);
      }
       $message= $otp.' is your OTP at Axzora. This is valid for 5 minutes.';  
      $user_data['otp']=$otp;
      error_reporting(0);
      // $key=settingValue('sms_key');
      // $secret_key=settingValue('sms_secret_key');
      // $sender_id=settingValue('sms_sender_id');
      // require_once('vendor/nexmo/src/NexmoMessage.php');
      // $nexmo_sms = new NexmoMessage($key,$secret_key);
      // $result = $nexmo_sms->sendText($user_data['countryCode'].$user_data['mobileno'],$sender_id,$message);
      $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://2factor.in/API/V1/".$api_key."/SMS/".$user_data['mobileno']."/".$otp,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
      $this->db->where('country_code', $user_data['countryCode']);
      $this->db->where('mobile_number', $user_data['mobileno']);
      $this->db->where('status', 1);
      $save_otp=$this->db->update('mobile_otp', array('status'=>0));
      $this->session->set_tempdata('otp', '$user_data', 300);
      $otp_data=array(
        'endtime'=>time()+300,
        'mobile_number'=>$user_data['mobileno'],
        'country_code'=>$user_data['countryCode'],
        'otp'=>$otp,
        'created_at'=>date('Y-m-d H:i:s')
      );
      $save_otp = $this->user_login->save_otp($otp_data);
      echo json_encode(array('response'=>'ok','result'=>'true','msg'=>'OTP has sent successfully'));
    }else{
      echo json_encode(array('response'=>'error','result'=>'mobile','msg'=>'Mobile number is already exists'));
    }}else{
    echo json_encode(array('response'=>'error','result'=>'email','msg'=>'Email is already exists'));
  } }
elseif(!empty($user_data['mobileno'])){
  $is_available = $this->user_login->otp_check_uemail($user_data);
  $is_available_mobile = $this->user_login->otp_check_mobile_no_user($user_data);
  if($is_available_mobile == 1){
    if(($_SERVER['HTTP_HOST']=='https') || ($_SERVER['HTTP_HOST']=='http')){
        $api_key = "523977b1-cfcd-11ea-9fa5-0200cd936042";  
      }else{
        $api_key = 'default_otp';
      }
     $default_otp=settingValue($api_key);
      if($default_otp==1){
        $otp ='1234';
      }else{
        $otp = rand(1000,9999);
      }
     $message= $otp.' is your OTP at Axzora. This is valid for 5 minutes.'; 
    $user_data['otp']=$otp;
    // error_reporting(0);
    // $key=settingValue('sms_key');
    // $secret_key=settingValue('sms_secret_key');
    // $sender_id=settingValue('sms_sender_id');
    // require_once('vendor/nexmo/src/NexmoMessage.php');
    // $nexmo_sms = new NexmoMessage($key,$secret_key);
    // $result = $nexmo_sms->sendText($user_data['countryCode'].$user_data['mobileno'],$sender_id,$message);
    // $this->session->set_tempdata('otp', '$user_data', 300);

    $curl = curl_init();
      curl_setopt_array($curl, array(
      CURLOPT_URL => "https://2factor.in/API/V1/".$api_key."/SMS/".$user_data['mobileno']."/".$otp,
      CURLOPT_RETURNTRANSFER => true,
      CURLOPT_ENCODING => "",
      CURLOPT_MAXREDIRS => 10,
      CURLOPT_TIMEOUT => 30,
      CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
      CURLOPT_CUSTOMREQUEST => "GET",
      CURLOPT_POSTFIELDS => "",
      CURLOPT_HTTPHEADER => array(
        "content-type: application/x-www-form-urlencoded"
      ),
    ));
    $response = curl_exec($curl);
    $err = curl_error($curl);
    curl_close($curl);
    $this->db->where('country_code', $user_data['countryCode']);
    $this->db->where('mobile_number', $user_data['mobileno']);
    $this->db->where('status', 1);
    $save_otp=$this->db->update('mobile_otp', array('status'=>0));
    $otp_data=array(
      'endtime'=>time()+300,
      'mobile_number'=>$user_data['mobileno'],
      'country_code'=>$user_data['countryCode'],
      'otp'=>$otp,
      'created_at'=>date('Y-m-d H:i:s')
    );
    $save_otp = $this->user_login->save_otp($otp_data);
    echo json_encode(array('response'=>'ok','result'=>'true','msg'=>'OTP has sent successfully'));
  }else{
    echo json_encode(array('response'=>'error','result'=>'mobile','msg'=>'Mobile number does not exists'));
  }}}


public function check_otp(){ 
 $input_data = $this->input->post();
 $check_data= array('mobile_number' => $input_data['mobileno'],'otp'=>$input_data['otp'] );
 if($input_data['name'] && $input_data['email'] != ''){ 
  $check = $this->user_login->otp_validation($check_data,$input_data);
  $provider_details = (!empty($check['data']))?$check['data']:'';
}else{
  $check = $this->user_login->check_otp($check_data);
  $provider_details = $this->user_login->get_provider_details($input_data['mobileno']);
}
if(is_array($check) && $check['msg']=='ok'){
  $return = array('response'=>'ok', 'msg'=>'Successful','login_data'=>$check );
  $check['logged_in'] = TRUE;
  $session_data = array(
   'id' => $provider_details['id'],
   'chat_token' => $provider_details['token'],
   'name'  => $provider_details['name'], 
   'email'     => $provider_details['email'], 
   'mobileno' => $provider_details['mobileno'],
   'usertype' => 'provider'
 ); 
  $this->session->set_userdata($session_data); 
  $login_details=array(
    'last_login'=>date('Y-m-d H:i:s'),
    'is_online'=>1
  );
  $this->db->where('id',$provider_details['id'])->update('providers',$login_details);
  echo json_encode($return);
}
else  if ($check=='invalid_otp') {
 $return = array('response'=>'error', 'msg'=>'Invaild OTP','result'=>'otp_invalid');
 echo json_encode($return);
}
elseif ($check=='otp_expired') {
 $return = array('response'=>'error', 'msg'=>'OTP expired','result'=>'otp_expired');
 echo json_encode($return);
}
else
  { $return = array('response'=>'error', 'msg'=>'Check Your OTP');
echo  json_encode($return);
}
}

public function check_otp_user(){
  $input_data = $this->input->post();
$check_data= array('mobile_number' => $input_data['mobileno'],'otp'=>$input_data['otp'] );
if($input_data['name'] && $input_data['email'] != ''){
  $check = $this->user_login->otp_validation_user($check_data,$input_data);
  $user_details = $check['data'];
}else{
  $check = $this->user_login->check_otp_user($check_data);
  $user_details = $this->user_login->get_user_details($input_data['mobileno']);
}
if(is_array($check) && $check['msg']=='ok'){
  $date=utc_date_conversion(date('Y-m-d H:i:s'));
  $return = array('response'=>'ok', 'msg'=>'Successful','login_data'=>$check );
  $check['logged_in'] = TRUE;
  if(!empty($input_data['mobileno'])){
    $this->db->where('mobileno', $input_data['mobileno']);
    $this->db->where('status', 1);
    $this->db->update('users', array('last_login'=>$date));
  }
  $session_data = array(
   'id' => $user_details['id'], 
   'chat_token' => $user_details['token'],
   'name'  => $user_details['name'], 
   'email'     => $user_details['email'], 
   'mobileno' => $user_details['mobileno'],
   'usertype' => 'user'
 ); 
  $this->session->set_userdata($session_data); 
  echo json_encode($return);
}else  if ($check=='invalid_otp') {
 $return = array('response'=>'error', 'msg'=>'Invaild OTP','result'=>'otp_invalid');
 echo json_encode($return);
}elseif ($check=='otp_expired') {
 $return = array('response'=>'error', 'msg'=>'OTP expired','result'=>'otp_expired');
 echo json_encode($return);
}else{ $return = array('response'=>'error', 'msg'=>'Check Your OTP');
echo  json_encode($return);
}}}
