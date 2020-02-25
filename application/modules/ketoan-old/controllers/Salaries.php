<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Salaries extends Admin_Controller {
	public function __construct()
	{
		parent::__construct();
		$this->load->model('salarie_model', 'salary');
		$this->load->model('salary_month_model', 'salary_month');
		$this->load->library("excel");
	}

	public function index( $id = '')
	{
		$this->mPageTitle = "Cài đặt hàng tháng";
		$check = $this->salary_month->get_by(
			array(
				'month' => date('m-Y')
			)
		);
		if(!$check){
			$this->salary_month->insert(
				array(
					'month' => date('m-Y')
				)
			);
		}
		
		if($this->input->post('save')){
			$this->salary_month->update(
				$this->input->post('id'),
				array(
					'count_day' 	=> format_price($this->input->post('count_day')),
				)
			);
		}
		if($id){
			$item = $this->salary_month->get($id);
			$this->mViewData['item'] = $item;
		}
		$results = $this->salary_month->get_all(
		);
		$this->mViewData['results'] = $results;
		$this->render('ketoan/salaries/index');
		$this->render('index');
	}

	public function uploads()
	{
		$this->mPageTitle = 'Gửi bảng lương';
		if($this->input->post('upload_excel')){
			$file = $this->salary->upload_file('file', 'salaries');
			$this->salary->insert(
				array(
					'name' => $this->input->post('name'),
					'file' => $file,
					'import_id' => get_current_user_id(),
					'created' => date('Y-m-d H:i:s'),
				)
			);
			redirect('ketoan/salaries/uploads');
		}

		$results = $this->salary->order_by('created', 'desc')->get_all();
		$this->mViewData['results'] = $results;
		$this->render('salaries/uploads');
	}

	public function salary_view($id){
		$this->mPageTitle = 'Chi tiết bảng lương';
		$salary = $this->salary->get($id);
		if(!$salary){
			redirect('errors/page_missing');
		}
		$path = 'assets/uploads/salaries/'.$salary->file;
		if(!(file_exists($path))){
			echo '<pre>';print_r('File data không tồn tại');echo '</pre>';die();
		}else{
			$excels = $this->excel->read($path);
			$results = array();
			foreach ($excels as $key => $value) {
				$results[$key] = $value;
			}
		}
		$this->mViewData['salary'] = $salary;
		$this->mViewData['results'] = $results;
		$this->render('ketoan/salaries/salary_view');
	}
}
