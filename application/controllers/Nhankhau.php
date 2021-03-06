<?php
defined('BASEPATH') or exit('No direct script access allowed');

// NOTE: this controller inherits from MY_Controller instead of Admin_Controller,
// since no authentication is required
class Nhankhau extends MY_Controller
{


    // public function __construct()
    // {		
    //     $this->load->library('excel');

    // }

    public function index()
    {
        $this->load->library('excel');
        $this->load->library('form_builder');
        $type = $this->input->post('type');


        if (!empty($type) && $type == 'NEW' && isset($_FILES["file"]["name"])) {

            ini_set('memory_limit', '200M');
            ini_set('max_file_uploads', 100);


            $arrReturn = array();
            for ($k = 0; $k < count($_FILES["file"]["name"]); $k++) {

                $file_name =  $_FILES["file"]["name"][$k];

                $path = $_FILES["file"]["tmp_name"][$k];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $key => $worksheet) {
                    $number_hk = $worksheet->getCellByColumnAndRow(7, 12)->getValue();
                    if (empty($number_hk)) {
                        break;
                    }
                    $bdateM = $worksheet->getCellByColumnAndRow(4, 15)->getValue();
                    $bdateM = strlen($bdateM) == 4 ?  '01/01/' . $bdateM : $bdateM;
                    $bdateFM = date_format(date_create_from_format('d/m/Y', $bdateM), 'Y-m-d');
                    $newData = (object) array(
                        'number'        => $worksheet->getCellByColumnAndRow(1, 3)->getValue(),
                        'number_hk'     => str_replace(' ', '', $number_hk),
                        'full_name'     => $worksheet->getCellByColumnAndRow(3, 7)->getValue(),
                        'from_strees'   => $worksheet->getCellByColumnAndRow(6, 8)->getValue(),
                        'from_ward'     => $worksheet->getCellByColumnAndRow(8, 8)->getValue(),
                        'from_city'     => !empty($worksheet->getCellByColumnAndRow(4, 9)->getValue()) ? $worksheet->getCellByColumnAndRow(4, 9)->getValue() : $worksheet->getCellByColumnAndRow(3, 9)->getValue(),
                        'from_name'     => $worksheet->getCellByColumnAndRow(5, 10)->getValue(),
                        'qh'       => $worksheet->getCellByColumnAndRow(10, 10)->getValue(),
                        'top'           => 1,
                        'date'          => $worksheet->getCellByColumnAndRow(1, 6)->getValue(),
                        'to_strees'     => $worksheet->getCellByColumnAndRow(4, 13)->getValue(),
                        'to_ward'       => $worksheet->getCellByColumnAndRow(6, 13)->getValue(),
                        'to_city'       => $worksheet->getCellByColumnAndRow(8, 13)->getValue(),
                        'birtdate'      => $bdateFM,
                        'birtdate_import' => $worksheet->getCellByColumnAndRow(4, 15)->getValue(),
                        'nguyenquan'    => $worksheet->getCellByColumnAndRow(3, 16)->getValue(),
                        'dantoc'        => $worksheet->getCellByColumnAndRow(3, 17)->getValue(),
                        'tongiao'       => $worksheet->getCellByColumnAndRow(6, 17)->getValue(),
                        'quoctich'      => $worksheet->getCellByColumnAndRow(9, 17)->getValue(),
                        'cmnd'          => $worksheet->getCellByColumnAndRow(3, 18)->getValue(),
                        'type'          => $file_name,
                        'hk01'          => $worksheet->getCellByColumnAndRow(3, 30)->getValue(),
                        'hk02'          => $worksheet->getCellByColumnAndRow(3, 31)->getValue(),
                        'hk07'          => $worksheet->getCellByColumnAndRow(3, 32)->getValue(),
                        'hk08'          => $worksheet->getCellByColumnAndRow(3, 33)->getValue(),
                        'khaisinh'      => $worksheet->getCellByColumnAndRow(5, 30)->getValue(),
                        'kethon'        => $worksheet->getCellByColumnAndRow(5, 31)->getValue(),
                        'giaycmnd'      => $worksheet->getCellByColumnAndRow(5, 32)->getValue(),
                        'nhaoHP'        => $worksheet->getCellByColumnAndRow(5, 33)->getValue(),
                        'sex'           => $worksheet->getCellByColumnAndRow(8, 15)->getValue() ? 'NAM' : 'NỮ',
                        'status'        => 1
                    );
                    array_push($arrReturn, $newData);
                    // if(!empty($newData->type) && (int)$newData->type > 0 ){
                    $row = 22;
                    $col_name = 1;
                    $col_birtdate = 4;
                    $col_sex = 5;
                    $col_nguyenquan = 6;
                    $col_dantoc = 7;
                    $col_tongiao = 8;
                    $col_cmnd = 9;
                    $col_fromQH = 11;

                    for ($i = 0; $i <= 7; $i++) {
                        $bdateU = $worksheet->getCellByColumnAndRow($col_birtdate, $row + $i)->getValue();
                        // echo $bdateU.'<br>';
                        $bdateU = strlen($bdateU) == 4 ?  '01/01/' . $bdateU : $bdateU;

                        // $bdate = date_format(DateTime::createFromFormat('d/m/Y',$bdateU),'Y-m-d');
                        $bdate = date_create_from_format('d/m/Y', $bdateU);
                        $bdate = date_format($bdate, 'Y-m-d');
                        $fullname = $worksheet->getCellByColumnAndRow($col_name, $row + $i)->getValue();
                        if (empty($fullname)) {
                            break;
                        }
                        $data = (object) array(
                            'number'        => $newData->number,
                            'number_hk'     => $newData->number_hk,
                            'from_strees'   => $newData->from_strees,
                            'from_ward'     => $newData->from_ward,
                            'from_city'     => $newData->from_city,
                            'from_name'     => $newData->from_name,
                            'to_strees'     => $newData->to_strees,
                            'to_ward'       => $newData->to_ward,
                            'to_city'       => $newData->to_city,
                            'date'          => $newData->date,
                            'to_strees'     => $newData->to_strees,
                            'to_ward'       => $newData->to_ward,
                            'to_city'       => $newData->to_city,
                            'full_name'     => $worksheet->getCellByColumnAndRow($col_name, $row + $i)->getValue(),
                            'birtdate'     =>  $bdate,
                            'birtdate_import' => $worksheet->getCellByColumnAndRow($col_birtdate, $row + $i)->getValue(),
                            'sex'     => $worksheet->getCellByColumnAndRow($col_sex, $row + $i)->getValue(),
                            'nguyenquan'     => $worksheet->getCellByColumnAndRow($col_nguyenquan, $row + $i)->getValue(),
                            'dantoc'     => $worksheet->getCellByColumnAndRow($col_dantoc, $row + $i)->getValue(),
                            'tongiao'     => $worksheet->getCellByColumnAndRow($col_tongiao, $row + $i)->getValue(),
                            'cmnd'     => $worksheet->getCellByColumnAndRow($col_cmnd, $row + $i)->getValue(),
                            'qh'     => $worksheet->getCellByColumnAndRow($col_fromQH, $row + $i)->getValue(),
                            'status'        => 1,
                            'type' => $file_name
                        );
                        array_push($arrReturn, $data);
                    }
                    // }
                }
            }
        }

        if (!empty($type) && $type == 'IN' && isset($_FILES["file"]["name"])) {
            $arrReturn = array();
            for ($k = 0; $k < count($_FILES["file"]["name"]); $k++) {
                $path = $_FILES["file"]["tmp_name"][$k];
                $file_name =  $_FILES["file"]["name"][$k];

                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $key => $worksheet) {
                    $number_hk = $worksheet->getCellByColumnAndRow(8, 9)->getValue();
                    if (empty($number_hk)) {
                        break;
                    }


                    $bdateM = $worksheet->getCellByColumnAndRow(4, 12)->getValue();
                    $bdateM = !empty($bdateM) ? $worksheet->getCellByColumnAndRow(4, 12)->getValue() :  $worksheet->getCellByColumnAndRow(3, 12)->getValue();
                    $bdateM = strlen($bdateM) == 4 ?  '01/01/' . $bdateM : $bdateM;
                    $bdateFM = !empty($bdateM) ?  date_format(date_create_from_format('d/m/Y', $bdateM), 'Y-m-d') : '';

                    $newData = (object) array(
                        'number'        => $worksheet->getCellByColumnAndRow(1, 3)->getValue(),
                        'number_hk'     => $number_hk,
                        'number_hk_old' => $worksheet->getCellByColumnAndRow(6, 9)->getValue(),
                        'full_name'     => !empty($worksheet->getCellByColumnAndRow(4, 11)->getValue()) ? $worksheet->getCellByColumnAndRow(4, 11)->getValue() : $worksheet->getCellByColumnAndRow(5, 11)->getValue(),
                        'from_strees'   => !empty($worksheet->getCellByColumnAndRow(6, 16)->getValue()) ? $worksheet->getCellByColumnAndRow(6, 16)->getValue() : $worksheet->getCellByColumnAndRow(5, 16)->getValue(),
                        'from_ward'     => $worksheet->getCellByColumnAndRow(8, 16)->getValue(),
                        'from_city'     => !empty($worksheet->getCellByColumnAndRow(6, 17)->getValue()) ? $worksheet->getCellByColumnAndRow(6, 17)->getValue() : $worksheet->getCellByColumnAndRow(5, 17)->getValue(),
                        'from_name'     => $worksheet->getCellByColumnAndRow(3, 18)->getValue(),
                        'from_qh'       => $worksheet->getCellByColumnAndRow(10, 10)->getValue(),
                        'qh'            => $worksheet->getCellByColumnAndRow(10, 20)->getValue(),
                        'top'           => 0,
                        'date'          => $worksheet->getCellByColumnAndRow(1, 6)->getValue(),
                        'to_strees'     => $worksheet->getCellByColumnAndRow(4, 8)->getValue(),
                        'to_ward'       => $worksheet->getCellByColumnAndRow(6, 8)->getValue(),
                        'to_city'       => $worksheet->getCellByColumnAndRow(8, 8)->getValue(),
                        'birtdate'      => $bdateFM,
                        'birtdate_import' => $worksheet->getCellByColumnAndRow(4, 12)->getValue(),
                        'nguyenquan'    => $worksheet->getCellByColumnAndRow(3, 13)->getValue(),
                        'dantoc'        => $worksheet->getCellByColumnAndRow(3, 14)->getValue(),
                        'tongiao'       => $worksheet->getCellByColumnAndRow(6, 14)->getValue(),
                        'quoctich'      => $worksheet->getCellByColumnAndRow(9, 14)->getValue(),
                        'cmnd'          => $worksheet->getCellByColumnAndRow(3, 15)->getValue(),
                        'hk01'          => $worksheet->getCellByColumnAndRow(3, 30)->getValue(),
                        'hk02'          => $worksheet->getCellByColumnAndRow(3, 31)->getValue(),
                        'hk07'          => $worksheet->getCellByColumnAndRow(3, 32)->getValue(),
                        'hk08'          => $worksheet->getCellByColumnAndRow(3, 33)->getValue(),
                        'khaisinh'      => $worksheet->getCellByColumnAndRow(5, 30)->getValue(),
                        'kethon'        => $worksheet->getCellByColumnAndRow(5, 31)->getValue(),
                        'giaycmnd'      => $worksheet->getCellByColumnAndRow(5, 32)->getValue(),
                        'nhaoHP'        => $worksheet->getCellByColumnAndRow(5, 33)->getValue(),
                        'sex'           => $worksheet->getCellByColumnAndRow(8, 12)->getValue() ? 'NAM' : 'NỮ',
                        'type'          => $file_name,
                        'chuyenden'     => 1,
                        'ngaychuyenden'     => $worksheet->getCellByColumnAndRow(1, 6)->getValue(),
                        'status'        => 2
                    );
                    array_push($arrReturn, $newData);


                    // if(!empty($newData->type) && (int)$newData->type > 0 ){
                    $row = 23;
                    $col_name = 1;
                    $col_birtdate = 4;
                    $col_sex = 5;
                    $col_nguyenquan = 6;
                    $col_dantoc = 7;
                    $col_tongiao = 8;
                    $col_cmnd = 9;
                    $col_fromQH = 11;



                    for ($i = 0; $i < 8; $i++) {
                        $fullname = $worksheet->getCellByColumnAndRow($col_name, $row + $i)->getValue();
                        $bdateU = $worksheet->getCellByColumnAndRow($col_birtdate, $row + $i)->getValue();
                        if (empty($fullname) && empty($bdateU)) break;

                        $bdateU = strlen($bdateU) == 4 ?  '01/01/' . $bdateU : $bdateU;
                        $bdate = !empty($bdateU) ? date_format(date_create_from_format('d/m/Y', $bdateU), 'Y-m-d') : '';

                        $data = (object) array(
                            'number'        => $newData->number,
                            'number_hk'     => $newData->number_hk,
                            'number_hk_old' => $newData->number_hk_old,
                            'from_strees'   => $newData->from_strees,
                            'from_ward'     => $newData->from_ward,
                            'from_city'     => $newData->from_city,
                            'from_name'     => $newData->from_name,
                            'date'          => $newData->date,
                            'to_strees'     => $newData->to_strees,
                            'to_ward'       => $newData->to_ward,
                            'to_city'       => $newData->to_city,
                            'full_name'     => $fullname,
                            'birtdate'      => $bdate,
                            'birtdate_import' => $worksheet->getCellByColumnAndRow($col_birtdate, $row + $i)->getValue(),
                            'sex'           => $worksheet->getCellByColumnAndRow($col_sex, $row + $i)->getValue(),
                            'nguyenquan'    => $worksheet->getCellByColumnAndRow($col_nguyenquan, $row + $i)->getValue(),
                            'dantoc'        => $worksheet->getCellByColumnAndRow($col_dantoc, $row + $i)->getValue(),
                            'tongiao'       => $worksheet->getCellByColumnAndRow($col_tongiao, $row + $i)->getValue(),
                            'cmnd'          => $worksheet->getCellByColumnAndRow($col_cmnd, $row + $i)->getValue(),
                            'qh'            => $worksheet->getCellByColumnAndRow($col_fromQH, $row + $i)->getValue(),
                            'chuyenden'     => 1,
                            'ngaychuyenden'     => $newData->date,
                            'status'        => 2,
                            'type'          => $file_name
                        );

                        array_push($arrReturn, $data);
                        // }
                    }
                }
            }
        }

        if (!empty($type) && $type == 'OUT' && isset($_FILES["file"]["name"])) {
            $arrReturn = array();
            for ($k = 0; $k < count($_FILES["file"]["name"]); $k++) {
                $path = $_FILES["file"]["tmp_name"][$k];
                $file_name =  $_FILES["file"]["name"][$k];

                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $key => $worksheet) {
                    if ($key == 3) {
                        break;
                    }
                    $number_hk = $worksheet->getCellByColumnAndRow(8, 10)->getValue();
                    $number_hk_old = $worksheet->getCellByColumnAndRow(6, 10)->getValue();


                    $bdateM = $worksheet->getCellByColumnAndRow(3, 13)->getValue();
                    $bdateM = strlen($bdateM) == 4 ?  '01/01/' . $bdateM : $bdateM;
                    $bdateFM = !empty($bdateM) ? date_format(date_create_from_format('d/m/Y', $bdateM), 'Y-m-d') : '';

                    $newData = (object) array(
                        'number'        => $worksheet->getCellByColumnAndRow(1, 3)->getValue(),
                        'number_hk'     => str_replace(' ', '', empty($number_hk) ? $number_hk_old : $number_hk),
                        'number_hk_old' => $number_hk_old,
                        'full_name'     => $key == 0  ? $worksheet->getCellByColumnAndRow(3, 8)->getValue() : $worksheet->getCellByColumnAndRow(4, 12)->getValue(),
                        'qh'            => $key == 0 ? 'CH' : $worksheet->getCellByColumnAndRow(10, 12)->getValue(),
                        'top'           => $key == 0 ? 1 : 0,
                        'date'          => $worksheet->getCellByColumnAndRow(0, 7)->getValue(),
                        'to_strees'     => $worksheet->getCellByColumnAndRow(4, 9)->getValue(),
                        'to_ward'       => $worksheet->getCellByColumnAndRow(6, 9)->getValue(),
                        'to_city'       => $worksheet->getCellByColumnAndRow(8, 9)->getValue(),
                        'birtdate'      =>  $bdateFM,
                        'birtdate_import' => $worksheet->getCellByColumnAndRow(3, 13)->getValue(),
                        'nguyenquan'    => $worksheet->getCellByColumnAndRow(3, 15)->getValue(),
                        'dantoc'        => $worksheet->getCellByColumnAndRow(2, 16)->getValue(),
                        'tongiao'       => $worksheet->getCellByColumnAndRow(5, 16)->getValue(),
                        'quoctich'      => $worksheet->getCellByColumnAndRow(9, 16)->getValue(),
                        'cmnd'          => $worksheet->getCellByColumnAndRow(3, 17)->getValue(),
                        'sex'           => $worksheet->getCellByColumnAndRow(7, 13)->getValue(),
                        'type'          => $file_name,
                        'chuyendi'      => 1,
                        'ngaychuyendi'  => $worksheet->getCellByColumnAndRow(0, 7)->getValue(),
                        'status'        => 3,
                        'noichuyendi'   => $worksheet->getCellByColumnAndRow(3, 18)->getValue()
                    );
                    array_push($arrReturn, $newData);


                    // if(!empty($newData->type) && (int)$newData->type > 0 ){
                    $row = 21;
                    $col_name = 1;
                    $col_birtdate = 4;
                    $col_sex = 5;
                    $col_nguyenquan = 6;
                    $col_dantoc = 7;
                    $col_tongiao = 8;
                    $col_cmnd = 9;
                    $col_fromQH = 11;


                    for ($i = 0; $i < 8; $i++) {
                        if ($key == 2) break;
                        $bdateU = $worksheet->getCellByColumnAndRow($col_birtdate, $row + $i)->getValue();
                        $bdateU = strlen($bdateU) == 4 ?  '01/01/' . $bdateU : $bdateU;
                        // $fm = $key == 1 ? 'm/d/Y' : 'd/m/Y';

                        $fullname = $worksheet->getCellByColumnAndRow($col_name, $row + $i)->getValue();
                        if (empty($fullname)) break;

                        // $bdate = !empty($bdateU) ?   ($key ==1 ?date('Y-m-d',strtotime(PHPExcel_Shared_Date::ExcelToPHPObject($bdateU)->format('Y-m-d'))) 
                        // : date_format(DateTime::createFromFormat('d/m/Y',$bdateU),'Y-m-d')) : '';
                        $bdate = !empty($bdateU) ? date_format(date_create_from_format('d/m/Y', $bdateU), 'Y-m-d') : '';

                        $data = (object) array(
                            'number'        => $newData->number,
                            'number_hk'     => str_replace(' ', '', empty($number_hk) ? $number_hk_old : $number_hk),
                            'number_hk_old' => $newData->number_hk_old,
                            'date'          => $newData->date,
                            'to_strees'     => $newData->to_strees,
                            'to_ward'       => $newData->to_ward,
                            'to_city'       => $newData->to_city,
                            'full_name'     => $fullname,
                            'birtdate'      => $bdate,
                            'birtdate_import' =>  $worksheet->getCellByColumnAndRow($col_birtdate, $row + $i)->getValue(),
                            'sex'           => $worksheet->getCellByColumnAndRow($col_sex, $row + $i)->getValue(),
                            'nguyenquan'    => $worksheet->getCellByColumnAndRow($col_nguyenquan, $row + $i)->getValue(),
                            'dantoc'        => $worksheet->getCellByColumnAndRow($col_dantoc, $row + $i)->getValue(),
                            'cmnd'          => $worksheet->getCellByColumnAndRow($col_cmnd, $row + $i)->getValue(),
                            'qh'            => $worksheet->getCellByColumnAndRow($col_fromQH, $row + $i)->getValue(),
                            'quoctich'      => $worksheet->getCellByColumnAndRow($col_tongiao, $row + $i)->getValue(),
                            'chuyendi'      => 1,
                            'ngaychuyendi'  => $newData->date,
                            'status'        => 3,
                            'noichuyendi'   => $newData->noichuyendi,
                            'type'          => $file_name
                        );
                        array_push($arrReturn, $data);
                    }
                    // }
                }
            }
        }

        if (!empty($type) && $type == 'KSINH' && isset($_FILES["file"]["name"])) {
            $arrReturn = array();
            for ($k = 0; $k < count($_FILES["file"]["name"]); $k++) {
                $file_name =  $_FILES["file"]["name"][$k];
                $path = $_FILES["file"]["tmp_name"][$k];
                $object = PHPExcel_IOFactory::load($path);
                foreach ($object->getWorksheetIterator() as $key => $worksheet) {
                    $number_hk = $worksheet->getCellByColumnAndRow(7, 10)->getValue();
                    $number_hk1 = $worksheet->getCellByColumnAndRow(9, 10)->getValue();
                    if (empty($number_hk)) {
                        break;
                    }


                    $bdateM = $worksheet->getCellByColumnAndRow(3, 14)->getValue();

                    $bdateM = empty($bdateM) ? $worksheet->getCellByColumnAndRow(4, 12)->getValue() : $bdateM;
                    $bdateM = empty($bdateM) ? $worksheet->getCellByColumnAndRow(3, 12)->getValue() : $bdateM;
                    $bdateM = strlen($bdateM) == 4 ?  '01/01/' . $bdateM : $bdateM;
                    // $bdateFM = !empty($bdateM) ?  date_format(date_create_from_format('d/m/Y', $bdateM), 'Y-m-d') : '';
                    $bdateM = !empty($bdateM) ? date('d/m/Y', strtotime(PHPExcel_Shared_Date::ExcelToPHPObject($bdateM)->format('Y-m-d'))) : '';

                    $bdateI =  date('Y-m-d', strtotime(PHPExcel_Shared_Date::ExcelToPHPObject($worksheet->getCellByColumnAndRow(3, 14)->getValue())->format('Y-m-d')));
                    $bdateI1 =  PHPExcel_Shared_Date::ExcelToPHPObject($worksheet->getCellByColumnAndRow(3, 14)->getValue());
                    $newData = (object) array(
                        'number'        => $worksheet->getCellByColumnAndRow(1, 3)->getValue(),
                        'number_hk'     => str_replace(' ', '', $number_hk . $number_hk1),
                        'number_hk_old' => $worksheet->getCellByColumnAndRow(3, 10)->getValue(),
                        'full_name'     => $worksheet->getCellByColumnAndRow(3, 13)->getValue(),
                        'qh'            => $worksheet->getCellByColumnAndRow(3, 18)->getValue(),
                        'cmnd'          => 'KHAI SINH',
                        'top'           => 0,
                        'date'          => $worksheet->getCellByColumnAndRow(1, 7)->getValue(),
                        'to_strees'     => $worksheet->getCellByColumnAndRow(3, 9)->getValue(),
                        'to_ward'       => $worksheet->getCellByColumnAndRow(6, 9)->getValue(),
                        'to_city'       => $worksheet->getCellByColumnAndRow(8, 9)->getValue(),
                        // 'birtdate'      => PHPExcel_Shared_Date::ExcelToPHPObject($worksheet->getCellByColumnAndRow(3, 14)->getValue())->format('Y-m-d'),
                        'birtdate'      => $bdateM,
                        'birtdate_import' => $bdateI . ',' . $bdateI1,
                        'nguyenquan'    => $worksheet->getCellByColumnAndRow(3, 16)->getValue(),
                        'dantoc'        => $worksheet->getCellByColumnAndRow(2, 15)->getValue(),
                        'tongiao'       => $worksheet->getCellByColumnAndRow(5, 15)->getValue(),
                        'quoctich'      => $worksheet->getCellByColumnAndRow(9, 15)->getValue(),
                        'type'          => $file_name,
                        'hk01'          => $worksheet->getCellByColumnAndRow(3, 25)->getValue(),
                        'hk02'          => $worksheet->getCellByColumnAndRow(3, 26)->getValue(),
                        'hk08'          => $worksheet->getCellByColumnAndRow(3, 27)->getValue(),
                        'khaisinh'      => $worksheet->getCellByColumnAndRow(5, 25)->getValue(),
                        'kethon'        => $worksheet->getCellByColumnAndRow(5, 26)->getValue(),
                        'giaycmnd'      => $worksheet->getCellByColumnAndRow(3, 28)->getValue(),
                        'nhaoHP'        => $worksheet->getCellByColumnAndRow(5, 27)->getValue(),
                        'sex'           => $worksheet->getCellByColumnAndRow(8, 13)->getValue() ? 'NAM' : 'NỮ',
                        'status'        => 4
                    );
                    array_push($arrReturn, $newData);

                    // if(!empty($newData->type) && (int)$newData->type > 0 ){
                    $row = 21;
                    $col_name = 1;
                    $col_birtdate = 4;
                    $col_sex = 5;
                    $col_nguyenquan = 6;
                    $col_dantoc = 7;
                    $col_quoctich = 8;
                    $col_cmnd = 9;
                    $col_fromQH = 11;

                    for ($i = 0; $i < 8; $i++) {
                        $fullname = $worksheet->getCellByColumnAndRow($col_name, $row + $i)->getValue();
                        if (empty($fullname)) break;

                        $d1 = $worksheet->getCellByColumnAndRow($col_birtdate, $row + $i)->getValue();
                        $bdate = !empty($d1) ?  date_format(date_create_from_format('d/m/Y', $d1), 'Y-m-d') : '';
                        $bdateI = $d1;
                        $bdateI1 = PHPExcel_Shared_Date::ExcelToPHPObject($d1)->format('Y-m-d');
                        $data = (object) array(
                            'number'        => $newData->number,
                            'number_hk'     => $newData->number_hk,
                            'date'          => $newData->date,
                            'to_strees'     => $newData->to_strees,
                            'to_ward'       => $newData->to_ward,
                            'to_city'       => $newData->to_city,
                            'full_name'     => $fullname,
                            'birtdate'     => $bdate,
                            'birtdate_import'      => $bdateI . ',' . $bdateI1,
                            'sex'     => $worksheet->getCellByColumnAndRow($col_sex, $row + $i)->getValue(),
                            'nguyenquan'     => $worksheet->getCellByColumnAndRow($col_nguyenquan, $row + $i)->getValue(),
                            'dantoc'     => $worksheet->getCellByColumnAndRow($col_dantoc, $row + $i)->getValue(),
                            'quoctich'     => $worksheet->getCellByColumnAndRow($col_quoctich, $row + $i)->getValue(),
                            'cmnd'     => $worksheet->getCellByColumnAndRow($col_cmnd, $row + $i)->getValue(),
                            'qh'     => $worksheet->getCellByColumnAndRow($col_fromQH, $row + $i)->getValue(),
                            'status'        => 4,
                            'type'  => $file_name
                        );

                        array_push($arrReturn, $data);
                    }
                    // }
                }
            }
        }

        if (!empty($arrReturn)) {
            foreach ($arrReturn as $key => $value) {
                $value->created = date('Y-m-d H:i:s');
                if ((!empty($value->top) && $value->top == 1)) {
                    $this->db->select('nk.id')
                        ->from('nhankhau as nk')
                        ->where('nk.number_hk=', $value->number_hk)
                        ->where('nk.cmnd=', $value->cmnd);

                    $data = $this->db->get()->row();

                    if (empty($data)) {
                        $this->db->insert('nhankhau', $value);
                        $value->nk_id = $this->db->insert_id();

                        $arrReturn[$key]->is_insert = 1;
                    } else {
                        $value->nk_id = $data->id;
                        $arrReturn[$key]->is_insert = 0;
                        if ($value->status == 3) {
                            $this->db->update('nhankhau', array(
                                'status'    => 3,
                                'chuyendi'  => 1,
                                'ngaychuyendi' => $value->date,
                                'noichuyendi'  => $value->noichuyendi
                            ), array('id' => $data->id));
                        }
                    }
                } else {

                    $this->db->select('nk.id,nk.full_name')
                        ->from('nhankhau as nk')
                        ->where('nk.number_hk=', $value->number_hk);
                    $this->db->where('nk.full_name=', !empty($value->full_name) ? $value->full_name : '');
                    $this->db->where('nk.birtdate=', !empty($value->birtdate) ? $value->birtdate : '');

                    $data1 = $this->db->get()->row();
                    if (empty($data1) && !empty($value->full_name)) {
                        $this->db->insert('nhankhau', $value);
                        $value->nk_id = $this->db->insert_id();
                        $arrReturn[$key]->is_insert = 1;
                    } else {
                        $value->nk_id = $data1->id;
                        $arrReturn[$key]->is_insert = 0;
                        if ($value->status == 3) {
                            $this->db->update(
                                'nhankhau',
                                array(
                                    'status'    => 3,
                                    'chuyendi'  => 1,
                                    'ngaychuyendi' => $value->date,
                                    'noichuyendi'  => $value->noichuyendi
                                ),
                                array('id' => $data1->id)
                            );
                        }
                    }
                }
            }
            $insert = 0;
            foreach ($arrReturn as $key => $value) {
                $insert = $insert + $value->is_insert;
            }

            $this->mViewData['arrReturn'] = $arrReturn;
            $this->mViewData['insert'] = $insert;
            $this->mViewData['hasNK'] = count($arrReturn) - $insert;
        }
        $this->mViewData['type'] = !empty($type) ? $type : '';


        $this->render('nhankhau/index', 'empty');
    }

    public function list()
    {

        if ($this->input->post('delete')) {
            $id = $this->input->post('delete');
            $this->db->delete('nhankhau', array('id' => $id));
        }

        $currentPage = $this->input->get('page');
        $currentPage = empty($currentPage) || $currentPage == 1 ? 0 : ($currentPage - 1) * 50;


        $sex = $this->input->get('sex') ? $this->input->get('sex') : '';
        $birtdate_from = $this->input->get('birtdate_from') ? $this->input->get('birtdate_from') : '';
        $birtdate_to = $this->input->get('birtdate_to') ? $this->input->get('birtdate_to') : '';

        $birtdate_to = !empty($birtdate_to) ? date_format(DateTime::createFromFormat('d/m/Y', $birtdate_to), 'Y-m-d') : $birtdate_to;
        $birtdate_from = !empty($birtdate_from) ? date_format(DateTime::createFromFormat('d/m/Y', $birtdate_from), 'Y-m-d') : $birtdate_from;


        $find = $this->input->get('find') ? $this->input->get('find') : '';
        $nguyenquan = $this->input->get('nguyenquan') ? $this->input->get('nguyenquan') : '';
        $status = $this->input->get('status') ? $this->input->get('status') : '';
        $number_hk = $this->input->get('number_hk') ? $this->input->get('number_hk') : '';
        $from = $this->input->get('from') ? $this->input->get('from') : '';

        $this->db->select('*')->from('nhankhau as nk');
        if (!empty($find)) {
            $this->db->group_start();
            $this->db->or_like('nk.full_name', $find);
            $this->db->or_like('nk.cmnd', $find);
            $this->db->group_end();
        }
        if (!empty($from)) {
            $this->db->group_start();
            $this->db->or_like('CONCAT(nk.to_strees," ",nk.to_ward, " ",nk.to_city)', $from);
            $this->db->or_like('CONCAT(nk.from_strees," ",nk.from_ward, " ",nk.from_city)', $from);
            $this->db->or_like('nk.noichuyendi', $from);
            $this->db->group_end();
        }

        if (!empty($sex)) {
            $this->db->where('nk.sex=', $sex);
        }

        if (!empty($status)) {
            $this->db->where('nk.status=', $status);
        }

        if (!empty($birtdate_from) && empty($birtdate_to)) {
            $this->db->where('nk.birtdate>=', $birtdate_from);
        }

        if (!empty($birtdate_to) && empty($birtdate_from)) {
            $this->db->where('nk.birtdate<=', $birtdate_to);
        }

        if (!empty($birtdate_from) && !empty($birtdate_to)) {
            $this->db->where('nk.birtdate>=', $birtdate_from);
            $this->db->where('nk.birtdate<=', $birtdate_to);
        }

        if (!empty($nguyenquan)) {
            $this->db->like('nk.nguyenquan', $nguyenquan);
        }

        if (!empty($number_hk)) {
            $this->db->like('nk.number_hk', $number_hk);
        }
        $this->db->limit(50, $currentPage);

        $this->db->order_by('nk.number_hk DESC');
        $arrReturn = $this->db->get()->result();

        //count
        $this->db->select('count(nk.id) as total')->from('nhankhau as nk');
        if (!empty($find)) {
            $this->db->group_start();
            $this->db->or_like('nk.full_name', $find);
            $this->db->or_like('nk.cmnd', $find);
            $this->db->group_end();
        }
        if (!empty($from)) {
            $this->db->group_start();
            $this->db->or_like('CONCAT(nk.to_strees," ",nk.to_ward, " ",nk.to_city)', $from);
            $this->db->or_like('CONCAT(nk.from_strees," ",nk.from_ward, " ",nk.from_city)', $from);
            $this->db->or_like('nk.noichuyendi', $from);
            $this->db->group_end();
        }
        if (!empty($sex)) $this->db->where('nk.sex=', $sex);
        if (!empty($status)) $this->db->where('nk.status=', $status);
        if (!empty($birtdate_from) && empty($birtdate_to)) $this->db->where('nk.birtdate>=', $birtdate_from);
        if (!empty($birtdate_to) && empty($birtdate_from)) $this->db->where('nk.birtdate<=', $birtdate_to);
        if (!empty($birtdate_from) && !empty($birtdate_to)) {
            $this->db->where('nk.birtdate>=', $birtdate_from);
            $this->db->where('nk.birtdate<=', $birtdate_to);
        }

        if (!empty($nguyenquan)) $this->db->like('nk.nguyenquan', $nguyenquan);

        if (!empty($number_hk)) $this->db->like('nk.number_hk', $number_hk);

        $c = $this->db->get()->row();




        $this->mViewData['birtdate_from'] = !empty($birtdate_from) ? date('d/m/Y', strtotime($birtdate_from)) : '';
        $this->mViewData['birtdate_to'] = !empty($birtdate_to) ? date('d/m/Y', strtotime($birtdate_to)) : '';
        $this->mViewData['nguyenquan'] = $nguyenquan;
        $this->mViewData['sex'] = $sex;
        $this->mViewData['find'] = $find;
        $this->mViewData['status'] = $status;
        $this->mViewData['status'] = $status;
        $this->mViewData['from'] = $from;
        $this->mViewData['number_hk'] = $number_hk;
        $this->mViewData['arrReturn'] = $arrReturn;
        $results = new stdClass();
        $results->page = $this->input->get('page') ? $this->input->get('page') : 1;
        $results->currentShow = count($arrReturn);
        $results->total = $c->total;
        $this->mViewData['results'] = $results;


        if ($this->input->post('export')) {


            $this->db->select('*')->from('nhankhau as nk');
            if (!empty($find)) {
                $this->db->group_start();
                $this->db->or_like('nk.full_name', $find);
                $this->db->or_like('nk.cmnd', $find);
                $this->db->group_end();
            }
            if (!empty($from)) {
                $this->db->group_start();
                $this->db->or_like('CONCAT(nk.to_strees," ",nk.to_ward, " ",nk.to_city)', $from);
                $this->db->or_like('CONCAT(nk.from_strees," ",nk.from_ward, " ",nk.from_city)', $from);
                $this->db->or_like('nk.noichuyendi', $from);
                $this->db->group_end();
            }

            if (!empty($sex)) {
                $this->db->where('nk.sex=', $sex);
            }

            if (!empty($status)) {
                $this->db->where('nk.status=', $status);
            }

            if (!empty($birtdate_from) && empty($birtdate_to)) {
                $this->db->where('nk.birtdate>=', $birtdate_from);
            }

            if (!empty($birtdate_to) && empty($birtdate_from)) {
                $this->db->where('nk.birtdate<=', $birtdate_to);
            }

            if (!empty($birtdate_from) && !empty($birtdate_to)) {
                $this->db->where('nk.birtdate>=', $birtdate_from);
                $this->db->where('nk.birtdate<=', $birtdate_to);
            }

            if (!empty($nguyenquan)) {
                $this->db->like('nk.nguyenquan', $nguyenquan);
            }

            if (!empty($number_hk)) {
                $this->db->like('nk.number_hk', $number_hk);
            }

            $this->db->order_by('nk.number_hk DESC');
            $arrReturn2 = $this->db->get()->result();



            $this->load->library("excel");
            $object = new PHPExcel();
            $object->setActiveSheetIndex(0);
            $table_columns = array(
                "Số",
                "Hộ khẩu củ",
                "Hộ khẩu",
                "Họ tên",
                "Giới tính",
                "CMND",
                "Quan hệ",
                "Ngày sinh",
                "Nguyên quán",
                "Dân tộc",
                "Tôn giáo",
                "Quốc tịch",
                "chuyển từ",
                "Chuyển đến",
                "Chuyển đi",
                "Ngày chuyển",
                "Tình trạng",
            );
            $column = 0;
            foreach ($table_columns as $field) {
                $object->getActiveSheet()->setCellValueByColumnAndRow($column, 1, $field);
                $column++;
            }

            $excel_row = 2;

            foreach ($arrReturn2 as $row) {
                $object->getActiveSheet()->setCellValueByColumnAndRow(0, $excel_row, $row->number);
                $object->getActiveSheet()->setCellValueByColumnAndRow(1, $excel_row, $row->number_hk_old);
                $object->getActiveSheet()->setCellValueByColumnAndRow(2, $excel_row, $row->number_hk);
                $object->getActiveSheet()->setCellValueByColumnAndRow(3, $excel_row, $row->full_name);
                $object->getActiveSheet()->setCellValueByColumnAndRow(4, $excel_row, $row->sex);
                $object->getActiveSheet()->setCellValueByColumnAndRow(5, $excel_row, $row->cmnd);
                $object->getActiveSheet()->setCellValueByColumnAndRow(6, $excel_row, $row->qh);
                $object->getActiveSheet()->setCellValueByColumnAndRow(7, $excel_row,  date('d/m/Y', strtotime($row->birtdate)));
                $object->getActiveSheet()->setCellValueByColumnAndRow(8, $excel_row, $row->nguyenquan);
                $object->getActiveSheet()->setCellValueByColumnAndRow(9, $excel_row, $row->dantoc);
                $object->getActiveSheet()->setCellValueByColumnAndRow(10, $excel_row, $row->tongiao);
                $object->getActiveSheet()->setCellValueByColumnAndRow(11, $excel_row, $row->quoctich);

                $object->getActiveSheet()->setCellValueByColumnAndRow(12, $excel_row, (!empty($row->from_strees) ? $row->from_strees . ' - ' : '') .
                    (!empty($row->from_ward) ? $row->from_ward . ' - ' : '') .
                    (!empty($row->from_city) ? $row->from_city : ''));

                $object->getActiveSheet()->setCellValueByColumnAndRow(13, $excel_row, (!empty($row->to_strees) ? $row->to_strees . ' - ' : '') .
                    (!empty($row->to_ward) ? $row->to_ward . ' - ' : '') .
                    (!empty($row->to_city) ? $row->to_city : ''));

                $object->getActiveSheet()->setCellValueByColumnAndRow(14, $excel_row, $row->noichuyendi);
                $object->getActiveSheet()->setCellValueByColumnAndRow(15, $excel_row, $row->date);
                $status = 'Hộ mới';
                if ($row->status == 2)  $status = 'Chuyển đến';
                if ($row->status == 3)  $status = 'Chuyển đi';
                if ($row->status == 4)  $status = 'Khai sinh';
                $object->getActiveSheet()->setCellValueByColumnAndRow(16, $excel_row, $status);
                $excel_row++;
            }

            $objWriter = new PHPExcel_Writer_Excel2007($object);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="dulieunhankhau.xlsx"');
            $objWriter->save('php://output');
        }

        $this->render('nhankhau/list', 'empty');
    }

    public function edit($id)
    {
        if (!empty($_POST['birtdate'])) {
            $_POST['birtdate'] = date_format(DateTime::createFromFormat('d/m/Y', $_POST['birtdate']), 'Y-m-d');
        }

        if ($this->input->post('id') && $this->input->post('number_hk')) {
            $this->db->update('nhankhau', $_POST, array('id' => $this->input->post('id')));
        }
        if ($this->input->post('id') == 0 && $this->input->post('number_hk')) {
            $this->db->insert('nhankhau', $_POST);
        }

        $this->db->select('*')->from('nhankhau as nk')->where('nk.id=', $id);
        $nk = $this->db->get()->row();
        $this->mViewData['nk'] = $nk;
        $this->mViewData['id'] = $id;


        $this->render('nhankhau/edit', 'empty');
    }

    public function ajax_update_birtdate()
    {
        $_POST  = json_decode(file_get_contents('php://input'), true);
        $this->db->update('nhankhau',array('birtdate'=> date_format(date_create_from_format('d/m/Y', $this->input->post('date')), 'Y-m-d')),array('id'=>$this->input->post('id')));
        if ($this->db->affected_rows() > 0){
            echo json_encode(array('status' => 1, 'message' => 'Cập nhật thành công!'));
        }else{
            echo json_encode(array('status' => 0, 'message' => 'Định dạng không hợp lệ!'));
        }
    }
}
