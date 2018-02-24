<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

include '../PHPExcel/IOFactory.php';
include '../../include/key';
$conn = new mysqli($conn_host, $conn_user, $conn_pass, $conn_database);
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$ds          = DIRECTORY_SEPARATOR; 
$storeFolder = 'test';  
 
//print_r($_FILES);

if (!empty($_FILES)) {
    $tempFile = $_FILES['file']['tmp_name'];         
    $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds; 
    $targetFile =  $targetPath. $_FILES['file']['name']; 
  
    move_uploaded_file($tempFile,$targetFile);
    
    $objPHPExcel = PHPExcel_IOFactory::load($targetFile);
    $sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);
    
    $n = 0;
    $r = 0;
    $rows = array();

    foreach ($sheetData As $Key => $Row)
    {
       $r++; 
       $cellval = $objPHPExcel->getActiveSheet()->getCell('B1')->getValue();
       
       $GiornataXLS = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(0, $r)->getValue());
       $Giornata = date('d-m-Y', PHPExcel_Shared_Date::ExcelToPHP($GiornataXLS)); 
       $startXLS = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(1, $r)->getValue());
       $start = gmdate('d-m-Y H:i:s', PHPExcel_Shared_Date::ExcelToPHP($startXLS)); 
       $stopXLS = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(2, $r)->getValue());
       $stop = gmdate('d-m-Y H:i:s', PHPExcel_Shared_Date::ExcelToPHP($stopXLS)); 
       $title = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(3, $r)->getValue());
       $text = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(4, $r)->getValue());
       $tons = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(5, $r)->getValue());
       $mam  = trim($objPHPExcel->getActiveSheet()->getCellByColumnAndRow(6, $r)->getValue());
       
       if ($title=='0'){
           $title='FERMATA';
           $text= '';
       }
       
       $qry_INS  = "INSERT INTO sts_budget_day (DATA, START, END, TITLE, TEXT, TON, mam) values ("
                 . " STR_TO_DATE('$Giornata', '%d-%m-%Y'), "
                 . " STR_TO_DATE('$start', '%d-%m-%Y %H:%i:%s'), "
                 . " STR_TO_DATE('$stop', '%d-%m-%Y %H:%i:%s'), "
                 . " '$title', '$text', $tons, $mam)" ;
       $duplicate = " ON DUPLICATE KEY ";
       $qry_UPD  = " UPDATE DATA = STR_TO_DATE('$Giornata', '%d-%m-%Y'),"
               .   " TITLE='$title',TEXT='$text',TON=$tons,mam=$mam" ;
       
        $sql = $qry_INS.$duplicate.$qry_UPD ;
        if (mysqli_query($conn, $sql)) {
           // echo "New record created successfully";
        } else {
            $errore .= "Error: " . $sql . "<br>" . mysqli_error($conn);
        }
       
       echo '{"error":"'.$errore.'"},';

    } 
    
} else { 
    //se vuoto fa questo
    $result  = array(); 
    $files = scandir($storeFolder);                 //1
    if ( false!==$files ) {
        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {       //2
                $obj['name'] = $file;
                $obj['size'] = filesize($storeFolder.$ds.$file);
                $result[] = $obj;
            }
        }
    }
    header('Content-type: text/json');              //3
    header('Content-type: application/json');

}