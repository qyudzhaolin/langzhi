// 首页动画
s1()
function s1 (src) {
  newSwiper()
  TweenMax.to('#s1', 0.8, {'autoAlpha': 1})
  $('.swiper-btn').addClass('my-button-hidden')
  $('#s1 .btn').click(function name (params) {
    // TweenMax.to('#s1', 0.8, {'autoAlpha': 0})
    TweenMax.to('#share', 0.8, {'autoAlpha': 1})
  })
}
/*============swiper 轮播图====================  */
var mySwiper = {}
function newSwiper () {
  var mySwiper = new Swiper('.swiper-container', {
    direction: 'horizontal',
    // loop: true,
    navigation: {
      nextEl: '.swiper-button-next',
      prevEl: '.swiper-button-prev',
      hideOnClick: false,
    // hiddenClass: 'my-button-hidden'
    },
    on: {
      transitionEnd: function (swiper) {
        if (mySwiper.realIndex == 0) {
          $('.swiper-btn').addClass('my-button-hidden')
        // this.navigation.$nextEl.css('display', 'none')
        // this.navigation.$prevEl.css('display', 'none')
        } else {
          $('.swiper-btn').removeClass('my-button-hidden')
        // this.navigation.$nextEl.css('display', 'block')
        // this.navigation.$prevEl.css('display', 'block')
        }
      }
    }
  })
}

// if (is_weixin == 1) {
// 	$("#s4 .share_weixin").show()
// 	$(".rule_box .main img").eq(0).show()
// }
// else{
// 	$("#s4 .share_weibo").show()
// 	$(".rule_box .main img").eq(1).show()
// }

// //分享好友
// $("#s4 .share_weixin").click(function(event) {
// 	$("#s4 .share").fadeIn()
// 	//_smq.push(['pageview','/share','share'])
// 	//_smq.push(['custom','share','14_share'])
// })
