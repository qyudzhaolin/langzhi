<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<!-- 微博增加 class wb -->
<html>
	<head>
		<title>皇家</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" type="text/css" href="/royal/php/Public/home/css/style.css">
		<script type="text/javascript">
		if(/Android (\d+\.\d+)/.test(navigator.userAgent)){
		    var version = parseFloat(RegExp.$1);
		    if(version>2.3){
		      var phoneScale = parseInt(window.screen.width)/640;
		      document.write('<meta name="viewport" content="width=640, minimum-scale = '+ phoneScale +', maximum-scale = '+ phoneScale +', target-densitydpi=device-dpi">');
		    }else{
		      document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">');
		    }
		}else{
		    document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">');
		}
		</script>
		<script type="text/javascript">
        var img="/royal/php/Public/home/images/"
        var url ="<?php echo U('Index/saveInfo');?>";
        var nackname = "<?php echo ($nickname); ?>";
        var isold = <?php echo ($isold); ?>;

    </script>
	</head>
	<body>
		<div class="box">
			<!-- 文字填写 -->
			<section class="screen" id="share">
				<div class="main catcanvas">
					<div class="canavs_box">						
						<img src="<?php echo ($info["img"]); ?>" alt="" class="img">
					</div>
					<span class="frame"></span>
				</div>
				<p id="write_text"><?php echo ($info["content"]); ?></p>
				<div class="up_btn">
					<a href="<?php echo U('Index/index');?>">						
						<img src="/royal/php/Public/home/images/btn1.png" alt="">
						<img src="/royal/php/Public/home/images/btn2.png" alt="">
					</a>
				</div>
				<img src="/royal/php/Public/home/images/text.png" alt="" class="main_text">
				<div class="share_ts">
					<img src="/royal/php/Public/home/images/share_text.png" alt="">
				</div>
			</section>
			<!-- 文字填写 -->
		</div>
	</body>
</html>