<?php
$ds          = DIRECTORY_SEPARATOR; 
$storeFolder = 'test';  
//$sha256      = 'null' ;
if (!empty($_FILES)) {
 
    //$tempFile = $_FILES['file']['tmp_name'];         
    $tempFile = $_FILES['file']['tmp_name'];         
    $sha256 = hash_file("sha256", $tempFile);
    
    $obj['name']   = $_FILES['file']['name'];
    $obj['size']   = $_FILES['file']['size'];
    $obj['sha256'] = $sha256;
    
    $result[] = $obj;
    
 //echo $tempFile;
 
 //   $targetPath = dirname( __FILE__ ) . $ds. $storeFolder . $ds; 
 //echo $targetPath;
 //   $targetFile =  $targetPath. $_FILES['file']['name']; 
 //   move_uploaded_file($tempFile,$targetFile);
  //  $sha256 = hash_file("sha256", $targetFile);
 
} else {                                                           
//    $result  = array();
// 
//    $files = scandir($storeFolder);                 //1
//    //print_r($files);
//    if ( false!==$files ) {
//        foreach ( $files as $file ) {
//            if ( '.'!=$file && '..'!=$file) {       //2
//                $obj['name'] = $file;
//                $obj['size'] = filesize($storeFolder.$ds.$file);
//                $result[] = $obj;
//            }
//        }
//    }
//    2778e8d41bbc2982ff0853d39f5d7b8e137454e756ada3abd61a1427094b6c39
//    b45011d5c671adee9cc0ce586c85e266bca2d7877e24c88004c2736758c6e3b4 
    //C:\xampp\tmp\php286.tmp"b45011d5c671adee9cc0ce586c85e266bca2d7877e24c88004c2736758c6e3b4"
    //C:\xampp\tmp\php981C.tmp"b45011d5c671adee9cc0ce586c85e266bca2d7877e24c88004c2736758c6e3b4"
     

}
//$result = ;

    header('Content-type: text/json');              //3
    header('Content-type: application/json');
    echo json_encode($result);