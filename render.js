export {Render, Render_index}

function Render(quest={}){
    let defaultQuest = {
        option:"",
        keyWord:"",
        index:"0"
    };
    $.ajax({
        url: `./list.php`,
        type: 'post',
        data:{
            ...defaultQuest,
            ...quest
        },
        success: function (res) {
            var news = document.querySelector(".news");
            news.innerHTML = ""
            var data = JSON.parse(res);
            console.log(data);
            for(var n=0;n<data.length;n++){
                var new_data = data[n];
                news.innerHTML += `
                <div class="news-box">
                    <div class="pic-box">
                        <img src="./picture/${new_data["id"]}.jpg" onerror="javascript:this.src='./picture/error.png';this.οnerrοr=null;">
                    </div>
                    <div class="text-box">
                        <div>
                            <h1 class="news-title">${new_data["title"]}</h1>
                            <p class="news-abstract">${new_data["content"].slice(0,40)}...</p>
                            <p class="text-target">${new_data["name"]}&nbsp&nbsp&nbsp&nbsp${new_data["author"]}&nbsp&nbsp&nbsp&nbsp${new_data["time"]}</p>
                        </div>
                        <div class="manage-box">
                            <button id="inf${new_data["id"]}">详细信息</button>
                            <button id="del${new_data["id"]}">删除</button>
                        </div>
                    </div>
                </div>
                `
            };
        }
    });
}
function Render_index(quest={}){
    let defaultQuest = {
        option:"",
        keyWord:"",
        index:"0"
    };
    let currentQuest = {
        ...defaultQuest,
        ...quest
    }
    $.ajax({
        url:"./list.php",
        type:"post",
        data:{
            ...currentQuest,
            index:"-1",
            curIndex:currentQuest["index"]
        },
        success: function(res){
            var curIndex = parseInt(res.slice(0,res.indexOf("[")));
            var len = Object.keys(JSON.parse(res.slice(res.indexOf("[")))).length;
            var num = Math.ceil(len/5);
            var index1 = document.querySelector(".index");
            index1.innerHTML = ""
            index1.innerHTML += `<button class="index-change" id="before1">上一页</button>
            <button class="index-num" id="start1">1</button><span>...</span>`;
            if(num<5){
                for(let i=1;i<num+1;i++){
                    index1.innerHTML += `<button class="index-num" id="ind${i}">${i}</button>`;
                }
            }
            else{
                if(num-curIndex>5){
                    for(let i=curIndex+1;i<curIndex+6;i++){
                        index1.innerHTML += `<button class="index-num" id="ind${i}">${i}</button>`;
                    }
                }
                else{
                    if(curIndex>num-5){
                        for(let i=num-4;i<num+1;i++){
                            index1.innerHTML += `<button class="index-num" id="ind${i}">${i}</button>`;
                        }
                    }
                    else{
                        for(let i=curIndex+1;i<num+1;i++){
                            index1.innerHTML += `<button class="index-num" id="ind${i}">${i}</button>`;
                        }
                    }
                }
            }
            index1.innerHTML += `<span>...</span>
            <button class="index-num" id="end1">${num}</button>
            <button class="index-change" id="next1">下一页</button>`;
            console.log(document.querySelector(`#ind${curIndex+1}`));
            $(`#ind${curIndex+1}`).css("background-color", "#40C5F1");
            $(`#ind${curIndex+1}`).css("color", "white");
        }
    });
}