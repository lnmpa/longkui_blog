<?php
namespace Mall\Controller;
use Common\Controller\HomebaseController;

class HomeController extends HomebaseController {
	
	/* 空操作，用于输出404页面 */
	public function _empty(){
		$this->redirect('Index/index');
	}
	
	public function __construct() {
		parent::__construct();
	}
	
	function _initialize() {
		parent::_initialize();
		header("Content-type: text/html; charset=utf-8");
		$nav = M('Nav')->where(array('cid'=>1,'parentid'=>0,'status'=>1))->order('listorder asc')->select();
		foreach ($nav as $key=>$val){
			$nav[$key]['href'] = sp_get_nav_url($val['href'],array('nid'=>$val['id']));
			$data = null;
			$sub_nav[$val['id']] = M('Nav')->where(array('cid'=>1,'parentid'=>$val['id'],'status'=>1))->order('listorder asc')->select();
			foreach ($sub_nav[$val['id']] as $k=>$v){
				$url = sp_get_nav_url($val['href'],array('nid'=>$val['id']));
				$sub_nav[$val['id']][$k]['href'] = $url;
			}
		}
		$this->assign('nav',$nav);
		$this->assign('sub_nav',$sub_nav);
		$nav_id = I('nid');
		if(!empty($nav_id)){
			$this->assign('location',$this->location($nav_id));
			$this->assign('nid',$nav_id);
		}
		$option =D('Common/Options')->where("option_name='contact_setting'")->getField('option_value');
		$options = json_decode($option,true);
		$this->assign('options',$options);
		
		$cateList = M('MallCate')->where(array('pid'=>0,'status'=>1))->select();
		$this->assign('cateList',$cateList);
	}
	
	/**
	 * 检查用户登录 ##重写
	 */
	protected function check_login($arr){
		if(!in_array(ACTION_NAME, $arr)){
			$session_user=session('user');
			if(empty($session_user)){
				//redirect(leuu('Login/index',array('redirect'=>base64_encode($_SERVER['PHP_SELF']))));
				$this->error('您还没有登录！',leuu('Login/index',array('redirect'=>base64_encode($_SERVER['PHP_SELF']))),0);
			}
		}
	
	}
	
	function location($nav_id,$cid = 1){
		$data=array();
		$location='<a href="'.U('Index/index').'">首页</a>';
		$nav_mod = M('nav');
		$nav_info = $nav_mod->field('id,label,parentid,path,href')->where(array('id'=>$nav_id,'cid'=>$cid,'status'=>1))->find();
		if($nav_info)
		{
			$cate_id_arr=explode('-', $nav_info['path']);
			
			foreach($cate_id_arr as $key=>$val)
			{
				if($key>0)
				{
					$data[$key] = $info = $nav_mod->field('id,label,href')->where(array('id'=>$val,'cid'=>$cid,'status'=>1))->find();
					$location.='&nbsp;&gt;&nbsp;<a href="'.U($info['href'],array('nid'=>$val)).'">'.$info['label'].'</a>';
 				}
			}
		}
		$leftList = $nav_mod->field('id,label,parentid,path,href')->where(array('parentid'=>$nav_info['parentid']))->select();
		foreach ($leftList as $k=>$v){
			$leftList[$k]['href'] = sp_get_nav_url($val['href'],array('nid'=>$val['id']));
		}
		$local[0]=$data;
		$local[1]=$location;
		$local[2]=$nav_info;
		$local[3]=$leftList;
		return $local;
	}
}