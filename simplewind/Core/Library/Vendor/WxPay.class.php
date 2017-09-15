<?php
namespace Vendor;
use Vendor\WxPay\WxPayBizPayUrl;
use Vendor\WxPay\WxPayApi;
use Vendor\WxPay\WxPayConfig;
use Vendor\WxPay\WxPayRefund;

class WxPay {
	
	/**
	 *
	 * 生成扫描支付URL,模式一
	 * @param BizPayUrlInput $bizUrlInfo
	 */
	public function GetPrePayUrl($productId)
	{
		$biz = new WxPayBizPayUrl();
		$biz->SetProduct_id($productId);
		$values = WxpayApi::bizpayurl($biz);
		$url = "weixin://wxpay/bizpayurl?" . $this->ToUrlParams($values);
		return $url;
	}
	
	/**
	 *
	 * 参数数组转换为url参数
	 * @param array $urlObj
	 */
	private function ToUrlParams($urlObj)
	{
		$buff = "";
		foreach ($urlObj as $k => $v)
		{
			$buff .= $k . "=" . $v . "&";
		}
	
		$buff = trim($buff, "&");
		return $buff;
	}
	
	/**
	 *
	 * 生成直接支付url，支付url有效期为2小时,模式二
	 * @param UnifiedOrderInput $input
	 */
	public function GetPayUrl($input)
	{
		if($input->GetTrade_type() == "NATIVE")
		{
			$result = WxPayApi::unifiedOrder($input,60);
			return $result;
		}
	}
	
	public function GetAppPayUrl($input)
	{
		if($input->GetTrade_type() == "APP")
		{
			$result = WxPayApi::unifiedOrder($input,60);
			return $result;
		}
	}
	
	public function GetRefundByTransaction($params){
		$transaction_id = $params ["transaction_id"];
		$total_fee = $params ["total_fee"];
		$refund_fee = $params ["refund_fee"];
		$input = new WxPayRefund ();
		$input->SetTransaction_id ( $transaction_id );
		$input->SetTotal_fee ( $total_fee );
		$input->SetRefund_fee ( $refund_fee );
		$input->SetOut_refund_no ( WxPayConfig::MCHID . date ( "YmdHis" ) );
		$input->SetOp_user_id ( WxPayConfig::MCHID );
		return WxPayApi::refund ( $input );
	}
	
	public function GetRefundByOutTradeNo($params){
		$out_trade_no = $params ["out_trade_no"];
		$total_fee = $params ["total_fee"];
		$refund_fee = $params ["refund_fee"];
		$input = new WxPayRefund ();
		$input->SetOut_trade_no ( $out_trade_no );
		$input->SetTotal_fee ( $total_fee );
		$input->SetRefund_fee ( $refund_fee );
		$input->SetOut_refund_no ( WxPayConfig::MCHID . date ( "YmdHis" ) );
		$input->SetOp_user_id ( WxPayConfig::MCHID );
		return WxPayApi::refund ( $input );
	}
}

?>