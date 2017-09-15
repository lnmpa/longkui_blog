<?php
namespace Index\Controller;
use Common\Api\YlpayApi;
use Common\Api\AlipayApi;
use Common\Api\WeixinpayApi;
use Vendor\WxPay\PayNotifyCallBack;

class TaxController extends HomeController {
	
	protected $ignore_arr = array('index');
	
	function _initialize() {
		parent::_initialize();
		$this->check_login($this->ignore_arr);
		
		$cate_id = "132";
		$parent_cate =  M('ArticleCate')->field('name,name_en,img')->find($cate_id);
		$this->assign("parent_cate",$parent_cate);
	}
	
    public function index(){
    	if(IS_POST){
    		$this->check_login();
    		$Model  =   D($this->myModName);
    		$uid =sp_get_current_userid();
    		$loginuser = D("Common/Users")->where(array("id"=>$uid))->find();
    			
    		$price = I('price');
    		if(!$price){
    			$this->error("请填写缴费金额！");
    		}
    		else if(!is_numeric($price)){
    			$this->error("缴费金额应当是一个数字，请重新填写！");
    		}
    		if($price < 0.1){
    			$this->error("最低缴纳0.1元，请重新填写！");
    		}
    	
    		$pay_cate = I('pay_cate');
    		if(!$pay_cate){
    			$this->error("请选择支付方式！");
    		}
    		else if(!in_array($pay_cate, array(1,2,3))){
    			$this->error("支付方式不存在！");
    		}
    		$tax_mod = D('tax');
    		$taxdata['user_id'] = $loginuser['id'];
    		$taxdata['uid'] = $loginuser['id'];
    		$taxdata['year'] = date('Y',NOW_TIME);
    		$taxdata['month'] = date('m',NOW_TIME);
    		$taxdata['date'] = date('Y-m-d',NOW_TIME);
    		$taxdata['add_time'] = date('Y-m-d H:i:s',NOW_TIME);
    		$taxdata['price'] = $price;
    		$taxdata['remark'] = $loginuser['user_nicename'].','.date('Y-m-d H:i:s',NOW_TIME).',在线支付党费';
    		$taxdata['pay_cate'] = $pay_cate;
    		$taxdata['status'] = 0;
    		$taxdata['order_id'] = sp_get_order_sn();//外部订单号
    		$re = $tax_mod->add($taxdata);
    		if($re){
    			$this->payOrder($pay_cate,$re);
    			//$this->success("提交成功，请等待跳转",U('Tax/payOrder?tax_id='.$re));
    		}
    		else{
    			$this->error("添加信息失败，请联系管理员！");
    		}
    	
    	}
    	 
    	 
    	$this->display();
    }
    
    public function inquiry(){
    	$loginuser = $this->user;
    	 
    	 
    	$this->display();
    }
    
    public function payOrder($type = 1,$tax_id = null){
    	if(!$tax_id){
    		$this->error("订单错误！");
    	}
    	
    	$tax_mod = D('tax');
    	$info = $tax_mod->find($tax_id);
    	
    	//执行支付
    	switch($type){
    		case 1://支付宝
    			$this->success("正在跳转到支付宝",U('Tax/alipay',array('tax_id'=>$tax_id)));
    			break;
    		case 2:// 微信
		    	$pay = new WeixinpayApi();
		    	$parms['out_trade_no'] = $info['order_id'];
		    	$parms['subject'] = "在线支付党费";
		    	$parms['total_fee'] = sprintf("%.2f", $info['price']);
		    	$parms['body'] = "在线支付党费";
		    	$parms['notify_url'] = U('Tax/wxpay_notify_url',"","",true);
		    	$result = $pay->doPay($parms);
		    	if($result['result_code'] == 'FAIL'){
		    		$this->error($result['err_code_des']);
		    	}
		    	else{
		    		$url = $result["code_url"];
		    		$this->ajaxReturn(array('status'=>0,'img'=>urlencode($url),'order_id'=>$info['order_id']));
		    	}
    			break;
    		case 3://银联支付
    			$this->success("正在跳转到银联支付",U('Tax/ylpay',array('tax_id'=>$tax_id)));
    			break;
    	}
    }
    
    public function alipay(){
    	header("Content-type: text/html; charset=utf-8");
    	$tax_mod = D('tax');
    	$tax_id = I('tax_id');
    	if(!$tax_id){
    		echo "<script>alert('参数错误！');window.history.go(-1);</script>";
    		exit();
    	}
    	$data = $tax_mod->find($tax_id);
    	$uid =sp_get_current_userid();
    	if($data['user_id'] != $uid){
    		echo "<script>alert('不是您的缴费！');window.history.go(-1);</script>";
    		exit();
    	}
    	$info = $tax_mod->find($tax_id);
    	
    	if($info['price'] <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	 
    	$pay = new AlipayApi();
    	$order_def['out_trade_no'] = $info['order_id'];
    	$order_def['subject'] = "在线支付党费";
    	$order_def['total_fee'] = sprintf("%.2f", $info['price']);
    	$order_def['body'] = "在线支付党费";
    	$order_def['notify_url'] = U('Tax/alipay_notify_url',"","",true);
    	$order_def['return_url'] = U('Tax/return_url',"","",true);
    	$url = $pay->doalipay($order_def);
    	echo $url;
    }
    
    public function ylpay(){
    	header("Content-type:text/html;charset=utf-8");
    	
    	$tax_mod = D('tax');
    	$tax_id = I('tax_id');
    	if(!$tax_id){
    		echo "<script>alert('参数错误！');window.history.go(-1);</script>";
    		exit();
    	}
    	$data = $tax_mod->find($tax_id);
    	$uid =sp_get_current_userid();
    	if($data['user_id'] != $uid){
    		echo "<script>alert('不是您的缴费！');window.history.go(-1);</script>";
    		exit();
    	}
    	$info = $tax_mod->find($tax_id);
    	
    	if($info['price'] <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	$pay = new YlpayApi();
    	$parms['orderId'] = $info['order_id'];
    	$parms['txnAmt'] = $info['price']*100;
    	$parms['txnTime'] = date('YmdHis');
    	$parms['frontUrl'] = U('Tax/return_url','','',true);
    	$parms['backUrl'] = U('Tax/ylpay_notify_url','','',true);
    	
    	$url = $pay->dopay($parms);
    	 
    	echo $url;
    }
    
    function do_order($order_sn,$pay_type,$pay_json){
    	$tax_mod = D('tax');
    	$data['status'] = 1;
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
    	if($pay_type == 'ylpay'){
    		$data['pay_money'] = sprintf("%.2f", $res['total_fee']/100);
    		$data['trade_no'] = $res['queryId'];
    	}
    
    	$data['pay_time'] = date('Y-m-d H:i:s',time());
    	$tax_mod->where(array('order_id'=>$order_sn))->save($data);
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
    
    function wxpay_inquiry_order(){
    	$out_trade_no = I("post.order_id");
    	$pay = new WeixinpayApi();
    	echo $pay->inquiry_order($out_trade_no);
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
     * 银联后台通知页面
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
     * 银联支付成功,跳转
     */
    function return_url(){
    	header("Location:".U('Profile/taxInquiry'));
    }
    
}