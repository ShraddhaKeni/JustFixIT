<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct() {

    parent::__construct();
    $this->load->model('dropdowns_model','dropdown');
    $this->data['csrf'] = array(
    		'name' => $this->security->get_csrf_token_name(),
    		'hash' => $this->security->get_csrf_hash()
     	);
    $this->load->helper('url');
  	}

	public function index()
	{
		   $this->load->helper('url');
		  $this->load->model('dropdowns_model');
   		  $data['generic'] = $this->dropdowns_model->get_generic();// same as foreach in view <?php foreach ($generic as $crows)
   		  $this->load->view('welcome_message', $data);
	}

	function get_category()
	{
		 echo "Hi"; 
		/* $this->load->model('dropdowns_model');
		if($this->input->post('generic_id'))
		{
			$data['category'] = $this->dropdowns_model->get_category($this->input->post('generic_id'));
			$this->load->view('welcome_message', $data);
		}*/
	}

}
