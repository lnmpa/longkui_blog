<?php
namespace Common\Model;
use Common\Model\CommonModel;
class SlideModel extends  CommonModel{
	
	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('slide_name', 'require', '名称不能为空！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
	);
	
	protected $_auto = array (
	    array ('slide_pic', 'sp_asset_relative_url', self::MODEL_BOTH, 'function'),
	);
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
	}
	
	protected function _after_select(&$resultSet,$options){
		parent::_after_select($resultSet,$options);
		foreach ($resultSet as $key=>$val){
			$resultSet[$key]['img'] = sp_get_image_url($val['slide_pic']);
			$resultSet[$key]['mimg'] = sp_get_image_url($val['slide_middle_pic']);
			$resultSet[$key]['bimg'] = sp_get_image_url($val['slide_big_pic']);
			$resultSet[$key]['url'] = sp_get_nav_url($val['slide_url']);
		}
		$this->data     =   $resultSet;
	}
	
	protected function _after_find(&$result,$options){
		parent::_after_find($result,$options);
		$result['img'] = sp_get_image_url($result['slide_pic']);
		$result['mimg'] = sp_get_image_url($result['slide_middle_pic']);
		$result['bimg'] = sp_get_image_url($result['slide_big_pic']);
		$result['url'] = sp_get_nav_url($result['slide_url']);
		$this->data     =   $result;
	}
}