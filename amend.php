<?php 
    include "config.php";
    if (!session_id()) session_start();
    if (!isset($_SESSION["pass"])){
        echo "<script>alert('请先登录后使用！');window.location='login.php';</script>";
    }
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Document</title>
        <link rel="stylesheet" href="amend.css">
    </head>
    <?php
        if(isset($_POST["cancel"])){
            echo "<script>location.href = './list.html';</script>";
        }
        if(isset($_POST["delete"])){
            $id = $_GET["id"];
            $sql = "DELETE FROM news WHERE id={$id}";
            if(mysqli_query($conn,$sql)){
                unlink("./picture/{$id}.jpg");    
                echo "<script>alert('删除成功！');location.href = './list.html';</script>";
            }else{
                echo "<script>alert('删除失败！');</script>";
            }
        }
        if(isset($_POST["save"])){
            $id = $_GET["id"];
            $category_id = $_POST["category_id"];
            $title = $_POST["title"];
            $content = $_POST["content"];
            // echo $text;
            move_uploaded_file($_FILES["file"]["tmp_name"], "picture/{$id}.jpg");
            $author = $_POST["author"];
            $time = $_POST["time"];
            $sql = "UPDATE news SET category_id='{$category_id}',title='{$title}',
            content='{$content}',author='{$author}',createtime='{$time}' WHERE id={$id}";
            // echo $sql;
            if(mysqli_query($conn,$sql)){
                echo "<script>alert('修改成功！');</script>";
            }else{
                echo "<script>alert('修改失败！');</script>";
            }
        }
    ?>
    <body>
        <div class="box" id="box">
            <header class="header">
                <div class="header-title">
                    <img src="./material/news.png" alt="error">
                    <p>新闻网站</p>
                </div>
                <div class="list-option">
                    <div class="search">
                        <select name="search-option" id="searchOpt" class="search-option" disabled>
                            <option value="title">标题</option>
                            <option value="author">作者</option>
                            <option value="id">编号</option>
                            <option value="category_name">类别</option>
                        </select>
                        <input type="text" class="search-input" id="searchInput" disabled>
                        <button class="search-button" disabled></button>
                    </div>
                    <div class="user">
                        <button class="user-info"></button>
                    </div>
                </div>
            </header>
            <form action="" method="post" class="content" onsubmit="return check(this)" enctype="multipart/form-data">
                <?php
                    $id = $_GET["id"];
                    $sql = "select * from news where id={$id}";
                    $res = mysqli_query($conn, $sql);
                    $news_sel = mysqli_fetch_array($res);
                ?>
                <div><span>编号</span><input type="text" name="id" value="<?php echo $news_sel["id"]; ?>" disabled></div>
                <div>
                    <span>类别</span>
                    <select name="category_id">
                        <?php 
                        $sql2 = "select * from category";
                        $res = mysqli_query($conn, $sql2);
                        while($r=mysqli_fetch_array($res)){
                            if($r["id"]==$news_sel["category_id"]){
                                echo "<option value='{$r["id"]}' selected>{$r["name"]}</option>";
                            }
                            else{
                                echo "<option value='{$r["id"]}'>{$r["name"]}</option>";
                            }
                        }
                    ?>
                    </select>
                </div>
                <div><span>标题</span><input type="text" name="title" value="<?php echo $news_sel["title"]; ?>"></div>
                <div class="content-text">
                    <textarea name="content" cols="30" rows="10" placeholder="正文由此处输入..."><?php echo $news_sel["content"]; ?></textarea>
                </div>
                <div><span>作者</span><input type="text" name="author" value="<?php echo $news_sel["author"]; ?>"></div>
                <div class="current-time"><span>时间</span><input type="text" name="time" value="<?php echo $news_sel["createtime"]; ?>"></div>
                <div class="file">
                    <div class="warp">
                        <div class="warp-content"></div>
                        <input type="file" id="file" name="file"/>
                    </div>
                    <div class="pic-box">
                        <img id="preview" src="<?php
                            if(file_exists("./picture/{$news_sel["id"]}.jpg")){
                                $img = "./picture/{$news_sel["id"]}.jpg";
                            }
                            else{
                                $img = "./picture/test.png";
                            }
                            $base64_img = base64EncodeImage($img);
                            echo $base64_img;
                            function base64EncodeImage ($image_file) {
                                $base64_image = '';
                                $image_info = getimagesize($image_file);
                                $image_data = fread(fopen($image_file, 'r'), filesize($image_file));
                                $base64_image = 'data:' . $image_info['mime'] . ';base64,' . chunk_split(base64_encode($image_data));
                                return $base64_image;
                            }
                        ?>"/>
                    </div>
                </div>
                <nav class="manage-box">
                    <input type="submit" name="save" id="save" value="修改">
                    <button id="delete" name="delete">删除</button>
                    <button id="cancel" name="cancel">取消</button>
                </nav>
            </form>
            <footer class="footer">
                <div class="footer-title">Welcome To This News Website</div>
                <div class="footer-introduce">It is made by:</div>
                <div class="iconBox">
                    <img src="./material/html5.png" alt="html5">
                    <img src="./material/css3.png" alt="css3">
                    <img src="./material/javascript.png" alt="javascript">
                    <img src="./material/jquery.png" alt="jquery">
                    <img src="./material/php.png" alt="php">
                    <img src="./material/mysql.png" alt="mysql">
                </div>
            </footer>
        </div>
        <script src="https://code.jquery.com/jquery-3.1.1.min.js"></script>
        <script>
                var file = document.querySelector("#file");
                var image = document.querySelector("#preview");
                file.onchange = function() {
                    var fileData = this.files[0];
                    var pettern = /^image/;
                
                    if (!pettern.test(fileData.type)) {
                        alert("图片格式不正确");
                        return;
                    }
                    var reader = new FileReader();
                    reader.readAsDataURL(fileData);
                    reader.onload = function(e) {
                        // console.log(this.result);
                        picData = this.result;
                        image.setAttribute("src", this.result)
                    }
                }
                function check(obj){
                        var temp = confirm('确认进行该操作？');
                        return temp;
                    }
        </script>
    </body>
</html>