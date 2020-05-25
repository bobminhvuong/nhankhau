<?php
defined('BASEPATH') OR exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| CI Bootstrap 3 Configuration
| -------------------------------------------------------------------------
| This file lets you define default values to be passed into views 
| when calling MY_Controller's render() function. 
| 
| See example and detailed explanation from:
| 	/application/config/ci_bootstrap_example.php
*/
$config['ci_bootstrap'] = array(
	// Site name
	'site_name' => 'Admin Panel',
	// Default page title prefix
	'page_title_prefix' => '',
	// Default page title
	'page_title' => '',
	// Default meta data
	'meta_data'	=> array(
		'author'		=> '',
		'description'	=> '',
		'keywords'		=> ''
	),
	// Default scripts to embed at page head or end
	'scripts' => array(
		'head'	=> array(
			'assets/dist/admin/adminlte.min.js',
			'assets/dist/admin/lib.min.js',
			'assets/dist/admin/app.min.js',
			'assets/plugins/daterangepicker/moment.min.js',
			'assets/plugins/daterangepicker/daterangepicker.js',
			'assets/plugins/select2/select2.min.js',

			'assets/plugins/datatables/jquery.dataTables.min.js',
			'assets/plugins/datatables/dataTables.bootstrap.min.js',

			'assets/plugins/datatables/dataTables.buttons.min.js',
		    'assets/plugins/datatables/buttons.print.min.js',
		    'assets/plugins/datatables/buttons.flash.min.js',
		    'assets/plugins/datatables/jszip.min.js',
		    'assets/plugins/datatables/buttons.html5.min.js',


			'assets/plugins/toastr-master/build/toastr.min.js',
			'assets/plugins/sweetalert/sweetalert.min.js',
			'assets/plugins/jQueryUI/jquery-ui.min.js',
			'assets/plugins/jQueryUI/jquery.number.js',
			'assets/plugins/timepicker/bootstrap-timepicker.min.js',
			'assets/plugins/iCheck/icheck.min.js',
			'assets/plugins/angularjs/angularjs.min.js',

			'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.all.min.js',
		),
		'foot'	=> array(

			'assets/themes/invoice.js',
			'assets/themes/global.js',
			'assets/themes/binhduong.js?version='.time(),// luyen edit
		),
	),
	// Default stylesheets to embed at page head
	'stylesheets' => array(
		'screen' => array(
			'assets/dist/admin/adminlte.min.css',
			'assets/dist/admin/lib.min.css',
			'assets/dist/admin/app.min.css',
			'assets/plugins/daterangepicker/daterangepicker.css',
			'assets/plugins/select2/select2.min.css',
			'assets/plugins/datatables/dataTables.bootstrap.css',
			'assets/plugins/datatables/buttons.dataTables.min.css',
			'assets/plugins/toastr-master/build/toastr.min.css',
			'assets/plugins/jQueryUI/jquery-ui.css',
			'assets/plugins/timepicker/bootstrap-timepicker.min.css',
			'assets/plugins/iCheck/flat/blue.css',
			'assets/plugins/iCheck/flat/green.css',
			'assets/plugins/bootstrap-wysihtml5/bootstrap3-wysihtml5.min.css',
			'assets/plugins/sweetalert/sweetalert.css',
			'assets/themes/switch.css',
			'assets/themes/style.css?version='.time(),// luyen edit load new css
		)
	),
	// Default CSS class for <body> tag
	'body_class' => '',
	// Multilingual settings
	// AdminLTE settings
	'adminlte' => array(
		'body_class' => array(
			'webmaster'			=> 'skin-red',
			'admin'				=> 'skin-green',

			'accountant'		=> 'skin-purple',
			'hr'				=> 'skin-purple',

			'manager_tuition'	=> 'skin-blue',
			'consultant'		=> 'skin-blue',
			'telesale'			=> 'skin-blue',
			'manager'			=> 'skin-blue',

			'receptionist'		=> 'skin-black',
			'technician'		=> 'skin-black',
			'beauty'			=> 'skin-black',
			'dng'				=> 'skin-black',
			
		)
	),
	// Debug tools
	'debug' => array(
		'view_data'	=> FALSE,
		'profiler'	=> FALSE
	),
);


/*
| -------------------------------------------------------------------------
| Override values from /application/config/config.php
| -------------------------------------------------------------------------
*/
$config['sess_cookie_name'] = 'ci_session_admin';