<?php
namespace Mall\Controller;

class PublicController extends HomeController {
	
	function _initialize() {
		parent::_initialize();
		
	}
	
	public function son(){
    	$nav_id = I('nid');
    	$data = M('Nav')->where(array('parentid'=>$nav_id))->order('listorder asc')->find();
    	$url = sp_get_nav_url($data['href'],array('nid'=>$data['id']));
    	header("Location:".$url);
    }
    
}