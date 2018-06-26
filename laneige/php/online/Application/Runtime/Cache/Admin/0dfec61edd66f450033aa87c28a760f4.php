<?php if (!defined('THINK_PATH')) exit();?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<title>登陆</title>
	<!-- 公共引用部分 -->
	<link rel="stylesheet" type="text/css" href="/sky/sky/Public/admin/css/bootstrap.min.css">
	<script type="text/javascript" src="/sky/sky/Public/admin/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="/sky/sky/Public/admin/js/bootstrap.min.js"></script>
	<!-- 公共引用部分 -->
	<link rel="stylesheet" type="text/css" href="/sky/sky/Public/admin/css/Login.css">
</head>
<body>
	<div id="main">
    	<h3></h3>
    	<form class="form-horizontal">
	    	<div class="form-group">
	    	  <label for="inputEmail3" class="col-sm-2 control-label">用户名</label>
	    	  <div class="col-sm-10">
	    	    <input type="text" class="form-control" id="user_name" placeholder="用户名">
	    	  </div>
	    	</div>
	    	<div class="form-group">
	    	  <label for="inputPassword3" class="col-sm-2 control-label">密码</label>
	    	  <div class="col-sm-10">
	    	    <input type="password" class="form-control" id="password" placeholder="密码">
	    	  </div>
	    	</div>
	    	<div class="form-group">
	    	    <button type="button" class="btn btn-default" id="submit">登陆</button>
	    	</div>
    	</form>
	</div>
</body>
</html>
<script>
jQuery(document).ready(function($) {
	document.onkeydown = function(e){ 
	    var ev = document.all ? window.event : e;
	    if(ev.keyCode==13) {
	        submit();    
		}
	}
	$("#submit").click(function(event) {
		submit();
	});
	function submit(){
		var user_name=$("#user_name").val();
		var password=$("#password").val();
		if (user_name=="") {
			alert("请填写用户名");
		}
		else if(password==""){
            alert("请填写密码");
		}
		else{
			$.ajax({
				url:"<?php echo U('Login/dologin');?>",
				type:"post",
				dataType:'json', 
				data:{'username':user_name,"password":password},
				success:function(data){
				//alert(data.msg);
					if(data.code == 1){
						window.location.href = "<?php echo U('Index/index',array('type'=>1));?>";
					}else{
						alert(data.msg);
						return false;
					}
				}
			});
		}
	}
});
</script>