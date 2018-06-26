<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">
	<meta name="apple-mobile-web-app-capable" content="yes">
	<meta name="format-detection" content="telephone=no">
	<title><?php echo ((isset($head_title) && ($head_title !== ""))?($head_title):"管理后台"); ?></title>
	<!-- 公共引用部分 -->
	<link rel="stylesheet" type="text/css" href="/sky/sky/Public/admin/css/bootstrap.min.css">
	<script type="text/javascript" src="/sky/sky/Public/admin/js/jquery-1.11.2.min.js"></script>
	<script type="text/javascript" src="/sky/sky/Public/admin/js/bootstrap.min.js"></script>
	<link rel="stylesheet" type="text/css" href="/sky/sky/Public/admin/css/allhead.css">
	<!-- 公共引用部分 -->
</head>
<body>
	<!-- S-头部 -->
	<div class="head">
		<span class="logo"></span>
		<div class="control">
			<span class="translateY"><?php echo ($real_name); ?></span>
			<a href="<?php echo U('Login/logout');?>" class="translateY"><strong>退出</strong></a>
		</div>
	</div>
	<!--E-头部 -->
	
	<!--S-主体部分 -->
	<div class="connet">
	
	<!-- S-侧边栏 -->
<div class="siderBar">
    <?php $username = session('username'); ?>
	<ul>
        <li class="y_s">
            <a href="<?php echo U('Index/index');?>" <?php if($controller_name == 'Index'): ?>class="current"<?php endif; ?>>
            <span class="icon_img"></span>
            <span class="icon_text">申领信息</span>
            </a>
        </li>
       


	</ul>
</div>
<!-- E-侧边栏 -->
 <div class="mainContent ">
<style>
.nav-tabs>li.active>a, .nav-tabs>li.active>a:focus, .nav-tabs>li.active>a:hover {
    color: #555;
    cursor: default;
    background-color: #EAEAEA;
    border: 1px solid #ddd;
    border-bottom-color: transparent;
}
</style>
<link rel="stylesheet" type="text/css"  href="/sky/sky/Public/admin/css/datetimepicker.min.css" />
	<div class="panel panel-primary">
	    <div class="panel-heading">
		   <h3 class="panel-title">用户信息</h3>
	    </div>
	    <div class="panel-body">
		   
			<div>
			   <form  class="form-inline"  action="<?php echo U('Index/index');?>" method="post" role="form"  id="searchform">
				   <div class="form-group">
					  <label class="sr-only" for="name">姓名</label>
					   <input type="text" class="form-control" name="name" id="name"  value="<?php echo ($search["name"]); ?>" placeholder="请输入姓名">
				   </div>
                   <div class="form-group">
                       <label class="sr-only" for="phone">手机号</label>
                       <input type="text" class="form-control" name="phone" id="phone" value="<?php echo ($search["phone"]); ?>" placeholder="请输入手机">
                   </div>

				   <div class="form-group">
					   <label class="sr-only" for="start_time">开始时间</label>
					   <input type="text" class="form-control" name="start_time" class="daterangepicker" id="start_time" value="<?php echo ($search["start_time"]); ?>" placeholder="请选择开始时间">
				   </div>
				   <div class="form-group">
					   <label class="sr-only" for="end_time">截止时间</label>
					   <input type="text" class="form-control" name="end_time" class="daterangepicker" id="end_time" value="<?php echo ($search["end_time"]); ?>" placeholder="请选择截止时间">
				   </div>
				   <input type="hidden" name="type" value="2" />
                   <button type="button" id="searchbtn" class="btn btn-primary">查询</button>
                   <button type="button" id="export" class="btn btn-primary">导出</button>
			   </form>
			   <br>
			</div>
			<table class="table table-striped table-bordered table-hover ">
				<thead>
				  <tr>
					 <th width="5%" class="text-center">ID</th>
					 <th width="10%" class="text-center">姓名</th>
					 <th width="10%" class="text-center">电话</th>
					 <th width="15%" class="text-center">时间</th>
				  </tr>
			   </thead>
			   <tbody>
				<?php if(is_array($list)): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?><tr>
					 <td class="text-center"><?php echo ($vo["id"]); ?></td>
                     
					 <td class="text-center"><?php echo ($vo["name"]); ?></td>

					 <td class="text-center"><?php echo ($vo["phone"]); ?></td>
					 <td class="text-center"><?php echo (date('Y-m-d H:i',$vo["cdate"])); ?></td>
				  </tr><?php endforeach; endif; else: echo "" ;endif; ?>
			   </tbody>
			</table>
			<div class="text-right"><?php echo ($page); ?></div>

		</div>
        <!--设置Modal-->
	</div>	
</div>
<script type="text/javascript" src="/sky/sky/Public/admin/js/moment.min.js"></script>
<script type="text/javascript" src="/sky/sky/Public/admin/js/datetimepicker.js"></script>
<script type="text/javascript">
$(function(){
	//日历控件初始化
	 $('#start_time').datetimepicker({
		language:  'fr',
		format:'yyyy-mm-dd',
        weekStart: 1,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2
	 });
     $('#end_time').datetimepicker({
		language:  'fr',
		format:'yyyy-mm-dd',
        weekStart: 1,
		autoclose: 1,
		todayHighlight: 1,
		minView: 2
	 });

	//查询
    $('#searchbtn').click(function () {
        $('#searchform').attr('action',"<?php echo U('Index/index');?>");
        $('#searchform').submit();
    })
	//导出
	$('#export').click(function () {
        $('#searchform').attr('action',"<?php echo U('Index/export');?>");
        $('#searchform').submit();
    });



    $('.setting').click(function(){
        var num = $(this).data('num');
        var id = $(this).data('id');
        $('#record_id').val(id);
        $('#zan_num').val(num);
    });

    $('#subbtn').click(function () {
        var postdata = $('#forms').serializeArray();
        $.ajax({
            url:"<?php echo U('Index/updateInfo');?>",
            type:'post',
            data:postdata,
            dataType:'json',
            success:function(res){
                if(res.status==1){
					alert('设置成功');
                    window.location.reload();
                }else if(res.status==2){
					//alert('未做更改');
                    $('.close').click();
                }else{
                    alert('操作失败');
                }
            }
        })
    })
})
</script>
	

	</div>
	<!--E-主体部分 -->



</body>
</html>