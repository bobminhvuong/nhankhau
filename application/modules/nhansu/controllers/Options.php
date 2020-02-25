<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Options extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('option_model', 'option');
		$this->load->model('admin_users_store_model', 'admin_users_store');
		$this->load->model('admin_users_group_model', 'admin_users_group');
		$this->load->library("excel");
	}
	public function sms(){
		$this->mPageTitle = 'Gửi sms';
		if($this->input->post('send')){
			$content = $this->input->post('content');
			foreach ($this->input->post('phone') as $phone) {
				send_sms($content, $phone);
			}
			redirect('nhansu/options/sms?status=success');
		}

		$list_store = $list_group = array('');
		if($this->input->get('store_id')){
			$list_store = $this->input->get('store_id');
		}
		if($this->input->get('group_id')){
			$list_group = $this->input->get('group_id');
		}
		$this->db->select('admin_users.*');
		$this->db->from('admin_users');
		$this->db->join('admin_users_stores', 'admin_users.id = admin_users_stores.user_id');
		$this->db->join('admin_users_groups', 'admin_users.id = admin_users_groups.user_id');
		$this->db->where('admin_users.id !=', 1);
		$this->db->where('admin_users.active', 1);
		
		$this->db->where_in('admin_users_stores.store_id', $list_store);
		$this->db->where_in('admin_users_groups.group_id', $list_group);
			
		
		$admin_users = $this->db->get()->result();
		$this->mViewData['store_id'] = $list_store;
		$this->mViewData['group_id'] = $list_group;
		$this->mViewData['results'] = $admin_users;

		$this->render('options/sms');
	}

	public function sms_v2(){
		$content = $this->input->post('content');
		$phone = $this->input->post('phone');
		$list = explode(',', $phone);
		foreach ($list as $value) {
			send_sms($content, $value);
		}
		redirect('nhansu/options/sms?status=success');
	}
	//luyen add control cho cài đặt chi nhánh
	public function setting_store()
	{
		$this->mPageTitle = 'Cài đặt chi nhánh';
		if($this->input->post('submit_edit')){

				$this->db->reset_query();
				$data = array(
									'password' => $this->input->post('password'),
							        'latitude_gps' => $this->input->post('latitude_gps'),
							        'longitude_gps' => $this->input->post('longitude_gps'),
							        'ipaddress' => $this->input->post('ipaddress')
							);

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('admin_stores', $data);

		}
		
		$this->db->reset_query();
        //$this->db->where('active',1);
        $results = $this->db->get('admin_stores')->result();
        $this->mViewData['results']  = $results;
		$this->render('options/setting_store');
	}
	//luyen end add
	//luyen add control cho quản lý ca
	public function shift_manager()
	{
		$this->mPageTitle = 'Quản lý ca';
		if($this->input->post('submit_edit')){

				$this->db->reset_query();
				$data = array(
									'name' => $this->input->post('name'),
							        'begin' => $this->input->post('begin'),
							        'end' => $this->input->post('end'),
							        'active' => $this->input->post('active')?1:0
							);

				$this->db->where('id', $this->input->post('id'));
				$this->db->update('admin_user_shifts', $data);

		}
		if($this->input->post('submit_delete')){
			
				$this->db->reset_query();
				$this->db->delete('admin_user_shifts', array('id' => $this->input->post('id')));
		}
		if($this->input->post('submit_add')){	
				$this->db->reset_query();
				$data = array(
									'name' => $this->input->post('name'),
							        'begin' => $this->input->post('begin'),
							        'end' => $this->input->post('end'),
							        'active' => $this->input->post('active')?1:0
							);
				$this->db->insert('admin_user_shifts', $data);
			
		}

		$this->db->reset_query();
        //$this->db->where('active',1);
        $this->db->select('admin_user_shifts.*,IF(id IN (SELECT DISTINCT shift_id from admin_user_timekeeping where 1),1,0) as in_use_shift');
        $results = $this->db->get('admin_user_shifts')->result();
        $this->mViewData['results']  = $results;
		$this->render('options/shift_manager');
	}
	//luyen end add
}
