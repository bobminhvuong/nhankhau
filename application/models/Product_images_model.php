<?php 

class Product_images_model extends MY_Model {
	public $table = 'product_images';
	public $id = 'id';

    public function get_avatar($id)
    {
      $query = $this->db->query("SELECT * FROM $this->table WHERE product_id = '".$id."' and main = 1 ");
      if($query->num_rows() > 0)
      {
        return $query->result();
      }
      else
      {
        return null;
      }
    }

  //get list images
    public function get_images($id)
    {
     $query = $this->db->query("SELECT * FROM $this->table WHERE product_id = '".$id."' and main = 0 ");
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