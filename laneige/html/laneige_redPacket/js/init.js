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
touchMove 判断左右滑动
********* *************************************/
var touched = false
function touchMove (params) {
  $('#active').on('touchstart', function (e) {
    // 判断默认行为是否可以被禁用
    if (e.cancelable) {
      // 判断默认行为是否已经被禁用
      if (!e.defaultPrevented) {
        e.preventDefault()
      }
    }
    startX = e.originalEvent.changedTouches[0].pageX
  })
  $('#active').on('touchend', function (e) {
    // 判断默认行为是否可以被禁用
    if (e.cancelable) {
      // 判断默认行为是否已经被禁用
      if (!e.defaultPrevented) {
        e.preventDefault()
      }
    }
    moveEndX = e.originalEvent.changedTouches[0].pageX
    X = Math.abs(moveEndX - startX)
    // 左滑
    if (X > 30) {
      touched = true
      // TweenMax.to('#s2', 0.8, {'autoAlpha': 1})
    }
  })
}



