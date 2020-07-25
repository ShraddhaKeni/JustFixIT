<?php
	defined('BASEPATH') OR exit('No direct script access allowed');

	class Subscription_model extends CI_Model {

		public function __construct() {

	        parent::__construct();
	        $this->load->database();
	        date_default_timezone_set('UTC');
	    }

		public function get_subscription_list()
    {
      return $this->db->get_where('subscription_fee',array('status'=>1))->result_array();
    }
    public function get_subscription($id)
		{
			return $this->db->get_where('subscription_fee',array('status'=>1,'id'=>$id))->row_array();
		}

		public function get_my_subscription()
		{
			$user_id = $this->session->userdata('id');
			return $this->db->get_where('subscription_details',array('subscriber_id'=>$user_id))->row_array();
		}

		public function subscription_success($inputs)
     {

       $new_details = array();
			 $stripe = array();

       $user_id = $inputs['user_id'];

       $subscription_id = $inputs['subscription_id'];
       $this->db->select('duration');
       $record = $this->db->get_where('subscription_fee',array('id'=>$subscription_id))->row_array();       
       if(!empty($record)){
       $duration = $record['duration'];
       $days = 30;
       switch ($duration) {
         case 1:
           $days = 30;
           break;
         case 2:
           $days = 60;
           break;
         case 3:
           $days = 90;
           break;
         case 6:
           $days = 180;
           break;
         case 12:
           $days = 365;
           break;
         case 24:
           $days = 730;
           break;

         default:
           $days = 30;
           break;
       }

        $subscription_date = date('Y-m-d H:i:s');
        $expiry_date_time =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subscription_date)) ." +".$days."days"));


       $new_details['subscriber_id'] = $stripe['subscriber_id'] = $user_id;
       $new_details['subscription_id'] = $stripe['subscription_id'] = $subscription_id;
       $new_details['subscription_date'] = $stripe['subscription_date'] = $subscription_date;
       $new_details['expiry_date_time'] = $expiry_date_time;
       $new_details['type']=1;  
			 $this->db->where('subscriber_id', $user_id);
       $count = $this->db->count_all_results('subscription_details');
       if($count == 0){
       $this->db->insert('subscription_details', $new_details);
       $this->db->insert('subscription_details_history', $new_details);
			 $stripe['sub_id'] = $this->db->insert_id();

       }else{

         $this->db->where('subscriber_id', $user_id);
        $this->db->update('subscription_details', $new_details);
          $this->db->insert('subscription_details_history', $new_details);
				 $this->db->where('subscriber_id', $user_id);
       $details_sub = $this->db->get('subscription_details')->row_array();
 			 $stripe['sub_id'] = $details_sub['id'];
       }
			 $stripe['tokenid'] = $inputs['token'];
			 $stripe['payment_details'] = $inputs['args'];
				return $this->db->insert('subscription_payment', $stripe);

     }else{

      return false;
     }

     }

     public function tempOrder($tempOrder){
      $this->db->insert('temporder',$tempOrder);
     }
     public function getTempOrder($id){
      $this->db->select('*');
      $this->db->from('temporder');
      $this->db->where('orderid',$id);
      $query = $this->db->get();
      return $query->result(); 
     }

     public function subscribe_provider_plan($inputs){
         $new_details = array();
         $stripe = array();

         $user_id = $inputs['subscriber_id'];

         $subscription_id = $inputs['subscription_id'];
         $this->db->select('duration');
         $record = $this->db->get_where('subscription_fee',array('id'=>$subscription_id))->row_array();       
         if(!empty($record)){
         $duration = $record['duration'];
         $days = 30;
         switch ($duration) {
           case 1:
             $days = 30;
             break;
           case 2:
             $days = 60;
             break;
           case 3:
             $days = 90;
             break;
           case 6:
             $days = 180;
             break;
           case 12:
             $days = 365;
             break;
           case 24:
             $days = 730;
             break;

           default:
             $days = 30;
             break;
         }

          $subscription_date = date('Y-m-d H:i:s');
          $expiry_date_time =  date('Y-m-d H:i:s',strtotime(date("Y-m-d  H:i:s", strtotime($subscription_date)) ." +".$days."days"));
         $new_details['subscriber_id'] = $stripe['subscriber_id'] = $user_id;
         $new_details['subscription_id'] = $stripe['subscription_id'] = $subscription_id;
         $new_details['subscription_date'] = $stripe['subscription_date'] = $subscription_date;
         $new_details['expiry_date_time'] = $expiry_date_time;
         $new_details['free_service'] = 'No';
         $new_details['type']=$inputs['type'];

         $new_details_history['subscriber_id'] = $stripe['subscriber_id'] = $user_id;
         $new_details_history['subscription_id'] = $stripe['subscription_id'] = $subscription_id;
         $new_details_history['subscription_date'] = $stripe['subscription_date'] = $subscription_date;
         $new_details_history['expiry_date_time'] = $expiry_date_time;
         $new_details_history['type']=$inputs['type'];  
         // $this->db->where('subscriber_id', $user_id);
         // $count = $this->db->count_all_results('subscription_details');
         
         $this->db->insert('subscription_details', $new_details);
         $this->db->insert('subscription_details_history', $new_details_history);
         $stripe['sub_id'] = $this->db->insert_id();

         
         $stripe['tokenid'] = $inputs['token'];
         $stripe['payment_details'] = $days.' '.$inputs['args'];
          return $this->db->insert('subscription_payment', $stripe);

       }else{

        return false;
       }
     }

}
