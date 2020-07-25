<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Country_model extends CI_Model{
	public function get_all_country_name(){
		$this->db->select("id,country_name,country_id");
		$this->db->from('country_table');
		$query = $this->db->get();
		return $query->result();
	}
	public function get_all_category(){
		$this->db->select("id,category_name");
		$this->db->from('categories');
		$this->db->where('status',1);
		$query = $this->db->get();
		return $query->result();	
	}
	public function get_subCategory($id){
		$this->db->select("id,subcategory_name");
		$this->db->from('subcategories');
		$this->db->where('category',$id);
		$query = $this->db->get();
		return $query->result();
	}
	public function getProviderById($id){
		$this->db->select('id,name,email,mobileno,country_code,category,subcategory,token');
		$this->db->from('providers');
		$this->db->where('id',$id);
		$query = $this->db->get();
		return $query->result();
	}

}