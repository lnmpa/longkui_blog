<?php
namespace Mall\Controller;
use Common\Api\AlipayApi;
use Common\Api\TenpayApi;
use Common\Api\YlpayApi;
use Vendor\WxPay\PayNotifyCallBack;
use Vendor\WxPay\CLogFileHandler;
use Vendor\WxPay\Log;

class ReturnPayController extends HomeController {
	
	protected $OrderMod;
	
	function _initialize() {
		parent::_initialize();
		$this->OrderMod = D('Common/Order');
	}
    
	function do_order($order_sn,$pay_type,$pay_json){
		$data['status'] = 2;
		$data['pay_type'] = $pay_type;
		$data['pay_json'] = $pay_json;
		
		$res = json_decode($pay_json,true);
		
		if($pay_type == 'alipay'){
			$data['pay_money'] = sprintf("%.2f", $res['total_fee']);
			$data['trade_no'] = $res['trade_no'];
		}
		if($pay_type == 'alipay_mobile'){
			$data['pay_money'] = sprintf("%.2f", $res['total_amount']);
			$data['trade_no'] = $res['trade_no'];
		}
		if($pay_type == 'wxpay'){
			$data['pay_money'] = sprintf("%.2f", $res['total_fee']/100);
			$data['trade_no'] = $res['transaction_id'];
		}
		if($pay_type == 'tenpay'){
			$data['pay_money'] = sprintf("%.2f", $res['total_fee']/100);
		}
		if($pay_type == 'ylpay'){
			$data['pay_money'] = sprintf("%.2f", $res['total_fee']/100);
			$data['trade_no'] = $res['queryId'];
		}
		
		$data['pay_time'] = date('Y-m-d H:i:s',time());
		$this->OrderMod->where(array('order_sn'=>$order_sn))->save($data);
	}
	
    function wxpay_notify_url(){
    	$ret = false;
    	$post=I('post.');
    	
    	$notify = new PayNotifyCallBack();
    	$result = $notify->Handle(true);
    	
    	if($result == "SUCCESS"){
    		$xml = $GLOBALS['HTTP_RAW_POST_DATA'];
    		$data = json_decode(json_encode(simplexml_load_string($xml, 'SimpleXMLElement', LIBXML_NOCDATA)),true);
    		
    		$this->do_order($data['out_trade_no'],'wxpay',json_encode($data));
    	}
    	 
    }
    
    /**
     * 支付宝后台通知页面
     */
    function alipay_notify_url(){
    	$post=I('post.');
    	$alipay=new AlipayApi(array());
    	$alipay_status=$alipay->verify_result();
    
    	if($alipay_status){//验证数据成功
    		if($post['trade_status'] == 'TRADE_FINISHED') {//交易完成(支付成功后，支付宝会再次发通知，交易完成，我只要交易成功后改变订单数据就行)
    			//不管
    		} else if ($post['trade_status'] == 'TRADE_SUCCESS') {//支付成功(支付成功后，支付宝会再次发通知，交易完成，我只要交易成功后改变订单数据就行)
    			$this->do_order($post['out_trade_no'],'alipay',json_encode($post));
    		}
    		$rel="success";		//请不要修改或删除
    	}else{
    		$rel="fail";        //请不要修改或删除
    	}
    
    	echo $rel;//请不要修改或删除
    }
    
    /**
     * 订单支付成功,跳转
     */
    function alipay_return_url(){
    	header("Location:".U('Mall/Order/index'));
    	/*$alipay=new AlipayApi(array());
    	if($alipay->verify_result(false)){
    		if ($_GET['trade_status'] == 'TRADE_SUCCESS'){
    			$this->success('支付成功!',U('Mall/Order/index'));
    		}else{
    			$this->error('支付失败!',U('Mall/Order/index'));
    		}
    	}else{
    		$this->error('验证签名失败!',U('Mall/Order/index'));
    	}*/
    }
    
    public function alipay_mobile_notify(){
    	$post=$_POST;
    	//M('Options')->add(array('option_name'=>time(),'option_value'=>json_encode($post)));
    	$pay = new AlipayApi();
    	$alipay_status = $pay->notify_verify();
    	
    	if($alipay_status){//验证数据成功
    		if($post['trade_status'] == 'TRADE_FINISHED') {//交易完成(支付成功后，支付宝会再次发通知，交易完成，我只要交易成功后改变订单数据就行)
    			//不管
    		} else if ($post['trade_status'] == 'TRADE_SUCCESS') {//支付成功(支付成功后，支付宝会再次发通知，交易完成，我只要交易成功后改变订单数据就行)
    			$this->do_order($post['out_trade_no'],'alipay_mobile',json_encode($post));
    		}
    		$rel="success";		//请不要修改或删除
    	}else{
    		$rel="fail";        //请不要修改或删除
    	}
    	
    	echo $rel;//请不要修改或删除
    }
    
    /**
     * 财付通后台通知页面
     */
    function tenpay_notify_url(){
    	$tenpay = new TenpayApi();
    	$data = $tenpay->notify_url();
    	if($data['status'] == 1){
    		$this->do_order($data['order_sn'],'tenpay',$data['pay_json']);
    		$rel = 'success';
    	}
    	else{
    		$rel = 'fail';
    	}
    	echo $rel;
    }
    
    /**
     * 订单支付成功,跳转
     */
    function tenpay_return_url(){
    	$tenpay = new TenpayApi();
    	$data = $tenpay->return_url();
    	if($data['status'] == 1){
    		$this->success("订单支付成功!",U('Mall/Order/index'));
    		//header("Location:".U('Mall/Order/index'));
    	}
    	else{
    		if(!$data['error']){
    			$this->error($data['error'],U('Mall/Order/index'));
    		}
    		else{
    			$this->error($data['info'],U('Mall/Order/index'));
    		}
    	}
    }
    
    /**
     * 财付通后台通知页面
     */
    function ylpay_notify_url(){
    	$data = $_POST;
    	if (isset ( $data ['signature'] )) {
    		$pay = new YlpayApi();
    		if($pay->validate($data)){
    			$this->do_order($data['orderId'],'ylpay',json_encode($data));
    			echo '验签成功';
    		}
    		else{
    			echo '验签失败';
    		}
    	
    	} else {
    		echo '签名为空';
    	}
    }
    
    /**
     * 订单支付成功,跳转
     */
    function ylpay_return_url(){
    	$pay = new YlpayApi();
    	$data = $_POST;
    	if($pay->validate($data)){
    		$this->success("订单支付成功!",U('Mall/Order/index'));
    		//header("Location:".U('Mall/Order/index'));
    	}
    	else{
    		$this->error("订单支付失败！",U('Mall/Order/index'));
    	}
    }
}