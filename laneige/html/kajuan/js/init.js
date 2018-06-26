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
  

  /*********************************************
  Preload 预加载图片
  **********************************************/
  var queue = new createjs.LoadQueue();
  var loadImgList = [];
  function getNum(num,imgsrc){
	//var prefix = "images/step4/page7_";
	var prefix = imgsrc;
	var src="";
	num = num+'';
	if(num.length==1){
	  src = prefix+"0000"+num;
	}else if(num.length==2){
	  src = prefix+"000"+num;
	}else if(num.length ==3){
	  src = prefix+"00"+num;
	}
	return src;
  }
  function getStr(num,id_prefix,endnum,imgsrc){
	var count =0;
	for(var i=num;i<endnum;i++){
	  count++
	  var str = {id:""+id_prefix+count+"",src:""+getNum(i,imgsrc)+".jpg"};
	  loadImgList.push(str);
	}
  }
  function preload(){
	//选择男女
	getStr(0,"s1_",29,ImgPath+"/s1/Page1_");
	queue.installPlugin(createjs.Sound);
	 queue.on("progress", handleLoadStart);
	 queue.on("complete", handleComplete);
	 queue.setMaxConnections(5);
	 queue.loadManifest(loadImgList);
  }
  
 function handleLoadStart(event) {
	//document.getElementById("loading_text").innerHTML = Math.floor(queue.progress * 100) + "%";
 }
 function handleComplete() {
		TweenMax.set("#s1",{autoAlpha:1});		
		s1();
}
