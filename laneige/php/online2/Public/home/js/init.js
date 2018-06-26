
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
 function preload(){
   queue.installPlugin(createjs.Sound);
   var i = 0;
  queue.on("progress", handleLoadStart);
  queue.on("complete", handleComplete);
  queue.setMaxConnections(5);
  queue.loadManifest([
    {id:"loading",src:images+"/loading.gif"},
    {id:"frame_1",src:images+"/s3icon/frame1.png"},
    {id:"frame_2",src:images+"/s3icon/frame2.png"},
    {id:"frame_3",src:images+"/s3icon/frame3.png"},
    {id:"frame_4",src:images+"/s3icon/frame4.png"},
    {id:"frame_5",src:images+"/s3icon/frame5.png"},
    {id:"frame_6",src:images+"/s3icon/frame6.png"},
    {id:"frame_7",src:images+"/s3icon/frame7.png"},
    {id:"frame_8",src:images+"/s3icon/frame8.png"},
    {id:"frame_9",src:images+"/s3icon/frame9.png"},
    {id:"frame_10",src:images+"/s3icon/frame10.png"},
    {id:"frame_11",src:images+"/s3icon/frame11.png"},
    {id:"frame_12",src:images+"/s3icon/frame12.png"},

  ]);
}


function handleLoadStart(event) {
  document.getElementById("loading_text").innerHTML = Math.floor(queue.progress * 100) + "%";
}
function handleComplete() {
    $('#loading').html(queue.getResult("loading"));
    setTimeout(function(){
      TweenMax.to("#loading",0.8,{autoAlpha:0});
      TweenMax.to("#s1",0.8,{autoAlpha:1});
      //启动swiper
      var mySwiper = new Swiper('#s1 .myswiper', {
        loop:true,
        autoplay: 3000,//可选选项，自动滑动
      })
    },5000)
}

  
