<?php 
    include "config.php";
    // if (!isset($_SESSION["pass"])){
    //     echo "<script>alert('请先登录后使用！');window.location='login.php';</script>";
    //  }    
    if(isset($_POST["add"])){
        if($_POST["add"]){
            $category_id = $_POST["category_id"];
            $title = $_POST["title"];
            $text = $_POST["text"];
            $author = $_POST["author"];
            $time = $_POST["time"];
            // $category_id = "1001";
            // $title = "我是三月七的狗";
            // $text = "我是三月七的狗我是三月七的狗我是三月七的狗我是三月七的狗我是三月七的狗我是三月七的狗
            // 我是三月七的狗我是三月七的狗我是三月七的狗";
            // $author = "我是三月七的狗";
            // $time = "2023-4-5 20:59:16";
            $sql = "INSERT INTO news (category_id,title,content,author,createtime) VALUES 
            ('{$category_id}', '{$title}','{$text}','{$author}','{$time}')";
            if (mysqli_query($conn,$sql)){
                $sql2 = "SELECT id FROM news ORDER BY id DESC LIMIT 1";
                $res2 = mysqli_query($conn,$sql2);
                $r = mysqli_fetch_assoc($res2);
                echo "{$r["id"]}";
            }else{
                echo "";
            }
        }
        else{
            $sql = "select * from category";
            $res = mysqli_query($conn,$sql);
            $arr = array();
            while($r = mysqli_fetch_assoc($res)){
                $new = array();
                $new["name"] = $r["name"];
                $new["id"] = $r["id"];
                $arr[] = $new;
            };
            echo json_encode($arr);
        }
        mysqli_close($conn);
    }
    else{
        echo "<script>window.location='./add.html';</script>";
    }

?>