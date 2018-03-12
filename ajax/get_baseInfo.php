<?php

$verifiche = filter_input(INPUT_POST, 'verifiche');
$found     = filter_input(INPUT_POST, 'found'); 
$nonce     = filter_input(INPUT_POST, 'nonce');
$id        = filter_input(INPUT_POST, 'id');
$hash      = filter_input(INPUT_POST, 'hash');

include '../include/key.php';

    $conn = mysqli_connect($conn_host, $conn_user, $conn_pass, $conn_database)
            or die("Connessione non riuscita MySQL DB: " . mysql_error());
    mysqli_select_db($conn, $conn_database);
    
//aggiornare il numero di attemps fatto 
    if ($verifiche > 0){
        
        $sel_att = "select attemps from sha_main_block where id = ".$id;
        $esegui_s = mysqli_query($conn, $sel_att)
        or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $sel_att);  
        
        $row = mysqli_fetch_array($esegui_s, MYSQLI_NUM);
        $att = $row[0] + $verifiche ;
        
        $upd_qry = "update sha_main_block set attemps = $att where id = $id ";
        $esegui = mysqli_query($conn, $upd_qry)
        or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $upd_qry);      
    }   
    
    //leggere il totale degli attemps eseguiti e passarlo in JSON su una variabile.
    
    $qry_found = "update sha_main_block set hash_blocco = '".$hash."', nonce='".$nonce."', data_blocco = SYSDATE() where id = $id";    
    if ($found==1){
       //blocco trovato
      //  $qry_found = "update sha_main_block set hash_blocco = '".$hash."', data_blocco = SYSDATE() where id = $id";    
        //echo $qry_found;
        $esegui = mysqli_query($conn, $qry_found)
        or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $qry_found); 
        
    }    
        $query="select sha.id, "
                . "sha.data_genesi, "                                                            
                . "sha.file, "
                . "sha.size, "
                . "sha.name, "
                . "sha.note, "
                . "sha.hash_file, "
                . "sha.hash_blocco, "
                . "(select IFNULL(hash_blocco, 0) from sha_main_block where id = sha.id -1) "
                . "from sha_main_block sha "
                . "where sha.hash_blocco is null "
                . "order by sha.id asc limit 1";
        $esegui = mysqli_query($conn, $query)
        or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $query);     
        
//$result = mysqli_query($conn, $query);
$rows = array();
    while ($row = mysqli_fetch_array($esegui, MYSQLI_NUM)){
       $rows['id'] = $row[0];
       // 0  |      1      |   4  |   5  |    6      |        8
       // ID | data_genesi | name | note | hash_file | hash_blocco_pre
       $txt =  $row[0].$row[1].$row[4].$row[5].$row[6].$row[8];
       $rows['shaX'] = hash('sha256', $txt);
    }
    //echo $txt;

echo '{ "data": ';
print(json_encode($rows));
echo ', "test": "'.$found.'" '
   . ', "qry": "'.$qry_found.'"  }';