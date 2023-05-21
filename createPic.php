<?php 
    include "config.php";
    // if (!isset($_SESSION["pass"])){
    //     echo "<script>alert('请先登录后使用！');window.location='login.php';</script>";
    //  }    
    if(1 ||isset($_POST["id"])){
        $id = $_POST["id"];
        $image=$_POST["picData"];   
        // $id = "1";
        // $image="";
        $path = "./picture/{$id}.jpg";
        if (strstr($image,",")){
            $image = explode(',',$image);
            $image = $image[1];
        }
        $r = file_put_contents($path, base64_decode($image));//返回的是字节数
        if (!$r) {
            echo "error";
        }else{
            echo "ok";
        }
    }
    else{
        echo "<script>window.location='./list.html';</script>";
    }
?>