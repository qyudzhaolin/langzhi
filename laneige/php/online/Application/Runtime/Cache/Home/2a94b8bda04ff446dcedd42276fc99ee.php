<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html>
	<head>
		<title>兰芝注水接力</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="format-detection" content="telephone=no">
		<link rel="stylesheet" type="text/css" href="/laneige2/php/online/Public/home/css/style.css">

        <script type="text/javascript">
          var imgurl="/laneige2/php/online/Public/home/images";
          var url="<?php echo U('Index/saveInfo');?>";
		</script>

		<script type="text/javascript" src="/laneige2/php/online/Public/home/js/jquery-1.11.2.min.js"></script>
		<script type="text/javascript" src="/laneige2/php/online/Public/home/js/swiper.min.js"></script>
		<link rel="stylesheet" href="/laneige2/php/online/Public/home/css/swiper.min.css">
		<script type="text/javascript" src="/laneige2/php/online/Public/home/js/TweenMax.min.js"></script>
		<!-- <script type="text/javascript" src="js/preloadjs.min.js"></script> -->
		<!-- <script type="text/javascript" src="js/vconsole.min.js"></script> -->
		<script type="text/javascript" src="/laneige2/php/online/Public/home/js/init.js"></script>
		
	</head>
	<body>
	<!-- <body> -->
		<div class="box">
			<!-- loading部分 -->
			<section class="screen" id="loading">
				
			</section>
			<!-- loading部分 -->
			<!-- s1 轮播 -->
			<section class="screen" id="s1">
				<div class="swiper-container myswiper">
				  <div class="swiper-wrapper">
				    <div class="swiper-slide slide">
				    	<img src="/laneige2/php/online/Public/home/images/slide1.png" alt="">
				    </div>
				    <div class="swiper-slide slide">
				    	<img src="/laneige2/php/online/Public/home/images/slide2.png" alt="">
				    </div>
				    <div class="swiper-slide slide">
				    	<img src="/laneige2/php/online/Public/home/images/slide3.png" alt="">
				    </div>
				  </div>
				</div>
				<a href="javascript:;" class="next_btn"></a>
				<a href="javascript:;" class="rule_btn"></a>
			</section>
			<!-- s1 轮播 -->
			<!-- s2 选择部分 -->
			<section class="screen" id="s2">
				<input type="text" maxlength="10" id="write" placeholder="不超过12个字符，支持中英文">
				<ul>
					<li><img src="/laneige2/php/online/Public/home/images/s3icon/icon1.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon2.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon3.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon4.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon5.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon6.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon7.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon8.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon9.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon10.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon11.png"></li>
					<li ><img src="/laneige2/php/online/Public/home/images/s3icon/icon12.png"></li>
				</ul>
				<a href="javascript:;" class="affirm_btn"></a>
			</section>
			<!-- s2 选择部分 -->
			<!-- s3 绘制图片 -->
			<section class="screen" id="s3">
				<p class="text"></p>
				<div class="img_box">
					<img alt="" id="newsrc">
				</div>
				<a href="javascript:;" class="next_btn"></a>
			</section>
			<!-- s3 绘制图片 -->
			<!-- s4 表单 -->
			<section class="screen" id="s4">
				<div class="form">
					 <div class="input_box">
					 	<input type="tel" id="phone" value="" placeholder="请填写您的手机号">
					 </div>
					 <div class="input_box select-box">
					 	<p>
					 		<span>请选择省份</span>
						 	<select id="province">
						 		<option value="请选择省份">请选择省份</option>
						 		 <?php if(is_array($list1)): $i = 0; $__LIST__ = $list1;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["province"]); ?>"><?php echo ($vo["province"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						 	</select>
					 	</p>
					 	<p>
					 		<span>请选择城市</span>
						 	<select id="city">
						 		<option value="请选择城市">请选择城市</option>
						 		 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["city"]); ?>"><?php echo ($vo["city"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						 	</select>
					 	</p>
					 </div>
					 



				

				

				
				 	<div class="input_box select-box">
					 	<p>
					 		<span>请选择您方便前往的专柜</span>
						 	<select id="shop">
						 		<option value="请选择您方便前往的专柜">请选择您方便前往的专柜</option>
						 		 <?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><option value="<?php echo ($vo["counter"]); ?>"><?php echo ($vo["counter"]); ?></option><?php endforeach; endif; else: echo "" ;endif; ?>
						 	</select>
					 	</p>
					</div>
					<a href="javascript:;" class="read_checkbox checked"></a>
					<a href="http://www.laneige.com/cn/zh/regulation/terms-and-conditions.html" class="tiaokuan"></a>
					<a href="http://www.laneige.com/cn/zh/regulation/privacy-policy.html" class="yinsi"></a>
					<a href="javascript:;" class="submit_btn"></a>
					<a href="javascript:;" class="rule_btn"></a>
				</div>
				<div class="success_box">
					<img src="/laneige2/php/online/Public/home/images/s4_alert.png" alt="">
				</div>
			</section>
			<!-- s4 表单 -->
           
			<!-- s4 规则 -->
			<div class="rule">
				<span class="close_btn"></span>		
				<div class="main">
					<a href="http://campaign.laneige.com/Silkintense2018_new/" class="href"></a>
					<img src="/laneige2/php/online/Public/home/images/rule_text.png" alt="">
				</div>
			</div>
			

		</div>

		<script type="text/javascript"src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
			<script type="text/javascript"src=" https://max-digital-api-dev.oss-cn-shanghai.aliyuncs.com/js/interface/service/spreading-tree/mco-1-1.js"></script>
    <script type="text/javascript">
        var userinfo = [<?php echo ($userinfo); ?>];
        __$$_obj.configure('JdMY05knvDZHzXfu','','z3npJUoiSQsCW2Ajk0wqbZNBlgvIO9EK',userinfo);
    </script>
    <script type="text/javascript">
        //alert(location.href.split('#')[0]);
        wx.config({
            debug: false,
            appId: '<?php echo ($signPackage["appId"]); ?>',
            timestamp: '<?php echo ($signPackage["timestamp"]); ?>',
            nonceStr: '<?php echo ($signPackage["nonceStr"]); ?>',
            signature: '<?php echo ($signPackage["signature"]); ?>',
            jsApiList: [
                'checkJsApi',
                'onMenuShareTimeline',
                'onMenuShareAppMessage',
                'onMenuShareQQ',
                'onMenuShareWeibo',
                'hideMenuItems',
                'showMenuItems',
                'hideAllNonBaseMenuItem',
                'showAllNonBaseMenuItem'
            ]
        });
        var shareData64 = {
            	    title: "申领试色|乔妹挚爱兰芝绝色丝润唇膏全新上市",
					desc: "兰芝绝色丝润唇膏全新上市！立即申领体验最佳拍档小白光气垫7日装",
					imgUrl: "http://laneige.cdn.max-digital.cn/H5/laneige/silkintense2018/share.jpg",
					link:"http://campaign.laneige.com/Silkintense2018_new/"
        };

        wx.ready(function () {
            //默认显示
            wx.showOptionMenu();
            wx.onMenuShareAppMessage(window.__$$_obj.makeAppMessageData(shareData64));
            wx.onMenuShareTimeline(window.__$$_obj.makeTimelineData(shareData64));
            wx.onMenuShareQZone(window.__$$_obj.makeQZoneData(shareData64));
            wx.onMenuShareWeibo(window.__$$_obj.makeWeiboData(shareData64));
            wx.onMenuShareQQ(window.__$$_obj.makeQQData(shareData64));
        });
    </script>
		<script type="text/javascript" src="/laneige2/php/online/Public/home/js/app.js"></script>
	</body>
</html>