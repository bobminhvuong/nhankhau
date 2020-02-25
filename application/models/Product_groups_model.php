<?php 
class Product_groups_model extends CI_Model{
   public $_table = 'product_groups';
   public $primary_key = 'group_id';

    function getRows($params = array()){
        $this->db->select('*');
        $this->db->from('depot_stores');
        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['group_id']);
            $query = $this->db->get();
            $result = $query->row_array();
        }else{
            //set start and limit
            if(array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit'],$params['start']);
            }elseif(!array_key_exists("start",$params) && array_key_exists("limit",$params)){
                $this->db->limit($params['limit']);
            }
            
            if(array_key_exists("returnType",$params) && $params['returnType'] == 'count'){
                $result = $this->db->count_all_results();
            }else{
                $query = $this->db->get();
                $result = ($query->num_rows() > 0)?$query->result_array():FALSE;
            }
        }
        //return fetched data
        return $result;
    }

   public function insert_groups($val)
   {
      $data = array(
      'name' => $val['name'],
      'active' => $val['active'],
      'created' => date('Y-m-d h:i:s'),
      'user_id' =>get_current_user_id(),
      'description' =>$val['description']
       );
      //$this->db->insert('product_groups', $data);
      if ($this->db->insert('product_groups', $data)) {
          return true;
          //echo json_encode(array('status' => 'Success', 'message' =>'addnew'));
      } else {
          return false;
          //echo json_encode(array('status' => 'Error', 'message' =>'Error'));
      }
   }

   //update
    public function update($val)
    {
      $data = array(
      'name' => $val['name'],
      'active' => $val['active'],
      'created' => date('Y-m-d h:i:s'),
      'user_id' =>get_current_user_id(),
      'description' =>$val['description']
       );

      $this->db->set($data);
      $this->db->where('group_id', $val['id']);

      if ($this->db->update('product_groups')) {
          return true;
      } else {
          return false;
      }

    }

    //get list
   public function get_lists()
   {
      $query = $this->db->query("SELECT * FROM product_groups ORDER BY group_id DESC");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
      }
   }

   public function details($id)
   {
      $query = $this->db->query("SELECT * FROM product_groups WHERE group_id = ".$id."");
      if($query->num_rows() > 0)
      {
        return $query->row();
      }
      else
      {
        return null;
      }
   }
 

}