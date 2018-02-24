<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$size    =  filter_input(INPUT_POST, 'size');
$sha256  =  filter_input(INPUT_POST, 'sha256');

$file    =  filter_input(INPUT_POST, 'file');
$titolo  =  filter_input(INPUT_POST, 'titolo');
$note    =  filter_input(INPUT_POST, 'note');
    
   include '../include/key.php';         
   
            $conn = mysqli_connect($conn_host, $conn_user, $conn_pass, $conn_database)
            or die("Connessione non riuscita MySQL DB: " . mysql_error());
//            mysqli_select_db($conn, $conn_database);
            

$qry_test_clone = "select * from sha_main_block where hash_file = '".$sha256."'";
$esegui_test = mysqli_query($conn, $qry_test_clone)
    or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $qry_test_clone);     

if(mysqli_num_rows($esegui_test)===0){
    $query = "insert into sha_main_block (file, size, name, note, hash_file) values ('$file', '$size', '$titolo', '$note', '$sha256' )";   
    $esegui = mysqli_query($conn, $query)
        or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $query);     
    echo '{ "Res": "';
    print($sha256);
    echo '", "NewBlock": 1 ';
    echo '}';
}else{
    echo '{ "Res": "';
    print($sha256);
    echo '", "NewBlock": -1 ';
    echo '}';
}


