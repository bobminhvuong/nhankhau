<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Store extends CI_Controller {
	public function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');

    }
	public function index()
	{

		$stores = $this->db->get_where('admin_stores', 
			array(
				'id !=' => 5,
				'id !=' => 8 
			)
		)->result();

		if($this->input->post('submit')){
			$session = array(
			    'store' => $this->input->post('store')
			);
			$this->session->set_userdata($session);
			$nation_id = $this->db->get_where('admin_stores', array('id'=>$this->input->post('store')))->result()[0]->nation_id;
			$this->session->set_userdata(array('nation'=>$nation_id));
		}

		if($this->session->userdata('store')){
			$store_id = $this->session->userdata('store');
			$nation_id = $this->session->userdata('nation');
		}else{
			$store_id = $nation_id =  0 ;
		}	

		$this->load->view('store', array('stores' => $stores, 'store_id' => $store_id, 'nation_id' => $nation_id));
	}
}

