<?php
function get_current_user_id(){
   $CI = get_instance();
   $CI->load->library('ion_auth');
   return $CI->ion_auth->get_user_id();
}

function get_current_user_name(){
   return get_user_name(get_current_user_id());
}

function get_user_name($id){
   $CI = get_instance();
   $user = $CI->admin_user->get($id);
   if($user)
      return $user->last_name.' '.$user->first_name;
   return 'Uknow';
}
//luyen them get line
function get_user_line($id){
   $CI = get_instance();
   $user = $CI->admin_user->get($id);
   if($user)
      return $user->line;
   return '';
}
//luyen them get main store
function get_main_store_id($id){
   $CI = get_instance();
   $user = $CI->admin_user->get($id);
   if($user)
      return $user->main_store_id;
   return 0;
}
function is_can_work(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('can_work'))){
      return TRUE;
   }
   return FALSE;
}
function is_webmaster(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster'))){
      return TRUE;
   }
   return FALSE;
}
function is_admin(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster', 'admin'))){
      return TRUE;
   }
   return FALSE;
}

function is_accountant(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster', 'admin', 'accountant'))){
      return TRUE;
   }
   return FALSE;
}

function is_leader(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster', 'admin', 'leader'))){
      return TRUE;
   }
   return FALSE;
}

function is_hr(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster', 'admin', 'hr'))){
      return TRUE;
   }
   return FALSE;
}

function is_manager(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster', 'admin', 'accountant', 'manager'))){
      return TRUE;
   }
   return FALSE;
}

function is_consultant(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster', 'admin', 'consultant'))){
      return TRUE;
   }
   return FALSE;
}


function is_technician(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('technician'))){
      return TRUE;
   }
   return FALSE;
}

function is_beauty(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('beauty'))){
      return TRUE;
   }
   return FALSE;
}

function is_telesale(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('telesale'))){
      return TRUE;
   }
   return FALSE;
}
function is_receptionist(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('webmaster', 'admin','receptionist'))){
      return TRUE;
   }
   return FALSE;
}

function is_only_consultant(){
   $CI = get_instance();
   if($CI->ion_auth->in_group(array('consultant'))){
      return TRUE;
   }
   return FALSE;
}


function get_group_users($group_id, $store_id = 'current'){
   $CI = get_instance();
   $CI->db->select('admin_users.id, admin_users.first_name, admin_users.last_name');
   $CI->db->join('admin_users_groups', 'admin_users.id = admin_users_groups.user_id');
   $CI->db->join('admin_users_stores', 'admin_users.id = admin_users_stores.user_id');
   $CI->db->where('admin_users.active', 1);
   if($store_id == 'current' ){
      $CI->db->where('admin_users_stores.store_id', get_current_store_id());
   }
   if(is_array($group_id)){
      $CI->db->where_in('admin_users_groups.group_id', $group_id);
   }else{
      $CI->db->where('admin_users_groups.group_id', $group_id);
   }
   $CI->db->order_by('admin_users.first_name');
   $CI->db->group_by('admin_users.id');
   $users = $CI->db->get('admin_users')->result();
   return $users;
}


function get_user_groups(){
   $CI = get_instance();
   $mUser_id = get_current_user_id();
   $groups = $CI->ion_auth->get_users_groups($mUser_id)->result();
   return $groups;
}

function get_user_groupname($user_id = ''){
   $CI = get_instance();
   $results = array();
   if($user_id){
      $mUser_id = $user_id;
   }else{
      $mUser_id = get_current_user_id();
   }
   $groups = $CI->ion_auth->get_users_groups($mUser_id)->result();
   foreach ($groups as $group) {
      $results[] = $group->name;
   }
   return $results;
}

function get_user_stores(){
   $CI = get_instance();
   $mUser_id = get_current_user_id();
   $CI->db->select('admin_stores.*');
   $CI->db->join('admin_users_stores', 'admin_stores.id = admin_users_stores.store_id');
   $CI->db->where('admin_users_stores.user_id', $mUser_id);
   $CI->db->group_by('admin_users_stores.store_id');
   $stores = $CI->db->get('admin_stores')->result();
   
   return $stores;
}

function get_user_stores_id($user_id = ''){
   $CI = get_instance();
   if($user_id){
      $mUser_id = $user_id;
   }else{
      $mUser_id = get_current_user_id();
   }
   

   $CI->db->select('store_id');
   $CI->db->where('user_id', $mUser_id);
   $stores = $CI->db->get('admin_users_stores')->result();
   $results = array();
   foreach ($stores as $store) {
      $results[] = $store->store_id;
   }
   return $results;
}


?>
