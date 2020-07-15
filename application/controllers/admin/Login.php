<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login extends CI_Controller {

   public $data;

   public function __construct() {

        parent::__construct();
        $this->load->model('admin_model','admin');
        $this->data['theme'] = 'admin';
        $this->data['model'] = 'login';
        $this->data['base_url'] = base_url();
        $this->load->helper('form');
        $this->data['csrf'] = array(
	    'name' => $this->security->get_csrf_token_name(),
	    'hash' => $this->security->get_csrf_hash()
	    );
    }


	public function index()
	{
	    if (empty($this->session->userdata['admin_id']))
	    {
	    	$this->load->vars($this->data);
	    	$this->load->view($this->data['theme'] . '/include/header');
		    $this->load->view($this->data['theme'].'/'.$this->data['model'].'/login');
	  		$this->load->view($this->data['theme'] . '/include/footer');
	    }
	    else {
	      redirect(base_url()."dashboard");
	    }
	}

  public function is_valid_login()
	{ 
		$username = $this->input->post('username');
		$password = $this->input->post('password');
		$result = $this->admin->is_valid_login($username,$password);

		if(!empty($result))
		{
			$this->session->set_userdata('admin_id',$result['user_id']);
  		$this->session->set_userdata('admin_profile_img',$result['profile_img']);
  		$this->session->set_userdata('chat_token',$result['token']);
  		$this->session->set_userdata('role',$result['role']);

			echo 1;
		}
	 else
		{
    $this->session->set_flashdata('error_message','Wrong login credentials.');
			echo 2;
		}
	}

	
 	public function logout()
	{
	    if (!empty($this->session->userdata['admin_id']))
	    {
	      $this->session->unset_userdata('admin_id');
	    }
	    $this->session->set_flashdata('success_message','Logged out successfully');
			redirect(base_url()."admin");
    }

}
