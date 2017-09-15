<?php
namespace Index\Controller;

class PublicController extends HomeController {
	
	function _initialize() {
		parent::_initialize();
		
	}
	
    public function son(){
    	$nid = I('nid');
    	$data = M('Nav')->where(array('cid'=>1,'parentid'=>$nid,'status'=>1))->order('listorder asc')->find();
    	$url = sp_get_nav_url($data['href'],array('nid'=>$data['id']));
    	header("Location:".$url);
    }
    
    public function son2(){
    	$nid = I('nid');
    	$data = M('Nav')->where(array('cid'=>1,'parentid'=>$nid,'status'=>1))->order('listorder asc')->find();
    	$info   =  parse_url($data['href']);
    	$url    =  $info['path'];
    	$url = sp_get_nav_url($url,array('nid'=>$data['id']));
    	header("Location:".$url);
    }

    
}