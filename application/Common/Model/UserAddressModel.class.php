<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model;
class UserAddressModel extends Model {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			array('uid', 'require', '用户ID不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		array('area_ids', 'require', '所在地区不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		array('address', 'require', '详细地址不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		array('name', 'require', '联系人不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		array('mobile', 'require', '手机号码不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		array('mobile', '/^(((13[0-9]{1})|(15[0-9]{1})|(18[0-9]{1}))+\d{8})$/', '手机号码格式不正确！', 1,'regex', self:: MODEL_BOTH),
    		array('zip_code', 'require', '邮政编码不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    );
    //自动完成
    protected $_auto = array(
            //array(填充字段,填充内容,填充条件,附加规则)
    	array('update_time','update_time',3,'callback'),
    	array('create_time','update_time',1,'callback'),
    	array('status','1',1),
    );
    
    function update_time(){
    	return date('Y-m-d H:i:s',time());
    }
    
    
}