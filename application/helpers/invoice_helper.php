<?php 
function count_package_services($customer_package_id, $package_id){
   $CI = get_instance();
   $CI->load->model('package_unit_model', 'package_unit');
   
   $CI->load->model('customer_package_unit_model', 'customer_package_unit');
   $package_units = $CI->db->query("SELECT * FROM package_units WHERE package_id = ".$package_id." GROUP BY type, unit_id ")->result();
   $i = 0;
   
   foreach ($package_units as $key => $value) {
      $used = $total = 0;
      $check = $CI->customer_package_unit->get_many_by(
         array(
            'customer_package_id' => $customer_package_id,
            'unit_id' => $value->unit_id,
            'type' => $value->type,
         )
      );

      
      foreach ($check as $c) {
         if($c->invoice_id != 0 && $c->used != '0000-00-00' ){
            $used += 1;
         }
         $total += 1;
      }
      if($used == $total)
         $bg = 'bg-red';
      else
         $bg = 'bg-green';
      $i++;?>
      <tr>
         <td><?php echo $i;?>.</td>
         <td><?php echo $value->type=='product' ? get_product_name($value->unit_id) : get_service_name($value->unit_id);?></td>
         <td class="text-center"><span class="badge <?php echo $bg;?>"><?php echo $used;?>/<?php echo $total;?></span></td>
      </tr>
   <?php }
}

function use_package_services($customer_package_id){
   $CI = get_instance();
   $CI->db->select('*, count(unit_id) as count');
   $CI->db->order_by('type');
   $CI->db->group_by('type, unit_id');
   $CI->db->where('used', '0000:00:00');
   $CI->db->where('invoice_id', '0');
   $CI->db->where('customer_package_id', $customer_package_id);
   $results = $CI->db->get('customer_package_units')->result();
   //echo '<pre>';print_r($results);
   foreach ($results as $key => $value) { ?>
   <tr>
      <td class="text-center">
         <select name="use_invoice_type">
            <option value="1">HD1</option>
            <!--option value="2">HD2</option-->    
         </select>
      </td>
      <td>
         <?php if($value->type == 'product'){ ?>
         <?php echo get_product_name($value->unit_id);?>
         <input type="hidden" name="use_unit_id" value="<?php echo $value->unit_id;?>">
         <input type="hidden" name="use_type" value="product">
         <?php } else { ?>
         <?php echo get_service_name($value->unit_id);?>
         <input type="hidden" name="use_unit_id" value="<?php echo $value->unit_id;?>">
         <input type="hidden" name="use_type" value="service">
         <?php } ?>
      </td>
      <td class="text-center">
         <select name="use_quantity">
            <?php for ($i = 1; $i <= $value->count; $i++) { ?>
               <option value="<?php echo $i;?>"><?php echo $i;?></option>
            <?php } ?>
         </select>
      </td>
      <td class="text-center">
         <input type="checkbox" value="<?php echo $value->customer_package_id;?>" class="use-checkbox">
      </td>
   </tr>
   <?php }
}

function get_package_debits($id){
   $CI = get_instance();
   $CI->load->model('customer_package_model', 'customer_package');
   $CI->load->model('customer_package_debit_model', 'customer_package_debit');
   $customer_package = $CI->customer_package->get($id);
   if($customer_package && $customer_package->debit > 0){
      $debit = $CI->db->query('SELECT SUM(total) as total FROM customer_package_debits WHERE customer_package_id ='.$id)->row()->total;
      if($debit != '')
         return  $customer_package->debit-$debit;
      else
         return  $customer_package->debit;
   }else{
      return 0;
   }
}

function get_customer_package_debits($customer_id){
   $CI = get_instance();
   $CI->load->model('customer_package_model', 'customer_package');
   $CI->load->model('customer_package_debit_model', 'customer_package_debit');
   $customer_package = $CI->customer_package->get_many_by(
      array(
         'customer_id'  => $customer_id,
         'active'       => 1,
         'store_id'     => get_current_store_id(),
         'debit >'      => 0
      )
   );
   $debit = $pay = 0;
   foreach($customer_package as $value){
      $debit += $value->debit;
      $check_pay = $CI->db->query('SELECT SUM(total) as total FROM customer_package_debits WHERE customer_package_id ='.$value->id)->row()->total;
      if($check_pay != ''){
         $pay += $check_pay;
      }
   }
   return $debit-$pay;
}
function check_new_customer($id, $date){
   $CI = get_instance();
   $CI->load->model('customer_model', 'customer');
   $customer = $CI->customer->get($id);
   if($customer){
      if($customer->created > $date.' 00:00:00'){
         return true;
      }
   }
   return false;
}

function check_old_customer($customer_phone, $date){
   $CI = get_instance();
   $CI->load->model('customer_model', 'customer');
   $customer = $CI->customer->get_by(array('phone' => $customer_phone));
   if($customer){
      if($customer->created < $date.' 00:00:00'){
         return true;
      }
   }
   return false;
}

function update_product_export($product_id){
   $CI = get_instance();
   $export = $CI->db->query("SELECT SUM(invoice_products.quantity) as total FROM invoices,invoice_products WHERE invoices.id = invoice_products.invoice_id AND invoice_products.product_id = ".$product_id." AND invoices.date = '".date('Y-m-d')."' GROUP BY invoice_products.product_id")->row();
   if($export){
      $total = $export->total;
   }else{
      $total = 0;
   }      
   $CI->db->query("UPDATE `depots` SET `export` = ".$total." WHERE `product_id` = ".$product_id." AND `date` = '".date('Y-m-d')."' ");
   $CI->db->query("UPDATE `depots` SET `end` = `begin` + `import` - `export` WHERE `product_id` = ".$product_id." AND `date` = '".date('Y-m-d')."' ");
}

function check_ads_data($id){
   $CI = get_instance();
   $CI->load->model('ads_detail_model', 'ads_detail');
   $CI->load->model('appointment_model', 'appointment');

   $check = $CI->ads_detail->get_many_by(
      array('ads_data_id' => $id)
   );
   if(!$check){
      $class = 'label-default';
      $label = 'Chưa xử lý';
   }else{
      $position = count($check) - 1;
      $val = $check[$position];
      if($val->action == 1){
         $app = $CI->appointment->get_many_by(
            array(
               'ads_data_id' => $id,
               'status' => 1
            )
         );
         if($app){
            $class = 'label-success';
            $label = 'Hoàn tất';
         }else{
            $class = 'label-primary';
            $label = 'Đã book';
         }
      }
      elseif($val->action == 2){
         $class = 'label-warning';
         $label = 'Gọi lại';
      }
      elseif($val->action == 3){
         $class = 'label-danger';
          $label = 'Đã hủy';
      }else{
         $class = 'label-danger';
         $label = 'Null';
      }
   }
   if($check){
      $time = time_last_login(strtotime($check[count($check)-1]->created));
   }else{
      $time = '';
   }
   return '<a href="ads/detail/'.$id.'" target="_blank">'.count($check).'x <span class="label '.$class.'">'.$label.'</span><br><small>'.$time.'</small></a>';
}
//luyen add

function check_ads_feedback($id){
   
   $CI = get_instance();
   $CI->db->reset_query();
   $query = $CI->db->get_where('ads_feedbacks', array('invoice_id' => $id));
   $num = $query->num_rows();
   $average=0;
   if(!$num){
      $class = 'label-default';
      $label = 'Chưa gọi';
   }else{
      $rows = $query->result();
      foreach ($rows as $key => $value) {
          $arv_now = ($value->rating_ktv);
          $average = $average !=0 ? ($average + $arv_now)/2 : $arv_now ; 
      }
      $class = 'label-success';
      $label = 'Hoàn tất';
   }
   return ''.'<a href="ads/feedback/'.$id.'" target="_blank">'.$num.'x <span class="label '.$class.'">'.$label.'</span><br>TB: '.number_format((float)$average, 1).'★</br></a>';
}
//luyen end

function check_ads_data_status($id){
   $CI = get_instance();
   $CI->load->model('ads_detail_model', 'ads_detail');
   $check = $CI->ads_detail->get_many_by(
      array('ads_data_id' => $id)
   );
   if(!$check){
      return 0;
   }else{
      $position = count($check) - 1;
      $val = $check[$position];
      return $val->action;
   }
}

function get_ads_data_status($id){
   $CI = get_instance();
   $CI->load->model('ads_detail_model', 'ads_detail');
   $check = $CI->ads_detail->get_many_by(
      array('ads_data_id' => $id)
   );
   if(!$check){
      $list_status = array(
         '0' => 1
      );
   }else{
      $list_status = array(
         '0' => 0,
         '1' => 0,
         '2' => 0,
         '3' => 0
      );
      foreach ($check as $c) {
         $list_status[$c->action] ++;
      }
   }
   return $list_status;
}

function get_store_revenue($results = array(), $start, $end){
   $result = new stdClass();
   $result->visa = $result->total = $result->count = 0;
   foreach ($results as $value) {
      if($value->date >= $start && $value->date <= $end){
         $result->count ++;
         $result->total += $value->total;
         $result->visa += $value->visa;
      }
   }
   return $result;
}

//luyen add thống kê CSKH
function count_appoitment_ads($results = array(), $start, $end){
   $result = new stdClass();
   $result->total = $result->answer = $result->no_answer = 0;
   foreach ($results as $value) {
      if(isset($value->created)){
         if($value->created >= $start && $value->created <= $end){
            $result->total ++;
            if(1) $result->answer ++;
            else $result->no_answer ++;
         }
      }
   }
   return $result;
}
function count_feedback_ads($results = array(), $start, $end){
   $result = new stdClass();
   $result->total = $result->answer = $result->no_answer = 0;
   foreach ($results as $value) {
      if(isset($value->created)){
         if($value->created >= $start && $value->created <= $end){
            $result->total ++;
            if($value->answer_duration>0) $result->answer ++;
            else $result->no_answer ++;
         }
      }
   }
   return $result;
}
// luyen end add

function get_store_customer($results = array(), $start, $end){
   $result = new stdClass();
   $result->visa = $result->total = $result->count = 0;
   foreach ($results as $value) {
      if($value->date >= $start && $value->date <= $end){
         $result->total += 1;
         // mới
         if(check_new_customer($value->customer_id, $value->date)){
            $result->visa += 1;
         }else{
            // cũ
            $result->count += 1;
         } 
      }
   }
   return $result;
}

function get_user_appointments($appointments = array(), $user_id, $start, $end){
   $result = new stdClass();
   $result->total = $result->active = 0;

   foreach ($appointments as $value) {
      if($value->date >= $start && $value->date <= $end && $value->import_id == $user_id){
         $result->total ++;
         if($value->status == 1){
            $result->active ++;
         }
      }
   }
   return $result;
}

function get_user_schedules($appointments = array(), $user_id, $start, $end){
   $result = new stdClass();
   $result->total = $result->active = 0;

   foreach ($appointments as $value) {
      if($value->created >= $start.' 00:00:00' && $value->created <= $end.' 23:59:59' && $value->import_id == $user_id){
         $result->total ++;
         if($value->status == 1){
            $result->active ++;
         }
      }
   }
   return $result;
}

function get_revenue_staffs($invoices, $user_id, $rule, $store_id){
   $results = array(
      'revenue'   => 0,
      'debit'     => 0,
      'total'     => 0
   );
   foreach ($invoices as $invoice) {
      if($invoice->store_id == $store_id){
         if($rule == 'skin_id'){
            if($invoice->skin_id == $user_id){
               foreach ($invoice->packages as $package) {
                  if($package->invoice_type == 1)
                     $results['revenue'] += $package->pay;
               }
               foreach ($invoice->services as $service) {
                  if($service->invoice_type == 1)
                     $results['revenue'] += $service->total;
               }
               foreach ($invoice->products as $product) {
                  if($product->invoice_type == 1)
                     $results['revenue'] += $product->total;
               }
               foreach ($invoice->debits as $debit) {
                  $results['debit'] += $debit->total;
               }
            }
         }
         else if($rule == 'technician_id'){
            if($invoice->technician_id == $user_id){
               foreach ($invoice->packages as $package) {
                  if($package->invoice_type == 2)
                     $results['revenue'] += $package->pay;
               }
               foreach ($invoice->services as $service) {
                  if($service->invoice_type == 2)
                     $results['revenue'] += $service->total;
               }
               foreach ($invoice->products as $product) {
                  if($product->invoice_type == 2)
                     $results['revenue'] += $product->total;
               }
            }
         }
      }
   }
   $results['total'] = $results['revenue'] + $results['debit'];
   return $results;
}

function get_staff_rates($user_id, $start_date, $end_date, $store_id ){
   $CI = get_instance();
   $invoices = $CI->db->query("SELECT id FROM invoices WHERE technician_id = ".$user_id." AND store_id = ".$store_id." AND date >= '".$start_date."' AND date <= '".$end_date."' ")->result();
   $nothing = 0;
   $list_stars = array();
   $results['rates'] = array(
      '1' => array(
         'value' => 0,
         'color' => 'red'
      ),
      '2' => array(
         'value' => 0,
         'color' => 'red'
      ),
      '3' => array(
         'value' => 0,
         'color' => 'yellow'
      ),
      '4' => array(
         'value' => 0,
         'color' => 'aqua'
      ),
      '5' => array(
         'value' => 0,
         'color' => 'green'
      ),
   );
   foreach ($invoices as $invoice) {
      $invoice_result = $CI->db->query("SELECT services, units FROM invoice_results WHERE id = ".$invoice->id."  ")->row();
      if($invoice_result){
         if($invoice_result->services != '[]' || $invoice_result->units != '[]'){
            $rate = $CI->db->query("SELECT id, star FROM rates WHERE id = ".$invoice->id." ")->row();
            if(!$rate){
               $nothing += 1;
            }else{
               if(in_array($rate->star, $list_stars)){
                  $results['rates'][$rate->star]['value'] += 1;
               }else{
                  $list_stars[] = $rate->star;
                  $results['rates'][$rate->star]['value'] = 1;
               }
            }
         }
      }
   }
   $results['nothing'] = $nothing;
   return $results;
}
//luyen add new function get detail all rate
function get_detail_rates($user_id, $start_date, $end_date){
   $CI = get_instance();
   $invoices = $CI->db->query("SELECT invoices.id,star,  group_concat(rating_ktv) as rating_ktv  FROM invoices left join ads_feedbacks on ads_feedbacks.invoice_id = invoices.id left join rates on rates.id = invoices.id  WHERE technician_id = ".$user_id." AND date >= '".$start_date."' AND date <= '".$end_date."'  GROUP  BY invoices.id")->result();
   return $invoices;
}
// luyen add to get star at spa of invoice
function get_star_by_invoice_id($invoice_id){
   $CI = get_instance();
   $invoices = $CI->db->query("SELECT star FROM rates WHERE id = ".$invoice_id)->result();
   if ($invoices)
   return $invoices[0]->star;
   else return false;
}

// luyen add to get rating_ktv CSKH of invoice
function get_feedback_by_invoice_id($invoice_id){
   $CI = get_instance();
   $invoices = $CI->db->query("SELECT * FROM ads_feedbacks WHERE invoice_id = ".$invoice_id." AND rating_ktv is not null")->result();
   if ($invoices)
   return $invoices;
   else return false;
}

function get_staff_all_rates($user_id, $start_date, $end_date){
   $CI = get_instance();
   $count = $means = 0;
   $invoices = $CI->db->query("SELECT id FROM invoices WHERE technician_id = ".$user_id." AND date >= '".$start_date."' AND date <= '".$end_date."' ")->result();
   $rate_status = get_option('rate_status');
   $rate_value = get_option('rate_value');
   foreach ($invoices as $invoice) {
      $invoice_result = $CI->db->query("SELECT services, units FROM invoice_results WHERE id = ".$invoice->id."  ")->row();
      if($invoice_result){
         if($invoice_result->services != '[]' || $invoice_result->units != '[]'){
            $rate = $CI->db->query("SELECT id, star FROM rates WHERE id = ".$invoice->id." ")->row();
            if(!$rate && $rate_status == 'true' ){
               $count += 1;
               $means += $rate_value;
            }else{
               $count += 1;
               $means += $rate->star;
            }
         }
      }
   }
   if($count > 0)
      return round($means/$count, 1);
   return 0;
}

function get_kpi_rates($mark, $start_date, $end_date){
   $mark_minus =  $mark-0.01;
   $mark_plus = $mark+0.01;
   $results = array(
      'bonus' => 0,
      'minus' => 0
   );
   $CI = get_instance();
   $lists = $CI->db->query("SELECT bonus, minus FROM rates_targets WHERE month >= '".$start_date."' AND month <= '".$end_date."' AND  begin <= ".$mark_plus." AND end >= ".$mark_minus." ")->result();
   foreach ($lists as $value) {
         $results['bonus'] += $value->bonus;
         $results['minus'] += $value->minus;
   }
   return $results;
}

function get_next_rates($mark){
   $mark_plus =  $mark+0.01;
   $CI = get_instance();
   $check = $CI->db->query("SELECT begin, bonus, minus FROM rates_targets WHERE month >= '".date('Y-m-01')."' AND month <= '".date('Y-m-31')."' AND begin > ".$mark_plus." ORDER BY begin ASC ")->row();
   if($check){
      return 'Mức kế tiếp: Bình quân: '.$check->begin.' | Thưởng: '.number_format($check->bonus).' | Phạt: '.number_format($check->minus);
   }else{
      return 'Bạn không có mức kế tiếp';
   }

}

// get target of user
function get_user_target($user_id, $column, $type, $begin, $end){

   $CI = get_instance();
   /*//công thức cũ
   $count = $CI->db->query("SELECT SUM(".$column.") as total FROM invoices WHERE ".$type." = ".$user_id." AND date >= 
   '".$begin."' AND date <= '".$end."'  ")->row();*/

   // luyen add công thức mới
   $i_type = $type=='skin_id' ? " = 1 ":($type=='technician_id' ? " = 2 " : " > 0 ");
   $count = $CI->db->query("SELECT SUM(rs.total) total FROM (select ip.total from invoices i 
join invoice_products ip on i.id=ip.invoice_id 
WHERE ip.total > 0 AND i.`date` >= '".$begin."' AND i.`date` <= '".$end."' AND i.".$type." = ".$user_id." AND invoice_type ".$i_type."
union all
select ise.total FROM invoices i 
join invoice_services ise 
on i.id=ise.invoice_id 
WHERE ise.total > 0 AND i.`date` >= '".$begin."' AND i.`date` <= '".$end."' AND i.".$type." = ".$user_id." AND invoice_type ".$i_type."
union all
select cp.pay FROM invoices i 
join customer_packages cp 
on i.id=cp.invoice_id 
WHERE cp.pay > 0 AND i.`date` >= '".$begin."' AND i.`date` <= '".$end."' AND i.".$type." = ".$user_id." AND invoice_type ".$i_type.") rs")->row();
   return $count->total;
}
// get target of store
function get_store_target($store_id, $begin, $end){
   $CI = get_instance();
   $count = $CI->db->query("SELECT SUM(total) as total FROM invoices WHERE store_id = ".$store_id." AND date >= 
   '".$begin."' AND date <= '".$end."'  ")->row();
   return $count->total;
}
?>