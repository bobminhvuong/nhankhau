<?php
defined('BASEPATH') OR exit('No direct script access allowed');
class Depots extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		
		$this->load->model('depot_store_model', 'depot_store');
		$this->load->model('depot_stores_action_model', 'depot_stores_action');
		$this->load->model('depot_model', 'depot');
		$this->load->model('depot_action_model', 'depot_action');
		$this->load->model('depot_actions_item_model', 'depot_actions_item');
		

		$this->_list_admin = get_group_users(2);
		$this->_list_manager = get_group_users(9);
		$this->_list_leader = get_group_users(16);
		$this->_list_accountant = get_group_users(3);
	}

	public function index(){
		if($date_filter = $this->input->get('date_filter')){
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
			$this->mPageTitle = 'Kho hàng '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Kho hàng';
		}
		$update = FALSE;
		if($start_date == $end_date && $start_date == date('Y-m-d')){
			$update = TRUE;
		}
		$this->mViewData['update'] = $update;
		$action_1 = $this->depot_action->get_many_by(
			array(
				'verify_time >=' => $start_date.' 00:00:00',
				'verify_time <=' => $end_date.' 23:59:59',
				'verify_status' => 1,
			)
		);

		$action_2 = $this->depot_stores_action->get_many_by(
			array(
				'type'	=> 'export',
				'receive'	=> 'company',
				'verify_time >=' => $start_date.' 00:00:00',
				'verify_time <=' => $end_date.' 23:59:59',
				'verify_status' => 1,
			)
		);

		$MYarray = array_merge($action_1, $action_2);
		
		$tmp = Array();
		foreach($MYarray as &$ma){
		    $tmp[] = &$ma->created;
		}
		array_multisort($tmp, $MYarray);
		$this->mViewData['actions'] = $MYarray;

		if($update){
			$results = $this->depot->get_many_by(
				array(
					'date' => date('Y-m-d'),
				)
			);
		}else{
			$results = array();
			$groups = $this->db->query("SELECT * FROM depots WHERE date >= '".$start_date."' AND date <= '".$end_date."' GROUP BY product_id")->result();
			foreach ($groups as $value) {
				$data = new stdClass();
				$data->product_id = $value->product_id;
				$check_begin = $this->db->query("SELECT begin FROM depots WHERE date = '".$start_date."' AND product_id = ".$value->product_id." ")->row();
				if($check_begin){
					$begin = $check_begin->begin;
				}else{
					$begin = 0;
				}

				$check_end = $this->db->query("SELECT end FROM depots WHERE date = '".$end_date."' AND product_id = ".$value->product_id." ")->row();
				if($check_end){
					$end = $check_end->end;
				}else{
					$end = 0;
				}

				$sum = $this->db->query("SELECT SUM(import) as t_import, SUM(export) as t_export  FROM depots WHERE date >= '".$start_date."' AND date <= '".$end_date."' AND product_id = ".$value->product_id." ")->row();

				$data->begin = $begin;
				$data->end = $end;
				$data->import = $sum->t_import;
				$data->export =  $sum->t_export;
				$results[] = $data;
			}

		}

		$this->mViewData['results'] = $results;
		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$this->render('depots/index');
	}

	public function import(){
		if($date_filter = $this->input->get('date_filter')){
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
			$this->mPageTitle = 'Nhập hàng '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Nhập hàng trong ngày';
		}

		if($this->input->post('save')){
			$count = count($this->input->post('product-id'));
			if($count != 0){
				$data = array(
					'type' 			=> 'import',
					'title' 		=> $this->input->post('title'),
					'note' 			=> $this->input->post('note'),
					'verify_status' => 1,
					'verify_time' 	=> date('Y-m-d H:i:s'),
					'import_id' 	=> get_current_user_id(),
					'created'		=> date('Y-m-d H:i:s'),
				);
				$this->depot_action->insert($data);
				$insert_id = $this->db->insert_id();
				for ($j=0; $j < count($this->input->post('product-id')); $j++) { 
					$this->depot_actions_item->insert(
						array(
							'tbl_name' 		=> 'depot_actions',
							'parent_id' 	=> $insert_id,
							'item_id' 		=> $this->input->post('product-id')[$j],
							'quantity' 		=> $this->input->post('product-quantity')[$j],
						)
					);
				}
			}
			redirect('ketoan/depots/import');
		}

		$action_1 = $this->depot_action->get_many_by(
			array(
				'type' => 'import',
				'created >=' => $start_date.' 00:00:00',
				'created <=' => $end_date.' 23:59:59',
			)
		);

		$action_2 = $this->depot_stores_action->get_many_by(
			array(
				'type'	=> 'export',
				'receive'	=> 'company',
				'verify_time >=' => $start_date.' 00:00:00',
				'verify_time <=' => $end_date.' 23:59:59',
			)
		);

		$MYarray = array_merge($action_1, $action_2);
		
		$tmp = Array();
		foreach($MYarray as &$ma){
		    $tmp[] = &$ma->created;
		}
		array_multisort($tmp, $MYarray);
		$this->mViewData['results'] = $MYarray;

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$this->render('depots/import');
	}

	public function export(){
		if($date_filter = $this->input->get('date_filter')){
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
			$this->mPageTitle = 'Xuất hàng '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Xuất hàng trong ngày';
		}

		if($this->input->post('save')){
			$count = count($this->input->post('product-id'));
			if($count != 0){
				if($_FILES['file']['size'] != 0) {
					$file = $this->depot->upload_file('file', 'depots');
				}else{
					$file = '';
				}
				if($this->input->post('receive') == 'store'){
					$store = $this->input->post('store');
				}else{
					$store = 0;
				}
				$data = array(
					'type' 			=> 'export',
					'title' 		=> $this->input->post('title'),
					'note' 			=> $this->input->post('note'),
					//'product_id' 	=> $this->input->post('product_id'),
					//'quantity' 		=> $this->input->post('quantity'),
					'receive' 		=> $this->input->post('receive'),
					'store'			=> $store,
					'file'			=> $file,
					'verify_id' 	=> $this->input->post('verify_id'),
					'import_id' 	=> get_current_user_id(),
					'created'		=> date('Y-m-d H:i:s'),
				);
				$this->depot_action->insert($data);
				$insert_id = $this->db->insert_id();
				for ($j=0; $j < count($this->input->post('product-id')); $j++) { 
					$this->depot_actions_item->insert(
						array(
							'tbl_name' 		=> 'depot_actions',
							'parent_id' 	=> $insert_id,
							'item_id' 		=> $this->input->post('product-id')[$j],
							'quantity' 		=> $this->input->post('product-quantity')[$j],
						)
					);
				}
			}
			redirect('ketoan/depots/export');
		}

		$results = $this->depot_action->get_many_by(
			array(
				'type' 			=> 'export',
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
			)
		);
		$this->mViewData['results'] = $results;
		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$this->render('depots/export');
	}

	public function depot_update(){
		$check = $this->depot->get_many_by(
			array(
				'date' => date('Y-m-d'),
			)
		);
		if($check){
			$this->db->query("UPDATE `depots` SET `end` = `begin` + `import` - `export` WHERE `date` = '".date('Y-m-d')."' ");
		}else{
			//insert
			$list_product = $this->db->query("SELECT * FROM depots GROUP BY product_id ORDER BY date DESC")->result();
			if($list_product){
				foreach ($list_product as $item) {
					$this->depot->insert(
						array(
							'product_id' 	=> $item->product_id,
							'date'			=> date('Y-m-d'),
							'begin'			=> $item->end,
							'end'			=> $item->end,
							'created'		=> date('Y-m-d H:i:s'),
						)
					);
				}
			}else{
				foreach (all_products() as $item) {
					$this->depot->insert(
						array(
							'product_id' 	=> $item->id,
							'date'			=> date('Y-m-d'),
							'created'		=> date('Y-m-d H:i:s'),
						)
					);
				}
			}
		}
		redirect('ketoan/depots');
	}

	public function import_store(){
		if($date_filter = $this->input->get('date_filter')){
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
			$this->mPageTitle = 'Nhập hàng '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Nhập hàng trong ngày';
		}
		$all_stores = all_stores();
		foreach ($all_stores as $key => $store) {
			$results = $this->depot_stores_action->get_many_by(
				array(
					'type' => 'import',
					'store_id' => $store->id,
					'created >=' => $start_date.' 00:00:00',
					'created <=' => $end_date.' 23:59:59',
				)
			);
			$all_stores[$key]->results = $results;

		}
		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$this->mViewData['all_stores'] = $all_stores;
		$this->render('depots/import_store');
	}

	public function export_store(){
		if($date_filter = $this->input->get('date_filter')){
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
			$this->mPageTitle = 'Xuất hàng '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Xuất hàng trong ngày';
		}
		$all_stores = all_stores();
		foreach ($all_stores as $key => $store) {
			$results = $this->depot_stores_action->get_many_by(
				array(
					'type' 			=> 'export',
					'store_id' 		=> $store->id,
					'created >=' 	=> $start_date.' 00:00:00',
					'created <=' 	=> $end_date.' 23:59:59',
				)
			);
			$all_stores[$key]->results = $results;

		}
		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$this->mViewData['all_stores'] = $all_stores;
		$this->render('depots/export_store');
	}

	public function remove($id){
		if(is_accountant()){
			$this->depot_actions_item->delete_by(
				array(
					'tbl_name' => 'depot_actions',
					'parent_id' => $id
				)
			);
			$this->depot_action->delete($id);
			echo 'Đã xoá';
		}
	}

	public function depot_print($id){
		$item = $this->depot_action->get($id);
		$results = $this->depot_actions_item->get_many_by(
			array(
				'tbl_name' => 'depot_actions',
				'parent_id' => $id
			)
		);
		$this->mViewData['item'] = $item;
		$this->mViewData['results'] = $results;
		$this->load->view('depots/print', array(
			'item' => $item,
			'results' => $results
		));
	}

}
