<?php
namespace Common\Api;

class TenpayApi{
	
	//默认配置
	protected $_config = array(
			
	);
	
	//在类初始化方法中，引入相关类库    
	public function _initialize() {
		header("Content-type:text/html;charset=utf-8");
    }
    
    public function __construct() {
    	if (C('TENPAY_CONFIG')) {
    		//可设置配置项 AUTH_CONFIG, 此配置项为数组。
    		$this->_config = array_merge($this->_config, C('TENPAY_CONFIG'));
    	}
    }
    
    public function dopay($parm){
    	require ("simplewind/Core/Library/Vendor/Tenpay/classes/RequestHandler.class.php");
    	
    	$partner = $this->_config['partner'];
    	$key = $this->_config['key'];
    	
    	$out_trade_no = $parm['out_trade_no'];
    	$total_fee = $parm['total_fee'];
    	$body = $parm['body'];
    	$subject = $parm['subject'];
    	$return_url = $parm['return_url'];
    	$notify_url = $parm['notify_url'];
    	
    	/* 创建支付请求对象 */
    	$reqHandler = new \RequestHandler();
    	$reqHandler->init();
    	$reqHandler->setKey($key);
    	$reqHandler->setGateUrl("https://gw.tenpay.com/gateway/pay.htm");
    	
    	//----------------------------------------
    	//设置支付参数
    	//----------------------------------------
    	$reqHandler->setParameter("partner", $partner);
    	$reqHandler->setParameter("out_trade_no", $out_trade_no);
    	$reqHandler->setParameter("total_fee", $total_fee);  //总金额
    	$reqHandler->setParameter("return_url",  $return_url);
    	$reqHandler->setParameter("notify_url", $notify_url);
    	$reqHandler->setParameter("body", $body);
    	$reqHandler->setParameter("bank_type", "DEFAULT");  	  //银行类型，默认为财付通
    	//用户ip
    	$reqHandler->setParameter("spbill_create_ip", $_SERVER['REMOTE_ADDR']);//客户端IP
    	$reqHandler->setParameter("fee_type", "1");               //币种
    	$reqHandler->setParameter("subject",$subject);          //商品名称，（中介交易时必填）
    	
    	//系统可选参数
    	$reqHandler->setParameter("sign_type", "MD5");  	 	  //签名方式，默认为MD5，可选RSA
    	$reqHandler->setParameter("service_version", "1.0"); 	  //接口版本号
    	$reqHandler->setParameter("input_charset", "utf-8");   	  //字符集
    	$reqHandler->setParameter("sign_key_index", "1");    	  //密钥序号
    	
    	//业务可选参数
    	$reqHandler->setParameter("attach", "");             	  //附件数据，原样返回就可以了
    	$reqHandler->setParameter("product_fee", "");        	  //商品费用
    	$reqHandler->setParameter("transport_fee", "0");      	  //物流费用
    	$reqHandler->setParameter("time_start", date("YmdHis"));  //订单生成时间
    	$reqHandler->setParameter("time_expire", "");             //订单失效时间
    	$reqHandler->setParameter("buyer_id", "");                //买方财付通帐号
    	$reqHandler->setParameter("goods_tag", "");               //商品标记
    	$reqHandler->setParameter("trade_mode","1");              //交易模式（1.即时到帐模式，2.中介担保模式，3.后台选择（卖家进入支付中心列表选择））
    	$reqHandler->setParameter("transport_desc","");              //物流说明
    	$reqHandler->setParameter("trans_type","1");              //交易类型
    	$reqHandler->setParameter("agentid","");                  //平台ID
    	$reqHandler->setParameter("agent_type","");               //代理模式（0.无代理，1.表示卡易售模式，2.表示网店模式）
    	$reqHandler->setParameter("seller_id","");                //卖家的商户号
    	
    	
    	
    	//请求的URL
    	$reqUrl = $reqHandler->getRequestURL();
    	
    	return $reqUrl;
    	//获取debug信息,建议把请求和debug信息写入日志，方便定位问题
    	/**/
    	//$debugInfo = $reqHandler->getDebugInfo();
    	//echo "<br/>" . $reqUrl . "<br/>";
    	//echo "<br/>" . $debugInfo . "<br/>";
    }
    
    public function notify_url(){
    	//---------------------------------------------------------
    	//财付通即时到帐支付后台回调示例，商户按照此文档进行开发即可
    	//---------------------------------------------------------
    	
    	$partner = $this->_config['partner'];
    	$key = $this->_config['key'];
    	
    	require ("simplewind/Core/Library/Vendor/Tenpay/classes/ResponseHandler.class.php");
    	require ("simplewind/Core/Library/Vendor/Tenpay/classes/RequestHandler.class.php");
    	require ("simplewind/Core/Library/Vendor/Tenpay/classes/client/ClientResponseHandler.class.php");
    	require ("simplewind/Core/Library/Vendor/Tenpay/classes/client/TenpayHttpClient.class.php");
    	require ("simplewind/Core/Library/Vendor/Tenpay/classes/function.php");
    	
    	log_result("进入后台回调页面");
    	
    	
    	/* 创建支付应答对象 */
    	$resHandler = new \ResponseHandler();
    	$resHandler->setKey($key);
    	
    	//判断签名
    	if($resHandler->isTenpaySign()) {
    	
    		//通知id
    		$notify_id = $resHandler->getParameter("notify_id");
    	
    		//通过通知ID查询，确保通知来至财付通
    		//创建查询请求
    		$queryReq = new \RequestHandler();
    		$queryReq->init();
    		$queryReq->setKey($key);
    		$queryReq->setGateUrl("https://gw.tenpay.com/gateway/simpleverifynotifyid.xml");
    		$queryReq->setParameter("partner", $partner);
    		$queryReq->setParameter("notify_id", $notify_id);
    	
    		//通信对象
    		$httpClient = new \TenpayHttpClient();
    		$httpClient->setTimeOut(5);
    		//设置请求内容
    		$httpClient->setReqContent($queryReq->getRequestURL());
    	
    		//后台调用
    		if($httpClient->call()) {
    			//设置结果参数
    			$queryRes = new \ClientResponseHandler();
    			$queryRes->setContent($httpClient->getResContent());
    			$queryRes->setKey($key);
    	
    			if($resHandler->getParameter("trade_mode") == "1"){
    				//判断签名及结果（即时到帐）
    				//只有签名正确,retcode为0，trade_state为0才是支付成功
    				if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" && $resHandler->getParameter("trade_state") == "0") {
    					log_result("即时到帐验签ID成功");
    					//取结果参数做业务处理
    					$out_trade_no = $resHandler->getParameter("out_trade_no");
    					//财付通订单号
    					$transaction_id = $resHandler->getParameter("transaction_id");
    					//金额,以分为单位
    					$total_fee = $resHandler->getParameter("total_fee");
    					//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
    					$discount = $resHandler->getParameter("discount");
    	
    					//------------------------------
    					//处理业务开始
    					//------------------------------
    					//处理数据库逻辑
    					//注意交易单不要重复处理
    					//注意判断返回金额
    					$res = $resHandler->getParameter();
    					$data['pay_json'] = json_encode($res);
    					//------------------------------
    					//处理业务完毕
    					//------------------------------
    					log_result("即时到帐后台回调成功");
    					$data['status'] = 1;
    					$data['info'] = "即时到帐后台回调成功";
    					$data['order_sn'] = $out_trade_no;
    				} else {
    					//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
    					//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->                         getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
    					log_result("即时到帐后台回调失败");
    					$data['status'] = 0;
    					$data['info'] = "即时到帐后台回调失败";
    				}
    			}
    			/*elseif ($resHandler->getParameter("trade_mode") == "2")
    			{
    				//判断签名及结果（中介担保）
    				//只有签名正确,retcode为0，trade_state为0才是支付成功
    				if($queryRes->isTenpaySign() && $queryRes->getParameter("retcode") == "0" )
    				{
    					log_result("中介担保验签ID成功");
    					//取结果参数做业务处理
    					$out_trade_no = $resHandler->getParameter("out_trade_no");
    					//财付通订单号
    					$transaction_id = $resHandler->getParameter("transaction_id");
    					//金额,以分为单位
    					$total_fee = $resHandler->getParameter("total_fee");
    					//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
    					$discount = $resHandler->getParameter("discount");
    	
    					//------------------------------
    					//处理业务开始
    					//------------------------------
    	
    					//处理数据库逻辑
    					//注意交易单不要重复处理
    					//注意判断返回金额
    	
    					log_result("中介担保后台回调，trade_state="+$resHandler->getParameter("trade_state"));
    					switch ($resHandler->getParameter("trade_state")) {
    						case "0":	//付款成功
    	
    							break;
    						case "1":	//交易创建
    	
    							break;
    						case "2":	//收获地址填写完毕
    	
    							break;
    						case "4":	//卖家发货成功
    	
    							break;
    						case "5":	//买家收货确认，交易成功
    	
    							break;
    						case "6":	//交易关闭，未完成超时关闭
    	
    							break;
    						case "7":	//修改交易价格成功
    	
    							break;
    						case "8":	//买家发起退款
    	
    							break;
    						case "9":	//退款成功
    	
    							break;
    						case "10":	//退款关闭
    								
    							break;
    						default:
    							//nothing to do
    							break;
    					}
    						
    	
    					//------------------------------
    					//处理业务完毕
    					//------------------------------
    					return "success";
    				} else
    					
    				{
    					//错误时，返回结果可能没有签名，写日志trade_state、retcode、retmsg看失败详情。
    					//echo "验证签名失败 或 业务错误信息:trade_state=" . $resHandler->getParameter("trade_state") . ",retcode=" . $queryRes->             										       getParameter("retcode"). ",retmsg=" . $queryRes->getParameter("retmsg") . "<br/>" ;
    					log_result("中介担保后台回调失败");
    					return "fail";
    				}
    			}*/
    	
    	
    	
    			//获取查询的debug信息,建议把请求、应答内容、debug信息，通信返回码写入日志，方便定位问题
    			/*
    			 echo "<br>------------------------------------------------------<br>";
    			echo "http res:" . $httpClient->getResponseCode() . "," . $httpClient->getErrInfo() . "<br>";
    			echo "query req:" . htmlentities($queryReq->getRequestURL(), ENT_NOQUOTES, "GB2312") . "<br><br>";
    			echo "query res:" . htmlentities($queryRes->getContent(), ENT_NOQUOTES, "GB2312") . "<br><br>";
    			echo "query reqdebug:" . $queryReq->getDebugInfo() . "<br><br>" ;
    			echo "query resdebug:" . $queryRes->getDebugInfo() . "<br><br>";
    			*/
    		}else
    		{
    			$data['status'] = 0;
    			$data['info'] = "通信失败";
    			$data['error'] = "call err:" . $httpClient->getResponseCode() ."," . $httpClient->getErrInfo();
    		}
    	
    	
    	} else
    	{
    		$data['status'] = 0;
    		$data['info'] = "认证签名失败";
    		$data['error'] = $resHandler->getDebugInfo();
    	}
    	return $data;
    }
    
    public function return_url(){
    	//---------------------------------------------------------
    	//财付通即时到帐支付页面回调示例，商户按照此文档进行开发即可
    	//---------------------------------------------------------
    	require_once ("simplewind/Core/Library/Vendor/Tenpay/classes/ResponseHandler.class.php");
    	require_once ("simplewind/Core/Library/Vendor/Tenpay/classes/function.php");
    	
    	$partner = $this->_config['partner'];
    	$key = $this->_config['key'];
    	
    	log_result("进入前台回调页面");
    	
    	
    	/* 创建支付应答对象 */
    	$resHandler = new \ResponseHandler();
    	$resHandler->setKey($key);
    	
    	//判断签名
    	if($resHandler->isTenpaySign()) {
    	
    		//通知id
    		$notify_id = $resHandler->getParameter("notify_id");
    		//商户订单号
    		$out_trade_no = $resHandler->getParameter("out_trade_no");
    		//财付通订单号
    		$transaction_id = $resHandler->getParameter("transaction_id");
    		//金额,以分为单位
    		$total_fee = $resHandler->getParameter("total_fee");
    		//如果有使用折扣券，discount有值，total_fee+discount=原请求的total_fee
    		$discount = $resHandler->getParameter("discount");
    		//支付结果
    		$trade_state = $resHandler->getParameter("trade_state");
    		//交易模式,1即时到账
    		$trade_mode = $resHandler->getParameter("trade_mode");
    	
    	
    		if("1" == $trade_mode ) {
    			if( "0" == $trade_state){
    				//------------------------------
    				//处理业务开始
    				//------------------------------
    					
    				//注意交易单不要重复处理
    				//注意判断返回金额
    					
    				//------------------------------
    				//处理业务完毕
    				//------------------------------
    					
    				//echo "<br/>" . "即时到帐支付成功" . "<br/>";
    				$data['status'] = 1;
    				$data['info'] = "即时到帐支付成功";
    	
    			} else {
    				//当做不成功处理
    				//echo "<br/>" . "即时到帐支付失败" . "<br/>";
    				$data['status'] = 0;
    				$data['info'] = "即时到帐支付成功";
    			}
    		}elseif( "2" == $trade_mode  ) {
    			if( "0" == $trade_state) {
    	
    				//------------------------------
    				//处理业务开始
    				//------------------------------
    					
    				//注意交易单不要重复处理
    				//注意判断返回金额
    					
    				//------------------------------
    				//处理业务完毕
    				//------------------------------
    					
    				//echo "<br/>" . "中介担保支付成功" . "<br/>";
    				$data['status'] = 1;
    				$data['info'] = "中介担保支付成功";
    	
    			} else {
    				//当做不成功处理
    				//echo "<br/>" . "中介担保支付失败" . "<br/>";
    				$data['status'] = 0;
    				$data['info'] = "中介担保支付失败";
    			}
    		}
    	
    	} else {
    		$data['status'] = 0;
    		$data['info'] = "认证签名失败";
    		$data['error'] = $resHandler->getDebugInfo();
    	}
    	return $data;
    }
    
}
?>