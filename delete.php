<?php
    include "config.php";
    if(isset($_DET["id"])){
        $id = $_GET["id"];
        $sql = "DELETE FROM news WHERE id={$id}"; 
        if (mysqli_query($conn,$sql)){
            unlink("./picture/{$id}.jpg");  
            echo "ok";
        }else{
            echo "error";
        }
    }
    else{
        echo "<script>window.location='./list.html';</script>";
    }
?>