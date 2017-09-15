<?php
namespace Common\Model;
use Common\Model\CommonModel;
class ApplyModel extends  CommonModel{
	
	//自动验证
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('name', 'require', '请输入您的姓名！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('sex', 'require', '请选择性别！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('education', 'require', '请选择学历！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('idcard', 'require', '请输入您的身份证号！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('mobile', 'require', '请输入您的手机号码！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
		array('email', 'require', '请输入您的E-mail！', self::MUST_VALIDATE, 'regex', self::MODEL_BOTH),
	);
	
	//自动完成
	protected $_auto = array(
			//array(填充字段,填充内容,填充条件,附加规则)
			array('add_time','add_time',3,'callback'),
	);
	
	function add_time(){
		return date('Y-m-d H:i:s',time());
	}
}