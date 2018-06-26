// 动画序列帧
function s1_canvas (src) {
  TweenMax.set('#s1 canvas', {'autoAlpha': 1,onComplete: function () {
      var fps = 10,
        currentFrame = 1,
        totalFrames = 25,
        canvas = document.getElementById('s1_canavs'),
        ctx = canvas.getContext('2d'),
        currentTime = rightNow()
      canvas.width = 640
      canvas.height = 1040
      ;(function animloop (time) {
        var delta = (time - currentTime) / 1000
        if (Math.abs(delta) < 1) {
          currentFrame += (delta * fps)
        }
        var frameNum = Math.floor(currentFrame)
        if (frameNum >= totalFrames) {
          currentFrame = frameNum = totalFrames
          TweenMax.to('#s1', 0.8, {'autoAlpha': 0})
          TweenMax.to('#s2', 1.2, {'autoAlpha': 1})
          return
        }
        img = queue.getResult('' + src + '_' + (frameNum + 1))
        sequences2 = requestAnimationFrame(animloop)
        drawFrame(ctx, img, 640, 1040, frameNum)
        currentTime = time
      })(currentTime)
  }})
}
function s1_canvas_x (src) {
  TweenMax.set('#s1_canavs_x', {'autoAlpha': 1,onComplete: function () {
      var fps = 10,
        currentFrame = 1,
        totalFrames = 25,
        canvas = document.getElementById('s1_canavs'),
        ctx = canvas.getContext('2d'),
        currentTime = rightNow()
      canvas.width = 640
      canvas.height = 1358
      ;(function animloop (time) {
        var delta = (time - currentTime) / 1000
        if (Math.abs(delta) < 1) {
          currentFrame += (delta * fps)
        }
        var frameNum = Math.floor(currentFrame)
        if (frameNum >= totalFrames) {
          currentFrame = frameNum = totalFrames
          TweenMax.to('#s1', 0.8, {'autoAlpha': 0})
          TweenMax.to('#s2', 1.2, {'autoAlpha': 1})
          return
        }
        img = queue.getResult('' + src + '_' + (frameNum + 1))
        sequences2 = requestAnimationFrame(animloop)
        drawFrame(ctx, img, 640, 1040, frameNum)
        currentTime = time
      })(currentTime)
  }})
}
// address('北京')
function address (address) {
  // for (var i = 0; i < $('#city option').length;i++) {
  //   if ($('#city option').eq(i).val() == address) {
  //     $('#city option').eq(i).attr('selected', 'selected')
  //   }
  // }
  $('#city').text(address)
}
$('select').change(function (event) {
  var val = $(this).val()
  $(this).siblings('span').text(val)
})
// //切换阅读协议
$('#s2 .checkbox').click(function (event) {
  $(this).toggleClass('checked')
})
// ===========s2============
// 提交
var submit_p = true
$('#s2 .submit_btn').click(function (event) {
  var city = $('#city').val()
  var phone = $('#phone').val()
  var haschecked = $('#s2 .checkbox').hasClass('checked')
  if (city == '城市') {
    alert('请选择城市')
    return false
  }
  if (phone == '') {
    alert('请填写手机号')
    return false
  }
  else if (!isMobile(phone)) {
    alert('请输入正确的手机号码')
    return false
  }
  if (!haschecked) {
    alert('请同意阅读协议')
    return false
  }
  // 提交表单
  if (submit_p) {
    submit_p = false
    $.ajax({
      url: "{:U('Index/saveInfo')}",
      type: 'post',
      dataType: 'json',
      data: {
        city: city,
        phone: phone
      },
      success: function (data) {
        _smq.push(['custom', 'info', '03_submit', phone])
        if (data.playnum == 1) {
          // 第一次领取卡卷
          TweenMax.to('#s3', 0.8, {autoAlpha: 1})
        }else {
          // 领过卡卷
          TweenMax.to('#s4', 0.8, {autoAlpha: 1})
        }
        // TweenMax.to('#s2', 0.8, {autoAlpha: 0})
        submit_p = true
      },
      error: function () {
        alert('网络繁忙')
        submit_p = true
      }
    })
    // 测试
    _smq.push(['custom', 'info', '03_submit', phone])
    TweenMax.to('#s2', 0.8, {autoAlpha: 0})
    TweenMax.to('#s3', 0.8, {autoAlpha: 1})

  // TweenMax.to('#s4', 0.8, {autoAlpha: 1})
  }
})
// 手机号监测代码
$('#phone').blur(function (e) {
  e.preventDefault()
  if ($(this).val() > 10000000000) {
    _smq.push(['custom', 'info', '02_number'])
  }
})
$('select').change(function (event) {
  var val = $(this).val()
  $(this).siblings('span').text(val)
  _smq.push(['custom', 'info', '01_city'])
})
// 验证手机
function isMobile (mobile) {
  var patt = /^1[34578]{1}\d{9}$/
  var re = new RegExp(patt)
  if (re.test(mobile)) {
    return $.trim(mobile)
  }else {
    return false
  }
}
// 显示规则
$('.rule_btn').click(function (event) {
  $('.rule_box').fadeIn()
  if ($(this).parent('section').attr('id') == 's2') {
    _smq.push(['custom', 'info', '04_rule'])
  }else {
    _smq.push(['custom', 'coupon', '06_rule'])
  }
})
// 关闭规则
$('.rule_box .close_btn').click(function (event) {
  $('.rule_box').fadeOut()
})
// 领卡卷
$('#s3 .get_kajuan').click(function (event) {
  alert('领取卡卷')
  _smq.push(['custom', 'coupon', '05_coupon'])
})
