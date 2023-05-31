<?php
if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class dropdowns_model extends CI_Model
{

	 function __construct() { 
        // Set table name 
        $this->table = 'generic'; 
    } 
     
 public function get_generic()
  {
    $this->db->select('g.id,g.generic_name');
    $this->db->from('generic g');
    $this->db->where('g.status',1);
    $result = $this->db->get()->result_array();
    return $result;
  }

  public function get_category1()
  {
    echo"<script>alert('Hi SK')</script>";
    $this->db->select('c.id,c.category_name');
    $this->db->from('categories c');
    $this->db->where('c.generic_id',$id);
    $result = $this->db->get()->result_array();
    return $result;
  }
		
}
?>
