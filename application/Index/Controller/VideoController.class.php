<?php
namespace Index\Controller;

class VideoController extends HomeController {
	
    protected $VideoMod;
    protected $VideoViewMod;
    protected $VideoCateMod;
    protected $ignore_arr = array('index');
    
	function _initialize() {
		parent::_initialize();
		$this->check_login($this->ignore_arr);
		$this->VideoMod = D("Common/Video");
		$this->VideoViewMod = D("Common/VideoView");
		$this->VideoCateMod = D("Common/VideoCate");
		
		$cate_id = "132";
		$parent_cate =  M('ArticleCate')->field('name,name_en,img')->find($cate_id);
		$this->assign("parent_cate",$parent_cate);
	}

    public function index($cate_id = null){
    	if(!empty($cate_id)){
            $where['cate_id'] = $cate_id;
            $this->assign("cate_id",$cate_id);
        }
        
        $where['status'] = array('egt',1);
        
        $keywords = I('keywords');
        if(!empty($keywords)){
        	$where['title'] = array('like',"%$keywords%");
        	$this->assign("keywords",$keywords);
        }
        
        $this->VideoViewMod->where($where);
        
        $count=$this->VideoViewMod->count();
        
        $page = $this->page($count, 12);
        
        $this->VideoViewMod
        ->where($where)
        ->limit($page->firstRow , $page->listRows)
        ->field("id,title,subject_info,add_time,img,speaker,study_time")
        ->order("sort_order DESC");
         
        $list = $this->VideoViewMod->select();
        $this->assign("page", $page->show('default'));
    	$this->assign("page2", $page->show('mobile'));
        $this->assign("list",$list);
        
        $this->_getCateSelect($cate_id);
        
        $this->display();
    }
    
    public function video_detail(){
    	$id=I('request.id');
    	$show = $this->VideoViewMod->where(array('id'=>$id))->find();
    	//专辑列表
    	$album_list = $this->VideoViewMod->where(array('album'=>$show['album'],'cate_id'=>$show['cate_id'],'status'=>1))
    	->field('id,cate_id,title,speaker,study_time,img')
    	->order('rand() desc')
    	->limit(4)
    	->select();
    	$this->assign('album_list',$album_list);
    	
    	$this->assign("show",$show);
    	$this->display();
    }
    
    function video_play(){
    	header("Content-type:text/html;charset=utf-8");
    	$mod = D('Common/Video');
    	$id=I('id');
    	$video=$this->VideoViewMod->where(array('id'=>$id))->find();
    	$video['hits']++;
    	$mod->save($video);
    	 
    	session('video_id',$id);
    	$uid = sp_get_current_userid();
    	$data['id'] = $uid;
    	$data['sessionID'] = session_id();
    	$re = D('Common/Users')->save($data);
    	 
    	$video_time_mod = D('VideoTime');
    	$videoTime = $video_time_mod->where(array('uid'=>$uid,'video_id'=>$id))->find();
    	if(!$videoTime){
    		$videoTime = array();
    		$videoTime['uid'] = $uid;
    		$videoTime['video_id'] = $id;
    		$videoTime['add_time'] = date('Y-m-d H:i:s',NOW_TIME);
    		$video_time_mod->add($videoTime);
    		$videoTime['time'] = 0;
    	}
    	$video['historyTime'] = $videoTime['time'];
    	$video['historyMTime'] = floor($videoTime['time']/60);
    	 
    	//本地目录没有视频则到http://e.hongso.gov.cn/去找
    	if(!is_file (iconv("UTF-8","gb2312",$video['video']))){
    		$video['video'] = "http://e.hongso.gov.cn/".$video['video'];
    	}
    	$this->assign("video",$video);
    	$this->display();
    }
    
    function check_repeat(){
    	$video_id = I('video_id');
    	if($video_id != session('video_id')){
    		$this->ajaxReturn(1);
    		exit();
    	}
    	$uid = sp_get_current_userid();
    	$sessionID = D('Common/Users')->where(array('id'=>$uid))->getField('sessionID');
    	if($sessionID != session_id()){
    		$this->ajaxReturn(2);
    		exit();
    	}
    }
    
    function saveTime(){
    	header("Content-type:text/html;charset=utf-8");
    	$video_time_mod = D('VideoTime');
    	$video_mod = D('Common/Video');
    	$user_mod = D('Common/Users');
    	 
    	if(sp_get_current_userid()){
    		 
    		$uid = sp_get_current_userid();
    		$user = $user_mod->where(array("id"=>$uid))->find();
    		if(!$user){
    			$data['error'] = 2;
    			$data['flag'] = 2;
    			$this->ajaxReturn($data);
    			exit();
    		}
    
    		$vTime = I('vTime');
    		$video_id = I('video_id');
    		$video = $video_mod->where(array('id'=>$video_id))->find();
    		if(!$video){
    			$data['error'] = $video_mod->getLastSql();
    			$data['flag'] = 2;
    			$this->ajaxReturn($data);
    			exit();
    		}
    		$videoTime = $video_time_mod->where(array('uid'=>$uid,'video_id'=>$video_id))->find();
    		if(!$videoTime){
    			$videoTime = array();
    			$videoTime['uid'] = $uid;
    			$videoTime['video_id'] = $video_id;
    			if($vTime > 0){
    				$videoTime['time'] = $vTime;
    			}
    			if($videoTime['time'] > $video['video_time']*60){
    				$videoTime['isend'] = 1;
    			}
    			$videoTime['add_time'] = date('Y-m-d H:i:s',NOW_TIME);
    			$video_time_mod->add($videoTime);
    		}
    		else{
    			if($vTime > $videoTime['time']){
    				$videoTime['time'] = $vTime;
    			}
    			if($videoTime['isend'] != 1){
    				if($videoTime['time'] > $video['video_time']*60){
    					$videoTime['isend'] = 1;
    				}
    				$videoTime['add_time'] = date('Y-m-d H:i:s',NOW_TIME);
    			}
    			$result = $video_time_mod->save($videoTime);
    			if($result && $videoTime['isend']){
    
    				$video_score_mod = D('VideoScore');
    				$map['vt.uid'] = $uid;
    				$map['vt.isend'] = 1;
    				$now_year = date('Y',NOW_TIME);
    				$map['vt.add_time'] = array(array('egt',$now_year.'-01-01 00:00:00'),array('lt',($now_year+1).'-01-01 00:00:00'),'and');
    				$list = $video_time_mod
    				->alias('vt')
    				->field("v.study_time")
    				->where($map)
    				->join("join __VIDEO__ as v on vt.video_id = v.id")
    				->select();
    				
    				$info = array();
    				$info['uid'] = $uid;
    				$info['year'] = $now_year;
    				foreach ($list as $key=>$val){
    					$info['score'] += $val['study_time'];
    				}
    				$info['org_id'] = $user['org_id'];
    				$old_info = $video_score_mod->where(array('year'=>$now_year,'uid'=>$uid))->find();
    				if($old_info){
    					$info['id'] = $old_info['id'];
    					$video_score_mod->save($info);
    				}
    				else{
    					$video_score_mod->add($info);
    				}
    
    			}
    		}
    		$this->success('保存成功','',true);
    	}
    }
    
    private function _getCateSelect($cate_id){
    	$result = $this->VideoCateMod->where(array('status'=>1))->select();
    	$tree = new \Tree();
    	foreach ($result as $r) {
    		$r['selected'] = $r['id'] == $cate_id ? 'selected' : '';
    		$r['parentid'] = $r['pid'];
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$select_categorys = $tree->get_tree(0, $str);
    	$this->assign('cate_select',$select_categorys);
    	return $select_categorys;
    }
}