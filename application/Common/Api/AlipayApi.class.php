<?php
namespace Common\Api;
use Vendor\Alipay\AlipaySubmit;
use Vendor\Alipay\AlipayNotify;

class AlipayApi{
	//在类初始化方法中，引入相关类库    
	public function _initialize() {
		header("Content-type: text/html; charset=utf-8");
    }
    
    public function doalipay($alipay_def){
    	 
    	$alipay_config = C('ALIPAY_CONFIG');
    	/**************************请求参数**************************/
    	//商户订单号，商户网站订单系统中唯一订单号，必填
    	$out_trade_no = $alipay_def['out_trade_no'];
    	 
    	//订单名称，必填
    	$subject = $alipay_def['subject'];
    	 
    	//付款金额，必填
    	$total_fee = $alipay_def['total_fee'];
    	 
    	//商品描述，可空
    	$body = $alipay_def['body'];
    	/************************************************************/
    	//构造要请求的参数数组，无需改动
    	$parameter = array(
    			"service"       => $alipay_config['service'],
    			"partner"       => $alipay_config['partner'],
    			"seller_id"		=> $alipay_config['partner'],
    			"payment_type"	=> $alipay_config['payment_type'],
    			"notify_url"	=> $alipay_def['notify_url'],
    			"return_url"	=> $alipay_def['return_url'],
    			 
    			"anti_phishing_key"=>$alipay_config['anti_phishing_key'],
    			"exter_invoke_ip"=>$alipay_config['exter_invoke_ip'],
    			"out_trade_no"	=> $out_trade_no,
    			"subject"	=> $subject,
    			"total_fee"	=> $total_fee,
    			"body"	=> $body,
    			"qr_pay_mode"	=>2,
    			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
    			//其他业务参数根据在线开发文档，添加参数.文档地址:https://doc.open.alipay.com/doc2/detail.htm?spm=a219a.7629140.0.0.kiX33I&treeId=62&articleId=103740&docType=1
    			//如"参数名"=>"参数值"
    	);
    	 
    	//建立请求
    	$alipaySubmit = new AlipaySubmit($alipay_config);
    	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
    	return $html_text;
    }
    
    /**
     * 验证返回数据
     */
    function verify_result($is_notify=true){
    	$alipay_config = C('ALIPAY_CONFIG');
    	//计算得出通知验证结果
    	$alipayNotify = new AlipayNotify($alipay_config);
    	$verify_result = $is_notify?$alipayNotify->verifyNotify():$alipayNotify->verifyReturn();
    	
    	if($verify_result) {//验证成功
    		return true;
    	}else{
    		return false;
    	}
    }
    
    /**
     * 退款验证返回数据
     */
    function refund_verify_result(){
    	$alipay_config = C('ALIREFUND_CONFIG');
    	//计算得出通知验证结果
    	$alipayNotify = new AlipayNotify($alipay_config);
    	$verify_result = $alipayNotify->verifyNotify();
    	
    	if($verify_result) {//验证成功
    		return true;
    	}else{
    		return false;
    	}
    }
    
    public function doRefund($parms){
    	$alipay_config = C('ALIREFUND_CONFIG');
    	/**************************请求参数**************************/
    	
    	//批次号，必填，格式：当天日期[8位]+序列号[3至24位]，如：201603081000001
    	
    	$batch_no = $parms['WIDbatch_no'];
    	//退款笔数，必填，参数detail_data的值中，“#”字符出现的数量加1，最大支持1000笔（即“#”字符出现的数量999个）
    	
    	$batch_num = $parms['WIDbatch_num'];
    	//退款详细数据，必填，格式（支付宝交易号^退款金额^备注），多笔请用#隔开
    	$detail_data = $parms['WIDdetail_data'];
    	
    	
    	/************************************************************/
    	
    	//构造要请求的参数数组，无需改动
    	$parameter = array(
    			"service" => trim($alipay_config['service']),
    			"partner" => trim($alipay_config['partner']),
    			"notify_url"	=> trim($parms['notify_url']),
    			"seller_user_id"	=> trim($alipay_config['partner']),
    			"refund_date"	=> trim($alipay_config['refund_date']),
    			"batch_no"	=> $batch_no,
    			"batch_num"	=> $batch_num,
    			"detail_data"	=> $detail_data,
    			"_input_charset"	=> trim(strtolower($alipay_config['input_charset']))
    	
    	);
    	
    	//建立请求
    	$alipaySubmit = new AlipaySubmit($alipay_config);
    	$html_text = $alipaySubmit->buildRequestForm($parameter,"get", "确认");
    	return $html_text;
    }
    
    public function mobilepay($alipay_def){
    	$alipay_config = C('ALIMOBILE_CONFIG');
    	
    	require_once "simplewind/Core/Library/Vendor/Alipay/wappay/service/AlipayTradeService.php";
    	require_once "simplewind/Core/Library/Vendor/Alipay/wappay/buildermodel/AlipayTradeWapPayContentBuilder.php";
    	//require dirname ( __FILE__ ).DIRECTORY_SEPARATOR.'./../config.php';
    	if (!empty($alipay_def['WIDout_trade_no'])&& trim($alipay_def['WIDout_trade_no'])!=""){
    		//商户订单号，商户网站订单系统中唯一订单号，必填
    		$out_trade_no = $alipay_def['WIDout_trade_no'];
    
    		//订单名称，必填
    		$subject = $alipay_def['WIDsubject'];
    		 
    		//付款金额，必填
    		$total_amount = $alipay_def['WIDtotal_amount'];
    		 
    		//商品描述，可空
    		$body = $alipay_def['WIDbody'];
    		 
    		//超时时间
    		$timeout_express="1m";
    		 
    		$payRequestBuilder = new \AlipayTradeWapPayContentBuilder();
    		$payRequestBuilder->setBody($body);
    		$payRequestBuilder->setSubject($subject);
    		$payRequestBuilder->setOutTradeNo($out_trade_no);
    		$payRequestBuilder->setTotalAmount($total_amount);
    		$payRequestBuilder->setTimeExpress($timeout_express);
    		 
    		$payResponse = new \AlipayTradeService($alipay_config);
    		$result=$payResponse->wapPay($payRequestBuilder,$alipay_def['return_url'],$alipay_def['notify_url']);
    		 
    		return $result;
    	}
    }
    
    function notify_verify(){
    	$alipay_config = C('ALIMOBILE_CONFIG');
    	require_once "simplewind/Core/Library/Vendor/Alipay/wappay/service/AlipayTradeService.php";
    	
    	$arr=$_POST;
    	$alipaySevice = new \AlipayTradeService($alipay_config);
    	$alipaySevice->writeLog(var_export($_POST,true));
    	$result = $alipaySevice->check($arr);
    	 
    	if($result) {//验证成功
    		return true;
    	}else{
    		return false;
    	}
    }
    
    function mobile_refund($params){
    	$alipay_config = C('ALIMOBILE_CONFIG');
    	
    	require_once "simplewind/Core/Library/Vendor/Alipay/wappay/service/AlipayTradeService.php";
    	require_once "simplewind/Core/Library/Vendor/Alipay/wappay/buildermodel/AlipayTradeRefundContentBuilder.php";
    	
    	if (!empty($params['WIDout_trade_no']) || !$params($_POST['WIDtrade_no'])){
    	
    		//商户订单号和支付宝交易号不能同时为空。 trade_no、  out_trade_no如果同时存在优先取trade_no
    		//商户订单号，和支付宝交易号二选一
    		$out_trade_no = trim($params['WIDout_trade_no']);
    	
    		//支付宝交易号，和商户订单号二选一
    		$trade_no = trim($params['WIDtrade_no']);
    	
    		//退款金额，不能大于订单总金额
    		$refund_amount=trim($params['WIDrefund_amount']);
    	
    		//退款的原因说明
    		$refund_reason=trim($params['WIDrefund_reason']);
    	
    		//标识一次退款请求，同一笔交易多次退款需要保证唯一，如需部分退款，则此参数必传。
    		$out_request_no=trim($params['WIDout_request_no']);
    	
    		$RequestBuilder = new \AlipayTradeRefundContentBuilder();
    		$RequestBuilder->setTradeNo($trade_no);
    		$RequestBuilder->setOutTradeNo($out_trade_no);
    		$RequestBuilder->setRefundAmount($refund_amount);
    		$RequestBuilder->setRefundReason($refund_reason);
    		$RequestBuilder->setOutRequestNo($out_request_no);
    	
    		$Response = new \AlipayTradeService($alipay_config);
    		$result=$Response->Refund($RequestBuilder);
    		$result = json_decode(json_encode($result),true);
    		return $result;
    	}
    }
}
?>