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

        if(isset($_FILES["file"]["name"])){
            $arrReturn = array();
            for ($k=0; $k < count($_FILES["file"]["name"]); $k++) { 
                $path = $_FILES["file"]["tmp_name"][$k];
                $object = PHPExcel_IOFactory::load($path);
                foreach($object->getWorksheetIterator() as $key=> $worksheet){
                    $number_hk = $worksheet->getCellByColumnAndRow(7, 12)->getValue();
                    if(empty($number_hk)){break;}
                        
                    $newData = (object) array(
                        'number'        => $worksheet->getCellByColumnAndRow(1, 3)->getValue(),
                        'number_hk'     => $number_hk,
                        'full_name'     => $worksheet->getCellByColumnAndRow(3, 7)->getValue(),
                        'from_strees'   => $worksheet->getCellByColumnAndRow(6, 8)->getValue(),
                        'from_ward'     => $worksheet->getCellByColumnAndRow(8, 8)->getValue(),
                        'from_city'     => $worksheet->getCellByColumnAndRow(4, 9)->getValue(),
                        'from_name'     => $worksheet->getCellByColumnAndRow(5, 10)->getValue(),
                        'from_qh'       => $worksheet->getCellByColumnAndRow(10, 10)->getValue(),
                        'top'           => 1,
                        'date'          => $worksheet->getCellByColumnAndRow(1, 6)->getValue(),
                        'to_strees'     => $worksheet->getCellByColumnAndRow(4, 13)->getValue(),
                        'to_ward'       => $worksheet->getCellByColumnAndRow(6, 13)->getValue(),
                        'to_city'       => $worksheet->getCellByColumnAndRow(8, 13)->getValue(),
                        'birtdate'      => $worksheet->getCellByColumnAndRow(4, 15)->getValue(),
                        'nguyenquan'    => $worksheet->getCellByColumnAndRow(3, 16)->getValue(),
                        'dantoc'        => $worksheet->getCellByColumnAndRow(3, 17)->getValue(),
                        'tongiao'       => $worksheet->getCellByColumnAndRow(6, 17)->getValue(),
                        'quoctich'      => $worksheet->getCellByColumnAndRow(9, 17)->getValue(),
                        'cmnd'          => $worksheet->getCellByColumnAndRow(3, 18)->getValue(),
                        'type'          => $worksheet->getCellByColumnAndRow(3, 20)->getValue(),
                        'hk01'          => $worksheet->getCellByColumnAndRow(3, 30)->getValue(),
                        'hk02'          => $worksheet->getCellByColumnAndRow(3, 31)->getValue(),
                        'hk07'          => $worksheet->getCellByColumnAndRow(3, 32)->getValue(),
                        'hk08'          => $worksheet->getCellByColumnAndRow(3, 33)->getValue(),
                        'khaisinh'      => $worksheet->getCellByColumnAndRow(5, 30)->getValue(),
                        'kethon'        => $worksheet->getCellByColumnAndRow(5, 31)->getValue(),
                        'giaycmnd'      => $worksheet->getCellByColumnAndRow(5, 32)->getValue(),
                        'nhaoHP'        => $worksheet->getCellByColumnAndRow(5, 33)->getValue(),
                        'sex'           => $worksheet->getCellByColumnAndRow(8, 15)->getValue() ? 'NAM' : 'NỮ',
                    );
                  
                       
                    array_push($arrReturn, $newData);

                    if(!empty($newData->type) && (int)$newData->type > 0 ){
                            $row = 22;
                            $col_name = 1;
                            $col_birtdate = 4;
                            $col_sex = 5;
                            $col_nguyenquan = 6;
                            $col_dantoc = 7;
                            $col_tongiao = 8;
                            $col_cmnd = 9;
                            $col_fromQH = 11;

                        for ($i=0; $i < (int)$newData->type; $i++) { 
                            $data = (object) array(
                                'number'        =>$newData->number,
                                'number_hk'     => $newData->number_hk,
                                'full_name'     => $worksheet->getCellByColumnAndRow($col_name, $row+$i)->getValue(),
                                'birtdate'     => $worksheet->getCellByColumnAndRow($col_birtdate, $row+$i)->getValue(),
                                'sex'     => $worksheet->getCellByColumnAndRow($col_sex, $row+$i)->getValue(),
                                'nguyenquan'     => $worksheet->getCellByColumnAndRow($col_nguyenquan, $row+$i)->getValue(),
                                'dantoc'     => $worksheet->getCellByColumnAndRow($col_dantoc, $row+$i)->getValue(),
                                'tongiao'     => $worksheet->getCellByColumnAndRow($col_tongiao, $row+$i)->getValue(),
                                'cmnd'     => $worksheet->getCellByColumnAndRow($col_cmnd, $row+$i)->getValue(),
                                'from_qh'     => $worksheet->getCellByColumnAndRow($col_fromQH, $row+$i)->getValue()
                            );
                           
                            array_push($arrReturn, $data);
                        }
                    }
                }
            }


            foreach ($arrReturn as $key => $value) {
                if((!empty($value->top) && $value->top == 1 )){
                        $this->db->select('nk.id')
                                    ->from('nhankhau as nk')
                                    ->where('nk.number_hk=',$value->number_hk)
                                    ->where('nk.cmnd=',$value->cmnd);
                        
                        $data = $this->db->get()->row();
                        if(empty($data)){
                            $this->db->insert('nhankhau',$value);
                            $arrReturn[$key]->is_insert = 1;
                        }else{
                            $arrReturn[$key]->is_insert = 0;
                        }
                }else{
                     $this->db->select('nk.id,nk.full_name')
                                    ->from('nhankhau as nk')
                                    ->where('nk.number_hk=',$value->number_hk);
                    $this->db->group_start();
                        $this->db->or_where('nk.cmnd=',!empty($value->cmnd) ? $value->cmnd : '');
                        $this->db->or_like('nk.full_name',!empty($value->full_name) ?$value->full_name : '' );
                    $this->db->group_end(); 
                    $data1 = $this->db->get()->row();
                    if(empty($data1)){
                        $this->db->insert('nhankhau',$value);
                        $arrReturn[$key]->is_insert = 1;
                    }else{
                        $arrReturn[$key]->is_insert = 0;
                    }
                }
            }

            $this->mViewData['arrReturn'] = $arrReturn;
        }
        
		$this->render('nhankhau/index', 'empty');
    }

    public function list()
    { 
        $sex = $this->input->get('sex') ?$this->input->get('sex') : '' ;
        $birtdate = $this->input->get('birtdate') ? $this->input->get('birtdate'): '' ;
        $find = $this->input->get('find') ? $this->input->get('find') :'';
        $nguyenquan = $this->input->get('nguyenquan') ? $this->input->get('nguyenquan') :'';

        $this->db->select('*')->from('nhankhau as nk');
        if(!empty($find)){
            $this->db->group_start();
            $this->db->or_like('nk.full_name',$find);
            $this->db->or_like('nk.cmnd',$find);
            $this->db->group_end();
        }
        if(!empty($sex)){
            $this->db->where('nk.sex=',$sex);
        }

        if(!empty($birtdate)){
            $this->db->like('nk.birtdate',$birtdate);
        }
        if(!empty($nguyenquan)){
            $this->db->like('nk.nguyenquan',$nguyenquan);
        }

        $this->db->order_by('nk.number_hk DESC');
        $arrReturn = $this->db->get()->result();

        $this->mViewData['birtdate'] = $birtdate;
        $this->mViewData['nguyenquan'] = $nguyenquan;
        $this->mViewData['sex'] = $sex;
        $this->mViewData['find'] = $find;

        $this->mViewData['arrReturn'] = $arrReturn;

        if($this->input->post('export')){

        }

		$this->render('nhankhau/list', 'empty');
    }
}