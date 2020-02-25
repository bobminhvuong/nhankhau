<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once APPPATH."third_party/PHPExcel.php"; 
require_once APPPATH."third_party/PHPExcel/IOFactory.php"; 
class Excel extends PHPExcel { 
   public function __construct() { 
      parent::__construct(); 
   } 
   public function export($fields = array(), $results = array(), $filename = ''){
      $objPHPExcel = new PHPExcel();
      $objPHPExcel->getProperties()->setTitle("export")->setDescription("none");
      $objPHPExcel->setActiveSheetIndex(0);
      // Field names in the first row
      //$fields = $query->list_fields();
      $col = 0;
      foreach ($fields as $field)
      {
          $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, 1, $field);
          $col++;
      }
      // Fetching the table data
      $row = 2;
      foreach($results as $data)
      {
          $col = 0;
          foreach ($fields as $key => $field)
          {
            if($data[$key]){
               $value = $data[$key];
            }else{
               $value = '';
            }
              $objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow($col, $row, $value);
              $col++;
          }
          $row++;
      }
      $objPHPExcel->setActiveSheetIndex(0);
       $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
       if(empty($filename))
         $filename= 'products-list-'.time().'.xls';
       else
         $filename .= '.xls';
       header('Content-Type: application/vnd.ms-excel');
       header('Content-Disposition: attachment;filename="'.$filename.'"'); 
       header('Cache-Control: max-age=0');
       $objWriter->save('php://output');
   }
    public function readSms($file){
        $return = array();
        $inputFileType = PHPExcel_IOFactory::identify($file);
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objPHPExcel = $objReader->load($file);
        $sheet = $objPHPExcel->getSheet(0); 
        $highestRow = $sheet->getHighestRow(); 
        $highestColumn = $sheet->getHighestColumn();
        //  Loop through each row of the worksheet in turn
        for ($row = 1; $row <= $highestRow; $row++){
            $cell = $sheet->getCellByColumnAndRow(0, $row);
            $val = $cell->getValue();
            if(is_phone_number($val))
              $return[] = str_replace(' ', '', $val);
            //  Read a row of data into an array
            // $return[] = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row,
            //                                 NULL,
            //                                 TRUE,
            //                                 FALSE);
            //  Insert row data array into your database of choice here
        }
        return $return;
    }
   public function read($file){
      $return = array();
      $html = '';
      $objPHPExcel = PHPExcel_IOFactory::load($file);
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
         $worksheetTitle     = $worksheet->getTitle();
         $highestRow         = $worksheet->getHighestRow(); // e.g. 10

         $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
         $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
         $nrColumns = ord($highestColumn) - 64;

         //echo '<pre>$worksheetTitle = ';print_r($worksheetTitle);echo '</pre>';
         //echo '<pre>$highestRow = ';print_r($highestRow);echo '</pre>';
         //echo '<pre>$highestColumn = ';print_r($highestColumn);echo '</pre>';
         //echo '<pre>$highestColumnIndex = ';print_r($highestColumnIndex);echo '</pre>';
         //echo '<pre>$nrColumns = ';print_r($nrColumns);echo '</pre>';
         // $html .= "<br>The worksheet ".$worksheetTitle." has ";
         // $html .= $nrColumns . ' columns (A-' . $highestColumnIndex . ') ';
         // $html .= ' and ' . $highestRow . ' row.';
         // $html .= '<br>Data: <table border="1"><tr>';
         // //$row = 2 Bỏ giá trị header
         // for ($row = 2; $row <= $highestRow; ++ $row) {
         //    $html .= '<tr>';
         //    // for ($col = 0; $col < $highestColumnIndex; ++ $col) {
         //       $col =  1;
         //       $cell = $worksheet->getCellByColumnAndRow($col, $row);
         //       echo "<pre>"; print_r($cell);echo "</pre>"; exit;
         //       $val = $cell->getValue();
         //       $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
         //       $html .= '<td>' . $val . '</td>';
         //    // }
         //    $html .= '</tr>';
         // }
         // $html .= '</table>';
         // 

         for ($row = 2; $row <= $highestRow; ++ $row) {
            $first_cell = $worksheet->getCellByColumnAndRow(2, $row);
            $user_code = $first_cell->getValue();
            if(!empty($user_code)){
               for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                  $cell = $worksheet->getCellByColumnAndRow($col, $row);
                  $val = $cell->getValue();
                  $return[$user_code][$col] = $val;
               }
            }  
         }
      }
      return $return;
   }

   public function read_recall($file){
      $return = array();
      $html = '';
      $objPHPExcel = PHPExcel_IOFactory::load($file);
      foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
         $worksheetTitle     = $worksheet->getTitle();
         $highestRow         = $worksheet->getHighestRow(); // e.g. 10

         $highestColumn      = $worksheet->getHighestColumn(); // e.g 'F'
         $highestColumnIndex = PHPExcel_Cell::columnIndexFromString($highestColumn);
         $nrColumns = ord($highestColumn) - 64;

         //echo '<pre>$worksheetTitle = ';print_r($worksheetTitle);echo '</pre>';
         //echo '<pre>$highestRow = ';print_r($highestRow);echo '</pre>';
         //echo '<pre>$highestColumn = ';print_r($highestColumn);echo '</pre>';
         //echo '<pre>$highestColumnIndex = ';print_r($highestColumnIndex);echo '</pre>';
         //echo '<pre>$nrColumns = ';print_r($nrColumns);echo '</pre>';
         // $html .= "<br>The worksheet ".$worksheetTitle." has ";
         // $html .= $nrColumns . ' columns (A-' . $highestColumnIndex . ') ';
         // $html .= ' and ' . $highestRow . ' row.';
         // $html .= '<br>Data: <table border="1"><tr>';
         // //$row = 2 Bỏ giá trị header
         // for ($row = 2; $row <= $highestRow; ++ $row) {
         //    $html .= '<tr>';
         //    // for ($col = 0; $col < $highestColumnIndex; ++ $col) {
         //       $col =  1;
         //       $cell = $worksheet->getCellByColumnAndRow($col, $row);
         //       echo "<pre>"; print_r($cell);echo "</pre>"; exit;
         //       $val = $cell->getValue();
         //       $dataType = PHPExcel_Cell_DataType::dataTypeForValue($val);
         //       $html .= '<td>' . $val . '</td>';
         //    // }
         //    $html .= '</tr>';
         // }
         // $html .= '</table>';
         // 
         $cellcheck = $worksheet->getCellByColumnAndRow(0, 1);
         if( 'Time' != $cellcheck->getValue()) return null;
         for ($row = 2; $row <= $highestRow; ++ $row) {
            //$first_cell = $worksheet->getCellByColumnAndRow(1, $row);
            $user_code = $row-2; //$first_cell->getValue();
            if(!empty($user_code)){
               for ($col = 0; $col < $highestColumnIndex; ++ $col) {
                  $cell = $worksheet->getCellByColumnAndRow($col, $row);
                  $val = $cell->getValue();
                  $return[$user_code][$col] = $val;
               }
            }  
         }
      }
      return $return;
   }
}
