<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends Admin_Controller {
	
	public function index()
	{
		$this->mPageTitle = 'Phần mềm nhân sự';
		$this->render('home');
	}


}
