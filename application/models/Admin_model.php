<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}
  public function is_valid_login($username,$password)
  {
    $password = md5($password);
    $this->db->select('user_id, profile_img,token,role');
    $this->db->from('administrators');
		$this->db->where('username',$username);
		$this->db->where('password',$password);
		$this->db->where_in('role',[1,2]);
	  $result = $this->db->get()->row_array();
    return $result;
  }

    public function admin_details($user_id)
	{
		$results = array();
		$results = $this->db->get_where('administrators',array('user_id'=>$user_id))->row_array();
		return $results;
	}

	public function update_profile($data)
	  {
			$user_id = $this->session->userdata('admin_id');
	    $results = $this->db->update('administrators', $data, array('user_id'=>$user_id));
	    return $results;
	  }

		public function change_password($user_id,$confirm_password,$current_password)
		{

	        $current_password = md5($current_password);
	        $this->db->where('user_id', $user_id);
	        $this->db->where(array('password'=>$current_password));
	        $record = $this->db->count_all_results('administrators');

	        if($record > 0){

	          $confirm_password = md5($confirm_password);
	          $this->db->where('user_id', $user_id);
	          return $this->db->update('administrators',array('password'=>$confirm_password));
	        }else{
	          return 2;
	        }
		}

		public function get_setting_list() {
        $data = array();
        $stmt = "SELECT a.*"
                . " FROM system_settings AS a"
                . " ORDER BY a.`id` ASC";
        $query = $this->db->query($stmt);
        if ($query->num_rows()) {
            $data = $query->result_array();
        }
        return $data;
    }

    public function edit_payment_gateway($id)
    {
        $query = $this->db->query(" SELECT * FROM `payment_gateways` WHERE `id` = $id ");
        $result = $query->row_array();
        return $result;
    }

     public function all_payment_gateway()
    {
      $this->db->select('*');
        $this->db->from('payment_gateways');
        $query = $this->db->get();
        return $query->result_array();         
    }

        public function categories_list()
		{
			return $this->db->get('categories')->result_array();
		}

		public function categories_list_filter($category,$from_date,$to_date){

			        if(!empty($from_date)) {
					$from_date=date("Y-m-d", strtotime($from_date));
					}else{
					$from_date='';
					}
					if(!empty($to_date)) {
					$to_date=date("Y-m-d", strtotime($to_date));
					}else{
					$to_date='';
					}
					$this->db->select('*');
					$this->db->from('categories');
					if(!empty($from_date)){
						$this->db->where('date(created_at) >=',$from_date);
					}
					if(!empty($to_date)){
						$this->db->where('date(created_at) <=',$to_date);
					}
					if(!empty($category)){
					$this->db->where('id',$category);
					}
					return $this->db->get()->result_array();

		}

		/*subcategory filter*/
		public function subcategory_filter($category,$subcategory,$from,$to){
				
					if(!empty($from)) {
					$from_date=date("Y-m-d", strtotime($from));
					}else{
					$from_date='';
					}
					if(!empty($to)) {
					$to_date=date("Y-m-d", strtotime($to));
					}else{
					$to_date='';
					}

			        $this->db->select('s.*,c.category_name');
					$this->db->from('subcategories s');
					$this->db->join('categories c', 'c.id = s.category', 'left');
					if(!empty($from_date)){
						$this->db->where('date(s.created_at) >=',$from_date);
					}
					if(!empty($to_date)){
						$this->db->where('date(s.created_at) <=',$to_date);
					}
					if(!empty($category)){
						$this->db->where('s.category',$category);
					}
					if(!empty($subcategory)){
						$this->db->where('s.id',$subcategory);
					}
					return $this->db->get()->result_array();

		}

		public function subcategories_list()
		{
					$this->db->select('s.*,c.category_name');
					$this->db->from('subcategories s');
					$this->db->join('categories c', 'c.id = s.category', 'left');
			return $this->db->get()->result_array();
		}
		public function search_catsuball($category,$subcategory)
		{
			$this->db->select('s.*,c.category_name');
			$this->db->from('subcategories s');
			$this->db->join('categories c', 'c.id = s.category', 'left');
			return $this->db->where(array('s.id'=>$category,'c.id'=>$subcategory,'s.status'=>1))->get()->result_array();
		}

		public function search_subcategory($subcategory)
		{
			$this->db->select('s.*,c.category_name');
			$this->db->from('subcategories s');
			$this->db->join('categories c', 'c.id = s.category', 'left');
			return $this->db->where(array('c.id'=>$subcategory,'s.status'=>1))->get()->result_array();
		}

		public function search_category($category)
		{
			$this->db->select('s.*,c.category_name');
			$this->db->from('subcategories s');
			$this->db->join('categories c', 'c.id = s.category', 'left');
			return $this->db->where(array('c.id'=>$category,'s.status'=>1))->get()->result_array();
		}
		
        public function categories_details($id)
		{
			return $this->db->get_where('categories',array('id'=>$id))->row_array();
		}

		public function subcategories_details($id)
		{
			return $this->db->get_where('subcategories',array('id'=>$id))->row_array();
		}
}
?>
