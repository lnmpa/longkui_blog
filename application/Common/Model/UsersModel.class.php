<?php
namespace Common\Model;
use Think\Model\RelationModel;
class UsersModel extends RelationModel
{
	
	protected $_validate = array(
		//array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
		array('user_login', 'require', '用户名称不能为空！', 1, 'regex', self:: MODEL_INSERT  ),
		array('user_nicename', 'require', '姓名不能为空！', 1, 'regex', self:: MODEL_INSERT  ),
		array('user_pass', 'require', '密码不能为空！', 1, 'regex', self:: MODEL_INSERT ),
		array('user_login', 'require', '用户名称不能为空！', 0, 'regex', self:: MODEL_UPDATE  ),
		array('user_pass', 'require', '密码不能为空！', 0, 'regex', self:: MODEL_UPDATE  ),
		array('user_login','','用户名已经存在！',0,'unique',self:: MODEL_BOTH ), // 验证user_login字段是否唯一
		//array('user_email','require','邮箱不能为空！',0,'regex',CommonModel:: MODEL_BOTH ), // 验证user_email字段是否唯一
		//array('user_email','','邮箱帐号已经存在！',0,'unique',self:: MODEL_BOTH ), // 验证user_email字段是否唯一
		//array('user_email','email','邮箱格式不正确！',0,'',self:: MODEL_BOTH ), // 验证user_email字段格式是否正确
	);
	
	protected $_auto = array(
	    array('create_time','mGetDate',self:: MODEL_INSERT,'callback'),
		array('update_time','mGetDate',self:: MODEL_BOTH,'callback'),
		array('user_status','1',self:: MODEL_INSERT),
	    array('birthday','',self::MODEL_UPDATE,'ignore')
	);
	
	protected $_link = array(
			'UsersInfo'=>array(
					'mapping_type'=>self::HAS_ONE,
					'foreign_key'   => 'id',
					'as_fields'=>'idcard,address'
			)
	);
	
	//用于获取时间，格式为2012-02-03 12:12:12,注意,方法不能为private
	function mGetDate() {
		return date('Y-m-d H:i:s');
	}
	
	protected function _before_write(&$data) {
		parent::_before_write($data);
		
		if(!empty($data['user_pass']) && strlen($data['user_pass'])<25){
			$data['user_pass']=sp_password($data['user_pass']);
		}
	}
}