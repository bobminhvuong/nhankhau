<?php 
class Stores_model extends CI_Model{
   //update
    public function update_store($val)
    {
      $data = array('invoices.store_id' => $val['store_id']);
      $this->db->set($data);
      $this->db->where('invoices.id', $val['invoice_id']);

      $this->db->update('invoices');
        
      $data_1 = array('appointments.store_id' => $val['store_id']);
      $this->db->set($data_1);
      $this->db->where('appointments.invoice_id', $val['invoice_id']);
      $this->db->update('appointments');
    }

    //get list
   public function store_lists()
   {
      $query = $this->db->query("SELECT * FROM admin_stores ORDER BY id DESC");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
      }
   }
   public function store_current($invoice_id)
   {
      $query = $this->db->query("SELECT * FROM invoices WHERE id = ".$invoice_id."");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
      }
   }
 

}