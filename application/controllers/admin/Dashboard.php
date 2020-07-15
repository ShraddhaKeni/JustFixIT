<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->data['theme'] = 'admin';
        $this->data['model'] = 'dashboard';
        $this->load->model('dashboard_model','dashboard');
        $this->data['base_url'] = base_url();
        $this->load->helper('user_timezone');
    }

	public function index()
	{
      $this->data['page'] = 'index';
      $this->data['payment']= $this->dashboard->get_payments_info();
  		$this->load->vars($this->data);
  		$this->load->view($this->data['theme'].'/template');
	

	}
  public function admin_notification($value='')
  {
     $this->data['page'] = 'admin_notification';
    $this->data['admin_notification']=$this->db->where('n.receiver',$this->session->userdata('chat_token'))->where('n.status',1)->from('notification_table as n')->join('providers as p ','p.token=n.sender')->select('n.notification_id,n.message,n.created_at,p.name,p.profile_img,n.utc_date_time')->get()->result_array();
     $notification_update=$this->db->where('receiver',$this->session->userdata('chat_token'))->update('notification_table',['status'=>0]);
     $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
  }


  public function map_list()
  {
      $this->data['page'] = 'map_list';
      $this->data['map']= $this->dashboard->get_payments_info();
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
  }

  public function service_map_list(){

  $this->db->select('tab_2.name,tab_1.service_latitude,tab_1.service_longitude,tab_1.service_title')->from('services tab_1');
  $val=$this->db->join('providers tab_2','tab_2.id=tab_1.user_id','LEFT')->get()->result_array();

  if(!empty($val)){

    $result_json = [];

    foreach ($val as $key => $value) {
      $temp = $temp2 = [];
      $temp2[] = $value["service_latitude"];
      $temp2[] = $value["service_longitude"];

      $temp['latLng'] = $temp2;
      $temp['name'] = $value['name'];

      $result_json[] = $temp;
    
    }

  }

  $data=json_encode($result_json);
  print($data);
  }

  public function users($value='')
  {
      $this->data['page'] = 'users';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
  }

   public function user_details($value='')
  {
      $this->data['page'] = 'user_details';
      $this->load->vars($this->data);
      $this->load->view($this->data['theme'].'/template');
  }


  public function users_list($value='')
  {
    extract($_POST);
    
      if($this->input->post('form_submit'))
      {
        $this->data['page'] = 'users';
        $username = $this->input->post('username');
        $email = $this->input->post('email');
        $from = $this->input->post('from');
        $to = $this->input->post('to');
        $this->data['lists'] = $this->dashboard->user_filter($username,$email,$from,$to);
        $this->load->vars($this->data);
        $this->load->view($this->data['theme'].'/template');

      }
      else
      {
        $lists = $this->dashboard->users_list();
      
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
              $row[]  = '<h2 class="table-avatar"><a href="#" class="avatar avatar-sm mr-2"> <img class="avatar-img rounded-circle" alt="" src="'.$profile_img.'"></a>
                        <a href="'.base_url().'user-details/'.$template->id.'">'.str_replace('-', ' ', $template->name).'</a></h2>';
             
              $row[]  = $template->email;
               $row[]  = $template->mobileno;
              $created_date='-';
              if (isset($template->last_login)) {
                 if (!empty($template->last_login) && $template->last_login != "0000-00-00 00:00:00") {
                   $date_time = $template->last_login;
                   $date_time = ($date_time);
                   $created_date = date("d M Y", strtotime($date_time));
                 }
               }
               $created_at='-';
              if (isset($template->created_at)) {
                 if (!empty($template->created_at) && $template->created_at != "0000-00-00 00:00:00") {
                   $date_time = $template->created_at;
                   $date_time = ($date_time);
                   $created_at = date("d M Y", strtotime($date_time));
                 }
               }
              $row[]  = $created_at;
              $row[]  = $created_date;

              if($template->status==1)
              {
                $val='checked';
              }
              else
              {
                $val='';
              }

              if($template->type==1)
              {
                  $row[] ='';
              }
              else
              {
                $row[] ='<div class="status-toggle"><input id="status_'.$template->id.'" class="check change_Status_user" data-id="'.$template->id.'" type="checkbox" '.$val.'><label for="status_'.$template->id.'" class="checktoggle">checkbox</label></div>';
			}

               
              
              $data[] = $row; 
        }

        $output = array(
                        "draw" => $_POST['draw'],
                        "recordsTotal" => $this->dashboard->users_list_all(),
                        "recordsFiltered" => $this->dashboard->users_list_filtered(),
                        "data" => $data,
                );
        echo json_encode($output);
      }

  
  }

   public function change_rating()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('rating_type',array('status' =>$status));
  }
  
   public function change_subcategory()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('subcategories',array('status' =>$status));
  }

   public function change_category()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('categories',array('status' =>$status));
  }

     public function change_Status()
  {
    $id=$this->input->post('id');
    $status=$this->input->post('status');

    $this->db->where('id',$id);
    $this->db->update('users',array('status' =>$status));
  }

 
}

?>
