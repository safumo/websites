<?php
    header("Content-Type:text/html;charset=utf-8");
    $servername="127.0.0.1";
    $port="3306";
    $username="root";
    $password="";
    $dbname="newsdb";
    $conn = mysqli_connect($servername.":$port", $username, $password, $dbname);
    mysqli_set_charset($conn,'utf8');      
?>