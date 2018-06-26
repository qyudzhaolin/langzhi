
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
 /*var queue = new createjs.LoadQueue();
 function preload(){
   queue.installPlugin(createjs.Sound);
   var i = 0;
  queue.on("progress", handleLoadStart);
  queue.on("complete", handleComplete);
  queue.setMaxConnections(5);
  queue.loadManifest([
    //{id:"s1_1",src:"images/s1/Page1_00000.jpg"}

  ]);
}


function handleLoadStart(event) {
  //document.getElementById("loading_text").innerHTML = Math.floor(queue.progress * 100) + "%";
}
function handleComplete() {
  
}
*/
  
