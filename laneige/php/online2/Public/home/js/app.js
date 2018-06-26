//定制我的唇膏
$("#s1 .next_btn").click(function(event) {
	TweenMax.to("#s1",0.8,{autoAlpha:0});
	TweenMax.to("#s2",0.8,{autoAlpha:1});
	_smq.push(['custom','act','01_customize']);
});

/************
	s2 选择部分
***********/
$("#s2 ul li").click(function(event) {
	$(this).addClass('active').siblings('li').removeClass('active');
});
//下一步
var canUpImg = true;
$("#s2 .affirm_btn").click(function(event) {
	var val = $('#write').val();
	var checkednum = $("#s2 ul .active").size();
	var index = $("#s2 ul .active").index();
	if(val == ""){
		alert("请输入您的大名");
		return false;
	}
	if(checkednum == 0){
		alert('请选择您心仪的图案');
		return false;
	}
	if(canUpImg){
		canUpImg = false;
		drawImg(index,val+"的专属唇膏");
	}
});
//绘制图片
function drawImg(num,text){
	var c=document.getElementById("drawimg");
	var ctx=c.getContext("2d");
	ctx.drawImage(queue.getResult("frame_"+(num+1)),0,0);
	//设置字体样式
    ctx.font = "30px SimSun,Helvetica Neue, Helvetica, STHeiTi";
    //设置字体填充颜色
    ctx.fillStyle = "#fff";
    ctx.textAlign="center";
    ctx.fillText(text, 271, 85);
	var imgobj = c.toDataURL("image/jpeg");
    $.ajax({
        url: "http://api.max-digital.cn/Api/oss/baseUpload",
        type:'post',
        dataType:'json',
        data:{
        	imgdata : imgobj,
        	type : "jpeg",
        	filepath :"H5/laneige/baseUpload",
        },            
        success:function(data){
        	if(data.code == "OK"){
        		$("#newsrc").attr("src",data.oss_file_url);
			    TweenMax.to("#s2",0.8,{autoAlpha:0});
				TweenMax.to("#s3",0.8,{autoAlpha:1});
				_smq.push(['custom','act','03_complete']);
        	}
        	else{
        		alert(data.code)
        	}
			canUpImg = true;
        },
        error:function(){
            alert("网络繁忙");
            canUpImg = true;                    
        }
    })
}

/************
	s3 选择部分
***********/
//前往专柜预约
$('#s3 .next_btn').click(function(event) {
	TweenMax.to("#s3",0.8,{autoAlpha:0});
	TweenMax.to("#s4",0.8,{autoAlpha:1});
	_smq.push(['custom','act','04_appoint']);
});





/************
	s4表单
***********/
//改变select值
$("select").change(function(event) {
	var newval = $(this).find('option:selected').val();
	$(this).siblings('span').html(newval);
});


//协议
$("#s4 .read_checkbox").click(function(event) {
	$(this).toggleClass('checked');
});


//表单
var can_submit = true ; 
$("#s4 .submit_btn").click(function(event) {
	var phone = $("#phone").val();
	var province = $("#province").find('option:selected').text();
	var city = $("#city").find('option:selected').text();
	var shop = $("#shop").find('option:selected').text();
	if (phone == "") {
		alert("请填写手机号");
		return false;
	}
	else if(!isMobile(phone)){
		alert("请填写正确的手机号");
		return false;
	}
	if (province =="请选择省份") {
		alert("请选择省份");
		return false;
	}
	if (city =="请选择城市") {
		alert("请选择城市");
		return false;
	}
	if (shop =="请选择您方便前往的专柜") {
		alert("请选择您方便前往的专柜");
		return false;
	}
	if(!$("#s4 .read_checkbox").hasClass('checked')){
		alert("请同意提交个人信息");
		return false;
	}
	var data = {
		"phone" : phone,
		"province" : province,
		"city" : city,
		"shop" : shop
	}
	//提交表单
	if (can_submit) {
		can_submit = false;
		$.ajax({
            url: saveinfo,
            type:'post',
            dataType:'json',
            data:data,            
            success:function(data){
                if(data.status == 1){
                	$("#s4 .success_box").fadeIn();
                	_smq.push(['custom','info','09_submit',phone]);
                }
                else{
                    alert(data.msg);
                }

                can_submit = true;
            },
            error:function(){
                alert("网络繁忙");
                can_submit = true;                    
            }
        })
    }
});

$("#phone").blur(function(event) {
	if($(this).val()>10000000000){
		_smq.push(['custom','info','05_number']);
	}
});
$("#province").change(function(event) {
	_smq.push(['custom','info','06_province']);
});
$("#city").change(function(event) {
	_smq.push(['custom','info','07_city']);
});
$("#shop").change(function(event) {
	_smq.push(['custom','info','08_counter']);
});



//验证手机
function isMobile(mobile){
	var patt =/^1[34578]{1}\d{9}$/;
	var re = new RegExp(patt);  
	if(re.test(mobile)){
		return $.trim(mobile);
	}else{
		return false;
	}
}




/************
	规则
***********/
//显示规则
$(".rule_btn").click(function(event) {
	$(".rule").fadeIn();
});
//关闭规则
$('.rule .close_btn').click(function(event) {
	$(".rule").fadeOut();
});


$("#s1 .rule_btn").click(function(event) {
	_smq.push(['custom','act','02_rule']);
});
$("#s4 .rule_btn").click(function(event) {
	_smq.push(['custom','info','10_rule']);
});














//音乐
/*var music = document.getElementById("audio");
music.volume = 0.5;
$("#music-btn").click(function(event) {
	$(this).toggleClass('off');
	if($(this).hasClass('off')){
		music.pause();
	}else{
		music.play();
	}
});*/



