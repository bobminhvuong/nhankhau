<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashbooks extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('cashbook_model', 'cashbook');
		$this->load->model('cashbook_store_model', 'cashbook_store');
		$this->load->model('cashbook_log_model', 'cashbook_log');
		$this->load->model('cashbook_revenue_model', 'cashbook_revenue');
		$this->load->model('paid_model', 'paid');
		$this->load->library('system_message');
		$this->_type = array(
			'13' 	=> 'Đồ uống / Đồ ăn',
			'3' 	=> 'Điện thoại',
			'4' 	=> 'Điện nước',
			'5' 	=> 'Vật dụng',
			'6' 	=> 'Tiền lương',
			'7' 	=> 'Tiếp khách',
			'8' 	=> 'Thuế',
			'9' 	=> 'Sửa chữa',
			'10' 	=> 'Nhập kho',
			'11' 	=> 'Khác',
			'12' 	=> 'Chi riêng',
			'14' 	=> 'Tạm ứng' 
		);

		$this->_list_admin = get_group_users(2);

	}
	public function index(){
		$update = FALSE;
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
			$this->mPageTitle = 'Sổ quỹ '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			
			$begin_date = date('Y-m-d', strtotime('-1 days'));
			$begin = new DateTime($begin_date);
			$end = new DateTime(date('Y-m-d'));
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			foreach ($period as $dt) {
			    update_cashbook_revenue_center($dt->format("Y-m-d"));
			}
			

			$update = TRUE;
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Sổ quỹ trong ngày';

			$list_check = array('amount', 'transfer');
			foreach ($list_check as $item) {
				$check = $this->cashbook_revenue->get_by(
					array(
						'date' => $start_date,
						'type' => $item,
						'store_id' => 0
					)
				);
				if(!$check){
					$last = $this->cashbook_revenue->order_by('date', 'DESC')->get_by(
						array(
							'type' => $item,
							'store_id' => 0
						)
					);
					$data['store_id'] = 0;
					$data['type'] = $item;
					$data['date'] = date('Y-m-d');
					if($last){
						$data['start'] = $last->end;
					}else{
						$data['start'] = 0;
					}
					$this->cashbook_revenue->insert($data);
				}
			}

		}

		$start_amount =  $this->cashbook_revenue->get_by(
			array(
				'date' => $start_date,
				'type' => 'amount',
				'store_id' => 0
			)
		);
		if($start_amount){
			$this->mViewData['start_amount'] = $start_amount->start;
		}else{
			$this->mViewData['start_amount'] = 0;
		}

		$start_transfer =  $this->cashbook_revenue->get_by(
			array(
				'date' => $start_date,
				'type' => 'transfer',
				'store_id' => 0
			)
		);
		if($start_transfer){
			$this->mViewData['start_transfer'] = $start_transfer->start;
		}else{
			$this->mViewData['start_transfer'] = 0;
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$this->mViewData['update'] = $update;

		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 61){
			echo '<pre>';print_r('Không được chọn quá 60 ngày');echo '</pre>';die();
		}

		$results = $this->cashbook->order_by('created')->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'verify_status'	=> 1,
			)
		);
		$result_stores = $this->cashbook_store->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
				'type_id'		=> 1,
				'verify_status' => 1
			)
		);
		$MYarray = array_merge($results, $result_stores);
		
		$tmp = Array();
		foreach($MYarray as &$ma){
		    $tmp[] = &$ma->created;
		}
		array_multisort($tmp, $MYarray);
		$this->mViewData['results'] = $MYarray;
		$this->render('cashbooks/index');
	}

	public function receipts(){
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
			$this->mPageTitle = 'Tiền thu '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Tiền thu trong ngày';
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));

		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 31){
			echo '<pre>';print_r('Không được chọn quá 30 ngày');echo '</pre>';die();
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));

		if($this->input->post('save')){

			if($this->cashbook->insert(
				array(
					'title'		=> $this->input->post('title'),
					'price'		=> format_price($this->input->post('price')),
					'formality' => $this->input->post('formality'),
					'type'		=> 'receipts',
					'created'	=> date('Y-m-d H:i:s'),
					'import_id'	=> get_current_user_id(),	
					//'verify_id' => $this->input->post('verify_id'),
					'note'		=> $this->input->post('note'),
					'verify_status' => 1,
				)
			)){
				$this->system_message->set_success('Thêm mới thành công');
			}else{
				$this->system_message->set_error('Đã có lỗi');
			}
			//redirect('invoices/receipts');
		}

		$results = $this->cashbook->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'receipts',
			)
		);

		
		$result_stores = $this->cashbook_store->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
				'type_id'		=> 1,
				//'verify_status' => 1
			)
		);

		$this->mViewData['message'] = $this->system_message->render();
		$this->mViewData['results'] = $results;
		$this->mViewData['result_stores'] = $result_stores;
		$this->render('cashbooks/receipts');
	}

	public function expenditures(){
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
			$this->mPageTitle = 'Tiền chi '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Tiền chi trong ngày';
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));

		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 31){
			echo '<pre>';print_r('Không được chọn quá 30 ngày');echo '</pre>';die();
		}

		if($this->input->post('save')){
			if($_FILES['file']['size'] != 0) {
				$file = $this->cashbook->upload_file('file', 'certificates');
			}else{
				$file = '';
			}

			if($this->input->post('type') == 2){
				$store = $this->input->post('store_id');
			}else{
				$store = 0;
			}

			if($this->cashbook->insert(
				array(
					'title'		=> $this->input->post('title'),
					'price'		=> format_price($this->input->post('price')),
					'formality' => $this->input->post('formality'),
					'type'		=> 'expenditures',
					'store'		=> $store,
					'note'		=> $this->input->post('note'),
					'type_id'	=> $this->input->post('type'),
					'file'		=> $file,
					'created'	=> date('Y-m-d H:i:s'),
					'import_id'	=> get_current_user_id(),	
					'verify_id' => $this->input->post('verify_id'),
				)
			)){
				$this->system_message->set_success('Thêm mới thành công');
			}else{
				$this->system_message->set_error('Đã có lỗi');
			}
			//redirect('invoices/receipts');
		}

		$results = $this->cashbook->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
			)
		);
		$this->mViewData['message'] = $this->system_message->render();
		$this->mViewData['results'] = $results;
		$this->render('cashbooks/expenditures');
	}

	public function view($id){
		$this->mPageTitle = 'Chi tiết phiếu thu - chi';
		$table = $this->input->get('table');
		$result = $this->db->query("SELECT * FROM ".$table." WHERE id = ".$id)->row();
		$this->mViewData['result'] = $result;
		$this->render('cashbooks/view');
	}

	public function cashbook_print($id){
		$table = $this->input->get('table');
		$result = $this->db->query("SELECT * FROM ".$table." WHERE id = ".$id)->row();
		$this->load->view('cashbooks/cashbook_print', array('result' => $result));
	}

	public function delete($id){
		if(is_admin()){
			$table = $this->input->get('table');
			$item = $this->db->query("SELECT * FROM ".$table." WHERE id = ".$id)->row();
			if($item){
				$data = array(
					'tbl_name' 	=> $table,
					'tbl_id' 	=> $id,
					'value' 	=> json_encode($item),
					'created' 	=> date('Y-m-d H:i:s'),
					'import_id' => get_current_user_id()
				);

				if($this->cashbook_log->insert($data)){
					$this->db->where('id', $id);
					$this->db->delete($table);
				}
			}
		}
		redirect('ketoan/cashbooks');
	}

	public function stores(){
		if($date_filter = $this->input->get('store_id')){
			$list_store = $this->input->get('store_id');
		}else{
			$list_store = array(get_current_store_id());
		}
		$this->mViewData['store_id'] = $list_store;
		$rule = array(
			'all' => array(0, 1),
			'verify' => array(1),
			'none' => array(0),
		);
		if($this->input->get('status')){
			$status = $rule[$this->input->get('status')];
			$this->mViewData['stt'] = $this->input->get('status');
		}else{
			$status = $rule['all'];
			$this->mViewData['stt'] = 'all';
		}
		$this->mViewData['status'] = $status;

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
			$this->mPageTitle = 'Thống kê '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Thống kê trong ngày';
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 31){
			echo '<pre>';print_r('Không được chọn quá 30 ngày');echo '</pre>';die();
		}

		

		$list_stores = array();
		foreach ($list_store as $store_id) {
			$list_stores[$store_id] = array();
			$cashbook_store = $this->cashbook_store->get_many_by(
				array(
					'created >=' 	=> $start_date.' 00:00:00',
					'created <=' 	=> $end_date.' 23:59:59',
					'store_id' 		=> $store_id,
					'verify_status' => $status,
				)
			);

			$cashbook = $this->cashbook->get_many_by(
				array(
					'created >=' 	=> $start_date.' 00:00:00',
					'created <=' 	=> $end_date.' 23:59:59',
					'type'			=> 'expenditures',
					'type_id'		=> 2,
					'store' 		=> $store_id,
					'verify_status' => $status,
				)
			);
			$MYarray = array_merge($cashbook, $cashbook_store);
		
			$tmp = Array();
			foreach($MYarray as &$ma){
			    $tmp[] = &$ma->created;
			}
			array_multisort($tmp, $MYarray);
			$list_stores[$store_id]['results'] = $MYarray;
			
		}

		$this->mViewData['list_stores'] = $list_stores;
		$this->render('cashbooks/stores');
	}

	public function paids()
	{
		$this->mPageTitle = 'Thống kê phần chi';
		$today = date('Y-m-d');
		$begin = new DateTime( date('Y-m-d', strtotime('-6 day', strtotime($today)))  );
		$end   = new DateTime( date('Y-m-d', strtotime('+1 day', strtotime($today)))  );
		$interval = DateInterval::createFromDateString('1 day');
		$period = new DatePeriod($begin, $interval, $end);

		foreach ($period as $dt) {
		   	$filter[$dt->format("Y-m-d")] = array(
				'date' => $dt->format("Y-m-d"),
		   	);
		}
		$results = array();
		foreach (all_stores() as $store) {
			$results[$store->id] = array();
			foreach ($filter as $key => $value) {
				$total = 0;
				$cashbook_store = $this->cashbook_store->get_many_by(
					array(
						'created >=' 	=> $value['date'].' 00:00:00',
						'created <=' 	=> $value['date'].' 23:59:59',
						'store_id' 		=> $store->id,
						'type'			=> 'expenditures',
						'type_id !='		=> 1,
					)
				);
				foreach ($cashbook_store as $val) {
					$total += $val->price;
				}
				$results[$store->id][$key] = $total;
			}
		}
		$this->mViewData['filter'] = $filter;
		$this->mViewData['results'] = $results;
		$this->render('cashbooks/paids');
	}

	public function paid_detail(){
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
			
			$this->mPageTitle = 'Chi '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Chi trong ngày';
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 31){
			echo '<pre>';print_r('Không được chọn quá 30 ngày');echo '</pre>';die();
		}

		if($this->input->get('store_id')){
			$store_id = $this->input->get('store_id');
		}else{
			$store_id = get_current_store_id();
		}
		$this->mViewData['store_id'] = $store_id;
		$store_name = get_store_name($store_id);
		$this->mPageTitle .= ' - '.$store_name;
		$cashbook_store = $this->cashbook_store->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'store_id' 		=> $store_id,
				'type'			=> 'expenditures',
				'type_id !='		=> 1,
			)
		);

		$this->mViewData['results'] = $cashbook_store;
		$this->render('cashbooks/paid_detail');
	}

	public function trashs(){
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
			$this->mPageTitle = 'Tiền chi '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Tiền chi trong ngày';
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$results = $this->db->query("SELECT * FROM cashbook_logs WHERE DATE_FORMAT(created, '%Y-%m-%d') >= '".$start_date."' AND DATE_FORMAT(created, '%Y-%m-%d') <= '".$end_date."' ")->result();
		
		$this->mViewData['results'] = $results;
		$this->render('cashbooks/trashs');
	}

	public function restore($id){
		if(is_admin()){
			$table = $this->input->get('table');
			$item = $this->db->query("SELECT * FROM cashbook_logs WHERE id = ".$id)->row();
			if($item){
				if($this->db->insert($table, json_decode($item->value))){
					echo $this->db->last_query();
					$this->cashbook_log->delete($id);
					echo $this->db->last_query();
				}

			}
		}
		redirect('ketoan/cashbooks/trashs');
	}

	public function update(){
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
			$this->mPageTitle = 'Cập nhật '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Cập nhật trong ngày';
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$begin = new DateTime( $start_date );
		$end   = new DateTime( $end_date );
		for($i = $begin; $i <= $end; $i->modify('+1 day')){
		    update_cashbook_revenue_center($i->format("Y-m-d"));
		}
		$this->render('cashbooks/update');
	}

	public function excel(){
		$update = FALSE;
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
			$this->mPageTitle = 'Sổ quỹ Excel '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			
			$begin_date = date('Y-m-d', strtotime('-1 days'));
			$begin = new DateTime($begin_date);
			$end = new DateTime(date('Y-m-d'));
			$interval = DateInterval::createFromDateString('1 day');
			$period = new DatePeriod($begin, $interval, $end);
			foreach ($period as $dt) {
			    update_cashbook_revenue_center($dt->format("Y-m-d"));
			}
			
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Sổ quỹ trong ngày';

			$list_check = array('amount', 'transfer');
			foreach ($list_check as $item) {
				$check = $this->cashbook_revenue->get_by(
					array(
						'date' => $start_date,
						'type' => $item,
						'store_id' => 0
					)
				);
				if(!$check){
					$last = $this->cashbook_revenue->order_by('date', 'DESC')->get_by(
						array(
							'type' => $item,
							'store_id' => 0
						)
					);
					$data['store_id'] = 0;
					$data['type'] = $item;
					$data['date'] = date('Y-m-d');
					if($last){
						$data['start'] = $last->end;
					}else{
						$data['start'] = 0;
					}
					$this->cashbook_revenue->insert($data);
				}
			}

		}

		$start_amount =  $this->cashbook_revenue->get_by(
			array(
				'date' => $start_date,
				'type' => 'amount',
				'store_id' => 0
			)
		);
		if($start_amount){
			$this->mViewData['start_amount'] = $start_amount->start;
		}else{
			$this->mViewData['start_amount'] = 0;
		}

		$start_transfer =  $this->cashbook_revenue->get_by(
			array(
				'date' => $start_date,
				'type' => 'transfer',
				'store_id' => 0
			)
		);
		if($start_transfer){
			$this->mViewData['start_transfer'] = $start_transfer->start;
		}else{
			$this->mViewData['start_transfer'] = 0;
		}

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		$this->mViewData['update'] = $update;

		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 61){
			echo '<pre>';print_r('Không được chọn quá 60 ngày');echo '</pre>';die();
		}

		$results = $this->cashbook->order_by('created')->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'verify_status'	=> 1,
			)
		);
		$result_stores = $this->cashbook_store->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
				'type_id'		=> 1,
				'verify_status' => 1
			)
		);
		$MYarray = array_merge($results, $result_stores);
		
		$tmp = Array();
		foreach($MYarray as &$ma){
		    $tmp[] = &$ma->created;
		}
		array_multisort($tmp, $MYarray);
		$this->mViewData['results'] = $MYarray;
		$this->render('cashbooks/excel');
	}


}
