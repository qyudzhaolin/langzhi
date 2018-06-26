/**
 * Created by max on 2017/9/12.
 */

$(function(){
    $(".apply").click(function(){
        _smq.push(['custom','ap','01_H5']);
        })

    var oDate1 = new Date().getTime();
    var oDate2 = 1507564800000;//10-10
    var oDate3 = 1510329600000;//11-11
    if (oDate1 >= oDate2 && oDate1 <oDate3)
    {
        if($("html").hasClass("mobile")){
            $(".apply").prop("href","http://clickc.admaster.com.cn/c/a94468,b1968003,c3249,i0,m101,8a1,8b2,h")
        }
        else{
            $(".apply").click(function(e){
                e.stopPropagation();
                e.preventDefault();
                $(".cover").show();
                $(".ercode").fadeIn();
            })
            $(document).click(function(){
                $(".cover").hide();
                $(".ercode").fadeOut();
            })
        }
        $(".s1 .pc").attr("src","images/apply_bg.jpg");
        $(".s1 .mobile").attr("src","images/apply_mobile_bg.jpg");
    }

    //var imgIndex = 0;
    if($("html").hasClass("mobile")){
        //imgIndex = 0;
        $(".part .mobile").show();
        $(".part .pc").hide();
    }else{

        $(".part .mobile").hide();
        $(".part .pc").show();


    }
    $(".buy1").click(function(){
        _smq.push(['custom','ap','03_buy_defensor_1']);
    })
    $(".buy2").click(function(){
        _smq.push(['custom','ap','04_buy_defensor_2']);
    })
    $(".buy3").click(function(){
        _smq.push(['custom','ap','05_buy_mask']);
    })
    $(".buy4").click(function(){
        _smq.push(['custom','ap','04_buy_defensor_2']);
    })
    $(".buy5").click(function(){
        _smq.push(['custom','ap','05_buy_mask']);
    })

})