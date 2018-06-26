var img = new Image();
img.src = "images/loading.gif";
img.onload = function(){
	$("#loading").html('<img src="'+ img.src +'">');
	setTimeout(function(){
		TweenMax.to("#loading",0.8,{autoAlpha:0});
		TweenMax.to("#s1",0.8,{autoAlpha:1});
		//启动swiper
		var mySwiper = new Swiper('#s1 .myswiper', {
			loop:true,
			autoplay: 2000,//可选选项，自动滑动
		})
	},5000)
}

//定制我的唇膏
$("#s1 .next_btn").click(function(event) {
	TweenMax.to("#s1",0.8,{autoAlpha:0});
	TweenMax.to("#s2",0.8,{autoAlpha:1});
});

/************
	s2 选择部分
***********/
$("#s2 ul li").click(function(event) {
	$(this).addClass('active').siblings('li').removeClass('active');
});

/************
	s3 选择部分
***********/
//前往专柜预约
$('#s3 .next_btn').click(function(event) {
	TweenMax.to("#s3",0.8,{autoAlpha:0});
	TweenMax.to("#s4",0.8,{autoAlpha:1});
});


/************
	s4表单
***********/
//改变select值
$("select").change(function(event) {
	var newval = $(this).find('option:selected').val();
	$(this).siblings('span').html(newval);
});
//下一步
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
	$("#s3 .text").html(val+"的专属唇膏");
	$('#newsrc').attr("src","images/s3icon/frame"+ (index+1) +".png");
	TweenMax.to("#s2",0.8,{autoAlpha:0});
	TweenMax.to("#s3",0.8,{autoAlpha:1});

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
            url: "{:U('Index/saveInfo')}",
            type:'post',
            dataType:'json',
            data:data,            
            success:function(data){
                if(data.status == 1){
                	$("#s4 .success_box").fadeIn();
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
    //测试
    $("#s4 .success_box").fadeIn();
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



