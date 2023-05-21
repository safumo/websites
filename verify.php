<?php
    if (!session_id()) session_start();
    if (!isset($_SESSION["pass"])){
        echo "404";
    }
    else{
        echo "200";
    }  
?>