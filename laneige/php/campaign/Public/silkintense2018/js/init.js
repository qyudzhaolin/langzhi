if (/Android (\d+\.\d+)/.test(navigator.userAgent)) {
  var version = parseFloat(RegExp.$1)
  if (version > 2.3) {
    var phoneScale = parseInt(window.screen.width) / 640
    document.write('<meta name="viewport" content="width=640, minimum-scale = ' + phoneScale + ', maximum-scale = ' + phoneScale + ', target-densitydpi=device-dpi">')
  }else {
    document.write('<meta name="viewport" content="width=640, target-densitydpi=device-dpi">')
  }
}else {
  document.write('<meta name="viewport" content="width=640, user-scalable=no, target-densitydpi=device-dpi">')
}

/*********************************************
Preload 预加载图片
**********************************************/
var queue = new createjs.LoadQueue()
var loadImgList = []
function imgArr (id, src, length) {
  for (var i = 0;i < length;i++) {
    var obj = {}
    obj.id = id + i + ''
    obj.src = src + i + '.jpg'
    loadImgList.push(obj)
  }
}
/*********************************************
 drawFrame 
 **********************************************/
function drawFrame (ctx, image, width, height, num) {
  var offsetY = 0,
    offsetX = 0
  ctx.clearRect(offsetX, offsetY, width, height)
  ctx.drawImage(image, offsetX, offsetY, width, height, 0, 0, width, height)
}
/*********************************************
 rightNow 
 **********************************************/
function rightNow () {
  if (window['performance'] && window['performance']['now']) {
    return window['performance']['now']()
  } else {
    return +(new Date())
  }
}

function preload () {
  // 首页动画帧
  if (window.screen.height ==812) {
    var index = 'iphonex_'
    var src = ImgPath + '/iphonex/Page1_'
    var len = 30
    imgArr(index, src, len)
  }else {
    var index = 'index_'
    var src = ImgPath + '/index/Page1_'
    var len = 26
    imgArr(index, src, len)
  }
  queue.on('progress', handleLoadStart)
  queue.on('complete', handleComplete)
  queue.setMaxConnections(5)
  queue.loadManifest(loadImgList)
}

function handleLoadStart (event) {
  // document.getElementById("loading_text").innerHTML = Math.floor(queue.progress * 100) + "%"
}
function handleComplete () {
  TweenMax.set('#s1', {autoAlpha: 1})
  // TweenMax.set('#s2', {autoAlpha: 1})
  // s1()
  if (window.screen.height == 812) {
    s1_canvas_x('iphonex')
  }else {
    s1_canvas('index')
  }
}
