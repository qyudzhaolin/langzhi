<?php
namespace Perfectrenew2018\Controller;
use Think\Think;

class LoginController extends CommonController {
	public $checklogin = false;
    public function  index(){
        $this->display('Admin:login');
    }
    public function dologin(){
        C('DB_PREFIX','laneige_');
        $username = I('post.username');
        $password = I('post.password');
        $password = md5($password);
        $map['username'] = trim($username);
        $map['password'] = trim($password);
        $userinfo = M('User')->where($map)->find();

        if($userinfo){
            session('uid',$userinfo['id']);
            session('username',$userinfo['username']);
            $arr['code'] = 1;
            $arr['msg'] = '登陆成功';
        }else{
            session('uid','');
            $arr['code'] = 0;
            $arr['msg'] = '账号或密码有误';
        }
        $this->ajaxReturn($arr);
    }
    public function logout(){
        session(null);
        $this->redirect("/Perfectrenew2018/Login/index");
    }
}