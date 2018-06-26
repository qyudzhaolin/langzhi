
//选择性别
function s1(){
	var s1canavs = document.getElementById("s1canavs");
	stage = new createjs.Stage(s1canavs);
	createjs.Ticker.setFPS(10);
	createjs.Ticker.addEventListener("tick", handleTick);
	var pageIndex = 1;
	function handleTick(event) {
	    pageIndex++;
		var page = new createjs.Bitmap(queue.getResult("s1_"+pageIndex));
	    if(pageIndex > 28){
			createjs.Ticker.removeAllEventListeners();	 
			TweenMax.to("#s1",0.8,{autoAlpha:0});		
			TweenMax.to("#s2",0.8,{autoAlpha:1});	
			
	    }
	    stage.removeAllChildren();
	    stage.addChild(page);
	    stage.update();
	}
}


/*var music = document.getElementById("audio");
$("#music-btn").click(function (event) {
	$(this).toggleClass('off');
	if ($(this).hasClass('off')) {
		music.pause();
	} else {
		music.play();
	}
});
document.addEventListener('DOMContentLoaded', function () {
(function audioAutoPlay() {
	var audio = document.getElementById("audio");
	audio.play();
		document.addEventListener("WeixinJSBridgeReady", function () {
			audio.play();
		}, false);
	})();
});*/

/**********
    s2
**********/
//改变select
$("select").change(function(event) {
	var val = $(this).val();
	$(this).siblings('span').text(val);
	_smq.push(['custom','prinfo','01_city']);	
});
//切换阅读协议
$("#s2 .checkbox").click(function(event) {
	$(this).toggleClass('checked');
});
//提交
var submit_p = true;
$("#s2 .submit_btn").click(function(event) {
	var city = $("#city").val();
	var phone = $("#phone").val();
	var haschecked = $("#s2 .checkbox").hasClass('checked');
	if(city == "城市"){
		alert("请选择城市");
		return false;
	}
	if(phone == ""){
		alert("请填写手机号");
		return false;
	}
	else if(!isMobile(phone)){
		alert("请输入正确的手机号码");
		return false;
	}
	if(!haschecked){
		alert("请同意阅读协议");
		return false;
	}
	//提交表单
	if (submit_p) {
		submit_p = false;
		$.ajax({
            url: "{:U('Index/saveInfo')}",
            type:'post',
            dataType:'json',
            data:{
            	city:city,
            	phone:phone,
            },            
            success:function(data){
				_smq.push(['custom','prinfo','03_submit',phone]);			
                if(data.playnum == 1){
					//第一次领取卡卷
                	TweenMax.to("#s3",0.8,{autoAlpha:1});
                }
                else{
					//领过卡卷
                	TweenMax.to("#s4",0.8,{autoAlpha:1});
                }
                TweenMax.to("#s2",0.8,{autoAlpha:0});
                submit_p = true;
            },
            error:function(){
                alert("网络繁忙");
                submit_p = true;                    
            }
        })
	}

});

$("#phone").blur(function (e) { 
	e.preventDefault();
	if($(this).val() > 10000000000){
		_smq.push(['custom','prinfo','02_number']);	
	}
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

/**********
   规则
**********/
//显示规则
$(".rule_btn").click(function(event) {
	$(".rule_box").fadeIn();
	if($(this).parent("section").attr("id") == "s2"){
		_smq.push(['custom','prinfo','04_rule']);	
	}else{
		_smq.push(['custom','prcoupon','06_rule']);
	}
	
});
//关闭规则
$(".rule_box .close_btn").click(function(event) {
	$(".rule_box").fadeOut();
});


//领卡卷
$("#s3 .get_kajuan").click(function(event) {
	alert('卡卷');
	_smq.push(['custom','prcoupon','05_coupon']);	
});



address("北京");
function address(address){
	for(var i = 0; i < $("#city option").length;i++){
		if($("#city option").eq(i).val() == address){
			$("#city option").eq(i).attr("selected","selected");			
			$("#city").siblings("span").text(address);
		}
	}	
}