<?php defined('BASEPATH') OR exit('No direct script access allowed'); 
class Dashboard extends CI_Controller { 
public $data; 
public function __construct() 
{ 
parent::__construct(); 
if(empty($this->session->userdata('id')))
{
redirect(base_url());
}
$this->data['theme'] = 'user';
$this->data['module'] = 'home';
$this->data['page'] = '';
$this->data['base_url'] = base_url();
$this->load->helper('user_timezone_helper');
$this->load->model('service_model','service');
$this->load->model('home_model','home');
$this->load->model('Api_model','api');
// Load pagination library
$this->load->library('ajax_pagination');
// Load post model
$this->load->model('booking');
$this->load->model('User_booking','userbooking');
// Per page limit
$this->perPage = 6;
}
public function index()
{
$this->data['page'] = 'index';
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function user_settings()
{
$this->data['page'] = 'user_settings';
$this->data['country']=$this->db->select('id,country_name')->from('country_table')->get()->result_array();
$this->data['city']=$this->db->select('id,name')->from('city')->get()->result_array();
$this->data['state']=$this->db->select('id,name')->from('state')->get()->result_array();
$this->data['user_address']=$this->db->where('user_id',$this->session->userdata('id'))->get('user_address')->row_array();
$this->data['profile']=$this->service->get_profile($this->session->userdata('id'));
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function user_wallet(){
$this->data['page'] = 'user_wallet';
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}

public function user_wallet_submit(){
if($this->input->post()){
if($this->input->post('txStatus')=='SUCCESS'){
$this->load->model('Wallet_model');
$type = $this->session->userdata('usertype');
if($type=='provider'){
$typeVal = 1;
}else{
$typeVal = 2;
}
$checkuser = $this->Wallet_model->wallet_info_id($this->session->userdata('id'),$typeVal);
$getamount = 0;
for($i=0; $i<count($checkuser); $i++){ $getamount=$checkuser[$i]->wallet_amt;
}
if(count($checkuser) >= 1){
	//echo "first"; exit;
$data = [
'user_provider_id' => $this->session->userdata('id'),
'type' => $typeVal,
'wallet_amt' =>$this->input->post('orderAmount')+ $getamount,
'token' => $this->session->userdata('chat_token'),
'updated_on' => date('Y-m-d H:i:s'),
];
$result = $this->Wallet_model->update_user_provider_wallet($data,$this->session->userdata('id'));
}else{
	//echo "second"; exit;
$data = [
'user_provider_id' => $this->session->userdata('id'),
'type' => $typeVal,
'wallet_amt' =>$this->input->post('orderAmount'),
'token' => $this->session->userdata('chat_token'),
'created_at' => date('Y-m-d H:i:s'),
];
$result = $this->Wallet_model->add_user_provider_wallet($data);
}$this->session->set_flashdata('success_message','Amout is successfully add in wallet');
redirect(base_url().'user-wallet');
}else{
$this->session->set_flashdata('error_message','Amout not added in wallet');
echo "<pre>"; print_r($this->input->post());
redirect(base_url().'user-wallet');
}}else{
	//$appId = pk_test_51Gzz20HShEbk1dXRzGAJl1NjXak3AhEzDdyar62TT
	//$secretKey = "48a401703d4f6f03fd4ff5da44689d582776e650";
	// $apklive = pk_live_51Gzz20HShEbk1dXRqkZYmBp8giBe2DrGrLd4jku82;
	// $secretkeyLive = sk_live_51Gzz20HShEbk1dXRl28UmwFr6S0OKIxEaXqqxnf2sabeGbdCtgRLYphkji7Ik;
$secretKey = "48a401703d4f6f03fd4ff5da44689d582776e650";
$data = [
//"token" => $this->input->get('token'),
"appId" => $this->input->get('appId'),
"orderId" => $this->input->get('orderId'),
"orderAmount" => $this->input->get('orderAmount'),
"returnUrl" => $this->input->get('returnUrl'),
"orderCurrency" => $this->input->get('orderCurrency'),
"orderNote" => $this->input->get('orderNote'),
"customerName" => $this->input->get('customerName'),
"customerPhone" => $this->input->get('customerPhone'),
"customerEmail" => $this->input->get('customerEmail'),
"notifyUrl" => $this->input->get('notifyUrl'),
];
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
}}



public function user_payment(){
$this->data['page'] = 'user_payment';
$this->data['services'] = $this->db->where('b.user_id',$this->session->userdata('id'))->where_in('b.status',[5,6,7])->from('book_service as b')->join('users as u','u.id=b.user_id')->join('services s','s.id=b.service_id')->select('b.*,u.*,s.service_title,s.service_image,b.status as booking_status')->order_by('b.id','desc')->get()->result_array();
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function user_accountdetails()
{
$this->data['page'] = 'user_accountdetails';
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
/*cropping*/
function prf_crop($av_src,$av_data,$av_file,$req_height,$req_width,$table_name,$redirect) {
$directoryName ='uploads/profile_img/';
//Check if the directory already exists.
if(!is_dir($directoryName)){
//Directory does not exist, so lets create it.
mkdir($directoryName, 0755);
}
if(!empty($av_src) && !empty($av_data) && !empty($av_file) )
{
$av_src = $av_src;
$av_data = $av_data;
$av_file = $av_file;
$av_file['name']=str_replace(' ','-',$av_file['name']);
$src = $directoryName.$av_file['name'];
$imageFileType = pathinfo($src,PATHINFO_EXTENSION);
$info = pathinfo($src);
$file_name = basename($src,'.'.$info['extension']);
$src2 = $directoryName.$av_file['name'];
move_uploaded_file($av_file['tmp_name'],$src2);
$image_name = str_replace(' ','-',$av_file['name']);
$new_name1 = time().'.'.$imageFileType;
$image1 = $this->prf_crop_call($image_name,$av_data,$new_name1,$directoryName,500,250);
$cropfliename = $new_name1;
$data['success'] = 'Y';
}else{
$new_name1 ='';
$imageFileType='';
$info='';
$cropfliename='';
$data['success'] = 'n';
}
$data['full_fliename'] =$new_name1;
$data['image_extension'] =$imageFileType ;
$data['image_info'] =$info ;
$data['Date'] =date('d/m/y') ;
$data['cropped_fliepath'] ='uploads/profile_img/'.$cropfliename;
$table_data['profile_img'] ='uploads/profile_img/'.$cropfliename;
$id=$this->session->userdata('id');
$this->db->where('id',$id);
if($this->db->update($table_name, $table_data)){
}else{
}
return $data;
}
function prf_crop_call($image_name,$av_data,$new_name,$directoryName,$t_width,$t_height) {
$w = $av_data['width'];
$h = $av_data['height'];
$x1 = $av_data['x'];
$y1 = $av_data['y'];
list($imagewidth, $imageheight, $imageType) = getimagesize($directoryName.$image_name);
$imageType = image_type_to_mime_type($imageType);
$ratio = ($t_width/$w);
$nw = ceil($w * $ratio);
$nh = ceil($h * $ratio);
$newImage = imagecreatetruecolor($nw,$nh);
switch($imageType) {
case "image/gif" : $source = imagecreatefromgif($directoryName.$image_name);
break;
case "image/pjpeg":
case "image/jpeg" :
case "image/jpg" : $source = imagecreatefromjpeg($directoryName.$image_name);
break;
case "image/png" :
case "image/x-png": $source = imagecreatefrompng($directoryName.$image_name);
break;
}
imagecopyresampled($newImage,$source,0,0,$x1,$y1,$nw,$nh,$w,$h);
switch($imageType) {
case "image/gif" : imagegif($newImage,$directoryName.$new_name);
break;
case "image/pjpeg":
case "image/jpeg" :
case "image/jpg" : imagejpeg($newImage,$directoryName.$new_name,100);
break;
case "image/png" :
case "image/x-png": imagepng($newImage,$directoryName.$new_name);
break;
}
}
public function profile_cropping(){
extract($_POST);
if(!empty($_FILES['profile_img'])){
$av_data = json_decode($_POST['avatar_data'],true);
$av_file = $_FILES['profile_img'];
$av_src = $av_file['name'];
$req_height = 250;
$req_width = 250;
$output = $this->prf_crop($av_src,$av_data,$av_file,$req_height,$req_width,$table_name,$redirect);
echo json_encode($output);
die();
}
}
public function update_user()
{
if (!empty($_POST)) {
removeTag($this->input->post());
$uploaded_file_name = '';
if (isset($_FILES) && isset($_FILES['profile_img']['name']) && !empty($_FILES['profile_img']['name'])) {
$uploaded_file_name = $_FILES['profile_img']['name'];
$uploaded_file_name_arr = explode('.', $uploaded_file_name);
$filename = isset($uploaded_file_name_arr[0]) ? $uploaded_file_name_arr[0] : '';
$this->load->library('common');
$upload_sts = $this->common->global_file_upload('uploads/profile_img/', 'profile_img', time().$filename);
if (isset($upload_sts['success']) && $upload_sts['success'] == 'y') {
$uploaded_file_name = $upload_sts['data']['file_name'];
if (!empty($uploaded_file_name)) {
$image_url='uploads/profile_img/'.$uploaded_file_name;
$table_data['profile_img'] = $this->image_resize(100,100,$image_url,$filename);
}
}
}
$id=$this->session->userdata('id');
$table_data['mobileno'] =$this->input->post('mobileno');
if(!empty($this->input->post('dob'))){
$table_data['dob'] =date('Y-m-d',strtotime($this->input->post('dob')));
}else{
$table_data['dob'] =NULL;
}
$this->db->where('id',$id);
if($this->db->update('users', $table_data))
{
$table_datas['address']=$_POST['address'];
if(!empty($_POST['state_id'])){
$table_datas['state_id']=$_POST['state_id'];
}
if(!empty($_POST['city_id'])){
$table_datas['city_id']=$_POST['city_id'];
}
if(!empty($_POST['country_id'])){
$table_datas['country_id']=$_POST['country_id'];
} if(!empty($_POST['pincode'])){
$table_datas['pincode']=$_POST['pincode'];
}
$user_count=$this->db->where('user_id', $id)->count_all_results('user_address');
if(count($table_datas)>0){
if($user_count==1){
$this->db->where('user_id',$id);
$this->db->update('user_address', $table_datas);
}else{
$table_datas['user_id']=$id;
$this->db->insert('user_address', $table_datas);
}
$this->session->set_flashdata('success_message','Profile updated successfully');
redirect(base_url()."user-settings");
}
else
{
$this->session->set_flashdata('error_message','Something wrong, Please try again');
redirect(base_url()."user-settings");
}
}
}
}
public function update_account()
{
$id=$this->session->userdata('id');
$table_data['account_holder_name'] = $this->input->post('account_holder_name');
$table_data['account_number'] = $this->input->post('account_number');
$table_data['account_iban'] = $this->input->post('account_iban');
$table_data['bank_name'] = $this->input->post('bank_name');
$table_data['bank_address'] = $this->input->post('bank_address');
$table_data['sort_code'] = $this->input->post('sort_code');
$table_data['routing_number'] = $this->input->post('routing_number');
$table_data['account_ifsc'] = $this->input->post('account_ifsc');
$this->db->where('id',$id);
$result = $this->db->update('users', $table_data);
if($result)
{
$this->session->set_flashdata('success_message','Account details updated successfully');
}
else
{
$this->session->set_flashdata('error_message','Something wrong, Please try again');
}
echo json_encode($result);
}
public function update_account_provider()
{
$id=$this->session->userdata('id');
$table_data['account_holder_name'] = $this->input->post('account_holder_name');
$table_data['account_number'] = $this->input->post('account_number');
$table_data['account_iban'] = $this->input->post('account_iban');
$table_data['bank_name'] = $this->input->post('bank_name');
$table_data['bank_address'] = $this->input->post('bank_address');
$table_data['sort_code'] = $this->input->post('sort_code');
$table_data['routing_number'] = $this->input->post('routing_number');
$table_data['account_ifsc'] = $this->input->post('account_ifsc');
$this->db->where('id',$id);
$result = $this->db->update('providers', $table_data);
if($result)
{
$data=array('tab_ctrl'=>4,'success_message'=>'Account details updated successfully');
$this->session->set_flashdata($data);
}
else
{
$data=array('tab_ctrl'=>4,'success_message'=>'Something wrong, Please try again');
$this->session->set_flashdata($data);
}
echo json_encode($result);
}
public function update_provider()
{
$uploaded_file_name = '';
$id=$this->session->userdata('id');
removeTag($this->input->post());
$table_data['category'] = $this->input->post('categorys');
$table_data['subcategory'] = $this->input->post('subcategorys');
$table_data['mobileno'] = $this->input->post('mobileno');
if(!empty($this->input->post('dob'))){
$table_data['dob']=date('Y-m-d',strtotime($this->input->post('dob')));
}else{
$table_data['dob']=NULL;
}
$this->db->where('id',$id);
if($this->db->update('providers', $table_data))
{
$table_datas['address']=$_POST['address'];
if(!empty($_POST['state_id'])){
$table_datas['state_id']=$_POST['state_id'];
}
if(!empty($_POST['city_id'])){
$table_datas['city_id']=$_POST['city_id'];
}
if(!empty($_POST['country_id'])){
$table_datas['country_id']=$_POST['country_id'];
} if(!empty($_POST['pincode'])){
$table_datas['pincode']=$_POST['pincode'];
}
$provider_count=$this->db->where('provider_id', $id)->count_all_results('provider_address');
if(count($table_datas)>0){
if($provider_count==1){
$this->db->where('provider_id',$id);
$this->db->update('provider_address', $table_datas);
}else{
$table_datas['provider_id']=$id;
$this->db->insert('provider_address', $table_datas);
}
}
$data=array('tab_ctrl'=>1,'success_message'=>'Profile updated successfully');
$this->session->set_flashdata($data);
redirect(base_url()."provider-settings");
}
else
{
$data=array('tab_ctrl'=>1,'error_message'=>'Something wrong, Please try again');
$this->session->set_flashdata($data);
redirect(base_url()."provider-settings");
}
}
public function user_reviews()
{
$this->data['page'] = 'user_reviews';
$this->db->select("r.*,u.profile_img,u.name,s.service_image,s.service_title");
$this->db->from('rating_review r');
$this->db->join('users u', 'u.id = r.user_id', 'LEFT');
$this->db->join('services s', 's.id = r.service_id', 'LEFT');
$this->db->where(array('r.user_id' => $this->session->userdata('id'),'r.status'=>1))->order_by('r.id','desc');
$this->data['reviews'] = $this->db->get()->result_array();
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function provider_reviews()
{
$this->data['page'] = 'provider_reviews';
$this->db->select("r.*,u.profile_img,u.name,s.service_image,s.service_title");
$this->db->from('rating_review r');
$this->db->join('users u', 'u.id = r.user_id', 'LEFT');
$this->db->join('services s', 's.id = r.service_id', 'LEFT');
$this->db->where(array('r.provider_id' => $this->session->userdata['id'],'r.status'=>1))->order_by('r.id','desc');
$this->data['reviews'] = $this->db->get()->result_array();
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function provider_settings()
{
$this->data['page'] = 'provider_settings';
$this->data['country']=$this->db->select('id,country_name')->from('country_table')->order_by('country_name','asc')->get()->result_array();
$this->data['city']=$this->db->select('id,name')->from('city')->get()->result_array();
$this->data['state']=$this->db->select('id,name')->from('state')->get()->result_array();
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function provider_wallet(){
$this->load->model('Wallet_model');
$getsysteminfo = $this->Wallet_model->get_system_info();
$this->data['system_info'] = $getsysteminfo;
$this->data['page'] = 'provider_wallet';
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function provider_wallet_submit(){
if($this->input->post()){
if($this->input->post('txStatus')=='SUCCESS'){
$this->load->model('Wallet_model');
$type = $this->session->userdata('usertype');
if($type=='provider'){
$typeVal = 1;
}else{
$typeVal = 2;
}
$checkuser = $this->Wallet_model->wallet_info_id($this->session->userdata('id'),$typeVal);
$getamount = 0;
for($i=0; $i<count($checkuser); $i++){ $getamount=$checkuser[$i]->wallet_amt;
}
if(count($checkuser) >= 1){
$data = [
'user_provider_id' => $this->session->userdata('id'),
'type' => $typeVal,
'wallet_amt' =>$this->input->post('orderAmount')+ $getamount,
'token' => $this->session->userdata('chat_token'),
'updated_on' => date('Y-m-d H:i:s'),
];
$result = $this->Wallet_model->update_user_provider_wallet($data,$this->session->userdata('id'));
}else{
$data = [
'user_provider_id' => $this->session->userdata('id'),
'type' => $typeVal,
'wallet_amt' =>$this->input->post('orderAmount'),
'token' => $this->session->userdata('chat_token'),
'created_at' => date('Y-m-d H:i:s'),
];
$result = $this->Wallet_model->add_user_provider_wallet($data);
}
$this->session->set_flashdata('success_message','Amout is successfully add in wallet');
redirect(base_url().'provider-wallet');
}
else{
$this->session->set_flashdata('error_message','Amout not added in wallet');
echo "<pre>"; print_r($this->input->post());
redirect(base_url().'provider-wallet');
}
}else{
$secretKey = $this->input->get('secretKey');
$data = [
"token" => $this->input->get('token'),
"appId" => $this->input->get('appId'),
"orderId" => $this->input->get('orderId'),
"orderAmount" => $this->input->get('orderAmount'),
"returnUrl" => $this->input->get('returnUrl'),
"orderCurrency" => $this->input->get('orderCurrency'),
"orderNote" => $this->input->get('orderNote'),
"customerName" => $this->input->get('customerName'),
"customerPhone" => $this->input->get('customerPhone'),
"customerEmail" => $this->input->get('customerEmail'),
"notifyUrl" => $this->input->get('notifyUrl'),
];
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
public function get_provider_return(){
$this->data['page'] = 'provider_response';
$this->data['token']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->load->view($this->data['theme'].'/template');
}
public function provider_notify(){
$this->data['page'] = 'provider_notify';
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->load->view($this->data['theme'].'/template');
}
public function provider_payment()
{
$this->data['page'] = 'provider_payment';
$this->data['services'] = $this->db->where('b.provider_id',$this->session->userdata('id'))->where_in('b.status',[5,6,7])->from('book_service as b')->join('users as u','u.id=b.user_id')->join('services s','s.id=b.service_id')->order_by('b.id','desc')->select('b.*,u.*,s.service_title,s.service_image,b.status as payment_status')->get()->result_array();
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function provider_subscription(){	
$this->data['page'] = 'provider_subscription';
$this->load->model('Wallet_model');
$getsysteminfo = $this->Wallet_model->get_system_info();
$getsubscriptionLog = $this->Wallet_model->getsubscriptionLog($this->session->userdata('id'));
$this->data['suscriptionLog'] = $getsubscriptionLog;
$this->data['system_info'] = $getsysteminfo;
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}

public function provider_subscription_submit(){
	$this->load->model('Subscription_model');
if($this->input->post()){
$orderId = 	$this->input->post('orderId');
$plandata = $this->Subscription_model->getTempOrder($orderId);
if($this->input->post('txStatus')=='SUCCESS'){
$this->load->model('Wallet_model');
$type = $this->session->userdata('usertype');
if($type=='provider'){
$typeVal = 1;
}else{
$typeVal = 2;
}

$data = [
'subscriber_id' => $this->session->userdata('id'),
'subscription_id' => $plandata[0]->planid,
'type' => $typeVal,
'token' => $this->session->userdata('chat_token'),
'args' => 'Days plan',
];
$result = $this->Subscription_model->subscribe_provider_plan($data);

$this->session->set_flashdata('success_message','Plan is successfully subscribed');
redirect(base_url().'provider-subscription');
}
else{
$this->session->set_flashdata('error_message','Plan not subscribed');
echo "<pre>"; print_r($this->input->post());
redirect(base_url().'provider-subscription');
}
}else{
$tempOrder = [
	"orderid" => $this->input->get('orderId'),
	"planid" => $this->input->get('planid'),
	"created_at"=> date('Y-m-d H:i:s'),
];
$this->Subscription_model->tempOrder($tempOrder);

$secretKey = $this->input->get('secretKey');
$data = [
"appId" => $this->input->get('appId'),
"orderId" => $this->input->get('orderId'),
"orderAmount" => $this->input->get('orderAmount'),
"returnUrl" => $this->input->get('returnUrl'),
"orderCurrency" => $this->input->get('orderCurrency'),
"orderNote" => $this->input->get('orderNote'),
"customerName" => $this->input->get('customerName'),
"customerPhone" => $this->input->get('customerPhone'),
"customerEmail" => $this->input->get('customerEmail'),
"notifyUrl" => $this->input->get('notifyUrl'),
];
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

public function zero_subscribe_plan($planid){
	$this->load->model('Subscription_model');
$data = [
'subscriber_id' => $this->session->userdata('id'),
'subscription_id' => $planid,
'type' => 1,
'token' => $this->session->userdata('chat_token'),
'args' => 'Days plan',
];
$result = $this->Subscription_model->subscribe_provider_plan($data);
$this->session->set_flashdata('success_message','Plan is successfully subscribed');
redirect(base_url().'provider-subscription');
}

public function provider_availability()
{
$this->data['page'] = 'provider_availability';
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}public function provider_accountdetails()
{
$this->data['page'] = 'provider_accountdetails';
$this->data['wallet']=$this->api->get_wallet($this->session->userdata('chat_token'));
$this->data['wallet_history']=$this->api->get_wallet_history_info($this->session->userdata('chat_token'));
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function provider_bookings()
{
$data = array();
$this->data['page'] = 'provider_bookings';
$provider_id = $this->session->userdata('id');
$status = $this->input->post('status');
$sortBy = $this->input->post('sortBy');
if(!empty($status)){
$conditions['where']['b.status']=$status;
}
$conditions['returnType'] = 'count';
$totalRec = $this->booking->getRows($conditions);
// Pagination configuration
$config['target'] = '#dataList';
$config['base_url'] = base_url('user/dashboard/ajaxPaginationData');
$config['total_rows'] = $totalRec;
$config['per_page'] = $this->perPage;
// Initialize pagination library
$this->ajax_pagination->initialize($config);
// Get records
$conditions = array(
'limit' => $this->perPage
);
$this->data['all_bookings'] = $this->booking->getRows($conditions);
// Load the list page view
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
function ajaxPaginationData(){
// Define offset
$page = $this->input->post('page');
if(!$page){
$offset = 0;
}else{
$offset = $page;
}
// Set conditions for search and filter
$status = $this->input->post('status');
$sortBy = $this->input->post('sortBy');
if(!empty($status)){
$conditions['where']['b.status']=$status;
}
// Get record count
$conditions['returnType'] = 'count';
$totalRec = $this->booking->getRows($conditions);
// Pagination configuration
$config['target'] = '#dataList';
$config['base_url'] = base_url('user/dashboard/ajaxPaginationData');
$config['total_rows'] = $totalRec;
$config['per_page'] = $this->perPage;
// Initialize pagination library
$this->ajax_pagination->initialize($config);
// Get records
$conditions = array(
'start' => $offset,
'limit' => $this->perPage
);
if(!empty($status)){
$conditions['where']['b.status']=$status;
}
$this->data['all_bookings'] = $this->booking->getRows($conditions);
// Load the data list view
$this->load->view('user/home/ajax-data', $this->data, false);
}
public function rate_review_post()
{
$review_data = $this->input->post();
$check_service_status = $this->home->check_booking_status($this->input->post('booking_id'));
if($check_service_status != '')
{
$result = $this->home->rate_review_for_service($review_data);
if($result == 1)
{
$this->session->set_flashdata('success_message','Thank you for your review');
$token=$this->session->userdata('chat_token');
$this->send_push_notification($token,$this->input->post('booking_id'),1,' Have Review The Service');
}
elseif($result == 2)
{
$this->session->set_flashdata('error_message','You have already reviewed this service');
}
else{
$this->session->set_flashdata('error_message','Booking not completed');
}
echo json_encode($result);
}
}
/*push notification*/
public function send_push_notification($token,$service_id,$type,$msg=''){
$data=$this->api->get_book_info($service_id);
if(!empty($data)){
if($type==1){
$device_tokens=$this->api->get_device_info_multiple($data['provider_id'],1);
}else{
$device_tokens=$this->api->get_device_info_multiple($data['user_id'],2);
}
if($type==2){
$user_info=$this->api->get_user_info($data['user_id'],$type);
$name=$this->api->get_user_info($data['provider_id'],1);
}else{
$name=$this->api->get_user_info($data['user_id'],2);
$user_info=$this->api->get_user_info($data['provider_id'],$type);
}
/*insert notification*/
$msg=ucfirst($name['name']).' '.strtolower($msg);
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
public function user_bookings()
{
$this->data['page'] = 'user_bookings';
$user_id = $this->session->userdata('id');
$status = $this->input->post('status');
$sortBy = $this->input->post('sortBy');
if(!empty($status)){
$conditions['where']['b.status']=$status;
}
$conditions['returnType'] = 'count';
$totalRec = $this->userbooking->getRows($conditions);
// Pagination configuration
$config['target'] = '#dataList';
$config['base_url'] = base_url('user/dashboard/userajaxPaginationData');
$config['total_rows'] = $totalRec;
$config['per_page'] = $this->perPage;
// Initialize pagination library
$this->ajax_pagination->initialize($config);
// Get records
$conditions = array(
'limit' => $this->perPage
);
$this->data['all_bookings'] = $this->userbooking->getRows($conditions);
// Load the list page view
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
function userajaxPaginationData(){
// Define offset
$page = $this->input->post('page');
if(!$page){
$offset = 0;
}else{
$offset = $page;
}
// Set conditions for search and filter
$status = $this->input->post('status');
$sortBy = $this->input->post('sortBy');
if(!empty($status)){
$conditions['where']['b.status']=$status;
}
// Get record count
$conditions['returnType'] = 'count';
$totalRec = $this->userbooking->getRows($conditions);
// Pagination configuration
$config['target'] = '#dataList';
$config['base_url'] = base_url('user/dashboard/userajaxPaginationData');
$config['total_rows'] = $totalRec;
$config['per_page'] = $this->perPage;
// Initialize pagination library
$this->ajax_pagination->initialize($config);
// Get records
$conditions = array(
'start' => $offset,
'limit' => $this->perPage
);
if(!empty($status)){
$conditions['where']['b.status']=$status;
}
$this->data['all_bookings'] = $this->userbooking->getRows($conditions);
// Load the data list view
$this->load->view('user/home/user-ajax-data', $this->data, false);
}
public function create_availability()
{ //print_r($_POST['availability']);exit;
$data['tab_ctrl']=3;
extract($_POST);
if($this->input->post()){
$check_availability=8;
foreach($_POST['availability'] as $row){
if(empty($row['from_time'])){
$check_availability--;
}
}
if($check_availability==0){
$this->session->set_flashdata('error_message','Kindly Select min one day..');
redirect(base_url().'provider-availability',$data);
}
$params = $this->input->post();
$check_provider = $this->home->provider_hours($this->session->userdata('id'));
if(empty($check_provider))
{
$result = $this->home->create_availability($params);
}
elseif(!empty($check_provider))
{
$result=$this->home->update_availability($params);
}
if($result)
{
$data=array('tab_ctrl'=>3,'success_message'=>'Availability time Created successfully');
$this->session->set_flashdata($data);
$this->session->set_flashdata('success_message','Availability time Created successfully');
redirect(base_url().'provider-availability',$data);
}
}
}
public function image_resize($width=0,$height=0,$image_url,$filename){
$source_path = base_url().$image_url;
list($source_width, $source_height, $source_type) = getimagesize($source_path);
switch ($source_type) {
case IMAGETYPE_GIF:
$source_gdim = imagecreatefromgif($source_path);
break;
case IMAGETYPE_JPEG:
$source_gdim = imagecreatefromjpeg($source_path);
break;
case IMAGETYPE_PNG:
$source_gdim = imagecreatefrompng($source_path);
break;
}
$source_aspect_ratio = $source_width / $source_height;
$desired_aspect_ratio = $width / $height;
if ($source_aspect_ratio > $desired_aspect_ratio) {
/*
* Triggered when source image is wider
*/
$temp_height = $height;
$temp_width = ( int ) ($height * $source_aspect_ratio);
} else {
/*
* Triggered otherwise (i.e. source image is similar or taller)
*/
$temp_width = $width;
$temp_height = ( int ) ($width / $source_aspect_ratio);
}
/*
* Resize the image into a temporary GD image
*/
$temp_gdim = imagecreatetruecolor($temp_width, $temp_height);
imagecopyresampled($temp_gdim,$source_gdim,0, 0,0, 0,$temp_width, $temp_height,$source_width,$source_height
);
/*
* Copy cropped region from temporary image into the desired GD image
*/
$x0 = ($temp_width - $width) / 2;
$y0 = ($temp_height - $height) / 2;
$desired_gdim = imagecreatetruecolor($width, $height);
imagecopy($desired_gdim,$temp_gdim,0, 0,$x0, $y0,$width, $height);
/*
* Render the image
* Alternatively, you can save the image in file-system or database
*/
$filename_without_extension = preg_replace('/\\.[^.\\s]{3,4}$/', '', $filename);
$image_url = "uploads/profile_img/".$filename_without_extension."_".$width."_".$height.".jpg";
imagejpeg($desired_gdim,$image_url);
return $image_url;
/*
* Add clean-up code here
*/
}
}