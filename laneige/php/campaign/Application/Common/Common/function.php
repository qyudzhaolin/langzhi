<?php
use Think\Crypt;
function is_weixin(){
    if(strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == true ) {
        return 1;
    }
    return 0;
}

function sub_curl($url,$data=array(),$is_post=1){
    $ch = curl_init();
    if(!$is_post)//get 请求
    {
        $url =  $url.'?'.http_build_query($data);
    }
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_POST, $is_post);
    if($is_post)
    {
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
    }
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
    $info = curl_exec($ch);
    $code=curl_getinfo($ch,CURLINFO_HTTP_CODE);
    curl_close($ch);
    return $info;
}


function send_sms_new($phone, $content, $cno, $we_key, $iv, $pcode){
    if(!$phone || !$content || !$cno || !$we_key || !$iv || !$pcode) return false;

    $data = array(
        'mobile' => $phone,
        'content' => $content,
        'cno' => $cno,
    );
    $data = json_encode($data);
    $url = "http://weapp.wemediacn.com/laneige/multiple_sapply/crontab/SendSMS";

    $aes = new Crypt();
    $aes->set_key($we_key);
    $aes->set_iv($iv);
    $aes->require_pkcs5();
    $encypt_data = $aes->encrypt($data);

    $postData['key'] = $we_key;
    $postData['pcode'] = $pcode;
    $postData['mtype'] = 1;
    $postData['data'] = $encypt_data;
    $return = sub_curl($url,$postData,1);
    $return = json_decode($return,true);
    return $return;
}

function getSign($url, $id, $iv, $appid){
    $post_url = "http://api.weq.me/wx/token.php?id=$id&key=$iv";
    $res = file_get_contents($post_url);
    $res = json_decode($res, true);
    if($res['errcode'] == 0){
        $aes = new Crypt();
        $aes->set_key($iv);
        $aes->set_iv($iv);
        $aes->require_pkcs5();
        $jsapi_ticket = trim($aes->decrypt($res['jsapi_ticket']));
        if($jsapi_ticket){
            $time = time();
            $nonceStr = createNonceStr();
            // 这里参数的顺序要按照 key 值 ASCII 码升序排序
            $string = "jsapi_ticket=$jsapi_ticket&noncestr=$nonceStr&timestamp=$time&url=$url";
            $signature = sha1($string);
            $signPackage = array(
                "appId"     => $appid,
                "nonceStr"  => $nonceStr,
                "timestamp" => $time,
                "url"       => $url,
                "signature" => $signature,
                "rawString" => $string
            );
            return $signPackage;
        }
    }
}

function get_api_ticket($url, $id, $iv, $appid){
    $post_url = "http://api.weq.me/wx/token.php?id=$id&key=$iv";
    $res = file_get_contents($post_url);
    $res = json_decode($res, true);
    if($res['errcode'] == 0){
        $aes = new Crypt();
        $aes->set_key($iv);
        $aes->set_iv($iv);
        $aes->require_pkcs5();
        $api_ticket = trim($aes->decrypt($res['api_ticket']));
        if($api_ticket){
            return $api_ticket;
        }
    }
    return false;
}

function get_token($id, $iv){
    $post_url = "http://api.weq.me/wx/token.php?id=$id&key=$iv";
    $res = file_get_contents($post_url);
    $res = json_decode($res, true);
    if($res['errcode'] == 0){
        $aes = new Crypt();
        $aes->set_key($iv);
        $aes->set_iv($iv);
        $aes->require_pkcs5();
        $access_token = trim($aes->decrypt($res['access_token']));
        if($access_token){
            return $access_token;
        }
    }
    return false;
}

function createNonceStr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
}
?>