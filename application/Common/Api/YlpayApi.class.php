<?php
namespace Common\Api;
use Vendor\Ylpay\sdk\AcpService;
use Vendor;

class YlpayApi{
	
	//默认配置
	protected $_config = array(
		'front_trans_url' => 'https://gateway.95516.com/gateway/api/frontTransReq.do',
		'back_trans_url' => 'https://gateway.95516.com/gateway/api/backTransReq.do',
	);
	
	//在类初始化方法中，引入相关类库    
	public function _initialize() {
		header ( 'Content-type:text/html;charset=utf-8' );
		include_once 'simplewind/Core/Library/Vendor/Ylpay/sdk/common.php';
    }
    
    public function __construct() {
    	if (C('YLPAY_CONFIG')) {
    		//可设置配置项 AUTH_CONFIG, 此配置项为数组。
    		$this->_config = array_merge($this->_config, C('YLPAY_CONFIG'));
    	}
    }
    
    public function dopay($parm){
		/**
		 * 重要：联调测试时请仔细阅读注释！
		 *
		 * 产品：跳转网关支付产品<br>
		 * 交易：消费：前台跳转，有前台通知应答和后台通知应答<br>
		 * 日期： 2015-09<br>
		 * 版本： 1.0.0
		 * 版权： 中国银联<br>
		 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
		 * 提示：该接口参考文档位置：open.unionpay.com帮助中心 下载 产品接口规范 《网关支付产品接口规范》，<br>
		 * 《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表)<br>
		 * 《全渠道平台接入接口规范 第3部分 文件接口》（对账文件格式说明）<br>
		 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
		 * 调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
		 * 测试过程中产生的6位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
		 * 2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
		 * 交易说明:1）以后台通知或交易状态查询交易确定交易成功,前台通知不能作为判断成功的标准.
		 * 2）交易状态查询交易（Form_6_5_Query）建议调用机制：前台类交易建议间隔（5分、10分、30分、60分、120分）发起交易查询，如果查询到结果成功，则不用再查询。（失败，处理中，查询不到订单均可能为中间状态）。也可以建议商户使用payTimeout（支付超时时间），过了这个时间点查询，得到的结果为最终结果。
		 */
		
		$params = array (
				
				// 以下信息非特殊情况不需要改动
				'version' => '5.0.0', // 版本号
				'encoding' => 'utf-8', // 编码方式
				'txnType' => '01', // 交易类型
				'txnSubType' => '01', // 交易子类
				'bizType' => '000201', // 业务类型
				'frontUrl' => $parm['frontUrl'], // 前台通知地址
				'backUrl' => $parm['backUrl'], // 后台通知地址
				'signMethod' => '01', // 签名方法
				'channelType' => '08', // 渠道类型，07-PC，08-手机
				'accessType' => '0', // 接入类型
				'currencyCode' => '156', // 交易币种，境内商户固定156
				
				// TODO 以下信息需要填写
				'merId' => $this->_config["merId"], // 商户代码，请改自己的测试商户号，此处默认取demo演示页面传递的参数
				'orderId' => $parm["orderId"], // 商户订单号，8-32位数字字母，不能含“-”或“_”，此处默认取demo演示页面传递的参数，可以自行定制规则
				'txnTime' => $parm["txnTime"], // 订单发送时间，格式为YYYYMMDDhhmmss，取北京时间，此处默认取demo演示页面传递的参数
				'txnAmt' => $parm["txnAmt"]  // 交易金额，单位分，此处默认取demo演示页面传递的参数
		        // 'reqReserved' =>'透传信息', //请求方保留域，透传字段，查询、通知、对账文件中均会原样出现，如有需要请启用并修改自己希望透传的数据

		// TODO 其他特殊用法请查看 special_use_purchase.php
		);
		AcpService::sign ( $params ,$this->_config['cacert'],$this->_config['pwd']);
		$html_form = AcpService::createAutoFormHtml ( $params, $this->_config['front_trans_url'] );
		echo $html_form;
    }
    
    public function validate($data){
    	return AcpService::validate ( $data );
    }
    
    public function dorefund($parm){
    	
    	/**
    	 * 重要：联调测试时请仔细阅读注释！
    	 *
    	 * 产品：跳转网关支付产品<br>
    	 * 交易：退货交易：后台资金类交易，有同步应答和后台通知应答<br>
    	 * 日期： 2015-09<br>
    	 * 版本： 1.0.0
    	 * 版权： 中国银联<br>
    	 * 说明：以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己需要，按照技术文档编写。该代码仅供参考，不提供编码性能规范性等方面的保障<br>
    	 * 该接口参考文档位置：open.unionpay.com帮助中心 下载  产品接口规范  《网关支付产品接口规范》<br>
    	 *              《平台接入接口规范-第5部分-附录》（内包含应答码接口规范，全渠道平台银行名称-简码对照表）<br>
    	 * 测试过程中的如果遇到疑问或问题您可以：1）优先在open平台中查找答案：
    	 * 							        调试过程中的问题或其他问题请在 https://open.unionpay.com/ajweb/help/faq/list 帮助中心 FAQ 搜索解决方案
    	 *                             测试过程中产生的6位应答码问题疑问请在https://open.unionpay.com/ajweb/help/respCode/respCodeList 输入应答码搜索解决方案
    	 *                          2） 咨询在线人工支持： open.unionpay.com注册一个用户并登陆在右上角点击“在线客服”，咨询人工QQ测试支持。
    	 * 交易说明： 1）以后台通知或交易状态查询交易（Form_6_5_Query）确定交易成功，建议发起查询交易的机制：可查询N次（不超过6次），每次时间间隔2N秒发起,即间隔1，2，4，8，16，32S查询（查询到03，04，05继续查询，否则终止查询）
    	 *        2）退货金额不超过总金额，可以进行多次退货
    	 *        3）退货能对11个月内的消费做（包括当清算日），支持部分退货或全额退货，到账时间较长，一般1-10个清算日（多数发卡行5天内，但工行可能会10天），所有银行都支持
    	 */
    	
    	$params = array(
    		//以下信息非特殊情况不需要改动
	    	'version' => '5.0.0',		      //版本号
	    	'encoding' => 'utf-8',		      //编码方式
	    	'signMethod' => '01',		      //签名方法
	    	'txnType' => '04',		          //交易类型
	    	'txnSubType' => '00',		      //交易子类
	    	'bizType' => '000201',		      //业务类型
	    	'accessType' => '0',		      //接入类型
	    	'channelType' => '07',		      //渠道类型
	    	'backUrl' => $parm['backUrl'], //后台通知地址
	    	
	    	//TODO 以下信息需要填写
	    	'orderId' => $parm["orderId"],	    //商户订单号，8-32位数字字母，不能含“-”或“_”，可以自行定制规则，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
	    	'merId' => $this->_config['merId'],	        //商户代码，请改成自己的测试商户号，此处默认取demo演示页面传递的参数
	    	'origQryId' => $parm["origQryId"], //原消费的queryId，可以从查询接口或者通知接口中获取，此处默认取demo演示页面传递的参数
	    	'txnTime' => $parm["txnTime"],	    //订单发送时间，格式为YYYYMMDDhhmmss，重新产生，不同于原消费，此处默认取demo演示页面传递的参数
	    	'txnAmt' => $parm["txnAmt"],       //交易金额，退货总金额需要小于等于原消费
    	);
    	
    	AcpService::sign ( $params ,$this->_config['cacert'],$this->_config['pwd']);
    	$url = $this->_config['back_trans_url'];
    	
    	$result_arr = AcpService::post ( $params, $url);
    	
    	
    	
    	if(count($result_arr)<=0) { //没收到200应答的情况
    		$data['status'] = 0;
    		$data['error'] = '未收到银联应答';
    		return $data;
    	}
    	
    	if (!AcpService::validate ($result_arr) ){
    		$data['status'] = 0;
    		$data['error'] = '应答报文验签失败';
    		return $data;
    	}
    	
    	if ($result_arr["respCode"] == "00"){
    		//交易已受理，等待接收后台通知更新订单状态，如果通知长时间未收到也可发起交易状态查询
    		//TODO
    		$data = $result_arr;
    		$data['status'] = 1;
    		return $data;
    	} else if ($result_arr["respCode"] == "03"
    			|| $result_arr["respCode"] == "04"
    			|| $result_arr["respCode"] == "05" ){
    		//后续需发起交易状态查询交易确定交易状态
    		//TODO
    		$data['status'] = 0;
    		$data['error'] = '处理超时，请稍后查询';
    		return $data;
    	} else {
    		//其他应答码做以失败处理
    		//TODO
    		$data['status'] = 0;
    		$data['error'] = "失败：" . $result_arr["respMsg"];
    		return $data;
    	}
    	
    }
    
    /**
     * 打印请求应答
     *
     * @param
     *        	$url
     * @param
     *        	$req
     * @param
     *        	$resp
     */
    function printResult($url, $req, $resp) {
    	echo "=============<br>\n";
    	echo "地址：" . $url . "<br>\n";
    	echo "请求：" . str_replace ( "\n", "\n<br>", htmlentities ( Vendor\Ylpay\sdk\createLinkString ( $req, false, true ) ) ) . "<br>\n";
    	echo "应答：" . str_replace ( "\n", "\n<br>", htmlentities ( Vendor\Ylpay\sdk\createLinkString ( $resp , false, true )) ) . "<br>\n";
    	echo "=============<br>\n";
    }
}
?>