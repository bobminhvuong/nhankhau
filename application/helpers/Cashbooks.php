<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cashbooks extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('cashbook_model', 'cashbook');
		$this->load->model('cashbook_store_model', 'cashbook_store');
		$this->load->model('cashbook_log_model', 'cashbook_log');
		$this->load->model('cashbook_revenue_model', 'cashbook_revenue');

		$this->_consultants = get_group_users(array(5,6));
		$this->_technicians = get_group_users(11);
		$this->_beautys = get_group_users(12);

		$this->_type = array(

			'1' 	=> 'Chi về Tổng',
			'2' 	=> 'Đồ uống / Đồ ăn',
			'3' 	=> 'Điện thoại',
			'4' 	=> 'Điện nước',
			'5' 	=> 'Vật dụng',
			'6' 	=> 'Tiền lương',
			'7' 	=> 'Tiếp khách',
			'8' 	=> 'Thuế',
			'9' 	=> 'Sửa chữa',
			'10' 	=> 'Nhập kho',
			'11' 	=> 'Khác',
			'12' 	=> 'Chi riêng' 
		);
		$last_date = date('Y-m-d', strtotime( date('Y-m-d')." -1 days"));

		$this->_yesterday = $last_date;
		$store_id = get_current_store_id();
		$this->_list_admin = get_group_users(2);
		$this->_list_manager = get_group_users(9);

		$last_date = date('Y-m-d', strtotime( date('Y-m-d')." -1 days"));
		// foreach(all_spas() as $spa){
			update_cashbook_revenue( $last_date, $store_id );
			update_cashbook_revenue( date('Y-m-d'), $store_id );
		// }
	}

	public function index(){
		$store_id = get_current_store_id();
		$nation_id = $store_id != 8? one_stores($store_id)[0]->nation_id:1;
		$this->mViewData['nation_id'] = $nation_id;
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
			$update = TRUE;
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Sổ quỹ trong ngày';
		}

		$control = FALSE;
		if($start_date == $end_date && $start_date < date('Y-m-d') ){
			$control = TRUE;
		}
		$this->mViewData['control'] = $control;

		$start_amount =  $this->cashbook_revenue->get_by(
			array(
				'date' => $start_date,
				'type' => 'amount',
				'store_id' => $store_id
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
				'store_id' => $store_id
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
		if($hourDiff > 31){
			echo '<pre>';print_r('Không được chọn quá 30 ngày');echo '</pre>';die();
		}

		$results = $this->cashbook_store->order_by('created')->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				//'verify_status !='	=> 2,
				'store_id' 		=> $store_id
			)
		);
		$result_ceos = $this->cashbook->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
				'type_id'		=> 2,
				'verify_status'	=> 1,
				'store' 		=> $store_id
			)
		);
		$MYarray = array_merge($results, $result_ceos);
		
		$tmp = Array();
		foreach($MYarray as &$ma){
		    $tmp[] = &$ma->created;
		}
		array_multisort($tmp, $MYarray);
		$this->mViewData['results'] = $MYarray;
		//$this->mViewData['results'] = $results;
		$this->render('cashbooks/index');
	}

	public function receipts($id = ''){
		if($id) {
			$item = $this->cashbook_store->get($id);
			if(is_admin() || $item->created >= $this->_yesterday.' 00:00:00' ){
				$this->mViewData['item'] = $item;
			}
			
		}
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

		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 31){
			echo '<pre>';print_r('Không được chọn quá 30 ngày');echo '</pre>';die();
		}

		$store_id = get_current_store_id();
		$nation_id = $store_id != 8? one_stores($store_id)[0]->nation_id:1;
		$this->mViewData['nation_id'] = $nation_id;

		if($this->input->post('save')){
			$price_input = $this->input->post('price')?$this->input->post('price'):0;
			if($id = $this->input->post('id')){
				//UPDATE
				if($this->cashbook_store->update(
					$id,
					array(
						'title'		=> $this->input->post('title'),
						'note'		=> $this->input->post('note'),
						'price' 	=> transfer_number_nation($price_input,$nation_id),
						'formality' => $this->input->post('formality'),
					)
				)){
					$this->system_message->set_success('Cập nhật thành công');
				}else{
					$this->system_message->set_error('Cập nhật thất bại');
				}
			}else{
				//INSERT
				if($this->cashbook_store->insert(
					array(
						'title'		=> $this->input->post('title'),
						'price' 	=> transfer_number_nation($price_input,$nation_id),
						'source' 	=> $this->input->post('formality'),
						'formality' => $this->input->post('formality'),
						'type'		=> 'receipts',
						'note'		=> $this->input->post('note'),
						'created'	=> date('Y-m-d H:i:s'),
						'import_id'	=> get_current_user_id(),	
						'verify_status' => 1,
						'verify_time' => date('Y-m-d H:i:s'),
						'store_id'	=> $store_id,
					)
				)){
					if($this->input->post('formality') == 'transfer'){
						
						
						$this->cashbook_store->insert(
							array(
								'title'		=> $this->input->post('title'),
								'price' 	=> format_price($this->input->post('price')),
								'source'	=> 'transfer',
								'formality' => 'transfer',
								'type'		=> 'expenditures',
								'type_id'	=> 1,
								'note'		=> 'Hệ thống tự chi',
								'created'	=> date('Y-m-d H:i:s'),
								'import_id'	=> get_current_user_id(),	
								'verify_id' => 2,
								'verify_status' => 1,
								'verify_time'	=> date('Y-m-d H:i:s'),
								'store_id'	=> $store_id,
							)
						);
						
					}
					$this->system_message->set_success('Thêm mới thành công');
				}else{
					$this->system_message->set_error('Đã có lỗi');
				}
			}
			redirect('cashbooks/receipts');
		}

		$results = $this->cashbook_store->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'receipts',
				'store_id' 		=> $store_id
			)
		);
		

		$result_ceos = $this->cashbook->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
				'type_id'		=> 2,
				'store' 		=> $store_id
			)
		);


		$this->mViewData['message'] = $this->system_message->render();
		$this->mViewData['results'] = $results;
		$this->mViewData['result_ceos'] = $result_ceos;
		$this->render('cashbooks/receipts');
	}

	public function expenditures($id = ''){
		$key_api = get_api_key_global_real();

		if($id) {
			$item = $this->cashbook_store->get($id);
			if(is_admin() || $item->created >= $this->_yesterday.' 00:00:00'){
				$this->mViewData['item'] = $item;
			}
			
		}

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

		$store_id = get_current_store_id();
		$nation_id = $store_id != 8? one_stores($store_id)[0]->nation_id:1;
		$this->mViewData['nation_id'] = $nation_id;
		if($this->input->post('save')){
			$price_input = $this->input->post('price')?$this->input->post('price'):0; 
			$price_real = $nation_id==1?$price_input:$price_input*100;
			if($price_real > $this->input->post('start_amount')){
				$this->system_message->set_error('Không thể chi nhiều hơn số dư');
			}else{
				if($_FILES['file']['size'] != 0) {
					$file = $this->cashbook_store->upload_file('file', 'certificates');
				}else{
					$file = '';
				}

				if($id = $this->input->post('id')){
					// UPDATE
					$update = array(
						'title'		=> $this->input->post('title'),
							'price' 	=> transfer_number_nation($price_input,$nation_id),
							'source'	=> $this->input->post('source'),
							'formality' => $this->input->post('formality'),
							'type_id'	=> $this->input->post('type'),
							'note'		=> $this->input->post('note'),
							//'verify_id' => $this->input->post('verify_id'),
							'verify_name' => '',

					);
					if($file != ''){
						$update['file'] = $file;
					}
					if($this->cashbook_store->update($id,$update)){
						$this->system_message->set_success('Cập nhật thành công');
					}else{
						$this->system_message->set_error('Đã có lỗi');
					}
				}else{
						// INSERT
						if($rs = $this->cashbook_store->insert(
							array(
								'title'		=> $this->input->post('title'),
								'price' 	=> transfer_number_nation($price_input,$nation_id),
								'source'	=> $this->input->post('source'),
								'formality' => $this->input->post('formality'),
								'type'		=> 'expenditures',
								'type_id'	=> $this->input->post('type'),
								'file'		=> $file,
								'note'		=> $this->input->post('note'),
								'created'	=> date('Y-m-d H:i:s'),
								'import_id'	=> get_current_user_id(),	
								'verify_name' => '',
								'store_id'	=> $store_id,
							)
						)){
							$data = (object) array(
								'api'			=> $key_api,
								'user_id'		=> get_current_user_id(),
								'store_name'	=> get_store_name(get_current_store_id()),
								'user_name'		=> get_current_user_name(),
								'nation_id'		=> $nation_id,
								'name'			=> $this->input->post('title'),
								'group_name'	=> $this->_type[$this->input->post('type')],
								'note'			=> $this->input->post('note'),
								'amount'		=> transfer_number_nation($price_input,$nation_id),
								'image_url'		=> base_url().'assets/uploads/certificates/'.$file,
								'source'		=>'',
								'destination'	=>'',
								'url' 			=> base_url().'cashbooks/verify/'.$rs
							);
							
							$result = yeucautaophieuchi_add($data);

							echo '<pre>';
							print_r($data);
							print_r($result);
							echo '</pre>';
							die();

							$this->system_message->set_success('Thêm mới thành công');
						}else{
							$this->system_message->set_error('Đã có lỗi');
						}
				}
			}
			//redirect('invoices/receipts');
		}

		$start_amount =  $this->cashbook_revenue->get_by(
			array(
				'date' => date('Y-m-d'),
				'type' => 'amount',
				'store_id' => $store_id
			)
		);
		if($start_amount){
			$this->mViewData['start_amount'] = $start_amount->end;
		}else{
			$this->mViewData['start_amount'] = 0;
		}

		$results = $this->cashbook_store->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
				'store_id' 		=> $store_id
			)
		);
		$this->mViewData['message'] = $this->system_message->render();
		$this->mViewData['results'] = $results;
		$this->render('cashbooks/expenditures');
	}

	public function verify($id= ''){
		// $this->mPageTitle = 'Phê duyệt thu chi';
		// $user_id = get_current_user_id();
		// $rule = array(
		// 	'verify_status'	=> 0,
		// 	'verify_id'		=> $user_id
		// );
		// $cashbook_store = $this->cashbook_store->get_many_by($rule);

		// $cashbook = $this->cashbook->get_many_by($rule);
		// $MYarray = array_merge($cashbook, $cashbook_store);
		// $tmp = Array();
		// foreach($MYarray as &$ma){
		//     $tmp[] = &$ma->created;
		// }
		// array_multisort($tmp, $MYarray);
		// $this->mViewData['results'] = $MYarray;
		// $this->render('cashbooks/verify');


		$limit = 20; $this->mViewData['limit'] = $limit;
		$current_page =  $this->input->get('page') ? $this->input->get('page'): 1;
		$this->mViewData['current_page'] = $current_page;
		$this->mPageTitle = 'Phê duyệt thu chi';

		if($this->input->post('accept') && $id){
			$this->db->set('verify_status', 1)->set('verify_id',get_current_user_id())->where('id',$id)->update('cashbook_stores');
		}

		if($this->input->post('reject') && $id){
			$this->db->set('verify_status', 2)->where('id',$id)->update('cashbook_stores');
		}

		if($id){
			$data_request =  $this->get_cashbook_stores_where_id($id);
			if(isset($data_request->verify_id) && $data_request->verify_id != 0){
				$this->db->select('	CONCAT(admin_users.last_name, " ", admin_users.first_name) as verify_name')->from('admin_users')->where('id',$data_request->verify_id);
				$data_request->verify_name = $this->db->get()->row()->verify_name;
			}
			$this->mViewData['data_request'] = $data_request;
		}

		$this->db->select('
							cashbook_stores.*,
							cashbook_stores.import_id,
							cashbook_stores.created,
							admin_stores.name as name_store,
							admin_stores.id as store_id,
							admin_users.first_name,
							admin_users.last_name,
							admin_nations.name as nation_name,
							admin_nations.id as nation_id
						')
							->from('cashbook_stores')
							->join('admin_stores', ' cashbook_stores.store_id = admin_stores.id')
							->join('admin_users', 'cashbook_stores.import_id = admin_users.id')
							->join('admin_nations', 'admin_stores.nation_id = admin_nations.id')
							->limit($limit,($current_page-1) * $limit)
							->order_by('created', 'DESC');

		$result =  $this->db->get()->result();

		$this->db->select('COUNT(cashbook_stores.id) as total_page')->from('cashbook_stores');
		$total = $this->db->get()->row();
		
		if($id_resend = $this->input->get('resend_request')){
			$rs = $this->get_cashbook_stores_where_id($id_resend);
			$rs->source = '';
			$rs->destination ='';
			$rs->group_name = !empty( $rs->type_id) ? $this->_type[$rs->type_id] : '';
			$rs->api = get_api_key_global_real();
			$rs->image_url = base_url().'assets/uploads/certificates'.$rs->file;
			$rs->url = base_url().'cashbooks/verify/'.$id_resend;
			$tmp = yeucautaophieuchi_add($rs);

			if(isset($tmp) && $tmp->status == 1){
				$this->mViewData['success'] = 'Gửi lại yêu cầu thành công!';
			}else{
				$this->mViewData['error'] = 'Gửi lại yêu cầu không thành công vui lòng xem lại!';
			}
		}

		$this->mViewData['total_page'] =$total->total_page;
		$this->mViewData['results'] = $result;
		$this->render('cashbooks/verify');
	}

	private function get_cashbook_stores_where_id($id_resend){
		$this->db->select('
		cashbook_stores.created,
		cashbook_stores.import_id as user_id,
		cashbook_stores.title as name,
		cashbook_stores.note,
		cashbook_stores.verify_status,
		cashbook_stores.verify_id,
		cashbook_stores.price as amount,
		cashbook_stores.file,
		cashbook_stores.type_id,
		CONCAT(admin_users.last_name, " ", admin_users.first_name) as user_name,
		admin_stores.description as store_name,
		admin_nations.id as nation_id
	')
		->from('cashbook_stores')
		->join('admin_stores', 'cashbook_stores.store_id = admin_stores.id')
		->join('admin_users', 'cashbook_stores.import_id = admin_users.id')
		->join('admin_nations', 'admin_stores.nation_id = admin_nations.id')
		->where('cashbook_stores.id ='.$id_resend)
		->order_by('created', 'DESC');
		$rs =  $this->db->get()->row();
		return $rs;
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
					'tbl_name' 		=> $table,
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
		redirect('cashbooks');
	}

	public function control(){
		$store_id = get_current_store_id();
		$today = $this->input->post('date');
		$type = $this->input->post('type');
		$start = $this->input->post('start');
		$end = $this->input->post('end');
		$tomorrow = date('Y-m-d', strtotime( $today." +1 days"));

		$rule_today = array(
			'store_id' => $store_id,
			'date' => $today,
			'type' => $type
		);
		$check_today = $this->cashbook_revenue->get_by($rule_today);
		if($check_today){

			$this->cashbook_revenue->update_by(
				$rule_today,
				array(
					'start' => $start,
					'end' => $end,
				)

			);

		}else{
			$rule_today['start'] = $start;
			$rule_today['end'] = $end;
			$this->cashbook_revenue->insert($rule_today);
		}	

		$rule_tomorrow = array(
			'store_id' => $store_id,
			'date' => $tomorrow,
			'type' => $type
		);
		$check_tomorrow = $this->cashbook_revenue->get_by($rule_tomorrow);
		if($check_tomorrow){
			$this->cashbook_revenue->update_by(
				$rule_tomorrow,
				array(
					'start' => $end,
				)
			);

		}else{
			$rule_tomorrow['start'] = $end;
			$this->cashbook_revenue->insert($rule_tomorrow);
		}
		$check_tomorrow = $this->cashbook_revenue->get_by($rule_tomorrow);

		$format_date = date('m/d/Y', strtotime($today));

		redirect('cashbooks/index?date_filter='.$format_date.'+-+'.$format_date.'&filter=1');
	}

	public function excel(){

		$store_id = get_current_store_id();
		$nation_id = $store_id != 8? one_stores($store_id)[0]->nation_id:1;
		$this->mViewData['nation_id'] = $nation_id;
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
			$start_date = $end_date = date('Y-m-d');
			$this->mPageTitle = 'Sổ quỹ Excel trong ngày';
		}

		$control = FALSE;
		if($start_date == $end_date && $start_date < date('Y-m-d') ){
			$control = TRUE;
		}
		$this->mViewData['control'] = $control;

		$start_amount =  $this->cashbook_revenue->get_by(
			array(
				'date' => $start_date,
				'type' => 'amount',
				'store_id' => $store_id
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
				'store_id' => $store_id
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
		if($hourDiff > 31){
			echo '<pre>';print_r('Không được chọn quá 30 ngày');echo '</pre>';die();
		}

		$results = $this->cashbook_store->order_by('created')->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				//'verify_status !='	=> 2,
				'store_id' 		=> $store_id
			)
		);
		$result_ceos = $this->cashbook->get_many_by(
			array(
				'created >=' 	=> $start_date.' 00:00:00',
				'created <=' 	=> $end_date.' 23:59:59',
				'type'			=> 'expenditures',
				'type_id'		=> 2,
				'verify_status'	=> 1,
				'store' 		=> $store_id
			)
		);
		$MYarray = array_merge($results, $result_ceos);
		
		$tmp = Array();
		foreach($MYarray as &$ma){
		    $tmp[] = &$ma->created;
		}
		array_multisort($tmp, $MYarray);
		$this->mViewData['results'] = $MYarray;
		//$this->mViewData['results'] = $results;
		$this->render('cashbooks/excel');
	}
}
