<?php
namespace Silkintense2018\Controller;
use Think\Controller;
use Think\Think;

class CommonController extends Controller {
    public function __construct() {
        parent::__construct();
		if($this->checklogin==true){
			$this->checkaccess();
		}
        $this->assign('controller_name', CONTROLLER_NAME);
        $this->assign('action_name', ACTION_NAME);
        $this->assign('module_name', MODULE_NAME);
    }
    
    public function checkaccess(){
        if(session('uid')){
            return true;
        }else{
            $this->redirect("/Silkintense2018/Login/index");
        }
    }
    
}