<?php
namespace Common\Api;
use Vendor\WxPay;
use Vendor\WxPay\WxPayUnifiedOrder;
use Vendor\WxPay\WxPayOrderQuery;
use Vendor\WxPay\JsApiPay;
use Vendor\WxPay\WxPayApi;

class WeixinpayApi{
	//在类初始化方法中，引入相关类库    
	public function _initialize() {
		header("Content-type:text/html;charset=utf-8");
    }
    
    public function doPay($parms){
    	
    	//商户订单号，商户网站订单系统中唯一订单号，必填
    	$out_trade_no = $parms['out_trade_no'];
    	
    	//订单名称，必填
    	$subject = $parms['subject'];
    	
    	//付款金额，必填
    	$total_fee = $parms['total_fee'];
    	
    	//商品描述，可空
    	$body = $parms['body'];
    	
    	$parameter = array(
    			"body"       	=> $body,//商品描述，可空
    			"attach"       	=> "商品",
    			"out_trade_no"  => $out_trade_no,//商户订单号，商户网站订单系统中唯一订单号，必填
    			"total_fee"     => $total_fee*100,//付款金额，必填
    			"time_start"	=> date("YmdHis"),
    			"time_expire"	=> date("YmdHis", time() + 600),
    			"goods_tag"		=> "商品",
    			"notify_url"	=> $parms['notify_url'],
    			"trade_type"	=> "NATIVE",
    			"product_id"	=> $subject,
    	);
    	
    	$notify = new WxPay();
    	$input = new WxPayUnifiedOrder();
    	$input->SetBody($parameter['body']);
    	$input->SetAttach($parameter['attach']);
    	$input->SetOut_trade_no($parameter['out_trade_no']);
    	$input->SetTotal_fee($parameter['total_fee']);
    	$input->SetTime_start($parameter['time_start']);
    	$input->SetTime_expire($parameter['time_expire']);
    	$input->SetGoods_tag($parameter['goods_tag']);
    	$input->SetNotify_url($parameter['notify_url']);
    	$input->SetTrade_type($parameter['trade_type']);
    	$input->SetProduct_id($parameter['product_id']);
    	$result = $notify->GetPayUrl($input);
    	
    	return $result;
    	//echo "<img alt=\"模式一扫码支付\" src=\"http://paysdk.weixin.qq.com/example/qrcode.php?data=".urlencode($url)."\" style=\"width:150px;height:150px;\"/>";
    }
    
    function doRefund($params){
    	$wxapi = new WxPay();
    	return $wxapi->GetRefundByTransaction($params);
    }
    
    function inquiry_order($out_trade_no = null){
    	if($out_trade_no){
    		$input = new WxPayOrderQuery();
    		$input->SetOut_trade_no($out_trade_no);
    		$data = WxPayApi::orderQuery($input);
    		return $data['trade_state'];
    	}
    }
    
    function domobile($parms){
    	//商户订单号，商户网站订单系统中唯一订单号，必填
    	$out_trade_no = $parms['out_trade_no'];
    	 
    	//订单名称，必填
    	$subject = $parms['subject'];
    	 
    	//付款金额，必填
    	$total_fee = $parms['total_fee'];
    	 
    	//商品描述，可空
    	$body = $parms['body'];
		
    	$parameter = array(
    			"body"       	=> $body,//商品描述，可空
    			"attach"       	=> "商品",
    			"out_trade_no"  => $out_trade_no,//商户订单号，商户网站订单系统中唯一订单号，必填
    			"total_fee"     => $total_fee*100,//付款金额，必填
    			"time_start"	=> date("YmdHis"),
    			"time_expire"	=> date("YmdHis", time() + 600),
    			"goods_tag"		=> "商品",
    			"notify_url"	=> $parms['notify_url'],
    			"trade_type"	=> "JSAPI",
    			"product_id"	=> $subject,
    	);
		
		// ①、获取用户openid
		$tools = new JsApiPay();
		$openId = $tools->GetOpenid ();
		// ②、统一下单
		$input = new WxPayUnifiedOrder ();
		$input->SetBody ($parameter['body']);
		$input->SetAttach ($parameter['attach']);
		$input->SetOut_trade_no ($parameter['out_trade_no']);
		$input->SetTotal_fee ($parameter['total_fee']);
		$input->SetTime_start ($parameter['time_start']);
		$input->SetTime_expire ($parameter['time_expire']);
		$input->SetGoods_tag ($parameter['goods_tag']);
		$input->SetNotify_url ($parameter['notify_url']);
		$input->SetTrade_type ($parameter['trade_type']);
		$input->SetOpenid ( $openId );
		$order = WxPayApi::unifiedOrder ($input);
		
		if($order['result_code'] == 'FAIL'){
			throw new \Exception($order['err_code_des']);
		}
		
		$jsApiParameters = $tools->GetJsApiParameters ( $order );
		// 获取共享收货地址js函数参数
		$editAddress = $tools->GetEditAddressParameters ();
		$data[0] = $order;
		$data[1] = $jsApiParameters;
		$data[2] = $editAddress;
		return $data;
    }
}
?>