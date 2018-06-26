<?php
namespace Home\Controller;
use Think\Controller;
use Think\Think;
 session('openid','ocrzDjpdSyStJOLldZiiwNirAKjQ');
class IndexController extends Controller
{
    protected $appid ='wx61c03ce66f14b0c3';
    public function index(){
        $openid = session('openid');
        if(!$openid){
            $url = "http://campaign.laneige.com/Silkintense2018_new/index/getcode";
            if($_GET['smtid']){
                $url .= "?smtid=".$_GET['smtid'];
            }else{
                if($_GET['smt_cp']) $url .= "?smt_cp=".$_GET['smt_cp'];
                if($_GET['smt_pl']) $url .= "&smt_pl=".$_GET['smt_pl'];
                if($_GET['smt_md']) $url .= "&smt_md=".$_GET['smt_md'];
            }
            $url = "http://api.weq.me/wx/authorize.php?id=15144605209907&scope=snsapi_base&redirect_uri=".urlencode($url);
            redirect($url);
        }else{

                session('openid', session('openid'));

        }

        $list = M('city')->select();
        $sql="select  *, count(distinct province) from laneige_silkintense2018f_city  group by province";
        $result = M('city')->query($sql);
        $this->assign('list1',$result);
        $this->assign('list',$list);

        $openid = session('openid');
        $userinfo = json_encode(array("openid"=>$openid));
        $this->assign(openid, $userinfo);
        $this->getShareInfo();
        $this->display('index');

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
        if($insert_id){
            // $this->sendsms($phone);
            $this->ajaxReturn(array('status'=>'1','msg'=>'success' ));
        }
        else{
            $this->ajaxReturn(array('status'=>'0','msg'=>'data error'));
        }

    }



    public function getcode(){
        if(I('get.openid')){
            session('openid', I('get.openid'));
            $url = 'http://campaign.laneige.com/Silkintense2018_new/';
            if($_GET['smtid']){
                $url .= "?smtid=".$_GET['smtid'];
            }else{
                if($_GET['smt_cp']) $url .= "?smt_cp=".$_GET['smt_cp'];
                if($_GET['smt_pl']) $url .= "&smt_pl=".$_GET['smt_pl'];
                if($_GET['smt_md']) $url .= "&smt_md=".$_GET['smt_md'];
            }
            redirect($url);
        }
    }


    protected function getShareInfo(){
        $is_weixin = is_weixin();
        $host = "http://" . $_SERVER['HTTP_HOST'];

            $uri = $_SERVER['REQUEST_URI'];
            $url = "http://" . $_SERVER['HTTP_HOST'].$uri;
            $signPackage = getSign($url, '15131578769769', 'h0aeMdAMN9aNmezJ', $this->appid);
            $this->assign('signPackage', $signPackage);

        $this->assign('host', $host);
        $this->assign('is_weixin', $is_weixin);
    }





    // 短信接口
    public function  sendsms($phone){
        $openid=session('openid');
        $data['mobile']=$phone;
        $data['FormatID']='40';
        $data['Content']='【兰芝】感谢参与活动，恭喜您成功预约专属唇膏刻字服务，XX期间至XX柜台，凭此短信定制您的专属唇膏。兰芝绝色丝润唇膏，一抹丝润，绝色当红，欢迎到柜体验！';
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










    public function get_access_token(){
        $token = get_token( '15131578769769', 'h0aeMdAMN9aNmezJ');
        print_R($token);
        return $token;
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




    public function test(){

        echo "1234";
    }






}



?>