<?php
namespace Silkintense2018\Controller;
use Think\Controller;
use Think\Think;
use Think\Crypt;

class IndexController extends Controller {
    protected $appid = 'wx61c03ce66f14b0c3';
    protected $card_id = "pkGCUjgvQXeaj5hjMIhC3z7MLeP8";
    
    public function index(){
        if(!session('openid') && !$_GET['openid']){
            $url = "http://api.weq.me/wx/authorize.php?id=15132409756023&scope=snsapi_base&redirect_uri=".urlencode("http://campaign.laneige.com/Silkintense2018/");
            redirect($url);
        }else{
            if(I('get.openid')){
                session('openid', I('get.openid'));
            }
        }
        $openid = session('openid');
        $userinfo = json_encode(array("openid"=>$openid));
        $this->assign('userinfo', $userinfo);
        $this->getShareInfo();
        $this->display('index');
    }

    protected function getShareInfo(){
        $is_weixin = is_weixin();
        $host = "http://" . $_SERVER['HTTP_HOST'];
        if($is_weixin) {
            $uri = $_SERVER['REQUEST_URI'];
            $url = "http://" . $_SERVER['HTTP_HOST'].$uri;
            $signPackage = getSign($url, '15132409756023', 'NobvkKm4e3i1vuNj', $this->appid);
            $this->assign('signPackage', $signPackage);
        }
        $this->assign('host', $host);
        $this->assign('is_weixin', $is_weixin);
    }

    /**
     * 保存基本信息
     */
    public function saveInfo(){
        if(IS_POST){
            //基本数据校验
            $data['phone'] = trim(I('post.phone'));
            $data['city'] = trim(I('post.city'));
            if(!$data['phone']) $this->ajaxReturn(array('status'=>0, 'msg'=>'请填写您的联系方式！'));
            if(!$data['city']) $this->ajaxReturn(array('status'=>0, 'msg'=>'请选择城市！'));
            
            $openid = session('openid');
            //判断手机号是否已经使用
            $draw_model = M('Info');
            $is_phone_have = $draw_model->where(array("phone"=>$data['phone']))->count();
            if($is_phone_have){
                $this->ajaxReturn(array('status'=>0, 'msg'=>'该手机号已申领！', 'playnum'=>2));
            }
            
            $is_openid_have = $draw_model->where(array("openid"=>$openid))->count();
            if($is_openid_have){
                $this->ajaxReturn(array('status'=>0, 'msg'=>'该微信号已申领！', 'playnum'=>2));
            }
            
            $data['openid'] = $openid;
            $data['cdate'] = date('Y-m-d H:i:s');
            $ret = $draw_model->add($data);
            if($ret){
                $url = "http://" . $_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
                $card_ticket = get_api_ticket($url, '15131578769769', 'Nc0sQ19GhWbsK94O', $this->appid);
                $timestamp = time();
                $nonceStr = createNonceStr();
                $card_arr = array(
                    'api_ticket'=>$card_ticket,
                    'nonce_str'=>$nonceStr,
                    'timestamp'=>$timestamp,
                    'card_id'=>$this->card_id,
                );
                sort($card_arr,SORT_STRING);
                $signature = sha1(implode($card_arr));
                $card_ext = "{\"code\":\"\",\"openid\":\"\",\"timestamp\":\"{$timestamp}\",\"nonce_str\":\"{$nonceStr}\",\"signature\":\"{$signature}\"}";
                $this->ajaxReturn(array('status'=>1,'card_ext'=>$card_ext, 'card_id'=>$this->card_id));
            }
            $this->ajaxReturn(array('status'=>0, 'msg'=>'提交失败，请稍后再试！'));
        }
    }
    
    public function getshop(){
        if(IS_POST){
            $lat = I('post.lat');
            $lng = I('post.lng');
    
            $sql="SELECT *,
            ROUND(6378.138*2*ASIN(SQRT(POW(SIN(($lng*PI()/180-latitude*PI()/180)/2),2)+COS($lng*PI()/180)*COS(latitude*PI()/180)*POW(SIN(($lat*PI()/180-longitude*PI()/180)/2),2)))*1000)
            AS juli
            FROM laneige_perfectrenew2018_city HAVING juli<20000
            ORDER BY juli asc limit 1";
            $list = M('City')->query($sql);
            if($list){
                $this->ajaxReturn(array('status'=>1,'city'=>$list[0]['city']));
            }
            $this->ajaxReturn(array('status'=>0));
        }
    }

    public function get_success(){
        $openid = session('openid');
        $data['is_get'] = 1;
        $data['udate'] = date("Y-m-d H:i:s");
        M('Info')->where("openid='$openid'")->save($data);
    }

    public function get_access_token(){
        $token = get_token('15132409756023', 'NobvkKm4e3i1vuNj');
        
        print_R($token);
        return $token;
    }
    
    
    public function test(){
        $url = 'https://api.weixin.qq.com/card/selfconsumecell/set?access_token=' . $this->get_access_token();
        $data = array(
            'card_id'            => $this->card_id,
            'is_open'            => true,
            //'need_verify_cod'    => false
        );
        $param = $this->json_encode($data);
        $res = $this->httpPost($url, $param);
        var_dump($res);
    }
    
    //获取店铺列表
    public function getpoilist(){
        $url = 'https://api.weixin.qq.com/cgi-bin/poi/getpoilist?access_token='.$this->get_access_token();
        $num = 50;
        $poi_list = array();
        for ($i = 0; $i < 10; $i++) {
            $begin = $i*$num;
            $param = array("begin"=>$begin, "limit"=>100);
            $result = $this->post_data ( $url, $param );
            foreach ($result['business_list'] as $row) {
                array_push($poi_list, $row);
            }
        }
        
        print_r($poi_list);die();
        return $poi_list;
    }
    
    function post_data($url, $param, $is_file = false, $return_array = true) {
    	set_time_limit ( 0 );
    	if (! $is_file && is_array ( $param )) {
    		$param = json_encode ( $param );
    	}
    	
    	if ($is_file) {
    		$header [] = "content-type: multipart/form-data; charset=UTF-8";
    	} else {
    		$header [] = "content-type: application/json; charset=UTF-8";
    	}
    	$ch = curl_init ();
    	if (class_exists ( '/CURLFile' )) { // php5.5跟php5.6中的CURLOPT_SAFE_UPLOAD的默认值不同
    		curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, true );
    	} else {
    		if (defined ( 'CURLOPT_SAFE_UPLOAD' )) {
    			curl_setopt ( $ch, CURLOPT_SAFE_UPLOAD, false );
    		}
    	}
    	curl_setopt ( $ch, CURLOPT_URL, $url );
    	curl_setopt ( $ch, CURLOPT_CUSTOMREQUEST, "POST" );
    	curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
    	curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
    	curl_setopt ( $ch, CURLOPT_HTTPHEADER, $header );
    	curl_setopt ( $ch, CURLOPT_USERAGENT, 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
    	curl_setopt ( $ch, CURLOPT_FOLLOWLOCATION, 1 );
    	curl_setopt ( $ch, CURLOPT_AUTOREFERER, 1 );
    	curl_setopt ( $ch, CURLOPT_POSTFIELDS, $param );
    	curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, true );
    	$res = curl_exec ( $ch );
    	$flat = curl_errno ( $ch );
    	if ($flat) {
    		$data = curl_error ( $ch );
    	}
    	
    	curl_close ( $ch );
    	
    	$return_array && $res = json_decode ( $res, true );
    	
    	return $res;
    }
    
    public function httpPost($url, $data) {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, TRUE);
        curl_setopt($ch, CURLOPT_HEADER, FALSE);
        curl_setopt($ch, CURLOPT_POST, TRUE);
        if (is_array($data)) {
            foreach ($data as &$value) {
                if (is_string($value) && stripos($value, '@') === 0 && class_exists('CURLFile', FALSE)) {
                    $value = new \CURLFile(realpath(trim($value, '@')));
                }
            }
        }
        curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
        $data = curl_exec($ch);
        curl_close($ch);
        if ($data) {
            return $data;
        }
        return false;
    }
    
    public function json_encode($array) {
        return preg_replace_callback('/\\\\u([0-9a-f]{4})/i', create_function('$matches', 'return mb_convert_encoding(pack("H*", $matches[1]), "UTF-8", "UCS-2BE");'), json_encode($array));
    }
}
