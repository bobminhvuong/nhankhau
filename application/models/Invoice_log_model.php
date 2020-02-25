<?php 
class Invoice_log_model extends CI_Model{
   public $table = 'tbl_invoice_log';
   public $primary_key = 'id';

    function getRows($params = array(),$stardate, $enddate, $store_id, $keysearch){
      if($stardate == null)
      {
        $stardate = date('Y-m-d 00:00:00');
      }
      else
      {
        $stardate = date("Y-m-d H:i:s", strtotime($stardate));
      }

      if($enddate == null)
      {
        $enddate = date('Y-m-d 23:59:59');
      }
      else
      {
        $enddate = date("Y-m-d H:i:s", strtotime($enddate));
      }
      
        $this->db->select('*, count(count_submit) as total_count');
        $this->db->from($this->table);
        $this->db->where('count_submit >=', '2');
        $this->db->where('created >=', $stardate);
        $this->db->where('created <=', $enddate);
        if($store_id != null)
        {
           $this->db->where('store_id', $store_id);
        }
        if($keysearch != null)
        {
          $this->db->like('customer_name', $keysearch);
          $this->db->or_like('customer_phone', $keysearch);
          $this->db->or_like('invoice_id', $keysearch);
        }
        $this->db->group_by("tbl_invoice_log.invoice_id");
        $this->db->order_by("total_count", "DESC");

        if(array_key_exists("id",$params)){
            $this->db->where('id',$params['id']);
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

   public function save($val)
   {
      $data = array(
      'invoice_id' => $val['invoice_id'],
      'list_products' => $val['list_products'],
      'list_services' => $val['list_services'],
      'created' => date('Y-m-d h:i:s'),
      'user_id' =>get_current_user_id(),
      'total_price'=>$val['total_price'],
      'amount_price'=>$val['amount_price'],
      'visa_price'=>$val['visa_price'],
      'store_id'=>get_current_store_id(),
      'count_submit'=>$val['count_submit'],
      'customer_name' =>$val['customer_name'],
      'customer_phone'=>$val['customer_phone']
       );
      if ($this->db->insert('tbl_invoice_log', $data)) {
          return true;
      } else {
          return false;
      }
      
   }

    //get list
   public function get_detail($invoice_id)
   {
      $query = $this->db->query("SELECT * FROM tbl_invoice_log WHERE  invoice_id = ".$invoice_id." ORDER BY id DESC limit 1 ");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
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
      $query = $this->db->query("SELECT invoice_id, user_id, created, store_id,customer_phone,customer_name, sum(count_submit) as count FROM tbl_invoice_log WHERE count_submit >= '2' GROUP BY invoice_id ORDER BY id DESC");
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
      $query = $this->db->query("SELECT * FROM tbl_invoice_log WHERE invoice_id = ".$id."");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
      }
   }

   //get list product
   public function list_products()
   {
      $query = $this->db->query("SELECT * FROM products ORDER BY id ASC");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
      }
   }

   public function product_code_end()
   {
      $query = $this->db->query("SELECT code FROM products WHERE code != 0 ORDER BY id DESC LIMIT 1");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
      }
   }

   //update
    public function update_product_code($id,$code)
    {
      $data = array('code' => $code);
      $this->db->set($data);
      $this->db->where('id', $id);

      if($this->db->update('products')) {
          return true;
      } else {
          return false;
      }

    }
 

}