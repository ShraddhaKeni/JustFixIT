<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Settings extends CI_Controller {

 public $data;

 public function __construct() {

  parent::__construct();

  $this->load->model('admin_model','admin');
  $this->data['theme'] = 'admin';
  $this->data['model'] = 'settings';
  $this->data['base_url'] = base_url();
  $this->load->helper('user_timezone');
  $this->data['user_role']=$this->session->userdata('role');
  $this->data['csrf'] = array(
    'name' => $this->security->get_csrf_token_name(),
    'hash' => $this->security->get_csrf_hash()
  );
}

public function index ()
{ 

 if ($this->input->post('form_submit')) {
   removeTag($this->input->post());
   $this->load->library('upload');
   $data = $this->input->post();

   if($_FILES['site_logo']['name'])
   {     
    $table_data1=[];
    $configfile['upload_path']   = FCPATH . 'uploads/logo';
    $configfile['allowed_types'] = 'gif|jpg|jpeg|png';
    $configfile['overwrite']     = FALSE;
    $configfile['remove_spaces'] = TRUE;
    $file_name                   = $_FILES['site_logo']['name'];
    $configfile['file_name']     = time().'_'.$file_name;
    $image_name = $configfile['file_name'];
    $image_url = 'uploads/logo/'.$image_name;
    $this->upload->initialize($configfile);                                
    if ($this->upload->do_upload('site_logo')) {          
      $img_uploadurl      = 'uploads/logo'.$_FILES['site_logo']['name'];      
      $key = 'logo_front';  
      $val = 'uploads/logo/'.$image_name;   
      $this->db->where('key', $key);
    }       
    $this->db->delete('system_settings');
    $table_data1['key']        = $key;
    $table_data1['value']      = strip_tags($val);
    $table_data1['system']      = 1;
    $table_data1['groups']      = 'config';
    $table_data1['update_date']  = date('Y-m-d');
    $table_data1['status']       = 1;
    $this->db->insert('system_settings', $table_data1);
  }
  if($_FILES['favicon']['name'])
  {  
    $img_uploadurl1 ='';
    $table_data2='';
    $table_data=[];
    $configfile['upload_path']   = FCPATH .'uploads/logo';
    $configfile['allowed_types'] = 'png|ico';
    $configfile['overwrite']     = FALSE;
    $configfile['remove_spaces'] = TRUE;
    $configfile['max_width']     = 50;
    $configfile['max_height']    = 50;
    $file_name                  = $_FILES['favicon']['name'];
    $configfile['file_name']    = $file_name;
    $this->upload->initialize($configfile);                   
    if ($this->upload->do_upload('favicon')) 
    { 
      
      $img_uploadurl1      = $_FILES['favicon']['name'];  
      $key                 = 'favicon';
      $val                 = $img_uploadurl1;
      $select_fav_icon     = $this->db->query("SELECT * FROM `system_settings` WHERE `key` = '$key' ");
      $fav_icon_result     = $select_fav_icon->row_array();
      
      if(count($fav_icon_result)>0)
      {
        $this->db->where('key',$key);
        $this->db->update('system_settings',array('value'=>$val));
      }
      else 
      {
        $table_data['key']        = $key;
        $table_data['value']      = strip_tags($val);           
        $this->db->insert('system_settings', $table_data);
      }
      $error = '';
    }else{
     $error = $this->upload->display_errors();
     
   }
 }
 if($data){
  $table_data=array();

        # stripe_option // 1 SandBox, 2 Live 
        # stripe_allow  // 1 Active, 2 Inactive  

  $live_publishable_key = $live_secret_key = $secret_key = $publishable_key = '';
  
  $query = $this->db->query("SELECT * FROM payment_gateways WHERE status = 1");
  $stripe_details = $query->result_array();
  if(!empty($stripe_details)){
    foreach ($stripe_details as $details) {
      if(strtolower($details['gateway_name']) == 'stripe'){
        if(strtolower($details['gateway_type'])=='sandbox'){
          
          $publishable_key    = $details['api_key'];
          $secret_key       = $details['value'];  
        }
        if(strtolower($details['gateway_type'])=='live'){
          $live_publishable_key = $details['api_key'];
          $live_secret_key    = $details['value'];
        }
      }
    }
  }
  
  
  $data['publishable_key']    = $publishable_key;
  $data['secret_key']       = $secret_key;
  $data['live_publishable_key'] = $live_publishable_key;
  $data['live_secret_key']    = $live_secret_key; 

  foreach ($data AS $key => $val) {

    if($key!='form_submit'){
      $this->db->where('key', $key);
      $this->db->delete('system_settings');
      $table_data['key']        = $key;
      $table_data['value']      = strip_tags($val);
      $table_data['system']      = 1;
      $table_data['groups']      = 'config';
      $table_data['update_date']  = date('Y-m-d');
      $table_data['status']       = 1;
      $this->db->insert('system_settings', $table_data);
      
    }
  }
}                         
$message = '';
if (!empty($error)) {
  $this->session->set_flashdata('error_message','Something wrong, Please try again');
}else{
 $this->session->set_flashdata('success_message','Settings updated successfully');  
}
redirect(base_url('admin/settings'));


}

$results = $this->admin->get_setting_list();
foreach ($results AS $config) {
  $this->data[$config['key']] = $config['value'];
}

$this->data['page'] = 'index';
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}


public function emailsettings ()
{
  if ($this->input->post('form_submit')) {

    
   removeTag($this->input->post());

   $this->load->library('upload');
   $data = $this->input->post();
   if($data){
    $table_data= array();
    foreach ($data AS $key => $val) {
      if($key!='form_submit'){
        $this->db->where('key', $key);
        $this->db->delete('system_settings');
        $table_data['key']        = $key;
        $table_data['value']      = $val;
        $table_data['system']      = 1;
        $table_data['groups']      = 'config';
        $table_data['update_date']  = date('Y-m-d');
        $table_data['status']       = 1;
        $this->db->insert('system_settings', $table_data);
        
      }
    }
  }                         
  
  
  $message='Settings saved successfully';
  $this->session->set_flashdata('success_message',$message);
  redirect(base_url('admin/emailsettings'));
}

$results = $this->admin->get_setting_list();
foreach ($results AS $config) {
  $this->data[$config['key']] = $config['value'];
}

$this->data['page'] = 'emailsettings';
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}
public function smssettings ()
{
 if ($this->input->post('form_submit')) {
  removeTag($this->input->post());
   $this->load->library('upload');
   $data = $this->input->post();
   if($data){
    $table_data= array();
   if(isset($_POST['default_otp'])){
    $data['default_otp']=1;
   }else{
    $data['default_otp']=0;
   }

    foreach ($data AS $key => $val) {
      if($key!='form_submit'){
        $this->db->where('key', $key);
        $this->db->delete('system_settings');
        $table_data['key']        = $key;
        $table_data['value']      = $val;
        $table_data['system']      = 1;
        $table_data['groups']      = 'config';
        $table_data['update_date']  = date('Y-m-d');
        $table_data['status']       = 1;
        $this->db->insert('system_settings', $table_data);
        
      }
    }
  }                         
  
  
  $message='Settings saved successfully';
  $this->session->set_flashdata('success_message',$message);
  redirect(base_url('admin/sms-settings'));
}
$results = $this->admin->get_setting_list();
foreach ($results AS $config) {
  $this->data[$config['key']] = $config['value'];
}
if(empty($this->data['default_otp'])){
  $this->data['default_otp']='';
}
$this->data['page'] = 'smssettings';
$this->load->vars($this->data);
$this->load->view($this->data['theme'].'/template');
}

public function stripe_payment_gateway() {      
 $id=settingValue('stripe_option');

 if($this->input->post('form_submit')) 
  { removeTag($this->input->post());
    if($_POST['gateway_type']=="sandbox"){
      $id=1;
    }else{
      $id=2;
    }
    $data['gateway_name'] = $this->input->post('gateway_name');
    $data['gateway_type'] = $this->input->post('gateway_type');
    $data['api_key'] = $this->input->post('api_key');
    $data['value'] = $this->input->post('value');
    $data['status'] = '1';
    $this->db->where('id',$id);
    if($this->db->update('payment_gateways',$data))
    {
      if($this->input->post('gateway_type')=='sandbox')
      {
        $datass['publishable_key']  = $this->input->post('api_key');
        $datass['secret_key']  = $this->input->post('value');
        
      }
      else
      {
        $datass['live_publishable_key'] = $this->input->post('api_key');
        $datass['live_secret_key']   = $this->input->post('value');
        
      }
      
      foreach ($datass AS $key => $val) {
        $this->db->where('key', $key);
        $this->db->delete('system_settings');
        $table_data['key']        = $key;
        $table_data['value']      = $val;
        $table_data['system']      = 1;
        $table_data['groups']      = 'config';
        $table_data['update_date']  = date('Y-m-d');
        $table_data['status']       = 1;
        $this->db->insert('system_settings', $table_data);
      }

      $message='Payment gateway edit successfully';
    }
    $this->session->set_flashdata('success_message',$message);
    redirect(base_url().'admin/stripe_payment_gateway'); 
    
  }
  if(!empty($id)){
     $this->data['list'] =  $this->admin->edit_payment_gateway($id);
   }else{
    $this->data['list'] =[];
    $this->data['list']['id']='';
    $this->data['list']['gateway_type']='';
    $this->data['gateway_type']='';
   }
 
  $this->data['page'] = 'stripe_payment_gateway';
  $this->load->vars($this->data);
  $this->load->view($this->data['theme'].'/template');
} 

public function payment_type(){ 
  if(!empty($_POST['type'])){
    $result=$this->db->where('gateway_type=',$_POST['type'])->get('payment_gateways')->row_array();
    echo json_encode($result);exit;
  }
}

public function edit($id=NULL)
{
  if($this->input->post('form_submit')) 
    { removeTag($this->input->post());
      if($_POST['gateway_type']=="sandbox"){
        $id=1;
      }else{
        $id=2;
      }
      $data['gateway_name'] = $this->input->post('gateway_name');
      $data['gateway_type'] = $this->input->post('gateway_type');
      $data['api_key'] = $this->input->post('api_key');
      $data['value'] = $this->input->post('value');
      $data['status'] = '1';
      $this->db->where('id',$id);
      if($this->db->update('payment_gateways',$data))
      { 
        if($this->input->post('gateway_type')=='sandbox')
        {
          $datass['publishable_key']  = $this->input->post('api_key');
          $datass['secret_key']  = $this->input->post('value');
          
        }
        else
        {
          $datass['live_publishable_key'] = $this->input->post('api_key');
          $datass['live_secret_key']   = $this->input->post('value');
          
        }
        $stripe_option=settingValue('stripe_option');
        if(!empty($stripe_option)){
          $this->db->where('key','stripe_option')->update('system_settings',['value'=>$id]);
        }else{
          $this->db->insert('system_settings',['key'=>'stripe_option','value'=>$id]);
        }
        
        foreach ($datass AS $key => $val) {
          $this->db->where('key', $key);
          $this->db->delete('system_settings');
          $table_data['key']        = $key;
          $table_data['value']      = $val;
          $table_data['system']      = 1;
          $table_data['groups']      = 'config';
          $table_data['update_date']  = date('Y-m-d');
          $table_data['status']       = 1;
          $this->db->insert('system_settings', $table_data);
        }

        $message='Payment gateway edit successfully';
      }
      $this->session->set_flashdata('success_message',$message);
      redirect(base_url().'admin/stripe_payment_gateway'); 
      
    }

    $this->data['list'] =  $this->admin->edit_payment_gateway($id);
    $this->data['page'] =    'stripe_payment_gateway_edit';
    $this->load->vars($this->data);
    $this->load->view($this->data['theme'].'/template');
    
  }





  
}
