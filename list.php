<?php 
    include "config.php";
    // if (!isset($_SESSION["pass"])){
    //     echo "<script>alert('请先登录后使用！');window.location='login.php';</script>";
    //  }    
    if(isset($_POST["option"])){
        function getArray($res){
            $arr = array();
            while($r = mysqli_fetch_assoc($res)){
                $new = array();
                $new["id"] = $r["id"];
                $new["name"] = $r["name"];
                $new["title"] = $r["title"];
                $new["content"] = $r["content"];
                $new["author"] = $r["author"];
                $new["time"] = $r["createtime"];
                $arr[] = $new;
            };
            return json_encode($arr);
        };
        $index = $_POST["index"];
        if($index != "-1"){
            $int1 = (int)$index*5;
            $limit = "LIMIT {$int1},5";
        }
        else{
            echo $_POST["curIndex"];
            $limit = "";
        }
        if(!!$_POST["keyWord"]){
            $option = $_POST["option"];
            $key = $_POST["keyWord"];
            // $option = "category_name";
            // $key = "新闻";
            // $index = 1;
            if($option == "title" || $option == "author"){
                $sql = "SELECT news.id,news.title,news.content,news.author,news.createtime,category.name 
                FROM news JOIN category ON category.id=news.category_id where {$option} like '%{$key}%'
                ORDER BY news.id ASC ".$limit;
            }
            elseif($option == "id"){
                $sql = "SELECT news.id,news.title,news.content,news.author,news.createtime,category.name 
                FROM news JOIN category ON category.id=news.category_id where news.id={$key} 
                ORDER BY news.id ASC ".$limit;
            }
            elseif($option == "category_name"){
                $sql = "SELECT news.id,news.title,news.content,news.author,news.createtime,category.name 
                FROM news JOIN category ON category.id=news.category_id WHERE category.name LIKE '%{$key}%'
                ORDER BY news.id ASC ".$limit;
            };
            $res = mysqli_query($conn,$sql);
            echo getArray($res);
        }
        else{
            // $index = 1;
            $sql = "SELECT news.id,news.title,news.content,news.author,news.createtime,category.name 
            FROM news JOIN category ON category.id=news.category_id ORDER BY news.id ASC ".$limit;
            $res = mysqli_query($conn,$sql);
            echo getArray($res);
        }  
    }
    else{
        echo "<script>window.location='./list.html';</script>";
    }
    mysqli_close($conn);
?>