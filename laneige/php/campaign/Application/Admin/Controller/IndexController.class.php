<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Think;

class IndexController extends CommonController {
	public $checklogin = true;
	private $pagesize = 20;
    public function index(){
        $model = M('Info');
        $search = I('');
        $map = $this->searchformat($search);
        $map['is_del'] = 0;
		$count = $model->where($map)->count();
        $Page = new \Think\Page($count,$this->pagesize);
        $list = $model->where($map)->limit($Page->firstRow.','.$Page->listRows)->order('id desc')->select();
        $Page->parameter = $search;
        $show = $Page->show();
        $this->assign('search',$search);
        $this->assign('list',$list);
        $this->assign('page',$show);
        $this->display('index');
    }
    
    public function set(){
        $info = M("Set")->find();
        $this->assign('info', $info);
        $this->display();
    }

    public function set_save(){
        $data['sms'] = I("post.sms");
        $data['share_title'] = I("post.share_title");
        $data['share_desc'] = I("post.share_desc");
        $data['share_img'] = I("post.share_img");
        $data['share_title_time'] = I("post.share_title_time");
        
        $info = M("Set")->find();
        if($info){
            $data['udate'] = date('Y-m-d H:i:s');
            $id = M("Set")->where("id=".$info['id'])->save($data);
        }else{
            $data['cdate'] = date('Y-m-d H:i:s');
            $id = M("Set")->add($data);
        }
       
        if($id){
            $this->ajaxReturn(array('status'=>1));
        }
        $this->ajaxReturn(array('status'=>0));
    }


    protected function searchformat($search){
        $name = trim($search['name']);
        if($name){
            $map['name'] = array('like','%'.$name.'%');
        }
        $phone = trim($search['phone']);
        if($phone){
            $map['phone'] = array('like','%'.$phone.'%');
        }
        $sdate = trim($search['start_time']);
        $edate = trim($search['end_time']);
        if($sdate && $edate){
//            $edate = $edate + 86399;
            $map['cdate'] = array('between',array($sdate.' 00:00:00',$edate.' 23:59:59'));
        }elseif($sdate){
            $map['cdate'] = array('gt',$sdate.' 00:00:00');
        }elseif($edate){
            $map['cdate'] = array('lt',$edate.' 23:59:59');
        }
        $type = I('type');
        if(is_numeric($type)){
            $map['type'] = $type;
        }
        return  $map;
    }


    public function export(){
        //导入PHPExcel类库，因为PHPExcel没有用命名空间，只能inport导入
        $search = I('');
        $map = $this->searchformat($search);
		$map['is_del'] = 0;
        $lists = M('Info')->where($map)->order('id desc')->select();
        $header = array(
            'phone'=>'电话',
            'city'=>'城市',
            'shop'=>'专柜',
            'type'=>'类型',
            'cdate'=>'时间'
        );
        $this->outPut($lists,$header);
    }
    protected function outPut($list=array(),$headtitle=array()){
        //dump($list);exit;
        $header = implode("\",\"",array_values($headtitle));
        $header = "\"" .$header;
        $header .= "\"\r\n";
        $content .= $header;
        $filename = 'Laneige_'.date('YmdHis').'.csv';
        ob_end_clean();
        header("Expires: ".gmdate("D, d M Y H:i:s")." GMT");
        header("Last-Modified: ".gmdate("D, d M Y H:i:s")." GMT");
        header("X-DNS-Prefetch-Control: off");
        header("Cache-Control: private, no-cache, must-revalidate, post-check=0, pre-check=0");
        header("Pragma: no-cache");
        header("Content-Type: application/octet-stream");
        header("Content-Type: application/force-download");
        header("Content-Disposition: attachment; filename=".$filename);
        $content=iconv("UTF-8","GBK//IGNORE",$content) ;
        echo $content;
        foreach($list as $row)
        {
            if($row['type']==2){
                $row['type'] = '预约试妆';
            }
            if($row['type']==1){
                $row['type'] = '免费申领';
            }
            $new_arr = array();
            $content = "";
            foreach ($headtitle as $key1 => $value)
            {
                array_push($new_arr, preg_replace("/\"/","\"\"","\t".$row[$key1]));
            }
            $line = implode("\",\"",$new_arr);
            $line = "\"" .$line;
            $line .= "\"\r\n";
            $content .= $line;
            $content=@iconv("UTF-8","GBK//IGNORE",$content) ;
            echo $content;
        }
    }
    
    
}