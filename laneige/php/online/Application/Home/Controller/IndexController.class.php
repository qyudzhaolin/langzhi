<?php
namespace Home\Controller;
use Think\Controller;
use Think\Think;
  //session('fans','ocrzDjpdSyStJOLldZiiwNirAKjQ');
class IndexController extends Controller
{
    public  $appid=15144605209907;//appid
    public  $key = 'abcdefghjkabcdef';//key
    public     $domain = "http://campaign.laneige.com/Silkintense2018_new/";
    protected $cipher     = MCRYPT_RIJNDAEL_128;
    protected $mode       = MCRYPT_MODE_CBC;
    protected $pad_method = NULL;
    protected $secret_key = '';
    public    $iv            = 'h0aeMdAMN9aNmezJ';

   
   public function index(){
      // 短信接口
    


           $openid = session('openid');
          if($this->is_weixin()) {
            if (empty($openid)) {
                $auth_url ="http://api.weq.me/wx/authorize.php?id=15144605209907&scope=snsapi_base&redirect_uri=".urlencode("http://campaign.laneige.com/Silkintense2018_new/");
                redirect($auth_url);
            }

            //分享Code
        }
        $this->getShareInfo();
        if ($openid) {
//            $fans = M('Fans')->find($fans_id);
            $fans['openid'] = $openid;
        }

        $list = M('city')->select();
        $sql="select  *, count(distinct province) from laneige_silkintense2018f_city  group by province";
        $result = M('city')->query($sql);
        $this->assign('list1',$result);
        $this->assign('list',$list);
        $this->assign('userinfo',json_encode($fans));
        $this->display('index');
        

    }

public function  sendsms($phone,$activetime,$counter){
        $openid=session('openid');
        $data['mobile']=$phone;
        $data['FormatID']='40';
       $data['Content']='感谢参与活动，恭喜您成功预约专属唇膏刻字服务，'.$activetime.'期间至'.$counter.'柜台，凭此短信定制您的专属唇膏。兰芝绝色丝润唇膏，一抹丝润，绝色当红，欢迎到柜体验！';
        $data['ScheduleDate']='2017-10-10';
        $data['TokenID']='7106088330600534';
        $info = http_build_query($data);
        $url = "http://www.wemediacn.net/webservice/smsservice.asmx/SendSMS";

        $status =sub_curl($url,$info,1);
        $where['openid']=$openid;
        $where['phone']=$phone;
        $where['status']=$status;
        $insert=M('sms')->add($where);
        if($insert){return 1;
        }
        else{
            return 0;
        }

    }
     public function saveInfo()
    {
        $data['province']=I('province');
        $data['city']=I('city');
        $data['phone']=I('phone');
        $data['cdate']=date('Y-m-d H:i:s');
        $data['counter']=I('shop');
        $insert_id=M('Info')->add($data);
        $phone=I('phone');
         $city=I('city');
        if($insert_id){

         $counter = M('city')->where("id=".$insert_id)->getField('counter');
         $activetime = M('city')->where("id=".$insert_id)->getField('activetime');
         $this->sendsms($phone,$activetime,$counter);
            $this->ajaxReturn(array('status'=>'1','msg'=>'success','id'=>$insert_id));

        
            
        }
        else{
            $this->ajaxReturn(array('status'=>'0','msg'=>'data error'));
        }
     
    }
    //获取签名
    public function getSignPackage()
    {
        $appid=15144605209907;
        $url = "http://campaign.laneige.com/Silkintense2018_new/";
        $checkres = $this->checkAppidAuth($appid);
        $url = urldecode($url);
        if (empty($url) || empty($appid) || empty($checkres)) {
            $arr['errcode'] = 0;
            $arr['errmsg'] = '参数错误 或 该公众号未授权到平台';
        }else{
            $signPackage = $this->getsignFromWx($appid,$url);
            if ($signPackage) {
                $arr = $signPackage;
                $arr['errcode'] = 0;
                $arr['errmsg'] = 'OK';
            } else {
                $arr['errcode'] = 0;
                $arr['errmsg'] = '请检查参数是否正确';
            }
        }
        return json_decode($arr);
    }

    
    function create_noncestr($length = 16) {
    $chars = "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789";
    $str = "";
    for ($i = 0; $i < $length; $i++) {
        $str .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
    }
    return $str;
    }
    public function getsignFromWx($appid,$url) {
        $key = 'abcdefghjkabcdef';
        $auth_url = "http://api.weq.me/wx/token.php?id={$appid}&key={$key}";
        $data = array();
        $data = $this->sub_curl($auth_url,$postdata,1);
        $signPackage = json_decode($data, true);
        $rt=$signPackage['jsapi_ticket']; 
     
        $this->set_key('abcdefghjkabcdef');
        $this->set_iv('h0aeMdAMN9aNmezJ');
        $this->require_pkcs5();

        $jsapiTicket = $this->decrypt($rt);

        $timestamp = time ();
        $nonceStr =  $this->create_noncestr($length = 16);
        // 这里参数的顺序要按照 key 值 ASCII 码升序排序
        $string = "jsapi_ticket=$jsapiTicket&noncestr=$nonceStr&timestamp=$timestamp&url=$url";
        $signature = sha1 ( $string );
        $signPackage = array (
            "appId" => $appid,
            "nonceStr" => $nonceStr,
            "timestamp" => $timestamp,
            "url" => $url,
            "signature" => $signature,
            "rawString" => $string
        );
        return $signPackage;
    }

    public function set_cipher($cipher)
    {
        $this->cipher = $cipher; 
    }
 
    public function set_mode($mode)
    {
        $this->mode = $mode;
    }
 
    public function set_iv($iv)
    {
        $this->iv = $iv;
    }
 
    public function set_key($key)
    {
        $this->secret_key = $key;
    }
 
    public function require_pkcs5()
    {
        $this->pad_method = 'pkcs5';
    }
 
    protected function pad_or_unpad($str, $ext)
    {
        if ( is_null($this->pad_method) )
        {
            return $str;
        }
        else 
        {
            $func_name = __CLASS__ . '::' . $this->pad_method . '_' . $ext . 'pad';
            if ( is_callable($func_name) )
            {
                $size = mcrypt_get_block_size($this->cipher, $this->mode);
                return call_user_func($func_name, $str, $size);
            }
        }
 
        return $str; 
    }
 
    protected function pad($str)
    {
        return $this->pad_or_unpad($str, ''); 
    }
 
    protected function unpad($str)
    {
        return $this->pad_or_unpad($str, 'un'); 
    }
 
 
    public function encrypt($str)
    {
        $str = $this->pad($str);
        $td = mcrypt_module_open($this->cipher, '', $this->mode, '');
 
        if ( empty($this->iv) )
        {
            $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        }
        else
        {
            $iv = $this->iv;
        }
        mcrypt_generic_init($td, $this->secret_key, $iv);
        $cyper_text = mcrypt_generic($td, $str);
        $rt = base64_encode($cyper_text);
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
 
        return $rt;
    }
 
 
    public function decrypt($str){
        $td = mcrypt_module_open($this->cipher, '', $this->mode, '');
 
        if ( empty($this->iv) )
        {
            $iv = @mcrypt_create_iv(mcrypt_enc_get_iv_size($td), MCRYPT_RAND);
        }
        else
        {
            $iv = $this->iv;
        }
 
        mcrypt_generic_init($td, $this->secret_key, $iv);
        $decrypted_text = mdecrypt_generic($td, base64_decode($str));
        $rt = $decrypted_text;
        mcrypt_generic_deinit($td);
        mcrypt_module_close($td);
 
        return $this->unpad($rt);
    }
 
    public static function pkcs5_pad($text, $blocksize)
    {
        $pad = $blocksize - (strlen($text) % $blocksize);
        return $text . str_repeat(chr($pad), $pad);
    }
 
    public static function pkcs5_unpad($text)
    {
        $pad = ord($text{strlen($text) - 1});
        if ($pad > strlen($text)) return false;
        if (strspn($text, chr($pad), strlen($text) - $pad) != $pad) return false;
        return substr($text, 0, -1 * $pad);
    }
   
    public function getcode(){
        $data = I('get.');
        print_r($data);
        $openid = $data['openid'];
        if($openid){
            session('openid',$openid);
            $this->redirect('index/index');
        }else{
            echo 'error';exit;
        }
    }
   public function share(){
        $this->getShareInfo();
        $id = intval(I('id'));
        $info = M('info')->find($id);
        $this->assign('info',$info);
        $this->display('share');
        

    }
  
   

    

    public function clear(){
        dump(session('fans_id'));
        session('fans_id',null);
        dump(session('fans_id'));
    }


    public  function cardurl(){
        $province_list=M('store');
        $list=$province_list->distinct(true)->field('city')->order('city DESC')->select();
        $this->assign('List',$list);
        $this->display('url');

    }

    /**
     * 分享
     */

    public function getShareInfo()
    {
        $is_weixin = 1;//$this->is_weixin();
        $url = "http://" . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
//        echo $url;
        if ($is_weixin) {
            $signPackage = $this->getSignPackage($url);
            //dump($signPackage);
            $this->assign('signPackage', $signPackage);

        }
    }



    



    /*public function getCode()
    {
        $data=$_GET;

         session('fans',$data);
        // $openid = I('get.openid');
        // if ($openid) {
        //     session('openid', $openid);
        // } else {
        //     $this->auth2();
        // }

        $this->redirect('index/index');
    }*/
    protected function is_weixin()
    {
        if (strpos($_SERVER['HTTP_USER_AGENT'], 'MicroMessenger') == true) {
            return true;
        }
        return false;
    }
    //curl操作
    protected function sub_curl($url, $data = array(), $is_post = 1)
    {
        $ch = curl_init();
        if (!$is_post)//get 请求
        {
            $url = $url . '?' . http_build_query($data);
        }
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, $is_post);
        if ($is_post) {
            curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        }
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, 10);
        $info = curl_exec($ch);
        $code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);
        return $info;
    }



 



 










}
  


 ?>