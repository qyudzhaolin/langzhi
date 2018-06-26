var shop_info=[
			{
				"province":"黑龙江",
				"moreinfo":[
					{
						"city" : "哈尔滨",
						"shopname" : "哈尔滨远大",
						"date" : "1.6-1.7",
					}
				]
			},
			{
				"province":"重庆",
				"moreinfo":[
					{
						"city" : "重庆",
						"shopname" : "重庆世纪新都",
						"date" : "1.6-1.7",
					}
				]
			},
			{
				"province":"河南",
				"moreinfo":[
					{
						"city" : "郑州",
						"shopname" : "郑州丹尼斯",
						"date" : "1.13-1.14",
					}
				]
			},
			{
				"province":"贵州",
				"moreinfo":[
					{
						"city" : "贵阳",
						"shopname" : "贵阳百盛",
						"date" : "1.13-1.14",
					}
				]
			},
			{
				"province":"江苏",
				"moreinfo":[
					{
						"city" : "南京",
						"shopname" : "南京中央",
						"date" : "1.20-1.21",
					},
					{
						"city" : "苏州",
						"shopname" : "苏州中心",
						"date" : "2.3-2.4",
					},
					{
						"city" : "常州",
						"shopname" : "常州百货大楼",
						"date" : "1.27-1.28",
					},
				]
			},
			{
				"province":"湖南",
				"moreinfo":[
					{
						"city" : "长沙",
						"shopname" : "长沙平和堂",
						"date" : "1.20-1.21",
					}
				]
			},
			{
				"province":"湖北",
				"moreinfo":[
					{
						"city" : "武汉",
						"shopname" : "武汉广场",
						"date" : "1.27-1.28",
					}
				]
			},
			{
				"province":"安徽",
				"moreinfo":[
					{
						"city" : "合肥",
						"shopname" : "合肥鼓楼",
						"date" : "2.3-2.4",
					}
				]
			},

			{
				"province":"四川",
				"moreinfo":[
					{
						"city" : "成都",
						"shopname" : "成都王府井",
						"date" : "2.10-2.11",
					}
				]
			},
			{
				"province":"浙江",
				"moreinfo":[
					{
						"city" : "杭州",
						"shopname" : "杭州武林银泰",
						"date" : "2.10-2.11",
					}
				]
			},			
		];
jQuery(document).ready(function($) {
	//补全地区
	for(var i=0;i<=shop_info.length-1;i++){
		var option='<option value="'+shop_info[i].province+'">'+shop_info[i].province+'</option>'
		$("#province").append(option);
	}
	//预约地区改变
	$("#province").change(function(event) {
		var val=$(this).val();
		$("#city").html('<option value="请选择城市">请选择城市</option>');
		$("#city").siblings('span').text("请选择城市");
		$("#shop").html('<option value="请选择您方便前往的专柜">请选择您方便前往的专柜</option>');
		$("#shop").siblings('span').text("请选择您方便前往的专柜");
		if ($(this).val()!="请选择省份") {
			for(var i=0;i<=shop_info.length-1;i++){
				if(shop_info[i].province == val){
					var newcity='<option value="请选择城市">请选择城市</option>';
					var newshopname='<option value="请选择您方便前往的专柜">请选择您方便前往的专柜</option>';
					for(var j = 0; j < shop_info[i].moreinfo.length;j++){
						newcity += '<option value="'+shop_info[i].moreinfo[j].city+'">'+shop_info[i].moreinfo[j].city+'</option>'
					}
					$("#city").html(newcity);
				}
			}				
		}
	});
	//城市改变
	$("#city").change(function(event) {
		var val=$(this).val();
		$("#shop").html('<option value="请选择您方便前往的专柜">请选择您方便前往的专柜</option>');
		$("#shop").siblings('span').text("请选择您方便前往的专柜");
		if (val!="请选择城市") {	
			var province = $("#province").val();
			var city = $("#city").val();
			for(var i=0;i<=shop_info.length-1;i++){
				if(shop_info[i].province == province){
					var newshopname='<option value="请选择您方便前往的专柜">请选择您方便前往的专柜</option>';
					for(var j = 0 ; j < shop_info[i].moreinfo.length; j++){
						if(shop_info[i].moreinfo[j].city == city){
							newshopname += '<option value="'+shop_info[i].moreinfo[j].shopname+'">'+shop_info[i].moreinfo[j].shopname+'</option>';
							//修改展示日期
							$("#s4 .success_box .img span").html(shop_info[i].moreinfo[j].date);
						}
					}
					$('#shop').html(newshopname);
					$('#shop').siblings('span').html("请选择您方便前往的专柜");
				}
			}
		}
	});
});