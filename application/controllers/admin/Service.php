<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Service extends CI_Controller {

 public $data;

 public function __construct() {

  parent::__construct();
  $this->load->model('service_model','service');
  $this->data['theme'] = 'admin';
  $this->data['model'] = 'service';
  $this->data['base_url'] = base_url();
  $this->session->keep_flashdata('error_message');
  $this->session->keep_flashdata('success_message');
  $this->load->helper('user_timezone_helper');
  $this->data['user_role']=$this->session->userdata('role');
}

public function index()
{
  redirect(base_url('subscriptions'));
}
public function subscriptions()
{
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'subscriptions';
    $this->data['model'] = 'service';
    $this->data['list'] = $this->service->subscription_list();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
   redirect(base_url()."admin");
 }
}

public function add_subscription()
{
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'add_subscription';
    $this->data['model'] = 'service';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
   redirect(base_url()."admin");
 }

}

public function check_subscription_name()
{
  $subscription_name = $this->input->post('subscription_name');
  $id = $this->input->post('subscription_id');
  if(!empty($id))
  {
    $this->db->select('*');
    $this->db->where('subscription_name', $subscription_name);
    $this->db->where('id !=', $id);
    $this->db->from('subscription_fee');
    $result = $this->db->get()->num_rows();
  }
  else
  {
    $this->db->select('*');
    $this->db->where('subscription_name', $subscription_name);
    $this->db->from('subscription_fee');
    $result = $this->db->get()->num_rows();
  }
  if ($result > 0) {
    $isAvailable = FALSE;
  } else {
    $isAvailable = TRUE;
  }
  echo json_encode(
    array(
      'valid' => $isAvailable
    ));
}

public function save_subscription()
{ 
  //echo "here into save"; exit;
  removeTag($this->input->post());
  $data['subscription_name'] = $this->input->post('subscription_name');
  $data['fee'] = $this->input->post('amount');
  $data['discount'] = $this->input->post('discount_per');
  $data['actual_amount'] =  $this->input->post('subscription_amount');
  $data['currency_code'] = 'USD';
  $data['duration'] = $this->input->post('duration');
  $data['fee_description'] = $this->input->post('subscription_description');
  $data['status'] = $this->input->post('status');
  $result = $this->db->insert('subscription_fee', $data);
  if(!empty($result))
  {
   $this->session->set_flashdata('success_message','Subscription added successfully');
   redirect(base_url().'subscriptions');
 }
 else
 {
  $this->session->set_flashdata('error_message','Something wrong, Please try again');
  echo 2;
}
}

public function edit_subscription($id)
{
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'edit_subscription';
    $this->data['model'] = 'service';
    $this->data['subscription'] = $this->service->subscription_details($id);
    //echo "<pre>"; print_r($this->data); exit;
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
  }
  else {
   redirect(base_url()."admin");
 }
}

public function update_subscription()
{ removeTag($this->input->post());
  $where['id'] = $this->input->post('subscription_id');
  $data['subscription_name'] = $this->input->post('subscription_name');
  $data['fee'] = $this->input->post('amount');
  $data['discount'] = $this->input->post('discount_per');
  $data['actual_amount'] =  $this->input->post('subscription_amount');
  $data['currency_code'] = 'USD';
  $data['duration'] = $this->input->post('duration');
  $data['fee_description'] = $this->input->post('subscription_description');
  $data['status'] = $this->input->post('status');
  //echo "<pre>"; print_r($data); exit;
  $result = $this->db->update('subscription_fee', $data, $where);
  if(!empty($result))
  {
   $this->session->set_flashdata('success_message','Subscription updated successfully');
   redirect(base_url().'subscriptions');
 }
 else
 {
  $this->session->set_flashdata('error_message','Something wrong, Please try again');
  echo 2;
}
}
public function service_providers(){
  $this->data['page'] = 'service_providers';
  $this->data['subcategory']=$this->service->get_subcategory();
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function getSubcategory($id){
  $this->load->model('Country_model');
  $subcategory = $this->Country_model->get_subCategory($id);
  echo json_encode($subcategory);
}

public function add_service_providers(){
  $this->load->model('Country_model');
  $countries = $this->Country_model->get_all_country_name();
  $categories = $this->Country_model->get_all_category();
  $this->data['page'] = 'add_service_providers';
  $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
);
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template',['countries'=>$countries,'csrf'=>$csrf,'categories'=>$categories]);
}

public function edit_service_providers($id){
  $this->load->model('Country_model');
  $countries = $this->Country_model->get_all_country_name();
  $categories = $this->Country_model->get_all_category();
  $provider = $this->Country_model->getProviderById($id);
  //echo "<pre>"; print_r($provider); exit;
  $this->data['page'] = 'edit_service_providers';
  $csrf = array(
        'name' => $this->security->get_csrf_token_name(),
        'hash' => $this->security->get_csrf_hash()
  );
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template',['countries'=>$countries,'csrf'=>$csrf,'categories'=>$categories,'provider'=>$provider]);
}

public function delete_service_providers($id){
  $this->load->model('Admin_model');
  echo $this->Admin_model->delete_provider($id);
}

public function save_provider(){
  $data = $this->input->post();
  $data['token'] = $this->security->get_csrf_hash();
  $data['created_at'] = date('Y-m-d H:i:s');
  $data['updated_at'] = date('Y-m-d H:i:s');
  $data['otp'] = '1234';
  $this->load->model('Admin_model');
  if(($data['category']!='')  && ($data['subcategory']!='') && ($data['name']!='') && ($data['email']!='') && ($data['country_code']!='') && ($data['mobileno']!='')){
      $this->Admin_model->save_provider($data);
      $this->session->set_flashdata('success_message','Value added successfully');
      redirect('service-providers');  
  }else{
      $this->session->set_flashdata('error_message','Something wrong, Value not added successfully');
      redirect(base_url().'add-service-providers');
  }  
}

public function update_provider($id){
  $data = $this->input->post();
  $data['updated_at'] = date('Y-m-d H:i:s');
  $this->load->model('Admin_model');
  $this->Admin_model->update_provider($id,$data);
  redirect('service-providers');
}

public function provider_details($value='')
{
  $this->data['page'] = 'provider_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

public function provider_list()
{
  extract($_POST);
  if($this->input->post('form_submit'))
  {

    $this->data['page'] = 'service_providers';
    $username = $this->input->post('username');
    $email = $this->input->post('email'); 
    $from = $this->input->post('from');
    $to = $this->input->post('to');
    $subcategory=$this->input->post('subcategory');
    $this->data['lists'] = $this->service->provider_filter($username,$email,$from,$to,$subcategory);
    $this->data['subcategory']=$this->service->get_subcategory();
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');

  }
  else
  {
   $lists = $this->service->provider_list();

   $data = array();
   $no = $_POST['start'];
   foreach ($lists as $template) {

     $no++;
     $row    = array();
     $row[]  = $no;
     $profile_img = $template->profile_img;
     if(empty($profile_img)){
      $profile_img = 'assets/img/user.jpg';
    }
    $row[]  = '<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" alt="" src="'.$profile_img.'"></a><a href="'.base_url().'provider-details/'.$template->id.'">'.$template->name.'</a></h2>';
    $row[]  = $template->mobileno;
    $row[]  = $template->email;
    $created_at='-';
    if (isset($template->created_at)) {
     if (!empty($template->created_at) && $template->created_at != "0000-00-00 00:00:00") {
      $date_time = $template->created_at;
      $date_time = utc_date_conversion($date_time);
      $created_at = date("d M Y", strtotime($date_time));
    }
  }
  $row[]  = $created_at;
  $row[]  = $template->subscription_name;
  $val = '';
  
  $status = $template->status;
  $delete_status = $template->status;
  if($status == 2)
  {
    $val = '';
  }
  elseif($status == 1)
  {
    $val = 'checked';
  }
  if($template->is_verified==0){
    $row[]='Not Verified';

  }else{
    $row[]='Verified';
  }
  $row[]='<a href="'.base_url().'edit-service-providers/'.$template->id.'" class="btn btn-sm bg-success-light" title="Edit" data-id="'.$template->id.'"><i class="far fa-edit mr-1"></i> Edit</a>

  <a href="javascript:void(0)" data-id="'.$template->id.'" class="btn btn-sm bg-danger-light delete_provider" title="Delete" data-id="'.$template->id.'"><i class="far fa-trash mr-1"></i> Delete</a>

  ';

  $data[] = $row;
}

$output = array(
  "draw" => $_POST['draw'],
  "recordsTotal" => $this->service->provider_list_all(),
  "recordsFiltered" => $this->service->provider_list_filtered(),
  "data" => $data,
);
echo json_encode($output);
}


}

public function service_list()
{
 extract($_POST);
 
 $this->data['page'] = 'service_list';

 if ($this->input->post('form_submit')) 
 {  
   $service_title = $this->input->post('service_title');
   $category = $this->input->post('category');
   $subcategory = $this->input->post('subcategory');
   $from = $this->input->post('from');
   $to = $this->input->post('to');
   $this->data['list'] =$this->service->service_filter($service_title,$category,$subcategory,$from,$to);
 }
 else
 {
  $this->data['list'] = $this->service->service_list();
}
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');

}

public function service_details($value='')
{
  $this->data['page'] = 'service_details';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
}

/*change service list */
public function change_Status_service_list(){
  $id=$this->input->post('id');
  $status=$this->input->post('status');

  if($status==0){
    $avail=$this->service->check_booking_list($id);
    if($avail==0){
      $this->db->where('id',$id);
      if($this->db->update('services',array('status' =>$status))){
        echo "success";
      }else{
        echo "error";
      }
    }else{
      echo "1";
    }
  }else{
    $this->db->where('id',$id);
    if($this->db->update('services',array('status' =>$status))){
      echo "success";
    }else{
      echo "error";
    }
  }
}

public function change_Status()
{
  $id=$this->input->post('id');
  $status=$this->input->post('status');

  $this->db->where('id',$id);
  $this->db->update('providers',array('status' =>$status));
}
public function delete_provider()
{
  $id=$this->input->post('id');
  $data=array('delete_status'=>1);
  $this->db->where('id',$id);
  
  if($this->db->update('providers',$data))
  {
    echo 1;
  }
}
public function change_verified(){
  $input_data=$this->input->post();
  $is_verified = $input_data['is_verified'];
  $provider_id = $input_data['provider_id'];
  $this->db->where('id',$provider_id);
  $this->db->update('providers',array('is_verified' =>$is_verified));
}
public function service_requests()
{
  if($this->session->userdata('admin_id'))
  {
    $this->data['page'] = 'service_requests';
    $this->data['model'] = 'service';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');		
  }
  else {
   redirect(base_url()."admin");
 }
}

public function request_list()
{
 $lists = $this->service->request_list();
 $data = array();
 $no = $_POST['start'];
 foreach ($lists as $template) {
   $no++;
   $row    = array();
   $row[]  = $no;
   $profile_img = $template['profile_img'];
   if(empty($profile_img)){
    $profile_img = 'assets/img/user.jpg';
  }
  $row[]  = '<a href="#" class="avatar"> <img alt="" src="'.$profile_img.'"></a><h2><a href="#">'.$template['username'].'</a></h2>';
  $row[]  = $template['contact_number'];
  $row[]  = $template['title'];
  $row[]  = '<p class="price-sup"><sup>RM</sup>'.$template['proposed_fee'].'</p>';
  $row[]  = '<span class="service-date">'.date("d M Y", strtotime($template['request_date'])).'<span class="service-time">'.date("H.i A", strtotime($template['request_time'])).'</span></span>';
  $row[]  = date("d M Y", strtotime($template['created']));
  $val = '';
  $status = $template['status'];
  if($status == -1)
  {
    $val = '<span class="label label-danger-border">Expired</span>';
  }
  if($status == 0)
  {
    $val = '<span class="label label-warning-border">Pending</span>';
  }
  elseif($status == 1)
  {
    $val = '<span class="label label-info-border">Accepted</span>';
  }
  elseif($status == 2)
  {
    $val = '<span class="label label-success-border">Completed</span>';
  }
  elseif($status == 3)
  {
    $val = '<span class="label label-danger-border">Declined</span>';
  }
  elseif($status == 4)
  {
    $val = '<span class="label label-danger-border">Deleted</span>';
  }
  $row[]  = $val;
  $data[] = $row;
}

$output = array(
  "draw" => $_POST['draw'],
  "recordsTotal" => $this->service->request_list_all(),
  "recordsFiltered" => $this->service->request_list_filtered(),
  "data" => $data,
);

        //output to json format
echo json_encode($output);

}

public function delete_service()
{
  $id=$this->input->post('service_id');

  $inputs['status']= '0';
  $WHERE =array('id' => $id);
  $result=$this->service->update_service($inputs,$WHERE);


  if($result)
  {
   $this->session->set_flashdata('success_message','Service deleted successfully');    
   redirect(base_url()."service-list");   
 }
 else
 {
  $this->session->set_flashdata('error_message','Something wrong, Please try again');
  redirect(base_url()."service-list");   

} 
}
}
