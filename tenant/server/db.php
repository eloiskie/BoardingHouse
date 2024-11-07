<?php
    $db_server      ='localhost';
    $db_user        ='root';
    $db_pass        ='';
    $db_name        ='boardinghouse';

    try{
        $conn   =mysqli_connect( $db_server,
                                 $db_user,
                                 $db_pass,
                                 $db_name);
    }
    catch(mysqli_sql_exception){
        echo"Not Connected";
    }
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

?>