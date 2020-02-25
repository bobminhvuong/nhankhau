<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Mpos extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('mpo_model', 'mpo');
		$this->load->model('mpos_detail_model', 'mpos_detail');
		$this->load->model('invoice_model', 'invoice');
		$this->load->model('invoice_visa_model', 'invoice_visa');
		$this->load->library('excel');
	}
	public function index()
	{
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
			$this->mPageTitle = 'Tải lên file mPos '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$start_date = date('Y-m-d', strtotime( date('Y-m-d')." -5 days"));
			$end_date = date('Y-m-d');
			$this->mPageTitle = 'Tải lên file mPos (5 ngày)';
		}
		$this->mPageTitle = 'mPos';
		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		if($this->input->post('save')){
			$file = $this->mpo->upload_file('file', 'mpos');
			$this->mpo->insert(
				array(
					'title' 	=> $this->input->post('title'),
					'note' 		=> $this->input->post('note'),
					'file' 		=> $file,
					'import_id' => get_current_user_id(),
					'created' 	=> date('Y-m-d H:i:s'),
				)
			);
			$insert_id = $this->db->insert_id();
			$path = 'assets/uploads/mpos/'.$file;
			$excels = $this->excel->read($path);
			foreach ($excels as $key => $value) {
				$data = array(
					'mpo_id' 			=> $insert_id,
					'ctgd' 				=> $value[2],
					'tenchuthe' 		=> $value[3],
					'sothe' 			=> $value[4],
					'card_bank' 		=> $value[5],
					'mid' 				=> $value[6],
					'tid' 				=> $value[7],
					'machuanchi' 		=> $value[8],
					'trangthai' 		=> $value[9],
					'sotien' 			=> $value[10],
					'loaithe' 			=> $value[11],
					'phigiaodich' 		=> $value[12],
					'kyhan' 			=> $value[13],
					'phitragop' 		=> $value[14],
					'nh_hotro' 			=> $value[15],
					'diadiem_thuchien'	=> $value[16],
					'daudocthe' 		=> $value[17],
					'tk_thanhtoan' 		=> $value[18],
					'motagiaodich' 		=> $value[19]
				);
				$excel_date = substr($value[0], 0, 5);
				$unix_date = ($excel_date - 25569) * 86400;
				$excel_date = 25569 + ($unix_date / 86400);
				$unix_date = ($excel_date - 25569) * 86400;
				$data['thoigian'] = gmdate("Y-m-d", $unix_date);

				if($value[1] != ''){
					$excel_date = substr($value[1], 0, 5);
					$unix_date = ($excel_date - 25569) * 86400;
					$excel_date = 25569 + ($unix_date / 86400);
					$unix_date = ($excel_date - 25569) * 86400;
					$data['tgketoan'] = gmdate("Y-m-d", $unix_date);

				}
				$check = $this->mpos_detail->get_by(
					array(
						'ctgd' => $value[2]
					)
				);
				if($check){
					$this->mpos_detail->update(
						$check->id,
						$data
					);
				}else{
					$this->mpos_detail->insert($data);
				}
			}
			redirect('ketoan/mpos/detail/'.$insert_id);
		}
		$results = $this->mpo->order_by('created', 'desc')->get_many_by(
			array(
				'created >=' => $start_date.' 00:00:00',
				'created <=' => $end_date.' 23:59:59',

			)
		);
		
		$this->mViewData['all_spas'] = all_spas();
		$this->mViewData['results'] = $results;
		$this->render('mpos/index');
	}

	public function detail($id)
	{
		$this->mPageTitle = 'Chi tiết file';
		$results = $this->mpos_detail->get_many_by(
			array(
				'mpo_id' => $id,
			)
		);
		$this->mViewData['results'] = $results;
		$this->render('mpos/detail');
	}

	public function lists()
	{
		$this->mPageTitle = 'Danh sách';
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
			$this->mPageTitle = 'Danh sách mPos '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$this->mPageTitle = 'Danh sách mPos trong ngày';
			$start_date = $end_date = date('Y-m-d');
		}
		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		
		$invoices = $this->invoice->select('id, date, store_id')->get_many_by(
			array(
				'date >=' => $start_date,
				'date <=' => $end_date,
				'invoice_visa_mpos !=' => 0
			)
		);
		$list_mpo_details = array();
		$list_id = array();
		
		foreach ($invoices as $invoice) {
			$list_code = array();
			if(!in_array($invoice->id, $list_id)){
				$id_item = array($invoice->id);
				$invoice_visas = $this->invoice_visa->get_many_by(
					array(
						'invoice_id' => $invoice->id,
						'type'	=> 1,
					)
				);
				foreach ($invoice_visas as $invoice_visa) {
					$list_code[] = $invoice_visa->value;
					/*
					$check_invoice_visa = $this->invoice_visa->get_many_by(
						array(
							'id !=' 	=> $invoice_visa->id,
							'value'		=> $invoice_visa->value
						)
					);
					*/
					$check_invoice_visa = $this->db->query("SELECT invoice_visas.* FROM invoices, invoice_visas WHERE invoices.id = invoice_visas.invoice_id AND invoice_visas.id !=  ".$invoice_visa->id." AND invoice_visas.value = '".$invoice_visa->value."' AND invoices.date = '".$invoice->date."'   ")->result();
					if($check_invoice_visa){
						foreach ($check_invoice_visa as $value) {
							$id_item[] = $value->invoice_id;
							$list_id[] = $value->invoice_id;

							$get_code = $this->invoice_visa->get_many_by(
								array(
									'invoice_id'	=> $value->invoice_id,
								)
							);
							foreach ($get_code as $v) {
								$list_code[] = $v->value;
							}

						}						
					}
				}
				$invoice->list_code = $list_code;
				$invoice->list_id = $id_item;
				
			}
		}
		$this->mViewData['invoices'] = $invoices;
		$this->render('mpos/lists');
	}

	public function transfer()
	{
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
			$this->mPageTitle = 'Danh sách chuyển khoản '.date('d-m', strtotime($start_date)).' &rarr; '.date('d-m', strtotime($end_date));
		}else{
			$this->mPageTitle = 'Danh sách chuyển khoản trong ngày';
			$start_date = $end_date = date('Y-m-d');
		}
		$this->mViewData['start'] = date('m/d/Y', strtotime($start_date));
		$this->mViewData['end'] = date('m/d/Y', strtotime($end_date));
		
		$invoices = $this->invoice->select('id,visa, date, store_id, invoice_visa_transfer')->get_many_by(
			array(
				'date >=' => $start_date,
				'date <=' => $end_date,
				'invoice_visa_transfer !=' => 0
			)
		);
		$results = array();
		foreach ($invoices as $invoice) {
			$invoice_visas = $this->invoice_visa->get_many_by(
				array(
					'invoice_id' => $invoice->id,
					'type'	=> 2,
				)
			);
			if($invoice_visas){
				$invoice->visa = $invoice_visas;
				
			}
			$results[] = $invoice;
		}
		$this->mViewData['results'] = $results;
		$this->render('mpos/transfer');
	}

	public function delete($id)
	{
		$this->mpos_detail->delete_by(array('mpo_id' => $id));
		$this->mpo->delete($id);
		redirect('ketoan/mpos');
	}

	public function view($id)
	{
		$this->mPageTitle = 'Chi tiết giao dịch';

		if($this->input->post('update')){
			$this->mpos_detail->update_by(
				array('ctgd' => $this->input->post('ctgd')),
				array('thoigian' => $this->input->post('date'))
			);
		}

		if(strlen($id) == 6){
			$rule = array('machuanchi' => $id);
		}else{
			$rule = array(
				'RIGHT(ctgd, 8) = ' => $id,
				'machuanchi' => '000000'
			);
		}
		$results = $this->mpos_detail->get_many_by($rule);
		$this->mViewData['results'] = $results;
		$this->render('mpos/view');
	}


}
