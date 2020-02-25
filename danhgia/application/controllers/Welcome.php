<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */
	 public function __construct(){

        parent::__construct();
        $this->load->database();
        $this->load->helper('url');
        $this->load->database();
        $this->load->library('session');

    }
	public function index()
	{
		if($this->session->userdata('store')){
			$store_id = $this->session->userdata('store');
		}else{
			$store_id = 0 ;
		}	
		$admin_store = $this->db->get_where('admin_stores', array('id' => $store_id))->row(); 
		if($admin_store){
			$rate = $this->db->get_where('rates', array('id' => $admin_store->rate_id))->row();
			if($rate){
				$this->load->view('wait');
			}else{
				$invoice = $this->db->get_where('invoices', array('id' => $admin_store->rate_id))->row();
				if($invoice){
					$data = array(
						'invoice' => $invoice,
						'customer' => $this->db->get_where('customers', array('id' => $invoice->customer_id))->row()
					);
					$this->load->view('index', $data);
				}else{
					$this->load->view('wait');
				}
			}
		}else{
			$this->load->view('wait');
		}

		if($this->input->post('send')){
			$data = array(
				'id' => $this->input->post('id'),
				'star' => $this->input->post('star'),
				'content' => $this->input->post('content'),
				'created' => date('Y-m-d H:i:s')
			);
			if($this->db->insert('rates', $data)){
				$session = array(
				    'success' => TRUE
				);
				$this->session->set_userdata($session);
			}
			redirect('/', 'location');
		}
		
	}
	public function call_to_app($data)
	{
		/*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'id'=>0, 
         );
         */
      
		$url = 'http://app.seoulspa.vn/danhgia';

		//create a new cURL resource
		$ch = curl_init($url);
		
		$payload = json_encode($data);
		//echo $payload;
  
		//attach encoded JSON string to the POST fields
		curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
  
		//set the content type to application/json
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));
  
		//return response instead of outputting
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  
		//execute the POST request
		$result = curl_exec($ch);
  
		//close cURL resource
		curl_close($ch);
		return json_decode($result);
	}
}
