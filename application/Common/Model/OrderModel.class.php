<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model;
class OrderModel extends Model {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
			//array('uid', 'require', '用户ID不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		//array('return_money', 'require', '退款金额不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		//array('return_money', 'is_numeric', '退款金额是一个数字！', 1, 'function', self:: MODEL_BOTH ),
    		//array('remark', 'require', '退款说明不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    		//array('pack_id', 'require', '订单产品不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    );
    //自动完成
    protected $_auto = array(
            //array(填充字段,填充内容,填充条件,附加规则)
    	//array('update_time','update_time',3,'callback'),
    	//array('add_time','update_time',1,'callback'),
    	//array('step_id','1',1),
    );
    
    function update_time(){
    	return date('Y-m-d H:i:s',time());
    }
    

    public function get_status_info($status){
    	switch ($status){
    		case -1:
    			$info = "订单删除";
    			break;
    		case 0:
    			$info = "<font color='#dd2727'>订单关闭</font>";
    			break;
    		case 1:
    			$info = "<font color='#dd2727'>待付款</font>";
    			break;
    		case 2:
    			$info = "<font color='grey'>待发货</font>";
    			break;
    		case 3:
    			$info = "<font color='grey'>待收货</font>";
    			break;
    		case 4:
    			$info = "<font color='green'>已收货</font>";
    			break;
    	}
    	return $info;
    }
    
}