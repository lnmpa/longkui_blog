<?php
namespace Common\Model;

use Common\Model\CommonModel;

class GuestbookModel extends CommonModel{
    
	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('full_name', 'require', '{%PLEASE_FILL_NAME}', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('email', 'require', '{%PLEASE_FILL_EMAIL}', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('email','email','{%EMAIL_ERROR}',0,'',CommonModel:: MODEL_BOTH ),
		array('phone', 'require', '{%PLEASE_FILL_TEL}', 1, 'regex', CommonModel:: MODEL_BOTH ),
		array('msg', 'require', '{%PLEASE_FILL_DESC}', 1, 'regex', CommonModel:: MODEL_BOTH ),
	    //array('tel', 'require', '{%PLEASE_FILL_TEL}', 1, 'regex', CommonModel:: MODEL_BOTH ),
	    //array('title', 'require', '{%PLEASE_FILL_PROBLEM}', 1, 'regex', CommonModel:: MODEL_BOTH ),
	);
	
	protected $_auto = array (
			array('createtime','mDate',1,'callback'), // 对msg字段在新增的时候回调htmlspecialchars方法
	);
	
	function mDate(){
		return date("Y-m-d H:i:s");
	}
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	
}