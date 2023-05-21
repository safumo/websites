export {verify}

function verify(){
    $.ajax({
        url:"verify.php",
        type:"get",
        async:false,
        success:(res)=>{
            if(res == "404"){
                alert('请先登录后使用！');
                window.location='login.html';
            }
        }
    });
}