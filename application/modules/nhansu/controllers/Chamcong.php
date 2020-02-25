<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Chamcong extends Admin_Controller {
	public $api_key = '';

	public function __construct()
	{
		parent::__construct();
		$this->load->model('option_model', 'option');
		$this->load->model('admin_users_store_model', 'admin_users_store');
		$this->load->model('admin_users_group_model', 'admin_users_group');
		//$this->load->model('admin_users_model', 'admin_users');
		$this->load->library("excel");
		$this->api_key = get_api_key_global_real();
	}
	public function ajax_change_store($store_id){
		$data = array('api'=>$this->api_key,
         'store_id'=>$store_id,
          'offset'=>0,
          'limit'=>0
      	);
		echo json_encode(chamcong_get_staffs($data)->data);
	}
	public function store_report(){
		if($this->input->post('submit_add'))
		{
			$data_add = array(
				'api'=>$this->api_key,
				'store_id'=>$this->input->post('store_id_add'),
				//'shift'=>$this->input->get('shift_name'),
				'shift_id'=>$this->input->post('shift_add'),
				'user_id'=>$this->input->post('user_id_add'),
				'date'=>date('d/m/Y',strtotime($this->input->post('date'))),
				'checkin'=>$this->input->post('begin_add'),
				'checkout'=>$this->input->post('end_add')
				/*""api"":"""",
            ""store_id"":1,
            ""shift_id"":1,
            ""user_id"":1,
            ""date"":""12/07/2019"",
            ""checkin"":""12/07/2019 08:03"",
            ""checkout"":""12/07/2019 17:03""*/
			);

			$rs = chamcong_manual_check($data_add);
			$this->mViewData['submit_add'] = $rs;
			//print_r($data_add);print_r($rs) ; die;
			sleep(2);
			//echo '<pre>';print_r($data_edit);print_r($rs);echo '</pr>'; return;
		}
		if($this->input->post('submit_edit'))
		{		
			$penalties = intval($this->input->post('penalties'));
			//$penalties = $penalties<10000?$penalties*1000:$penalties;
			if($this->input->post('reason')=='') return;
			$data_edit = array(
				'api'=>$this->api_key,
				'id'=>$this->input->post('id'),
				//'shift'=>$this->input->get('shift_name'),
				'shift_id'=>$this->input->post('shift'),
				'checkin'=>$this->input->post('begin'),
				'checkout'=>$this->input->post('end'),
				'user_id'=>get_current_user_id(),
				'penalties'=>$penalties,
				'reason'=>$this->input->post('reason')
			);

			$rs = chamcong_update_shift($data_edit);
			$this->mViewData['submit_edit'] = $rs;
			sleep(2);
			//echo '<pre>';print_r($data_edit);print_r($rs);echo '</pr>'; return;
		}
		if($this->input->post('submit_delete'))
		{
			if($this->input->post('reason')=='') return;
			$data_delete = array(
				'api'=>$this->api_key,
				'id'=>$this->input->post('id')
			);
			$rs = chamcong_delete_shift($data_delete);
			sleep(2);
		}

		$this->mPageTitle = 'Báo cáo Chi nhánh';

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
			$this->mPageTitle = 'Báo cáo Chi nhánh '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date =  date('Y-m-01'); $end_date = date('Y-m-d');
			$this->mPageTitle = 'Báo cáo Chi nhánh từ đầu tháng';
		}
		

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));

		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 31 && $this->input->get('export')){
			echo '<pre>';print_r('Không được xuất Excel quá 1 tháng');echo '</pre>';die();
		}

		$current_page = $this->input->get('page')?intval($this->input->get('page')):1;
		$this->mViewData['current_page'] = $current_page;
		$store_id = $this->input->get('store_id')?$this->input->get('store_id'):1;
		$this->mViewData['store_id'] = $store_id;
		$this->mViewData['store_name'] = get_store_name($store_id);

		$user_id = $this->input->get('user_id');
		$this->mViewData['user_id'] = $user_id;

		$all_stores = all_spas();
		$this->mViewData['all_stores'] = $all_stores;

		$data_get_shifts = array('api' => $this->api_key );
		$all_shifts = chamcong_get_shifts($data_get_shifts); 
		if($all_shifts->status==1) $this->mViewData['all_shifts'] = $all_shifts->data;
		$limit = 50; $this->mViewData['limit'] = $limit;

		$data_get_staff = array('api' => $this->api_key,'store_id'=> $store_id,'offset'=>0,'limit'=>0 );
        $all_staff_option = chamcong_get_staffs($data_get_staff);
        $this->mViewData['all_staff_option'] = $all_staff_option;

        $is_user_id = $user_id ? $user_id : 0;
        $have_report = $this->input->get('export')==1?true:false;
        $data = array(
        	'api' => $this->api_key, 
        	'store_id' => $store_id, 
        	'user_id' => $is_user_id, 
        	'from' => date('d/m/Y', strtotime($start_date)), 
        	'to' => date('d/m/Y', strtotime($end_date)), 
        	'export' => $have_report, 
        	'offset' => $limit*($current_page-1), 
        	'limit' => $limit, 
        );
        $all_staff_of_store = chamcong_get_reports($data);
        //$this->get_report($store_id,$is_user_id,date('d/m/Y', strtotime($start_date)),date('d/m/Y', strtotime($end_date)),$have_report,$limit*($current_page-1),$limit);
        if($have_report) redirect($all_staff_of_store->download_url, 'refresh');
//echo '<pre>';  print_r($all_staff_of_store);echo '</pre>'; die();
		
		$this->mViewData['all_staff_of_store'] = $all_staff_of_store;
		$this->render('chamcong/store_report');
	}
	public function month_report(){
		
		$this->mPageTitle = 'Chấm công tháng';

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
			$this->mPageTitle = 'Chấm công tháng theo Chi nhánh '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{

			$start_date =  date('Y-m-01'); $end_date = date('Y-m-d');
			$this->mPageTitle = 'Chấm công từ đầu tháng';
		}
		

		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));

		$hourDiff = (strtotime($end_date) - strtotime($start_date)) / 86400;
		if($hourDiff > 31 && $this->input->get('export')){
			echo '<pre>';print_r('Không được xuất Excel quá 1 tháng');echo '</pre>';die();
		}

		$store_id = $this->input->get('store_id')?$this->input->get('store_id'):1;
		$this->mViewData['store_id'] = $store_id;
		$this->mViewData['store_name'] = get_store_name($store_id);

		$user_id = 0;
        $have_report = $this->input->get('store_id')?true:false;
        if($have_report) {
        	$data = array(
        	'api' => $this->api_key, 
        	'store_id' => $store_id, 
        	'user_id' => $user_id, 
        	'from' => date('d/m/Y', strtotime($start_date)), 
        	'to' => date('d/m/Y', strtotime($end_date)), 
        	'export' => true//$have_report, 
	        );
	        $month_report = chamcong_get_month_report($data);
        	//redirect($month_report->download_url, 'refresh');
			//echo '<pre>';  print_r($data); print_r($month_report);echo '</pre>'; die();
			$this->mViewData['month_report'] = $month_report;
		}
		$this->render('chamcong/month_report');
	}
}
