<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Admin_users extends Admin_Controller {

	public function __construct()
	{
		parent::__construct();
		$this->load->library('form_builder');
		$this->load->model('permissions_model', 'permissions');
		$this->load->model('permission_groups_model', 'permission_groups');
		$this->load->model('penance_model', 'penance');
		$this->load->model('admin_user_model', 'admin_user');
		$this->load->model('admin_user_profile_model', 'admin_user_profile');
		$this->load->model('admin_user_info_model', 'admin_user_info');
		$this->load->model('admin_user_month_model', 'admin_user_month');
		$this->_type = array(
			"1" => 'Lương cơ bản',
			"2" => 'Phụ cấp trách nhiệm',
			"3" => 'Phụ cấp cơm',
			//"4" => 'Tăng ca',
			//"5" => 'Thưởng',
		);
		
	}

	// Admin Users CRUD
	public function index()
	{	
		if($this->input->post('fileSubmit')&&$this->input->post('id'))
		{
			$name_avatar = 'avatar'.(string)$this->input->post('id');
			$name_line = 'line'.(string)$this->input->post('id');
			$line = ($this->input->post($name_line)!='')? $this->input->post($name_line):'';
			
			if(isset($_FILES[$name_avatar]['name']) && $_FILES[$name_avatar]['size'] != 0 ){
				
				$file = $this->admin_user->upload_file($name_avatar, 'avatars');
				if(isset($_SERVER['HTTPS'])){
					        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
					    }
					    else{
					        $protocol = 'http';
					    }
					    $full_url = $protocol. "://" . $_SERVER['HTTP_HOST'].'/assets/uploads/avatars/'.$file;
					    //xoa avatar cu neu ton tai
					    $current_user = $this->admin_user->get(get_current_user_id());
						if($current_user->image_url && $current_user->image_url!=''){
							$file_img_old = str_replace($protocol. "://" . $_SERVER['HTTP_HOST'], '.', $current_user->image_url);
							//echo $file_img_old; return;
							if (file_exists($file_img_old))
								{    
								    unlink($file_img_old) or die("Couldn't delete file");
								}
						}
                        //save in db
                        //array_push($value,'image_url'=>$full_url);
				// $this->admin_user_profile->insert(
				// 	array(
				// 		'user_id' 	=> $laster_id,
				// 		'file'		=> $file,
				// 		'created'	=> date('Y-m-d H:i:s')
				// 	)
				// );
				
			}
			if(isset($full_url)&&$full_url!=''&&$line!=''){
				$value=array('image_url'=>$full_url,'line'=>$line);
			}
			else if(isset($full_url)&&$full_url!=''){
				$value=array('image_url'=>$full_url);
			}
			else if($line!=''){
				$value=array('line'=>$line);
			}
			if(isset($full_url)&&$full_url!=''||$line!=''){
			$this->db->reset_query();
            $this->db->where('id',$this->input->post('id'));
			$this->db->update('admin_users',$value);
			}
		}
		$all_users_online = $this->admin_user->get_many_by(
			array(
				'online' => 1,
			)
		);
		foreach ($all_users_online as $user_online) {
			//60s đăng nhập
			if(time() - $user_online->last_action > 60){
				$this->db->update('admin_users', array('online' => 0), array('id' => $user_online->id));
			}
		}
		
		$this->mPageTitle = 'Danh sách nhân viên';
		$this->db->select('admin_users.*');
		$this->db->from('admin_users');
		$this->db->join('admin_users_stores', 'admin_users.id = admin_users_stores.user_id');
		$this->db->join('admin_users_groups', 'admin_users.id = admin_users_groups.user_id');
		$this->db->where('admin_users.id !=', 1);
		$this->db->order_by('admin_users.first_name', 'asc');
		$this->db->group_by('admin_users.id');

		if($key = $this->input->get('key')){
			$key = str_replace('   ',' ',$key);
			$key = str_replace('  ',' ',$key);
			$key_ = str_replace(' ','%',$key);
			$this->db->group_start();
			$this->db->or_like('admin_users.phone', $key_);
			$this->db->or_like("CONCAT( admin_users.last_name,'%', admin_users.first_name )",$key_,'both',false);
			$this->db->or_like("CONCAT( admin_users.first_name,'%', admin_users.last_name )",$key_,'both',false);
			$this->db->group_end();
			$this->mViewData['key'] = $key;
		}
		if(isset($_GET['active']) && $_GET['active'] != "") {
			$this->db->where('admin_users.active', $_GET['active']);
			$this->mViewData['active'] = $_GET['active'];
		}
		else {
			$this->db->where('admin_users.active', 1);
			$this->mViewData['active'] = 1;
		}

		if(isset($_GET['online']) && $_GET['online'] != "") {
			$this->db->where('admin_users.online', $_GET['online']);
			$this->mViewData['online'] = $_GET['online'];
		}

		if($store_id = $this->input->get('store_id')){
			$this->db->where_in('admin_users_stores.store_id', $store_id);
			$this->mViewData['store_id'] = $store_id;
		}

		if($group_id = $this->input->get('group_id')){
			$this->db->where_in('admin_users_groups.group_id', $group_id);
			$this->mViewData['group_id'] = $group_id;
		}
		//echo $this->db->get_compiled_select();
		$admin_users = $this->db->get()->result();
		$results = array();
		foreach ($admin_users as $key => $value) {
			$value->profiles = $this->db->query("SELECT * FROM admin_user_profiles WHERE user_id = ".$value->id)->result();
			$value->groups = $this->admin_users_group->get_many_by(
				array(
					'user_id' => $value->id
				)
			);
			$value->stores = $this->admin_users_store->get_many_by(
				array(
					'user_id' => $value->id
				)
			);
		}
		$this->mViewData['results'] = $admin_users;
		$this->render('admin_users/index');
	}

	public function update()
	{	
		if($this->input->post('fileSubmit')&&$this->input->post('id'))
		{
			$name_avatar = 'avatar'.(string)$this->input->post('id');
			$name_line = 'line'.(string)$this->input->post('id');
			$line = ($this->input->post($name_line)!='')? $this->input->post($name_line):'';
			
			if(isset($_FILES[$name_avatar]['name']) && $_FILES[$name_avatar]['size'] != 0 ){
				
				$file = $this->admin_user->upload_file($name_avatar, 'avatars');
				if(isset($_SERVER['HTTPS'])){
					        $protocol = ($_SERVER['HTTPS'] && $_SERVER['HTTPS'] != "off") ? "https" : "http";
					    }
					    else{
					        $protocol = 'http';
					    }
					    $full_url = $protocol. "://" . $_SERVER['HTTP_HOST'].'/assets/uploads/avatars/'.$file;
					    //xoa avatar cu neu ton tai
					    $current_user = $this->admin_user->get(get_current_user_id());
						if($current_user->image_url && $current_user->image_url!=''){
							$file_img_old = str_replace($protocol. "://" . $_SERVER['HTTP_HOST'], '.', $current_user->image_url);
							//echo $file_img_old; return;
							if (file_exists($file_img_old))
								{    
								    unlink($file_img_old) or die("Couldn't delete file");
								}
						}
                        //save in db
                        //array_push($value,'image_url'=>$full_url);
				// $this->admin_user_profile->insert(
				// 	array(
				// 		'user_id' 	=> $laster_id,
				// 		'file'		=> $file,
				// 		'created'	=> date('Y-m-d H:i:s')
				// 	)
				// );
				
			}
			if(isset($full_url)&&$full_url!=''&&$line!=''){
				$value=array('image_url'=>$full_url,'line'=>$line);
			}
			else if(isset($full_url)&&$full_url!=''){
				$value=array('image_url'=>$full_url);
			}
			else if($line!=''){
				$value=array('line'=>$line);
			}
			if(isset($full_url)&&$full_url!=''||$line!=''){
			$this->db->reset_query();
            $this->db->where('id',$this->input->post('id'));
			$this->db->update('admin_users',$value);
			}
		}
		$this->mPageTitle = 'Cập nhật nhân viên';
		$this->db->reset_query();
		$this->db->select('*');
		$this->db->from('admin_users');
		$this->db->where('id !=', 1);
		$this->db->where('active', 1);
		$this->db->order_by('admin_users.first_name', 'asc');
		$admin_users = $this->db->get()->result();
		$this->mViewData['results'] = $admin_users;
		$store_lists = all_spas();
		$this->mViewData['store_lists'] = $store_lists;
		$this->render('admin_users/update');
	}

	public function ajax_update(){
		parse_str($_POST['data'], $post);
        $json = array();
        $value = array(
    		'birthday' 		=> $post['birthday'],
    		'id_card' 		=> $post['id_card'],
    		'id_date' 		=> $post['id_date'],
    		'phone_contact' => $post['phone_contact'],
    		'main_store_id' => $post['main_store_id'],
    		'can_work' => $post['can_work'],
    		'contract' 		=> $post['contract']
    	);
        if($this->admin_user->update($post['id'], $value)){
        	$json['success'] = true;
    	}else{
    		$json['error'] = true;
    	}
		echo json_encode($json);
        die;
	}


	public function add($action = '')
	{
		if($action){
			$this->mViewData['basic'] = TRUE;
		}else{
			$this->mViewData['basic'] = FALSE;
		}
		$this->mPageTitle = 'Thêm mới nhân viên';
		$groups = all_groups();
		$stores = all_spas();
		if(is_webmaster()){
			unset($groups[0]);
		}else{
			unset($groups[0]);
			unset($groups[1]);
		}
		$this->mViewData['groups'] = $groups;
		$this->mViewData['stores'] = $stores;
		$this->mViewData['error'] = $this->session->flashdata('error')?$this->session->flashdata('error'):'';
		$this->render('admin_users/add');
	}

	public function edit($id)
	{
		if(!is_webmaster() && $id == 1)
			redirect('/errors/page_missing', 'location');
			
		$admin_user = $this->admin_user->get($id);
		if(!$admin_user)
			redirect('/errors/page_missing', 'location');

		$admin_user->profiles = $this->db->query("SELECT * FROM admin_user_profiles WHERE user_id = ".$id)->result();

		$admin_user->groups = $this->admin_users_group->get_many_by(
			array(
				'user_id' => $id
			)
		);

		$admin_user->stores = $this->admin_users_store->get_many_by(
			array(
				'user_id' => $id
			)
		);

		$this->mViewData['admin_user'] = $admin_user;
		$groups = all_groups();
		$stores = all_spas();
		unset($groups[0]);
		/*
		if(is_webmaster()){
			unset($groups[0]);
		}else{
			unset($groups[0]);
			unset($groups[1]);
		}
		*/
		
		$this->mViewData['groups'] = $groups;
		$this->mViewData['stores'] = $stores;
		$this->mViewData['error'] = $this->session->flashdata('error')?$this->session->flashdata('error'):'';
		$this->mPageTitle = 'Chỉnh sửa nhân viên';
		$this->render('admin_users/edit');
	}

	public function remove_img($id)
	{	
		$admin_user->profiles = $this->db->query("SELECT * FROM admin_user_profiles WHERE id = ".$id)->row();
		if(is_admin()){
			$img = base_url('assets/staffs/'.$admin_user->profiles->file);
			unlink($img);
			$this->db->delete('admin_user_profiles', array('id' => $id)); 
		}
		redirect('nhansu/admin_users/edit/'.$admin_user->profiles->user_id);
	}

	

	public function save()
	{
		
		if($this->input->post('save')){
			if(!in_array($this->input->post('main_store_id'), $this->input->post('stores'))) { 
				
				$this->load->library('user_agent');
				$this->session->set_flashdata('error', 'Lỗi: Danh sách chi nhánh phân quyền phải bao gồm cả chi nhánh chính. Vui lòng thêm chi nhánh chính vào!');
				redirect($this->agent->referrer());
				die();
			}
			//$stores = $this->input->post('stores');
			//$main_store_id = $this->input->post('main_store_id');

			if($this->input->post('date_start') == ''){
				$date_start = date('Y-m-d');
			}else{
				$date_start = $this->input->post('date_start');
			}
			if($this->input->post('active') == 0){
				$date_end = date('Y-m-d');
			}else{
				$date_end = date('0000-00-00');
			}
			
			$data = array(
				'last_name'	 		=> $this->input->post('last_name'),
				'first_name' 		=> $this->input->post('first_name'),
				'username' 			=> $this->input->post('username'),
				'phone' 			=> $this->input->post('phone'),
				//'phone_contact' 	=> $this->input->post('phone_contact'),
				//'birthday' 			=> $this->input->post('birthday'),
				'date_start' 		=> $date_start,
				'date_end' 			=> $date_end,
				'main_store_id' 			=> $this->input->post('main_store_id'),

				//'address'			=> $this->input->post('address'),
				//'address_contact'	=> $this->input->post('address_contact'),
				//'id_card'			=> $this->input->post('id_card'),
				//'id_date'			=> $this->input->post('id_date'),
				'created_on'		=> time(),
				'active' 			=> $this->input->post('active'),
				'contract' 			=> $this->input->post('contract'),
				'verify' 			=> $this->input->post('verify'),
				'can_work' 			=> $this->input->post('can_work'),
			);
			if($this->input->post('id') || $this->input->post('verify') == 1){
				$data['address'] = $this->input->post('address');
				$data['address_contact'] = $this->input->post('address_contact');
				$data['phone_contact'] = $this->input->post('phone_contact');
				$data['birthday'] = $this->input->post('birthday');
				$data['id_card'] = $this->input->post('id_card');
				$data['id_date'] = $this->input->post('id_date');
			}

			if($this->input->post('password') != ''){
				$data['password'] = $this->ion_auth->hash_password($this->input->post('password'));
			}

			if($this->input->post('id')){
				//update
				$laster_id = $this->input->post('id');
				$this->admin_user->update($laster_id, $data);
				$this->admin_users_group->delete_by(
					array(
						'user_id' => $laster_id
					)
				);
				$this->admin_users_store->delete_by(
					array(
						'user_id' => $laster_id
					)
				);
			}else{
				//insert
				$this->db->reset_query();
				if($this->db->query("select count(id) as cou from admin_users where phone="."'".$this->input->post('phone')."'")->row()->cou>0){echo 'Đã tồn tại tài khoản với số điện thoại này'; die();
				}
				else {
					$this->db->reset_query();
					$this->admin_user->insert($data);
				$laster_id = $this->db->insert_id();}
			}
			if(isset($_FILES['file']) && isset($_FILES['file']['name']) && $_FILES['file']['size'] != 0 ){
				$file = $this->admin_user->upload_file('file', 'staffs');
				$this->admin_user_profile->insert(
					array(
						'user_id' 	=> $laster_id,
						'file'		=> $file,
						'created'	=> date('Y-m-d H:i:s')
					)
				);
			}


			if($this->input->post('groups')){
				foreach ($this->input->post('groups') as $group) {
					$this->admin_users_group->insert(
						array(
							'user_id' => $laster_id,
							'group_id' => $group
						)
					);
				}
			}
			if($this->input->post('stores')){
				foreach ($this->input->post('stores') as $store) {
					$this->admin_users_store->insert(
						array(
							'user_id' => $laster_id,
							'store_id' => $store
						)
					);
				}
			}
		}
		redirect('/nhansu/admin_users', 'location');
	}

	public function groups()
	{
		$this->mPageTitle = 'Nhóm quản trị';
		$groups = $this->admin_group->get_all();
		unset($groups[0]);
		$this->mViewData['results'] = $groups;
		$this->render('admin_users/groups');
	}

	public function group($group_id = NULL)
	{
		if($this->input->post('save')){
			$data = array(
				'name' => $this->input->post('name'),
				'description' => $this->input->post('description')
			);
			if($this->input->post('id')){
				$this->admin_group->update($this->input->post('id'), $data);
				$laster_id = $this->input->post('id');
			}else{
				$this->admin_group->insert($data);
				$laster_id = $this->db->insert_id();
			}
			$this->permission_groups->delete_by(array('group_id' => $group_id));
			foreach ($this->input->post('permissions') as $key => $value) {
				$this->permission_groups->insert(
					array(
						'permission_id' => $value,
						'group_id' => $laster_id
					)
				);
			}
			redirect('/nhansu//admin_users/groups', 'location');
		}

		if(empty($group_id)){
			$this->mPageTitle = 'Thêm nhóm mới';
			$group = new stdClass();
			$group->id = '';
			$group->name = '';
			$group->description = '';
		}else{
			$this->mPageTitle = 'Chỉnh sửa Nhóm';
			$group = $this->admin_group->get($group_id);
			if(!$group)
				redirect('/errors/page_missing', 'location');

		}
		$all_permissions = $this->permissions->get_all();
		foreach ($all_permissions as $key => $value) {
			$check = $this->permission_groups->get_by(
				array(
					'permission_id' => $value->id,
					'group_id' => $group_id
				)
			);
			if($check){
				$all_permissions[$key]->status = 'selected="selected"'; 
			}else{
				$all_permissions[$key]->status  = '';
			}
		}
		$this->mViewData['all_permissions'] = $all_permissions;
		$this->mViewData['group'] = $group;
		$this->render('admin_users/group');
	}

	public function permissions()
	{
		$results = $this->permissions->get_all();
		$this->mViewData['results'] = $results;
		$this->mPageTitle = 'Phân quyền';
		$this->render('admin_users/permissions');
	}

	public function permission($permission_id = NULL)
	{
		if($this->input->post('save')){
			$data = array(
				'name' => $this->input->post('name'),
				'action' => $this->input->post('action'),
				'description' => $this->input->post('description')
			);
			if($this->input->post('id')){
				$this->permissions->update($this->input->post('id'), $data);
			}else{
				$this->permissions->insert($data);
			}
			redirect('/nhansu/admin_users/permissions', 'location');
		}

		if(empty($permission_id)){
			$this->mPageTitle = 'Thêm Phân quyền';
			$group = new stdClass();
			$group->id = '';
			$group->name = '';
			$group->action = '';
			$group->description = '';
		}else{
			$this->mPageTitle = 'Chỉnh sửa Phân quyền';
			$group = $this->permissions->get($permission_id);
			if(!$group)
				redirect('/errors/page_missing', 'location');
		}
		$this->mViewData['group'] = $group;
		$this->render('admin_users/permission');
	}

	public function logout($user_id = 0)
	{
		if($user_id){
			$user = $this->admin_user->get_by(
				array(
					'active' => 1,
					'id' => $user_id
				)
			);
			if ($user) {
				if(is_admin()){
					$this->ion_auth->logout();
					$this->ion_auth_model->set_session($user);
					$this->ion_auth_model->update_last_login($user->id);
					$this->ion_auth_model->clear_login_attempts($user->email);
					$this->ion_auth_model->remember_user($user->id);
					redirect('/');
				}else{
					redirect('permission');
				}
			}
		}else{
			$this->ion_auth->logout();
		}
		redirect('login');
	}


	// Penance
	public function penance_add()
	{
		$this->mPageTitle = "Biên bản xử phạt";

		$list_users = get_group_users(array(2,8,3));
		$list_user_receives = get_group_users(array(3,4,5,6,7,8,9,10,11,12,13));
		$this->mViewData['list_users'] = $list_users;
		$this->mViewData['list_user_receives'] = $list_user_receives;
		$this->mViewData['list_users'] = $list_users;
        $this->render('penance/add');
        if(isset($_POST['save'])){
        	foreach ($this->input->post('user_id') as $user_id) {
        		$data = array(
	        		'user_id' => $user_id,	
	        		'import_id' =>	get_current_user_id(),	
	        		'cause' => $this->input->post('cause'),	
	        		'formality'	=> $this->input->post('formality'),
	        		'price'	=> $this->input->post('price'),
	        		'note' => $this->input->post('note'),
	        		'created' => date('Y-m-d H:i:s'),
	        		'store_id' => get_current_store_id(),
	        	);
	        	$this->penance->insert($data);
	        	$insert_id = $this->db->insert_id();
	        	/*
	        	if(get_option('penance_status')) {
	        		$url = 'https://quanly.seoulspa.vn/admin/penance/view/'.$insert_id;
					$content_sms = str_replace('%url%', $url, get_option( 'penance'));
					$phone = get_user_phone($user_id);
					echo '<pre>';print_r($phone);echo '</pre>';
	        		send_sms($content_sms, $phone);
				}
				*/
        	}
        	//redirect('admin/penance/lists/', 'refresh');
        }
	}
	public function penance_lists()
	{
		if($this->input->get('date_filter')){
      		$date_filter = $this->input->get('date_filter');
			$date = explode('-', $date_filter);
			$date_1 = explode('/',$date[0]);
			$date_2 = explode('/',$date[1]);
			$start_date = trim($date_1[2]) . '-' . trim($date_1[0]) . '-' . trim($date_1[1]);
			if($date[0] == $date[1]){
				$end_date = date('Y-m-d', strtotime('+1 day' ,strtotime($start_date)));
			}else{
				$end_date = trim($date_2[2]) . '-' . trim($date_2[0]) . '-' . trim($date_2[1]);
			}
		}else{
			$start_date = date('Y-m-01');
			$end_date = date('Y-m-31'); 
		}
		$where = array(
			'created >=' => $start_date.' 00:00:00',
			'created <=' => $end_date.' 23:59:59',
			'status < ' => 3,
		);
		if($this->input->get('user_id')){
			$where['user_id'] = $this->input->get('user_id');
		}
		if($this->input->get('import_id')){
			$where['import_id'] = $this->input->get('import_id');
		}
		if($this->input->get('status')){
			$where['status'] = $this->input->get('status');
		}
		$this->mPageTitle = "Danh sách";
		$list = $this->penance->get_many_by($where);
		$list_users = get_group_users(array(2,8,3));
		$list_user_receives = get_group_users(array(8,3,4,5,6,7));

		$this->mViewData['list_users'] = $list_users;
		$this->mViewData['list_user_receives'] = $list_user_receives;
		$this->mViewData['list'] = $list;
        $this->render('penance/index');
        if(isset($_POST['save'])){
        	if(is_admin()){
        		$item = $this->penance->get($_POST['id']);
        		$this->penance->update($_POST['id'], array('status' => 2, 'cancel' => $_POST['cancel'] ));
        		/*
        		if(get_option('penance_status')) {
        			$phone = get_user_phone($item->user_id);
        			$content_sms = 'Bien ban cua ban da duoc huy. Ly do: '.$_POST['cancel'];
        			send_sms($content_sms, $phone);
        		}
        		*/
        	}
        	redirect('nhansu/admin_users/penance_lists', 'refresh');
        }
	}
	public function penance_view($id)
	{
		$this->mPageTitle = "Nội dung biên bản";
		$penance = $this->penance->get($id);
		$this->mViewData['penance'] = $penance;
        $this->render('penance/view');
	}

	public function setup($id)
	{
		$this->mViewData['user_id'] = $id;
		$user = $this->admin_user->get($id);
		$this->mPageTitle = "Cài đặt nhân viên: ".$user->last_name.' '.$user->first_name;
		if($item_id = $this->input->get('id')){
			$item = $this->admin_user_info->get($item_id);
			$this->mViewData['item'] = $item;
		}
		if($this->input->post('save')){
			if($_FILES['file']['size'] != 0) {
				$file = $this->admin_user_info->upload_file('file', 'staffs');
			}else{
				$file = '';
			}

			$data = array(
				'type' 	=> $this->input->post('type'),
				'value' => format_price($this->input->post('value')),
				'date' 	=> $this->input->post('date'),
				'note' 	=> $this->input->post('note'),
			);
			if($idd = $this->input->post('id')){
				if($file != ''){
					$data['file'] = $file;
				}
				$this->admin_user_info->update($idd, $data);
			}else{
				$data['user_id'] = $id;
				$data['file'] = $file;
				$data['created'] = date('Y-m-d H:i:s');
				$data['import_id'] = get_current_user_id();
				$this->admin_user_info->insert($data);
			}
		}
		$results = $this->admin_user_info->get_many_by(
			array(
				'user_id' => $id
			)
		);
		$this->mViewData['results'] = $results;
        $this->render('nhansu/admin_users/setup');
	}

	public function custom($id)
	{
		$this->mViewData['user_id'] = $id;
		$user = $this->admin_user->get($id);
		$this->mPageTitle = "Cài đặt hàng tháng: ".$user->last_name.' '.$user->first_name;
		$check = $this->admin_user_month->get_by(
			array(
				'user_id' => $id,
				'month' => date('m-Y')
			)
		);
		if(!$check){
			$this->admin_user_month->insert(
				array(
					'user_id' => $id,
					'month' => date('m-Y')
				)
			);
		}
		
		if($this->input->post('save')){
			$this->admin_user_month->update(
				$this->input->post('id'),
				array(
					'overtime' 	=> format_price($this->input->post('overtime')),
					'bonus' 	=> format_price($this->input->post('bonus')),
					'infringe' 	=> format_price($this->input->post('infringe')),
				)
			);
		}
		if($item_id = $this->input->get('id')){
			$item = $this->admin_user_month->get($item_id);
			$this->mViewData['item'] = $item;
		}
		$results = $this->admin_user_month->get_many_by(
			array(
				'user_id' => $id
			)
		);
		$this->mViewData['results'] = $results;
		$this->render('nhansu/admin_users/custom');
	}

}


