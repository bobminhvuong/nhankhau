<?php 
class Sms_model extends MY_Model {
   public $_table = 'sms';
   public $primary_key = 'sms_id';
   public $has_store_id = true;
   function insert_sms_receiver($sms_id, $phones){
   	if(!empty($phones) && is_array($phones)){
   		$phones = array_values(array_unique($phones));
   		foreach ($phones as $number) {
   			$data = array(
					'sms_id'       => $sms_id ,
					'phone_number' => $number
				);
   			$this->db->insert('sms_receiver', $data);
   		}
   	}
   }

   function get_idsms(){
      $return = array();
      $query = $this->db->query("SELECT sms_id FROM sms WHERE send_status = 0 ");
      return $query->result();
   }

   function totalSMSByStatus(){
   	$return = array();
   	$query = $this->db->query("SELECT send_status as status, COUNT(sms_id) as total FROM sms GROUP BY send_status");
   	if($query->num_rows() > 0){
   		foreach ($query->result() as $key => $value) {
   			$return[$value->status] = $value->total;
   		}
   	}
   	return $return ;
   }
}