<?php 
function get_current_store_id(){
   $CI = get_instance();
   return $CI->session->userdata('store_id');
}

function all_groups(){
   $CI = get_instance();
   $CI->load->model('admin_group_model', 'admin_group');
   $groups = $CI->admin_group->order_by('id')->get_all();
   return $groups;
}

function all_spas(){
   $CI = get_instance();
   $CI->load->model('admin_store_model', 'admin_store');
   $stores = $CI->admin_store->order_by('id')->get_all();
   return $stores;
}

function all_stores(){
   $CI = get_instance();
   $CI->load->model('admin_store_model', 'admin_store');
   $stores = $CI->admin_store->order_by('id')->get_many_by(
      array('id !=' => 8)
   );
   return $stores;
}

function one_stores($ids){
   $CI = get_instance();
   $CI->load->model('admin_store_model', 'admin_store');
   $stores = $CI->admin_store->order_by('id')->get_many_by(
      array('id != 8 AND id in ('.$ids.')')
   );
   return $stores;
}
function get_group_name($id){
   $CI = get_instance();
   $group = $CI->admin_group->get($id);
   if($group) 
      return $group->description;
   return 'Uknow';
}

function get_store_name($id){
   $CI = get_instance();
   $store = $CI->admin_store->get($id);
   if($store) 
      return $store->description;
   return 'Uknow';
}
function get_store_address($id){
   $CI = get_instance();
   $store = $CI->admin_store->get($id);
   if($store) 
      return $store->address;
   return 'Uknow';
}

function all_services($nation_id=1){
   $CI = get_instance();
   $CI->load->model('service_model', 'service');
   $services = $CI->service->order_by('description')->get_many_by(array('active' => 1, 'type' => 'spa','nation_id'=>$nation_id));
   return $services;
}

function all_nails($nation_id=1){
   if(get_current_store_id() != 1) return array();
   $CI = get_instance();
   $CI->load->model('service_model', 'service');
   $services = $CI->service->order_by('description')->get_many_by(array('active' => 1, 'type' => 'nail','nation_id'=>$nation_id));
   return $services;
}

function get_service_name($id){
   $CI = get_instance();
   $CI->load->model('service_model', 'service');
   $service = $CI->service->get($id);
   if($service) 
      return $service->description;
   return 'Uknow';
}

function get_package_name($id){
   $CI = get_instance();
   $CI->load->model('package_model', 'package');
   $package = $CI->package->get($id);
   if($package) 
      return $package->description;
   return 'Uknow';
}


function check_package_services($package_id){
   $CI = get_instance();
   $CI->load->model('package_unit_model', 'package_unit');
   $package_unit = $CI->package_unit->get_by(array('package_id' => $package_id));
   if ($package_unit) return TRUE;
   return FALSE;
}

function all_packages($nation_id=1){
   $CI = get_instance();
   $CI->load->model('package_model', 'package');
   $CI->db->select('packages.*');
   $CI->db->from('packages', 'package_units');
   $CI->db->join('package_units', 'packages.id = package_units.package_id');
   $CI->db->where('packages.type', 'normal');
   $CI->db->where('packages.active', 1);
   $CI->db->where('packages.nation_id', $nation_id);
   $CI->db->order_by('packages.id', 'DESC');
   $CI->db->group_by('packages.id');
   $results = $CI->db->get()->result();
   return $results;
}

function all_gifts($nation_id=1){
   $CI = get_instance();
   $CI->load->model('package_model', 'package');
   $gifts = $CI->package->get_many_by(
      array(
         'active' => 1, 
         'type' => 'gift',
         'nation_id' => $nation_id
      )
   );
   return $gifts;
}

function all_products($nation_id=1){
   $CI = get_instance();
   $CI->load->model('product_model', 'product');
   $products = $CI->product->order_by('description')->get_many_by(
      array(
         'active' => 1,
         'type'   => 'retail',
         'nation_id'=>$nation_id
      )
   );
   return $products;
}

function all_products_full(){
   $CI = get_instance();
   $CI->load->model('product_model', 'product');
   $products = $CI->product->order_by('description')->get_many_by(array('active' => 1));
   return $products;
}

function get_product_name($id){
   $CI = get_instance();
   $CI->load->model('product_model', 'product');
   $product = $CI->product->get($id);
   if($product) 
      return $product->description;
   return 'Uknow';
}

//get product code
function get_product_code($id){
   $CI = get_instance();
   $CI->load->model('product_model', 'product');
   $product = $CI->product->get($id);
   if($product) 
      return $product->code;
   return 'Uknow';
}

function get_customer_id_for_phone($phone){
   $CI = get_instance();
   $CI->load->model('customer_model', 'customer');
   $customer = $CI->customer->get_by(array('phone' => $phone));
   if(!$customer) {
      return 0;
   }
   return $customer->id;
}


function get_customer($id){
   $CI = get_instance();
   $CI->load->model('customer_model', 'customer');
   $customer = $CI->customer->get($id);
   if(!$customer) {
      $customer = new stdClass();
      $customer->id = 0;
      $customer->name = 'Uknow';
      $customer->phone = 'Uknow';
   }
   return $customer;
}

function get_customer_name($id){
   $CI = get_instance();
   $CI->load->model('customer_model', 'customer');
   $customer = $CI->customer->get($id);
   if($customer) 
      return $customer->name;
   return 'Uknow';
}

function get_customer_phone($id){
   $CI = get_instance();
   $CI->load->model('customer_model', 'customer');
   $customer = $CI->customer->get($id);
   if($customer) 
      return $customer->phone;
   return 'Uknow';
}

function time_last_login($time){
   $result = '';
   $date1=date_create(date("d-m-Y H:i:s", $time));
   $date2=date_create(date('d-m-Y H:i:s'));
   $diff = date_diff($date1, $date2);
   if($diff->format("%y") > 0){
      if( $diff->format("%y") == 48){
         return 'Chưa đăng nhập';
      }else{
         $result .= $diff->format("%y").' năm ';
         return $result; 
      }
   }
   if($diff->format("%m") > 0){
      $result .= $diff->format("%m").' tháng ';
      return $result;
   }
   if($diff->format("%d") > 0){
      $result .= $diff->format("%d").' ngày ';
   }
   if($diff->format("%h") > 0){
      $result .= $diff->format("%h").' giờ ';
   }
   if($diff->format("%i") > 0){
      $result .= $diff->format("%i").' phút ';
   }
   if(empty($result)) $result = 'Vừa xong';
   return $result;
}

function format_phone($phone) {
   $phone_array=(str_split($phone));
   for ($i=0; $i<count($phone_array); $i++) {
      if (($phone_array[$i]!="0") && ($phone_array[$i]!="1") && ($phone_array[$i]!="2") && ($phone_array[$i]!="3") && ($phone_array[$i]!="4")
      && ($phone_array[$i]!="5") && ($phone_array[$i]!="6") && ($phone_array[$i]!="7") && ($phone_array[$i]!="8")
      && ($phone_array[$i]!="9") && ($phone_array[$i]!="+") ) {
         $phone_array[$i]="del";
      }
   }
   $phone_format="";
   for ($i=0; $i<count($phone_array); $i++) {
   if ($phone_array[$i]!="del") {
   $phone_format = $phone_format.$phone_array[$i];}
   }
   return $phone_format;
}

function is_phone_number($number){
   $number = preg_replace("/[^0-9]/", '', $number);
   if(strlen($number) == 11 || strlen($number) == 10 || strlen($number) == 9){
      return true;
   }
   return false;
}

function char_limiter($str, $n = 500, $end_char = '&#8230;')
{
   if (mb_strlen($str) < $n)
   {
      return $str;
   }
   return substr( $str,  0, $n).$end_char;
}

function str_unicode($str) {  
   $str = preg_replace("/(à|á|ạ|ả|ã|â|ầ|ấ|ậ|ẩ|ẫ|ă|ằ|ắ|ặ|ẳ|ẵ)/", 'a', $str);  
   $str = preg_replace("/(è|é|ẹ|ẻ|ẽ|ê|ề|ế|ệ|ể|ễ)/", 'e', $str);  
   $str = preg_replace("/(ì|í|ị|ỉ|ĩ)/", 'i', $str);  
   $str = preg_replace("/(ò|ó|ọ|ỏ|õ|ô|ồ|ố|ộ|ổ|ỗ|ơ|ờ|ớ|ợ|ở|ỡ)/", 'o', $str);  
   $str = preg_replace("/(ù|ú|ụ|ủ|ũ|ư|ừ|ứ|ự|ử|ữ)/", 'u', $str);  
   $str = preg_replace("/(ỳ|ý|ỵ|ỷ|ỹ)/", 'y', $str);  
   $str = preg_replace("/(đ)/", 'd', $str);  
   $str = preg_replace("/(À|Á|Ạ|Ả|Ã|Â|Ầ|Ấ|Ậ|Ẩ|Ẫ|Ă|Ằ|Ắ|Ặ|Ẳ|Ẵ)/", 'A', $str);  
   $str = preg_replace("/(È|É|Ẹ|Ẻ|Ẽ|Ê|Ề|Ế|Ệ|Ể|Ễ)/", 'E', $str);  
   $str = preg_replace("/(Ì|Í|Ị|Ỉ|Ĩ)/", 'I', $str);  
   $str = preg_replace("/(Ò|Ó|Ọ|Ỏ|Õ|Ô|Ồ|Ố|Ộ|Ổ|Ỗ|Ơ|Ờ|Ớ|Ợ|Ở|Ỡ)/", 'O', $str);  
   $str = preg_replace("/(Ù|Ú|Ụ|Ủ|Ũ|Ư|Ừ|Ứ|Ự|Ử|Ữ)/", 'U', $str);  
   $str = preg_replace("/(Ỳ|Ý|Ỵ|Ỷ|Ỹ)/", 'Y', $str);  
   $str = preg_replace("/(Đ)/", 'D', $str);  
   $str = str_replace("%20", ' ', $str);    
   return $str;  
}

function send_sms($content, $phones = array(), $type = 2 ){

   //1: Tin hiển thị thương hiệu(Brandname) quảng cáo. Mỗi lần gửi tối thiểu 20 số. Phải đăng ký Brandname trước mới gửi được
   //2: Tin hiển thị thương hiệu(Brandname) chăm sóc khách hàng. Có thể gửi 1 lần 1 số, tin đi ngay. Phải đăng ký Brandname trước mới gửi được
   //3: Đầu số ngẫu nhiên dạng (09xxxxx), giá rẻ, dùng để quảng cáo, tốc độ chậm
   //7: Đầu số ngẫu nhiên dạng (09xxxxx), dùng để gửi các tin nhắn không mang nội dung dung quảng cáo, tốc độ cao như mã kích hoạt, xác nhận đơn hàng
   //6: Đầu số cố định dạng (19001525) - hiển thị số 19001525, dùng cho chăm sóc khách hàng
   //4: Đầu số cố định dạng (19001534) - hiển thị số 19001534, dùng cho quảng cáo, khuyến mãi
   $CI = get_instance();
   $CI->load->model('sms_model', 'sms');
   if(!empty($content) && !empty($phones)){

      $APIKey = get_option('APIKeySMS');
      $SecretKey = get_option('SecretKeySMS');
      //$APIKey = '1DB185DCFB40836B29BFC1A500E3EB';
      //$SecretKey = '762A93BF6D0A97E73A833BC07EDC8F';

      $content = char_limiter(str_unicode($content), 160, '') ;
      $ch = curl_init();
      $numbers_sent = array();
      $Send_SMS_Xml  = "<RQST>";
         $Send_SMS_Xml .= "<APIKEY>". $APIKey ."</APIKEY>";
         $Send_SMS_Xml .= "<SECRETKEY>". $SecretKey ."</SECRETKEY>";
         $Send_SMS_Xml .= "<ISFLASH>0</ISFLASH>";
         $Send_SMS_Xml .= "<BRANDNAME>SeoulSpa.Vn</BRANDNAME>";
         $Send_SMS_Xml .= "<SMSTYPE>".$type."</SMSTYPE>";
         $Send_SMS_Xml .= "<CONTENT>".$content."</CONTENT>";
         $Send_SMS_Xml .= "<CONTACTS>";
         if(is_numeric($phones) && is_phone_number($phones)){
            $phones = preg_replace("/[^0-9]/", '', $phones);
            $Send_SMS_Xml .= "<CUSTOMER><PHONE>".$phones."</PHONE></CUSTOMER>";
            $numbers_sent[] = $phones;
         }
         else if(is_array($phones)){
            $phones = array_values(array_unique($phones));
            foreach ($phones as $number) {
               if(is_phone_number($number)){
                  $number = preg_replace("/[^0-9]/", '', $number);
                  $Send_SMS_Xml .= "<CUSTOMER><PHONE>".$number."</PHONE></CUSTOMER>";
                  $numbers_sent[] = $number;
               }
            }
         }
         $Send_SMS_Xml .= "</CONTACTS>";
      $Send_SMS_Xml .= "</RQST>";
      if(!empty($numbers_sent)){
         curl_setopt($ch, CURLOPT_URL, "http://api.esms.vn/MainService.svc/xml/SendMultipleMessage_V4/" );
         curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1 );
         curl_setopt($ch, CURLOPT_POST,           1 );
         curl_setopt($ch, CURLOPT_POSTFIELDS,     $Send_SMS_Xml ); 
         curl_setopt($ch, CURLOPT_HTTPHEADER,     array('Content-Type: text/plain')); 
         $result = curl_exec ($ch); 
         $sent_result = simplexml_load_string($result);

         if ($sent_result === false) {
            die('Error parsing XML');   
         }else{
            if(isset($sent_result->SMSID)){
               $sms_id = $sent_result->SMSID;
               /*
               $SMS_Status = get_sms_status($sms_id);
               $data_sms = array(
                  'sms_id' => $sms_id,
                  'sms_type' => $type,
                  'content' => $content,
                  'type_send' => '1',
                  'user_send' => (get_current_user_id()) ? get_current_user_id() : 0,
                  'code_result' => $sent_result->CodeResult,
                  'send_status' => $SMS_Status->StatusCode,
                  'total_sent' => $SMS_Status->TotalSent,
                  'total_receiver' => $SMS_Status->TotalReceiver,
                  'sent_success' => $SMS_Status->SuccessCount,
                  'sent_failed' => $SMS_Status->FailedCount,
                  'error_message' => (isset($SMS_Status->ErrorMessage)) ? $SMS_Status->ErrorMessage : '',
                  'total_price' => $SMS_Status->TotalPrice,
                  'date_send' => date('Y-m-d H:i:s'),
               ); 
               $CI->sms->insert($data_sms);
               $CI->sms->insert_sms_receiver($sms_id, $numbers_sent);
               */
               return true;
            }
         }
      }else{
         return false;
      }
   }else{
      return false;
   }
}

function update_sms($sms_id){
   $CI = get_instance();
   $CI->load->model('sms_model', 'sms');
   $status = get_sms_status($sms_id);
   $data_sms = array(
      'send_status' => $status->SendStatus,
      'total_sent' => $status->TotalSent,
      'total_receiver' => $status->TotalReceiver,
      'sent_success' => $status->SuccessCount,
      'sent_failed' => $status->FailedCount,
      'error_message' => (isset($status->ErrorMessage)) ? $status->ErrorMessage : '',
      'total_price' => $status->TotalPrice,
      'updated_at' => date('Y-m-d H:i:s'),
   );
   return $CI->sms->update($sms_id, $data_sms);
}

function get_sms_status($SMSID){
   $APIKey = '1DB185DCFB40836B29BFC1A500E3EB';
   $SecretKey ='762A93BF6D0A97E73A833BC07EDC8F';
   $ch = curl_init();
   $url = 'http://rest.esms.vn/MainService.svc/xml/GetSendStatus?RefId='.$SMSID.'&ApiKey='.$APIKey.'&SecretKey='.$SecretKey.'';
   curl_setopt($ch, CURLOPT_URL, $url);
   return simplexml_load_file($url);
}

function get_sms_balance(){
   //$APIKey = get_option( 'APIKeySMS', '1DB185DCFB40836B29BFC1A500E3EB');
   //$SecretKey = get_option( 'SecretKeySMS', '762A93BF6D0A97E73A833BC07EDC8F');
   $APIKey = get_option('APIKeySMS');//'1DB185DCFB40836B29BFC1A500E3EB';
   $SecretKey = get_option('SecretKeySMS');//'762A93BF6D0A97E73A833BC07EDC8F';
   $data="http://rest.esms.vn/MainService.svc/json/GetBalance/$APIKey/$SecretKey";
   $curl = curl_init($data); 
   curl_setopt($curl, CURLOPT_FAILONERROR, true); 
   curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
   $result = curl_exec($curl); 
   $obj = json_decode($result,true);
   return $obj;
}

function get_sms_balance_CPC(){
   //$APIKey = get_option( 'APIKeySMS', '1DB185DCFB40836B29BFC1A500E3EB');
   //$SecretKey = get_option( 'SecretKeySMS', '762A93BF6D0A97E73A833BC07EDC8F');
   $APIKey = get_option('APIKeySMS_CPC');//'F871BE4D0DA655B3B99415FF25D602';
   $SecretKey = get_option('SecretKeySMS_CPC');//'69DBA57D9B153443C031D72DA162D7';
   $data="http://rest.simosms.com/MainService.svc/json/GetBalance/$APIKey/$SecretKey";
   $curl = curl_init($data); 
   curl_setopt($curl, CURLOPT_FAILONERROR, true); 
   curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true); 
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true); 
   $result = curl_exec($curl); 
   $obj = json_decode($result,false);
   return $obj;
}
function send_sms_CPC($content, $phones, $type = 2 ){
   $phone_sms = $phones;
   if(substr($phone_sms, 0,3)=='855') $phone_sms = substr($phone_sms,3);
   if(substr($phone_sms, 0,1)=='0') $phone_sms = substr($phone_sms,1);
   $phone_sms = '855'.$phone_sms;
   $CI = get_instance();
   $CI->load->model('sms_model', 'sms');
   if(!empty($content) && !empty($phones)){
      $content = urlencode($content);
      $APIKey = get_option('APIKeySMS_CPC');
      $SecretKey = get_option('SecretKeySMS_CPC');
      $url = 'http://rest.simosms.com/MainService.svc/json/SendMultipleMessage_V4?Phone='.$phone_sms.'&Content='.$content.'&ApiKey='.$APIKey.'&SecretKey='.$SecretKey.'&SmsType=2&IsUnicode=1&Sandbox=1&Brandname=SEOUL%20SPA';
      $ch = curl_init($url);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:text/plain'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }else{
      return false;
   }
}

function get_option($name){
   $CI = get_instance();
   $CI->load->model('option_model', 'option');
   $option = $CI->option->get_by(array('name' => $name));
   if($option) return $option->value;
   return '';
}

function get_comment($id){
   $CI = get_instance();
   $CI->load->model('ads_detail_model', 'ads_detail');
   $lists = $CI->ads_detail->get_many_by(array('ads_data_id' => $id));
   $results = '';
   foreach ($lists as $key => $list) {
      if($list->action == 1){
         $label = 'label label-primary';
      }
      elseif($list->action == 2){
         $label = 'label label-warning';
      }
      else{
         $label = 'label label-danger';
      };
      if(empty($list->note)) $list->note = '...';
      $created = date('d-m', strtotime($list->created)).' '.date('H:i', strtotime($list->created));
      $results .= '<label class="'.$label.'">'.$created.' : '.$list->note.'</label><br>';

   }
   return $results;
}

function view_kpi($category, $unit_id, $nation_id=1){
   $list_items = array();
   $CI = get_instance();
   $CI->load->model('kpi_model', 'kpi');
   $kpi = $CI->kpi->order_by('staff, date', 'asc')->get_many_by(
      array(
         'category' => $category,
         'unit_id' => $unit_id,
         'active' => 1
      )
   );
   foreach ($kpi as $value) {
      if($value->staff == 'technician'){

         $staff = 'Kỹ thuật viên';
      }
      else if($value->staff == 'beauty'){
         $staff = 'Soi da';
      }
      if(in_array($value->staff, $list_items)){
         //$staff = '|__';
      }else{
         $list_items[] = $value->staff;
      }

      if($value->unit == 'percent'){
         $unit = $value->number.' %';
      }
      else if($value->unit == 'amount'){
         $unit = format_currency($value->number,$nation_id);
      }
      echo $staff.': '.$unit;
      echo '<br>';
      echo '<small>|__'.date('d-m-Y', strtotime($value->date)).' (HD:'.$value->invoice_type.')</small>';
      echo '<br>';
   }
}

function get_kpi($staff, $category, $unit_id, $date, $invoice_type, $price){
   $result = array(
      'unit' => 'null',
      'type' => 'null',
      'kpi' => 0,
   );
   $CI = get_instance();
   $CI->load->model('kpi_model', 'kpi');
   $kpi = $CI->kpi->order_by('date', 'desc')->get_by(
      array(
         'category' => $category,
         'staff' => $staff,
         'unit_id' => $unit_id,
         'date <=' => $date,
         'invoice_type' => $invoice_type,
         'active' => 1
      )
   );
   if($kpi){
      $result['unit'] = $kpi->number;
      if($kpi->unit == 'amount'){
         $result['type'] = 'vnđ';
         $result['kpi'] = $kpi->number;
      }elseif($kpi->unit == 'percent'){
         $result['type'] = '%';
         $result['kpi'] = $price*0.01*$kpi->number;
      }
   }
   return $result;
}

function notif_appointments(){
   $CI = get_instance();
   $CI->load->model('appointment_model', 'appointment');
   $results = $CI->appointment->order_by('time')->get_many_by(
      array(
         'store_id' => get_current_store_id(),
         'status' => 0,
         'date' => date('Y-m-d'),
         'time >=' => date('H:i:s', time()),
         'time <=' => date('H:i:s', time() + 3600),
      )
   );
   return $results;
}

function check_verify(){
   $CI = get_instance();
   $user_id = get_current_user_id();
   $CI->load->model('cashbook_model', 'cashbook');
   $CI->load->model('cashbook_store_model', 'cashbook_store');
   $count = 0;
   $rule = array(
      'verify_status'   => 0,
      'verify_id'       => $user_id,
      'active'          => 0
   );
   $cashbook = $CI->cashbook->get_many_by($rule);
   $count += count($cashbook);
   $cashbook_store = $CI->cashbook_store->get_many_by($rule);
   $count += count($cashbook_store);
   return $count;
}

function get_verify(){
   $CI = get_instance();
   $user_id = get_current_user_id();
   $CI->load->model('cashbook_model', 'cashbook');
   $CI->load->model('cashbook_store_model', 'cashbook_store');
   $count = 0;
   $rule = array(
      'verify_status'   => 0,
      'verify_id'    => $user_id
   );
   $cashbook = $CI->cashbook->get_many_by($rule);
   $count += count($cashbook);
   $cashbook_store = $CI->cashbook_store->get_many_by($rule);
   $count += count($cashbook_store);
   return $count;
}

function minify_phone($phone){
   return '****'.substr($phone, 4);
}

function get_invoice_images($invoice_id){
   $CI = get_instance();
   $CI->load->model('invoice_image_model', 'invoice_image');
   $results = $CI->invoice_image->get_many_by(
      array(
         'invoice_id' => $invoice_id,
      )
   );
   if($results){
      $images = ' <i class="fa fa-image viewCustomerImages" style="cursor: pointer; color: blue" data-id="'.$invoice_id.'"></i>';
      /*
      $images .= '<div class="modal fade" id="image-'.$invoice_id.'" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
                     <div class="modal-dialog modal-lg">
                        <div class="modal-content">
                           <div id="carousel-example-generic-'.$invoice_id.'" class="carousel slide" data-ride="carousel" data-interval="false">
                              <div class="carousel-inner text-center">';
                              foreach ($results as $key => $value) {
                                 if($key == 0) $active = 'active';
                                 else $active = '';
                                 $images .= '<div class="item '.$active.'">';
                                 $images .= '   <img class="img-responsive" data-src="assets/uploads/customers/'.$value->image.'">';
                                 $images .= '</div>';
                              } 

      $images .=              '</div>
                              <a class="left carousel-control" href="#carousel-example-generic-'.$invoice_id.'" role="button" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a>
                              <a class="right carousel-control" href="#carousel-example-generic-'.$invoice_id.'" role="button" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
                           </div>
                         </div>
                     </div>
                  </div>';
      */
      return $images;
   }
   return '';
}

function is_image($image){
   $img = substr($image, -3);
   if(in_array($img, array('png', 'PNG', 'jpg', 'JPG', 'bmp', 'BMP', 'peg', 'PEG')))
      return TRUE;
   return FALSE;
}

function format_price($price){
   return (INT)str_replace(".", "", $price);
}

function call_api($method = 'POST', $curl, $data = array()){
   $data_string = json_encode($data);
   $curl = curl_init($curl);
   curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
   curl_setopt($curl, CURLOPT_HTTPHEADER, array(
      'Content-Type: application/json',
      'Content-Length: ' . strlen($data_string))
   );
   curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);  // Make it so the data coming back is put into a string
   curl_setopt($curl, CURLOPT_POSTFIELDS, $data_string);  // Insert the data
   // Send the request
   $result = curl_exec($curl);
   return json_decode($result);
}

function get_verify_status($table, $id){
   $CI = get_instance();
   $value = $CI->db->query("SELECT * FROM ".$table." WHERE id = ".$id." ")->row();
   if($value){
      if( $value->verify_id != get_current_user_id()){
         if($value->verify_status == 0) echo '<span class="label label-primary">Chờ duyệt</span>';
         else if($value->verify_status == 1) echo '<span class="label label-success">Đã duyệt</span>';
         else if($value->verify_status == 2) echo '<span class="label label-danger">Không duyệt</span>';
      }else{?>
      <div class="verify">
         <div class="panel list-group" style="margin-bottom: 5px">
            <?php
            if($value->verify_status == 0){ 
               $class = '';
               $title = 'Chưa duyệt';
            }
            else if($value->verify_status == 1){ 
               $class = 'btn-success';
               $title = 'Đã duyệt';
            }
            else if($value->verify_status == 2) {
               $class = 'btn-danger';
               $title = 'Không duyệt';
            }
            else{ 
               $class = 'btn-warning';
               $title = 'Unknown';
            }?>
            <button class="btn btn-xs <?php echo $class;?>" data-toggle="collapse" data-target="#packages-<?php echo $value->id;?>" data-parent="#menu"><?php echo $title;?></button>
            <div id="packages-<?php echo $value->id;?>" class="sublinks collapse">
               <a class="list-group-item small btn-verify" data-table="<?php echo $table;?>" data-id="<?php echo $value->id;?>" data-status="0">Chưa duyệt</a>
               <a class="list-group-item small btn-verify" data-table="<?php echo $table;?>" data-id="<?php echo $value->id;?>" data-status="1">Duyệt</a>
               <a class="list-group-item small btn-verify" data-table="<?php echo $table;?>" data-id="<?php echo $value->id;?>" data-status="2">Không duyệt</a>
            </div>
         </div>
      </div>
   <?php } }
}

function get_depot_items($table, $id){
   $CI = get_instance();
   $lists = $CI->db->query("SELECT * FROM depot_actions_items WHERE tbl_name = '".$table."' AND parent_id = ".$id." ")->result();
   foreach ($lists as $key => $value) {
      echo $value->quantity.' x '.get_product_name($value->item_id).'<br>';
   }
}

function get_depot_item_product_code($table, $id){
   $CI = get_instance();
   $lists = $CI->db->query("SELECT * FROM depot_actions_items WHERE tbl_name = '".$table."' AND parent_id = ".$id." ")->result();
   foreach ($lists as $key => $value) {
      echo get_product_code($value->item_id).'<br>';
   }
}

function product_code($table, $id){
   $CI = get_instance();
   $lists = $CI->db->query("SELECT code FROM products WHERE id = ".$id." ")->result();
   foreach ($lists as $key => $value) {
      echo $value->code.'<br>';
   }
}

function get_item_depots($table, $id){
   $CI = get_instance();
   $lists = $CI->db->query("SELECT * FROM depot_actions_items WHERE tbl_name = '".$table."' AND parent_id = ".$id." ")->result();
   return $lists;
}

function update_cashbook_revenue($today, $store_id ){
   $CI = get_instance();
   $CI->load->model('cashbook_revenue_model', 'cashbook_revenue');
   $list_check = array('amount', 'transfer');


   foreach ($list_check as $item) {
      $check = $CI->cashbook_revenue->get_by(
         array(
            'date' => $today,
            'type' => $item,
            'store_id' => $store_id
         )
      );
      if(!$check){
         $last = $CI->cashbook_revenue->order_by('date', 'DESC')->get_by(
            array(
               'type' => $item,
               'store_id' => $store_id
            )
         );
         $data['store_id'] = $store_id;
         $data['type'] = $item;
         $data['date'] = $today;
         if($last){
            $data['start'] = $last->end;
         }else{
            $data['start'] = 0;
         }
         $CI->cashbook_revenue->insert($data);
      }
   }

   $start_amount =  $CI->cashbook_revenue->get_by(
      array(
         'date' => $today,
         'type' => 'amount',
         'store_id' => $store_id
      )
   )->start;

   $start_transfer =  $CI->cashbook_revenue->get_by(
      array(
         'date' => $today,
         'type' => 'transfer',
         'store_id' => $store_id
      )
   )->start;
   
   $results = $CI->cashbook_store->order_by('created')->get_many_by(
      array(
         'created >='   => date($today.' 00:00:00'),
         'created <='   => date($today.' 23:59:59'),
         'store_id'     => $store_id,
         'verify_status'     => 1,
      )
   );
   $result_ceos = $CI->cashbook->get_many_by(
      array(
         'created >='   => date($today.' 00:00:00'),
         'created <='   => date($today.' 23:59:59'),
         'type'         => 'expenditures',
         'type_id'      => 2,
         'verify_status'   => 1,
         'store'     => $store_id
      )
   );
   $MYarray = array_merge($results, $result_ceos);
   $total_amount = intval($start_amount);
   $total_visa = $start_transfer;
   foreach ($MYarray as $key => $value) {
      if($value->source == 'amount'){
         if(isset($value->store)){
            if($value->verify_status == 1){ //lúc đầu là !=2
               $total_amount += $value->price;
            }
         }else{
            if($value->type == 'expenditures'){
               if($value->verify_status == 1){ //lúc đầu là !=2
                  $total_amount -= $value->price;
               }
            }
            else if($value->type == 'receipts'){

               if($value->verify_status == 1){ //lúc đầu là !=2
                  $total_amount += $value->price;
               }
            }
         }
      }

      else if($value->source == 'transfer'){
         if(isset($value->store)){
            $total_visa += $value->price;
         }else{
            if($value->type == 'expenditures'){
    
               $total_visa -= $value->price;
            }
            else if($value->type == 'receipts'){
               $total_visa += $value->price;
            }
         }
      }
   }
   $CI->cashbook_revenue->update_by(
      array(
         'store_id' => $store_id,
         'date' => $today,
         'type' => 'amount'
      ),
      array(
         'end' => $total_amount
      ) 
   );
   $CI->cashbook_revenue->update_by(
      array(
         'store_id' => $store_id,
         'date' => $today,
         'type' => 'transfer'
      ),
      array(
         'end' => $total_visa
      ) 
   );

   $tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($today)));


   $check_tomorrow_amount = $CI->cashbook_revenue->get_by(
      array(
         'date' => $tomorrow,
         'type' => 'amount',
         'store_id' => $store_id
      )
   );
   if($check_tomorrow_amount){
      $CI->cashbook_revenue->update(
         $check_tomorrow_amount->id,
         array(
            'start' => $total_amount
         )
      );
   }else{
      $CI->cashbook_revenue->insert(
         array(
            'date' => $tomorrow,
            'type' => 'amount',
            'store_id' => $store_id,
            'start' => $total_amount
         )
      );
   }

   $check_tomorrow_transfer = $CI->cashbook_revenue->get_by(
      array(
         'date' => $tomorrow,
         'type' => 'transfer',
         'store_id' => $store_id
      )
   );
   if($check_tomorrow_transfer){
      $CI->cashbook_revenue->update(
         $check_tomorrow_transfer->id,
         array(
            'start' => $total_visa
         )
      );
   }else{
      $CI->cashbook_revenue->insert(
         array(
            'date' => $tomorrow,
            'type' => 'transfer',
            'store_id' => $store_id,
            'start' => $total_visa
         )
      );
   }
}

function update_cashbook_revenue_center($today){
   $CI = get_instance();
   $CI->load->model('cashbook_revenue_model', 'cashbook_revenue');
   $list_check = array('amount', 'transfer');


   foreach ($list_check as $item) {
      $check = $CI->cashbook_revenue->get_by(
         array(
            'date' => $today,
            'type' => $item,
            'store_id' => 0
         )
      );
      if(!$check){
         $last = $CI->cashbook_revenue->order_by('date', 'DESC')->get_by(
            array(
               'type' => $item,
               'store_id' => 0
            )
         );
         $data['store_id'] = 0;
         $data['type'] = $item;
         $data['date'] = $today;
         if($last){
            $data['start'] = $last->end;
         }else{
            $data['start'] = 0;
         }
         $CI->cashbook_revenue->insert($data);
      }
   }

   $start_amount =  $CI->cashbook_revenue->get_by(
      array(
         'date' => $today,
         'type' => 'amount',
         'store_id' => 0
      )
   )->start;

   $start_transfer =  $CI->cashbook_revenue->get_by(
      array(
         'date' => $today,
         'type' => 'transfer',
         'store_id' => 0
      )
   )->start;
   /*
   $results = $CI->cashbook_store->order_by('created')->get_many_by(
      array(
         'created >='   => date($today.' 00:00:00'),
         'created <='   => date($today.' 23:59:59'),
         'store_id'     => 0
      )
   );
   $result_ceos = $CI->cashbook->get_many_by(
      array(
         'created >='   => date($today.' 00:00:00'),
         'created <='   => date($today.' 23:59:59'),
         'type'         => 'expenditures',
         'type_id'      => 2,
         'verify_status'   => 1,
         'store'     => 0
      )
   );
   */
   $results = $CI->cashbook->order_by('created')->get_many_by(
      array(
         'created >='   => $today.' 00:00:00',
         'created <='   => $today.' 23:59:59',
         'verify_status'   => 1,
      )
   );
   $result_ceos = $CI->cashbook_store->get_many_by(
      array(
         'created >='   => $today.' 00:00:00',
         'created <='   => $today.' 23:59:59',
         'type'         => 'expenditures',
         'type_id'      => 1,
         'verify_status' => 1
      )
   );

   $MYarray = array_merge($results, $result_ceos);
   $total_amount = $start_amount;
   $total_visa = $start_transfer;
   foreach ($MYarray as $key => $value) {

      if($value->formality == 'amount'){
         if(isset($value->store_id)){
            $total_amount += $value->price;
         }else{
            if($value->type == 'expenditures'){ 
               $total_amount -= $value->price;
            }
            else if($value->type == 'receipts'){ 
               $total_amount += $value->price;
            }
         }
      }
      else if($value->formality == 'transfer'){
         if(isset($value->store_id)){
            $table = 'cashbook_stores';
            $total_visa += $value->price;
         }else{
            if($value->type == 'expenditures'){ 
               $total_visa -= $value->price;
            }
            else if($value->type == 'receipts'){ 
               $total_visa += $value->price;
            }
         }
      }  
   }
   
   $CI->cashbook_revenue->update_by(
      array(
         'store_id' => 0,
         'date' => $today,
         'type' => 'amount'
      ),
      array(
         'end' => $total_amount
      ) 
   );
   $CI->cashbook_revenue->update_by(
      array(
         'store_id' => 0,
         'date' => $today,
         'type' => 'transfer'
      ),
      array(
         'end' => $total_visa
      ) 
   );

   $tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($today)));
   $check_tomorrow_amount = $CI->cashbook_revenue->get_by(
      array(
         'date' => $tomorrow,
         'type' => 'amount',
         'store_id' => 0
      )
   );
   if($check_tomorrow_amount){
      $CI->cashbook_revenue->update(
         $check_tomorrow_amount->id,
         array(
            'start' => $total_amount
         )
      );
   }else{
      $CI->cashbook_revenue->insert(
         array(
            'date' => $tomorrow,
            'type' => 'amount',
            'store_id' => 0,
            'start' => $total_amount
         )
      );
   }

   $check_tomorrow_transfer = $CI->cashbook_revenue->get_by(
      array(
         'date' => $tomorrow,
         'type' => 'transfer',
         'store_id' => 0
      )
   );
   if($check_tomorrow_transfer){
      $CI->cashbook_revenue->update(
         $check_tomorrow_transfer->id,
         array(
            'start' => $total_visa
         )
      );
   }else{
      $CI->cashbook_revenue->insert(
         array(
            'date' => $tomorrow,
            'type' => 'transfer',
            'store_id' => 0,
            'start' => $total_visa
         )
      );
   }

   
}

function update_depots($date, $store_id){

   //$store_id = get_current_store_id();
	$CI = get_instance();
   $CI->load->model('depot_action_model', 'depot_action');
   $CI->load->model('depot_stores_action_model', 'depot_stores_action');

   $CI->db->query("UPDATE `depot_stores` SET `import` = 0, `export` = 0 WHERE `date` = '".$date."' AND `store_id` = ".$store_id." ");

   $action_1 = $CI->depot_stores_action->get_many_by(
      array(
         'store_id' => $store_id,
         'verify_status' => 1,
         'verify_time >=' => $date.' 00:00:00',
         'verify_time <=' => $date.' 23:59:59',
      )
   );

   $action_2 = $CI->depot_action->get_many_by(
      array(
         'type' => 'export',
         'receive' => 'store',
         'store' => $store_id,
         'verify_status' => 1,
         'verify_time >=' => $date.' 00:00:00',
         'verify_time <=' => $date.' 23:59:59',
      )
   );



   $invoices = $CI->db->query("SELECT * FROM invoices WHERE store_id = ".$store_id." AND date >= '".$date."' AND date <= '".$date."'  ")->result();
   $invoice_products = $check_products = array();
   foreach ($invoices as $invoice) {
      $customer_package_units = $CI->db->query("SELECT * FROM customer_package_units WHERE invoice_id = ".$invoice->id." AND type = 'product' ")->result();
      foreach ($customer_package_units as $value) {
         if(in_array($value->unit_id, $check_products)){
            $invoice_products[$value->unit_id] += 1;
         }else{
            $check_products[] = $value->unit_id;
            $invoice_products[$value->unit_id] = 1;
         }
      }
      $products = $CI->db->query("SELECT * FROM invoice_products WHERE invoice_id = ".$invoice->id." ")->result();
      foreach ($products as $value) {
         if(in_array($value->product_id, $check_products)){
            $invoice_products[$value->product_id] += $value->quantity;
         }else{
            $check_products[] = $value->product_id;
            $invoice_products[$value->product_id] = $value->quantity;
         }
      }
   }

   $check_products = $list_products = array();

   foreach ($action_1 as $ac_1) {
      $products_1 = get_item_depots('depot_stores_actions', $ac_1->id);
      foreach ($products_1 as $key => $pr_1) { 
         //Nhập
         if($ac_1->type == 'import'){
            if(!in_array($pr_1->item_id, $check_products)){
               $check_products[] = $pr_1->item_id;

               $list_products[$pr_1->item_id]['import'] = $list_products[$pr_1->item_id]['export'] = 0;
               $list_products[$pr_1->item_id]['import'] = $pr_1->quantity;
            }else{
               $list_products[$pr_1->item_id]['import'] += $pr_1->quantity;
            }
         }

         //Xuất
         if($ac_1->type == 'export'){
            if(!in_array($pr_1->item_id, $check_products)){
               $check_products[] = $pr_1->item_id;

               $list_products[$pr_1->item_id]['import'] = $list_products[$pr_1->item_id]['export'] = 0;
               $list_products[$pr_1->item_id]['export'] = $pr_1->quantity;
            }else{
               $list_products[$pr_1->item_id]['export'] += $pr_1->quantity;
            }
         }
      }

   }

   foreach ($action_2 as $ac_2) {
      $products_2 = get_item_depots('depot_actions', $ac_2->id);
      foreach ($products_2 as $key => $pr_2) { 
         //Nhập
         if(!in_array($pr_2->item_id, $check_products)){
            $check_products[] = $pr_2->item_id;

            $list_products[$pr_2->item_id]['import'] = 0;
            $list_products[$pr_2->item_id]['import'] = $pr_2->quantity;
         }else{
            $list_products[$pr_2->item_id]['import'] += $pr_2->quantity;
         }
         
      }
   }

   foreach ($invoice_products as $key => $inv) {
      if(!in_array($key, $check_products)){
         $check_products[] = $key;
         $list_products[$key]['export'] = $inv;
         $list_products[$key]['import'] = 0;
      }else{
         $list_products[$key]['export'] += $inv;
      }
   }

   echo 'COUNT = '.count($list_products);

   foreach ($list_products as $key => $value) {
      $check_pr = $CI->depot_store->get_by(
         array(
            'product_id' => $key,
            'store_id' => $store_id,
            'date' => $date
         )
      );
      if($check_pr){
         $CI->depot_store->update(
            $check_pr->id,
            array(
               'import' => $value['import'],
               'export' => isset($value['export']) ? $value['export'] :0,
            )
         );
      }else{
         $CI->depot_store->insert(
            array(
               'product_id' => $key,
               'store_id' => $store_id,
               'date' => $date,
               'import' => $value['import'],
               //'export' => $value['export'],
               'export' => isset($value['export']) ? $value['export'] :0,
               'created' => date('Y-m-d H:i:s')
            )
         );
      }
   }

   $CI->db->query("UPDATE `depot_stores` SET `end` = `begin` + `import` - `export` WHERE `date` = '".$date."' AND store_id = ".$store_id." ");

   $tomorrow = date('Y-m-d', strtotime('+1 day', strtotime($date)));
   
   $products_current = $CI->db->query("SELECT * FROM depot_stores WHERE date = '".$date."' AND store_id = ".$store_id." ")->result();

   foreach ($products_current as $key => $value) {

      $check_tomorrow = $CI->depot_store->get_by(
         array(
            'product_id' => $value->product_id,
            'store_id' => $store_id,
            'date' => $tomorrow
         )
      );
      if($check_tomorrow){
         //update
         $CI->depot_store->update(
            $check_tomorrow->id,
            array(
               'begin' => $value->end
            )
         );
      }else{
         //insert
         $CI->depot_store->insert(
            array(
               'product_id' => $value->product_id,
               'begin' => $value->end,
               'store_id' => $store_id,
               'date' => $tomorrow,
               'created' => date('Y-m-d H:i:s')
            )
         );
      }
   }
}

function all_notify_categories(){
   $CI = get_instance();
   $CI->load->model('notify_categorie_model', 'notify_categorie');
   $notify_categorie = $CI->notify_categorie->get_many_by(array('active' => 1));
   return $notify_categorie;
}

function all_notify_category_name($id){
   $CI = get_instance();
   $CI->load->model('notify_categorie_model', 'notify_categorie');
   $option = $CI->notify_categorie->get($id);
   if($option) return $option->name;
   return 'Unknow';
}

function get_invoice_mpos($list_id, $list_code, $date){
   $CI = get_instance();
   $CI->load->model('mpo_model', 'mpo');
   $CI->load->model('mpos_detail_model', 'mpos_detail');
   $CI->load->model('invoice_model', 'invoice');
   $CI->load->model('invoice_visa_model', 'invoice_visa');

   $invoice = $CI->invoice->select('invoice_visa_mpos')->get_many_by(
      array(
         'id' =>  array_unique($list_id)
      )
   );

   $result['price_soft'] = 0;
   $result['price_mpos'] = 0;
   $result['list_ctgd'] = array();
   foreach ($invoice as $value) {
      $result['price_soft'] +=  $value->invoice_visa_mpos;
   }
   if(empty($list_code)){
      $result['code'] = '<span class="label label-danger">Chưa nhập mã</span>';
      $result['status'] = '<span class="label label-danger">Chưa nhập mã</span>';
   }else{
      $result['code'] = '';
      $count = count(array_unique($list_code));
      foreach (array_unique($list_code) as $key => $value) {
         
         $result['code'] .= '<a href="mpos/view/'.$value.'" target="_blank">'.$value.'</a>';
         if($key < $count - 1){
            $result['code'] .= ', ';
         }
         if(strlen($value) == 6 && $value != '000000'){
            $mpo_detail = $CI->mpos_detail->get_many_by(
               array(
                  'thoigian'  => $date,
                  'machuanchi' => $value
               )
            );
         }
         elseif(strlen($value) == 8){
            $mpo_detail = $CI->mpos_detail->get_many_by(
               array(
                  'thoigian'  => $date,
                  'machuanchi' => '000000',
                  'RIGHT(ctgd , 8) =' => $value
               )
            );
         }
         if(isset($mpo_detail)){
            foreach ($mpo_detail as $mpo_d) {
               $result['list_ctgd'][] = $mpo_d->ctgd;
               $result['price_mpos'] += $mpo_d->sotien;
            }
         }
      }  
   }
   if($result['price_soft'] == $result['price_mpos']){
      $result['status'] = '<span class="label label-success">Thành công</span>';
   }else{
      $result['status'] = '<span class="label label-warning">Không khớp</span>';
   }
  
   return $result;
}

function list_category($current_id, $parent = 0, &$results = array() , $level = 0){
   $CI = get_instance();
   $CI->load->model('category_service_model', 'category_service');
   $query = $CI->category_service->get_many_by(
      array(
         'parent_id' => $parent,
         'id !=' => $current_id
      )
   );
   if(count($query) > 0){
      $level ++;
      foreach ($query as $value) {
         $value->level = $level-1;
         $results[] = $value;
         list_category($current_id, $value->id, $results, $level);
      }
   }
   return $results;
}
function get_statistic_service($invoices, $id){

   $CI = get_instance();
   $result = array(
      'count' => 0,
      'total' => 0,
      'customer_new' => 0,
      'customer_old' => 0,
   );
   $invoice_service = $CI->db->query("SELECT invoice_services.id, invoice_services.total, invoices.customer_id,invoices.date FROM invoices, invoice_services WHERE invoice_services.service_id = ".$id." AND invoice_services.invoice_id IN (".$invoices.")  AND invoice_services.invoice_id = invoices.id")->result();
   if($invoice_service){
      foreach ($invoice_service as $value) {
         if(check_new_customer($value->customer_id, $value->date)){
            $result['customer_new'] += 1;
         }
         $result['count'] += 1;
         $result['total'] += $value->total;
      }

      
   }
   $result['customer_old'] = $result['count'] - $result['customer_new'];
   $customer_package_unit = $CI->db->query("SELECT COUNT(id) as count_id, SUM(price) as sum_total FROM customer_package_units WHERE type = 'service' AND unit_id = ".$id." AND invoice_id IN (".$invoices.") ")->row();
   if($customer_package_unit){
      $result['count'] += $customer_package_unit->count_id;
      $result['total'] += $customer_package_unit->sum_total;
      $result['customer_old'] += $customer_package_unit->count_id;
   }

   return $result;
}
//get product image avatar
function get_product_avatar($product_id)
{
   $CI = get_instance();
   $CI->db->select('product_images.image_url');
   $CI->db->where('product_images.product_id', $product_id);
   $CI->db->where('product_images.main', 1);
   $avatar = $CI->db->get('product_images')->result();
   if(count($avatar))
   {
      return $avatar[0]->image_url;
   }
   else
   {
      return null;
   }
}
//get price product
function get_product_price($id){
   $CI = get_instance();
   $CI->load->model('product_model', 'product');
   $product = $CI->product->get($id);
   if($product) 
      return $product->price;
   return 'Uknow';
}
//get price service id
function get_service_price($id){
   $CI = get_instance();
   $CI->load->model('service_model', 'service');
   $service = $CI->service->get($id);
   if($service) 
      return $service->price;
   return 0;
}
//get product categroy
function get_product_category($id){
   $CI = get_instance();
   $CI->db->select('product_groups.name');
   $CI->db->where('product_groups.group_id', $id);
   $group_name = $CI->db->get('product_groups')->result();
   if(count($group_name))
   {
      return $group_name[0]->name;
   }
   else
   {
      return null;
   }
}

//get mpos image
function get_mpos_image($id){
   $CI = get_instance();
   $CI->db->select('invoice_visas.value');
   $CI->db->where('invoice_visas.invoice_id', $id);
   $arr = $CI->db->get('invoice_visas')->result();
   if(count($arr))
   {
      return $arr[0]->value;
   }
   else
   {
      return null;
   }
}

//get total_service_kpis for HD2 amount
function get_total_service_kpis_hd2($id){
   $CI = get_instance();
   $CI->db->select('sum(number) as total');
   $CI->db->where('kpis.unit_id', $id);
   $CI->db->where('kpis.unit', 'amount');
   $CI->db->where('kpis.invoice_type', 2);
   $arr = $CI->db->get('kpis')->result();
   if(count($arr))
   {
      return $arr[0]->total;
   }
   else
   {
      return null;
   }
}
//get total_service_kpis for HD2 %
function get_service_price_kpi($id, $service_price,$invoice_type, $type,$date){
   $CI = get_instance();
   $CI->db->select('number');
   $CI->db->where('kpis.unit_id', $id);
   $CI->db->where('kpis.unit', $type);
   $CI->db->where('kpis.active', 1);
   $CI->db->where('kpis.invoice_type', $invoice_type);
   $CI->db->where('kpis.date <=', $date);
   $CI->db->order_by('created', 'desc');
   $arr = $CI->db->get('kpis')->result();
   if(count($arr))
   {
      if($type == 'percent')
      {
         return $service_price*0.01*$arr[0]->number;
      }
      else
      {
         return $arr[0]->number;
      }
      
   }
   else
   {
      return 0;
   }
}

//get detail by unit_id
function get_unit_detail($id,$date)
{
   $CI = get_instance();
   $CI->db->select('*');
   $CI->db->where('kpis.unit_id', $id);
   $CI->db->where('kpis.active', 1);
   $CI->db->where('kpis.date <=', $date);
   $CI->db->order_by('created', 'desc');
   $arr = $CI->db->get('kpis')->result();
   if(count($arr))
   {
      return $arr;
   }
   else
   {
      return null;
   }
}

//get count for unit_id
function get_count_unit_id($id,$type,$date)
{
   $CI = get_instance();
   $CI->db->select('count(id) as total');
   $CI->db->where('kpis.unit_id', $id);
   $CI->db->where('kpis.active', 1);
   $CI->db->where('kpis.date <=', $date);
   $CI->db->where('kpis.invoice_type', 2);
   $arr = $CI->db->get('kpis')->result();
   if(count($arr))
   {
      return $arr[0]->total;
   }
   else
   {
      return 1;
   }
}
//get count invoice_log
function get_count_invoice_log($id)
{
   $CI = get_instance();
   $CI->db->select('id');
   $CI->db->where('tbl_invoice_log.invoice_id', $id);
   $query = $CI->db->get('tbl_invoice_log');
   $num = $query->num_rows();
   if($num>0)
   {
      return $num;
   }
   else
   {
      return 0;
   }
}
//luyen add function 
function get_action_rating($action,$content_action)
{
   $result='';
   if($action==0) return '';
   else if($action==1){
      $result = '<p class="text-primary">Đồng ý đặt lịch</p>';
      $split_content = explode('|', $content_action);
      $result = $result .'
         <span class="label label-success">'.$split_content[0].'
         </span><br>'.'
         <span class="label label-success">'.$split_content[1].'
         </span><br>'.'
         <span class="label label-success">'.get_store_name($split_content[2]).'
         </span><br>'.'
         <span class="label label-success">'.$split_content[4].'
         </span>';
      return $result;
   }
   else if($action==2) return '<p class="text-warning">Gọi lại</p>';
   else return '<p class="text-danger">Hủy</p>';
}
//luyen add quan ly tags
function hex2rgb($hex) {
      if($hex=='') return '';
      $hex = str_replace("#", "", $hex);

      if(strlen($hex) == 3) {
         $r = hexdec(substr($hex,0,1).substr($hex,0,1));
         $g = hexdec(substr($hex,1,1).substr($hex,1,1));
         $b = hexdec(substr($hex,2,1).substr($hex,2,1));
      } else {
         $r = hexdec(substr($hex,0,2));
         $g = hexdec(substr($hex,2,2));
         $b = hexdec(substr($hex,4,2));
      }
      
      return $r.','.$g.','.$b;
   }
function is_rgb_color($color)
   {
      $cls = explode(',', $color);
      if(count($cls)==3){
         if(intval($cls[0])>=0&&intval($cls[0])<=255&&intval($cls[1])>=0&&intval($cls[1])<=255&&intval($cls[2])>=0&&intval($cls[2])<=255) return true;
         else return false;
      }
      else return false;
   }
function rgb2hex($rgb) {
   if($rgb=='') return '';
   if(is_rgb_color($rgb)){
      $rgbs = explode(',', $rgb);
      return sprintf("#%02x%02x%02x", intval($rgbs[0]), intval($rgbs[1]), intval($rgbs[2]));
     }

    else  return '';
   }
// cac function trong api de tam tai day luyen add
   function get_api_key_global_real() {
      if($_SERVER['SERVER_NAME']=='app.seoulspa.vn') {
         return get_option('key_abc');
      }
      else return '831-1011-1141-1181-1011-1141-611-491-501-531-461-501-491-501-461-501-521-531-461-501-481-531-591-681-971-1161-971-981-971-1151-1011-611-1151-1181-991-971-1091-1121-1171-991-1041-1051-971-591-1121-1111-1141-1161-611-511-511-481-541-591-851-1051-1001-611-1081-971-971-1151-1071-1051-1101-951-1161-971-1051-1201-1011-591-801-1191-1001-611-491-501-511-521-531-541-591-991-1041-971-1141-1151-1011-1161-611-391-1171-1161-1021-561-391-591';
   }
   function get_api_key_global_test() {
   return '831-1011-1141-1181-1011-1141-611-491-501-531-461-501-491-501-461-501-521-531-461-501-481-531-591-681-971-1161-971-981-971-1151-1011-611-1081-971-971-1151-1071-1051-1101-951-1151-1121-971-591-1121-1111-1141-1161-611-511-511-481-541-591-851-1051-1001-611-1081-971-971-1151-1071-1051-1101-951-1151-1121-971-591-801-1191-1001-611-1081-971-971-1151-1071-1051-1101-951-1151-1121-971-591-991-1041-971-1141-1151-1011-1161-611-391-1171-1161-1021-561-391-591';
   }
   
   function chamcong_get_shifts($data){
      //data have api_key


      $url = 'http://abc.seoulspa.vn/api/ToCheck/GetShifts';

      //create a new cURL resource
      $ch = curl_init($url.'?api='.$data['api']);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
      
   }
   function chamcong_get_staffs($data){

      //setup request to send json via POST
      /*$data = array('api'=>$api_key,
         'store_id'=>$store_id,
          'offset'=>$offset,
          'limit'=>$limit
      );*/
      $url = 'http://abc.seoulspa.vn/api/ToCheck/GetStaffs_Report';

      //create a new cURL resource
      $ch = curl_init($url);

      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
      
   }
   function chamcong_get_reports($data){
      //setup request to send json via POST
      /*$data = array('api'=>$this->api_key,
         'store_id'=>$store_id,
         'user_id'=>$user_id,
         'from'=>$from,
         'to'=>$to,
         'export'=>$export,
         'offset'=>$offset,
         'limit'=>$limit
      );*/
      $url = 'http://abc.seoulspa.vn/api/ToCheck/Report';

      //create a new cURL resource
      $ch = curl_init($url);

      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function chamcong_update_shift($data){
      //setup request to send json via POST
      /*$data = array(
         'api'=>$api_key,
            'id'=>$id,
            //'shift'=>$this->input->get('shift_name'),
            'shift_id'=>$shift,
            'checkin'=>$begin,
            'checkout'=>$end,
            'user_id'=>$user_id,
            'penalties'=>$penalties,
            'reason'=>$reason
      );*/
      $url = 'http://abc.seoulspa.vn/api/ToCheck/Update';

      //create a new cURL resource
      $ch = curl_init($url);

      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
      
   }
   function chamcong_delete_shift($data){
      /*$data = array(
            'api'=>$api_key,
            'id'=>$id
         );*/
      $url = 'http://abc.seoulspa.vn/api/ToCheck/Delete';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
      
   }
   function chamcong_get_summary_report($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'store_id'=>$store_id,
         'user_id'=>$user_id,
         'from'=>$from,
         'to'=>$to,
         'export'=>$export,
         //'offset'=>$offset,
         //'limit'=>$limit
      );*/
      $url = 'http://abc.seoulspa.vn/api/tocheck/summary_report';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function chamcong_get_month_report($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'store_id'=>$store_id,
         'user_id'=>0,
         'from'=>$from,
         'to'=>$to,
         'export'=>$export
      );*/
      
      $url = 'http://abc.seoulspa.vn/api/ToCheck/MonthReport';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   
   function cskh_get_cancle_appointment($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'store_id'=>$store_id,
         'date'=>$to,  // format 25/06/2019
         'export'=>$export,
         'offset'=>$offset, 
         'limit'=>$limit  //50
      );*/
      $url = 'http://abc.seoulspa.vn/api/CustomerCare/Report_cancel';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function cskh_get_remind_appointment($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'store_id'=>$store_id,
         'find'=>'0928341',  
         'search_type'=>0, // 0 = all, 1 = Kh nợ, 2 = KH không nợ
         'from'=>$from,  // format 25/06/2019
         'to'=>$to,
         'offset'=>$offset, 
         'limit'=>$limit  //50
      );*/
      $url = 'http://abc.seoulspa.vn/api/CustomerCare/Report_Remind';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function cskh_get_care_history($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'customer_id'=>0,
         'appointment_id'=>'152334',  //id của reporrt_cancle 
         'customer_package_id'=>3232, // là customer_package_id của report_remind
         'phone'=>0904328985,
      );*/
      
      $url = 'http://abc.seoulspa.vn/api/customercare/History';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function cskh_get_invoices_history($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'customer_id'=>21312,
      );*/
      
      $url = 'http://abc.seoulspa.vn/api/CustomerCare/Invoice';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function cskh_add_appointment($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'appointment_id'=>236007, //lấy từ id của báo cáo khách hủy hẹn
         'store_id'=>7, 
         'user_id'=>237,
         'customer_id'=>23723, 
         'name'=>'cô Thúy',  //lấy từ report hủy hẹn
         'phone'=>'0989007183',  //lấy từ report hủy hẹn
         'customer_package_id'=>'0',  //nếu là user đặt lại từ báo cáo nhắc lịch thì truyền vào
         'date'=>'01/01/2019',  //ngày khách dự kiến tới làm
         'time'=>'08:30',  //ngày khách dự kiến tới làm
         'note'=>'note',  //ngày khách dự kiến tới làm
      );*/
      
      $url = 'http://abc.seoulspa.vn/api/CustomerCare/Appointment';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function cskh_add_record($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'id'=>0, //nếu là update thì truyền id vào
         'customer_id'=>23723, //lấy từ report - nó có thể =0
         'appointment_id'=>234324,  //lấy từ Cancel_Report
         'customer_package_id'=>35456,  //lấy từ Cancel_Report
         'user_id'=>1,  
         'note'=>'Gọi lại sau 2 ngày', 
         'color'=>'1,1,1',  
         'remind_date'=>'15/05/2019',
         );
         */
      
      $url = 'http://abc.seoulspa.vn/api/CustomerCare/Add';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function cskh_delete_record($data)//$offset,$limit
   {
      /*//setup request to send json via POST
      $data = array('api'=>$this->api_key,
         'id'=>0, 
         );
         */
      
      $url = 'http://abc.seoulspa.vn/api/CustomerCare/Delete';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }

   function chamcong_manual_check($data)//$offset,$limit
   {
      /*"{
            ""api"":"""",
            ""store_id"":1,
            ""shift_id"":1,
            ""user_id"":1,
            ""date"":""12/07/2019"",
            ""checkin"":""12/07/2019 08:03"",
            ""checkout"":""12/07/2019 17:03""
         }"*/
      
      $url = 'http://abc.seoulspa.vn/api/ToCheck/ManualCheck';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function yeucautaogoi_resend($data)
   {
      $url = 'http://abc.seoulspa.vn/api/Request/ReSend';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function yeucautaogoi_get($data)//$offset,$limit
   {
      $url = 'http://abc.seoulspa.vn/api/Request/GetPackages';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function yeucautaogoi_add($data)//$offset,$limit
   {
      $url = 'http://abc.seoulspa.vn/api/Request/addPackage';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json','Content-Length: ' . strlen(json_encode($data))));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function yeucautaogoi_confirm($data)//$offset,$limit
   {
      $url = 'http://abc.seoulspa.vn/api/Request/ConfirmPackage';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function yeucautaophieuchi_add($data)//$offset,$limit
   {
      $url = 'http://abc.seoulspa.vn/api/request/expenditures';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function xacnhanphieuchi($data)
   {
      $url = 'http://abc.seoulspa.vn/api/request/Confirm_Expenditure';

      //create a new cURL resource
      $ch = curl_init($url);
      
      $payload = json_encode($data);
      //echo $payload;

      //attach encoded JSON string to the POST fields
      curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);

      //set the content type to application/json
      curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type:application/json'));

      //return response instead of outputting
      curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);

      //execute the POST request
      $result = curl_exec($ch);

      //close cURL resource
      curl_close($ch);
      return json_decode($result);
   }
   function all_nations(){
      $CI = get_instance();
      $kq = $CI->db->query('select * from admin_nations')->result();
      //$kq = array();
      //array_push($kq, (object) array('id' => 1, 'name'=> 'Việt Nam'));
      //array_push($kq, (object) array('id' => 2, 'name'=> 'Campuchia'));
      return $kq;
   }

   function format_currency($number,$nation_id=1){
      //$number = intval(str_replace(',', '', $number));
      if ($number==0) return $nation_id==1?'0 đ':'0 $';
      return $nation_id==1?number_format($number).' đ':number_format($number/100,2).' $';
   }
   function format_currency_noname($number,$nation_id=1){
      $number = intval(str_replace(',', '', $number));
      return $nation_id==1?$number:$number/100;
   }
   function transfer_number_nation($number,$nation_id=1){
      return $nation_id==1?intval($number):intval($number*100);
   }
   function param_print($param,$nation_id=1){
      $params  = array(
         'PHIẾU THU' => array(
            1 => 'PHIẾU THU',
            2 => 'ប័ណ្ណចំនូល',
             ), 
         'Tên Khách Hàng:' => array(
            1 => 'Tên Khách Hàng:',
            2 => 'ឈ្មោះអតិថិជន:',
             ), 
         'Kỹ thuật viên:' => array(
            1 => 'Kỹ thuật viên:',
            2 => 'ផ្នែកបច្ចេកទេស:',
             ),
         'Kỹ thuật viên' => array(
            1 => 'Kỹ thuật viên',
            2 => 'ផ្នែកបច្ចេកទេស',
             ),
         'Số phiếu thu:' => array(
            1 => 'Số phiếu thu:',
            2 => 'លេខប័ណ្ណចំនូល:',
             ),
         'Số phiếu thu:' => array(
            1 => 'Số phiếu thu:',
            2 => 'លេខប័ណ្ណចំនូល:',
             ),
         'Ngày:' => array(
            1 => 'Ngày:',
            2 => 'ថ្ងៃ',
             ),
         'Thanh toán visa:' => array(
            1 => 'Thanh toán visa:',
            2 => 'ទូទាត់ដោយ visa:',
             ),
         'Còn lại:' => array(
            1 => 'Còn lại:',
            2 => 'នៅខ្វះ:',
             ),
         'Ghi chú:' => array(
            1 => 'Ghi chú:',
            2 => 'ចំណាំ:',
             ),
         'Nhân viên đặt lịch' => array(
            1 => 'Nhân viên đặt lịch',
            2 => 'បុគ្គលិកដាក់ណាត់',
             ),
         'Tổng' => array(
            1 => 'Tổng',
            2 => 'សរុប',
             ),
         'Seoulspa.vn Hệ Thống 30 Chi Nhánh' => array(
            1 => 'Seoulspa.vn Hệ Thống 30 Chi Nhánh',
            2 => 'Seoulspa.com.kh ប្រព័ន្ធ 30 សាខា',
            ),
         'Đánh giá' => array(
            1 => 'Đánh giá',
            2 => 'វាយតម្លៃ',
         ), 

         'Nội dung' => array(
            1 => 'Nội dung',
            2 => 'មាតិកា',
            ),
         'Gửi đi' => array(
               1 => 'Gửi đi',
               2 => 'បញ្ចូនទៅ',
               ),
               
         'Cám ơn quý khách đã sử dụng dịch vụ' => array(
                  1 => 'Cám ơn quý khách đã sử dụng dịch vụ',
                  2 => 'សូមអរគុណអតិថិជនដែលបានប្រើប្រាស់សេវ៉ាកម្',
                  ),
      );
      return $params[$param][$nation_id];
   }

   function get_rates_targets($month,$year, $value){
      $rule = array('begin <=' => $value+0.01, 'end >= '=>$value-0.01, 'MONTH(month)'=>$month,'YEAR(month)'=>$year );
      $CI = get_instance();
      $CI->load->model('rates_target_model', 'rates_target');
      $rs = $CI->rates_target->get_by($rule);
      //$rs = $CI->db->select('name,bonus,minus')->get_where('rates_targets', $rule)->result();
      if($rs) 
         return $rs;
      return '';
   }
