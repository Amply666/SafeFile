<?php

include '../include/key.php';

    $conn = mysqli_connect($conn_host, $conn_user, $conn_pass, $conn_database)
            or die("Connessione non riuscita MySQL DB: " . mysql_error());
    mysqli_select_db($conn, $conn_database);
        //CONCAT(LEFT(hash_blocco, 10), '...')
        $query="select id, data_genesi, file, size, hash_file, hash_blocco from sha_main_block ";
        $esegui = mysqli_query($conn, $query)
        or die("Queri non valida: " . mysql_error() ."<hr>QUERY:". $query);     

$result = mysqli_query($conn, $query);
$rows = array();
    while ($row = mysqli_fetch_array($result, MYSQLI_NUM)){
       $rows[] = $row;
    }
    

echo '{ "data": ';
print(json_encode($rows));
echo '}';