<?php
    include "config.php";
    if(isset($_GET["id"])){
        $id = $_GET["id"];
        $sql = "DELETE FROM news WHERE id={$id}"; 
        if (mysqli_query($conn,$sql)){
            if(file_exists("./picture/{$id}.jpg")){
                unlink("./picture/{$id}.jpg");  
            }
            echo "ok";
        }else{
            echo "error";
        }
    }
    else{
        echo "<script>window.location='./list.html';</script>";
    }
?>