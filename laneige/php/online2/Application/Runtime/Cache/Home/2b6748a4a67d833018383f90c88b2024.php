<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="/Public/home/css/main.css?a=<?php echo time(); ?>">
    <title>“爱与玛丽珍，缺一不可”</title>
    <script type="text/javascript">
        var path ="/Public//home/img";

    </script>
    <script src="/Public/home/js/jquery-3.2.1.min.js"></script>
    <script type="text/javascript" src="/Public/home/js/createjs.min.js"></script>
    <script src="/Public/home/js/init.js"></script>

</head>
<body>
    <div id="index-wrap">
        <audio src="/Public/home/css/music.mp3" id = "music" style = "opacity: 0;" loop> 您的浏览器不支持 audio 标签。 </audio>
        
        <div id = "box-8">
            <div class="index">
                <p>门店查询<br><span id = "info-area">苏州</span></p>
                <ul id = "info-list">
                </ul>
            </div>
            <img src="/Public/home/img/box3-return.png" alt="" onclick="returnBox('box-10','box-8')" class="return">
        </div>
        <div id = "box-10" class="boxShow">
            <div class="id">ID:1712112017083EDEN</div>
            <div class="button">
                <a href="http://www.stellafashion.com/"> <img src="/Public/home/img/box10-button.png" alt="" class="jrgw"></a>
                <div class="mdlist">
                    <img src="/Public/home/img/box7-button2.png" alt="" class="cx">
                    <select id= "select">
                        <?php if(is_array($List)): foreach($List as $key=>$vo): ?><option value="<?php echo ($vo["city"]); ?>"><?php echo ($vo["city"]); ?></option><?php endforeach; endif; ?>
                    </select>
                </div>
            </div>
        </div>
        <!-- <img src="img/music.png" alt="" class="music xuanzhuan"> -->
    </div>
    <!-- <script src="js/main.js"></script> -->
    <!-- <script src="js/loding.js"></script> -->
    <script>
        //门店选择
        $("#select").change(function(){
            var url ="<?php echo U('Index/storelist');?>";
            $.post(url,{area:$('#select').val()},function(result){
                if(result){
                    $("#info-area").html($('#select').val())
                    $("#info-list").html("");
                    for(var i = 0; i < result.list.length;i++){

                        $("#info-list").append(
                            "<li><p><span></span>"+result.list[i].store+"</p><p><span></span>"+result.list[i].phone+"</p><p><span></span>"+result.list[i].address+"</p></li>"
                        );
                    }
                    returnBox("box-8","box-10");
                }else{
                    alert("网络繁忙")
                }

            },"json");

        });


        //返回
        function returnBox(box,box2){
            $('#'+box).addClass("boxShow")
            $('#'+box2).removeAttr("class");
            if(box == 'box-2' || box == 'box-3'){
                $("body").addClass("scrollable");
            }else{
                $("body").removeClass("scrollable");
            }
        }
    </script>
</body>
</html>