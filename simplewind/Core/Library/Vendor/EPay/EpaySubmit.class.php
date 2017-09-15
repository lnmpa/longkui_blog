<?php
namespace Vendor\EPay;
/* *
 * 类名：EpaySubmit
 * 功能：e支付各接口请求提交类
 * 详细：构造e支付各接口表单HTML文本，获取远程HTTP数据
 * 版本：1.0
 * 修改日期：2013-12-14
 * 说明：
 * 以下代码只是为了方便商户测试而提供的样例代码，商户可以根据自己网站的需要，按照技术文档编写,并非一定要使用该代码。
 * 该代码仅供学习和研究e支付接口使用，只是提供一个参考。
 */
require_once("epay_core.function.php");
require_once("epay_md5.function.php");

class EpaySubmit {
	/**
	 *e支付网关地址（新）
	 */
	var $epay_gateway_new = 'https://epay.cmbc.com.cn/ipad/service.html?';

	function __construct(){
	}
    function EpaySubmit() {
    }
	
	/**
	 * 生成签名结果
	 * @param $para_sort 已排序要签名的数组
	 * return 签名结果字符串
	 */
	function buildRequestMysign($para_sort, $signkey) {
		//把数组所有元素，按照“参数=参数值”的模式用“&”字符拼接成字符串
		$prestr = createLinkstring($para_sort);
		
		$mysign = md5Sign($prestr, $signkey);
		return $mysign;
	}

	/**
     * 生成要请求给e支付的参数数组
     * @param $para_temp 请求前的参数数组
     * @return 要请求的参数数组
     */
	function buildRequestPara($para_temp, $signkey) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = paraFilter($para_temp);

		//对待签名参数数组排序
		$para_sort = argSort($para_filter);

		//生成签名结果
		$mysign = $this->buildRequestMysign($para_sort, $signkey);
		
		//签名结果与签名方式加入请求提交参数组中
		$para_sort['sign'] = $mysign;
		
		return $para_sort;
	}

	/**
	 * 生成签名
	 * @param $para_temp 请求前的参数数组
	 * @return 按数组生成的签名
	 */
	function buildRequestSign($para_temp, $signkey) {
		//除去待签名参数数组中的空值和签名参数
		$para_filter = paraFilter($para_temp);
	
		//对待签名参数数组排序
		$para_sort = argSort($para_filter);
	
		//生成签名结果
		$mysign = $this->buildRequestMysign($para_sort, $signkey);
	
		return $mysign;
	}
	
    /**
     * 建立请求，以表单HTML形式构造（默认）
     * @param $para_temp 请求参数数组
     * @param $method 提交方式。两个值可选：post、get
     * @param $button_name 确认按钮显示文字
     * @return 提交表单HTML文本
     */
	function buildRequestForm($para_temp, $signkey, $method, $button_name) {
		//待请求参数数组
		$para = $this->buildRequestPara($para_temp, $signkey);
		
		$sHtml = "<form id='epaysubmit' name='epaysubmit' action='".$this->epay_gateway_new."_input_charset=utf-8"."' method='".$method."'>";
		while (list ($key, $val) = each ($para)) {
            $sHtml.= "<input type='hidden' name='".$key."' value='".$val."'/>";
        }

		//submit按钮控件请不要含有name属性
        $sHtml = $sHtml."<input type='submit' value='".$button_name."'></form>";
		
		$sHtml = $sHtml."<script></script>";
		//document.forms['epaysubmit'].submit();
		return $sHtml;
	}
}
?>