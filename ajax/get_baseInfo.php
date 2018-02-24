<?php

$verifiche = filter_input(INPUT_POST, 'verifiche');
$found     = filter_input(INPUT_POST, 'found'); 
$nonce     = filter_input(INPUT_POST, 'nonce');
$id        = filter_input(INPUT_POST, 'id');

include '../include/key.php';

    $conn = mysqli_connect($conn_host, $conn_user, $conn_pass, $conn_database)
            or die("Connessione non riuscita MySQL DB: " . mysql_error());
    mysqli_select_db($conn, $conn_database);
    
    if ($found===1){
       //blocco trovato
        
    }
    
    if (isset($id) ){
        $qry1 = 'Select attemps from sha_main_block where id='.$id ;
        $attNum = get_value($conn, $qry1);
        $val = intval($attNum) + intval($verifiche);
        
        $QryupdCoun = 'update sha_main_block set attemps = '.$val.' where id='.$id;
        mysqli_query($conn, $QryupdCoun);  
        //echo $QryupdCoun;
    }
        
        $query="select id, data_genesi, file, size, name, note, hash_file, hash_blocco, hash_blocco_pre from sha_main_block where hash_blocco is null order by id asc limit 1";
        $esegui = mysqli_query($conn, $query)
        or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $query);     

$result = mysqli_query($conn, $query);
$rows = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
       $rows['id'] = $row[0];
       // 0  |      1      |   4  |   5  |    6      |        8
       // ID | data_genesi | name | note | hash_file | hash_blocco_pre
       $txt =  $row[0].$row[1].$row[4].$row[5].$row[6].$row[8];
       $rows['shaX'] = hash('sha256', $txt);
    }
    //echo $txt;

echo '{ "data": ';
print(json_encode($rows));
echo '}';

function get_value($conn, $sql) {
        $result = mysqli_query($conn, $sql)
                or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $sql);    
    
        while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
            $rows[] = $row[0];
        }

    return is_array($rows) ? $rows[0] : "";
}