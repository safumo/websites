<?php include "config.php" ?>
<?php
    if (!session_id()) session_start();
    if(isset($_SESSION['views'])){
        $_SESSION['views']=$_SESSION['views']+1;
    }
    else{
        $_SESSION['views']=1;
    }
    if(isset($_POST["restype"])){
        $username = $_POST["username"];
        $passwd = md5($_POST["password"]);
        $t = $_POST["restype"];
        // $username = "aa";
        // $passwd = md5("aa");
        // $t = 0;
        if($t){
            $type = "admin";
        }
        else{
            $type = "tourist";
        }
        $sql = "SELECT * FROM {$type} WHERE username='{$username}'";
        $rs = mysqli_query($conn,$sql);
        if (mysqli_num_rows($rs)==0){
            echo "alert('用户名不存在！')";
        }else{
            $row = mysqli_fetch_array($rs);
            if($row["passwd"]==$passwd){
                $_SESSION["user"] = $username;
                $_SESSION["pass"] = "ok";
                if($type=="admin"){
                    $_SESSION["type"] = "admin";
                    echo "alert('管理员 {$_SESSION["user"]} 欢迎登录!');window.location='list.html'";
                }
                else{
                    $_SESSION["type"] = "tourist";
                    echo "alert('游客 {$_SESSION["user"]} 欢迎登录!');window.location='list.html'";
                }
            }else{
                echo "alert('密码错误！')";
            }
            
        }
    }
    else{
        echo "<script>window.location='./login.html';</script>";
    }
?>
 <?php
    mysqli_close($conn);
 ?>   