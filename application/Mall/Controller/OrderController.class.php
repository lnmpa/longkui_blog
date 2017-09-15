<?php
namespace Mall\Controller;
use Common\Api\AlipayApi;
use Common\Api\TenpayApi;
use Common\Api\WeixinpayApi;
use Common\Api\YlpayApi;


class OrderController extends HomeController {
	
	protected $OrderMod;
	protected $OrderProductMod;
	protected $OrderRefundMod;
	protected $MallMod;
	protected $MallCateMod;
	protected $MallViewMod;
	
	function _initialize() {
		parent::_initialize();
		$this->check_login();
		$this->check_user();
		$this->OrderMod = D('Common/Order');
		$this->OrderProductMod = D('Common/OrderProduct');
		$this->OrderRefundMod = D('Common/OrderRefund');
		$this->MallMod = D("Common/Mall");
		$this->MallCateMod = D("Common/MallCate");
		$this->MallCateMod->setLang(LANG_SET);
		switch (LANG_SET){
			case 'en-us':
				$this->MallViewMod = D("Common/MallEnView");
				break;
			default:
				$this->MallViewMod = D("Common/MallView");
		}
	}
	
    public function index(){
    	$GoodSkuMod = M('GoodSku');
    	$uid = sp_get_current_userid();
    	$where['uid'] = $uid;
    	$where['status'] = array('egt',0);
    	if(I('type')){
    		$where['status'] = array('eq',I('type'));
    		$this->assign('type',I('type'));
    	}
    	
    	$list = $this->OrderMod->where($where)->order('create_time desc')->select();
    	foreach ($list as $key=>$val){
    		$list[$key]['_productList'] = $this->OrderProductMod->where(array('order_id'=>$val['id']))->select();
    		$list[$key]['countprice'] = sprintf("%.2f", 0);
	    	foreach ($list[$key]['_productList'] as $k=>$v){
				$product = array();
				$product = $this->MallViewMod->field('price,title,img')->find($v['product_id']);
				$list[$key]['_productList'][$k] = array_merge($list[$key]['_productList'][$k],$product);
				$refund = array();
				$refund = $this->OrderRefundMod->field('step_id,type_id,is_receive,return_money,remark,img1,img2,img3')->find($v['refund_id']);
				$list[$key]['_productList'][$k]['refund'] = $refund;
				
				//$price = $GoodSkuMod->where(array('properies'=>$v['props']))->getField('price');
				//if($price>0){$list[$key]['_productList'][$k]['price'] = $price;}
				//$list[$key]['_productList'][$k]['sum_price'] = $list[$key]['_productList'][$k]['price']*$v['num'];
				$list[$key]['_productList'][$k]['attr_info'] = implode('<br>', $this->getAttrInfo($v['props']));
				$refund_title = "";
				if(in_array($val['status'], array(2,3,4))){
					if($refund['step_id'] == 0){
						$refund_title = "申请售后";
					}
					else if($refund['step_id'] == -1){
						$refund_title = "售后中止";
					}
					else if($refund['step_id'] >= 4){
						$refund_title = "售后结果";
					}
					else if($refund['step_id'] == 2){
						$refund_title = "填写退货单";
					}
					else{
						$refund_title = "售后中";
					}
					
				}else if($val['status'] == 0){
					if($refund['step_id'] == 4){
						$refund_title = "售后结果";
					}
				}
				$list[$key]['_productList'][$k]['refund_title'] = $refund_title;
				if($refund['step_id'] != 4){
					$list[$key]['countprice'] += $v['sum_price'];
				}
	    	}
	    	$list[$key]['status_info'] = $this->OrderMod->get_status_info($val['status']);
			$list[$key]['osm'] = think_encrypt($val['order_sn']);
    	}
    	$map['uid'] = $uid;
    	$map['status'] = array('in',array(0,1,2,3,4));
    	$orderNum[0] = $this->OrderMod->where($map)->count();
    	$map['status'] = 1;
    	$orderNum[1] = $this->OrderMod->where($map)->count();
    	$map['status'] = 2;
    	$orderNum[2] = $this->OrderMod->where($map)->count();
    	$map['status'] = 3;
    	$orderNum[3] = $this->OrderMod->where($map)->count();
    	$map['status'] = 4;
    	$orderNum[4] = $this->OrderMod->where($map)->count();
    	$this->assign('orderNum',$orderNum);
    	
    	$this->assign('list',$list);
    	$this->display();
    }
    
    private function getAttrInfo($props){
    	$list = explode('|', $props);
    	foreach ($list as $key=>$val){
    		$id_arr = array();
    		$id_arr = explode(':', $val);
    		$data[$key] = get_spe($id_arr[0])."：".get_spe_son($id_arr[1]);
    	}
    	return $data;
    }
    
    public function inquiry_order(){
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	if(!$osm){
    		$this->error('参数错误！');
    	}
    	$order_sn = think_decrypt($osm);
    	$status = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid))->getField('status');
    	if($status > 1){
    		$this->success('订单支付成功！');
    	}
   		else{
    		$this->error('订单未支付成功！');
    	}
    }
    
    public function deleteOrder($id = null){
    	if(!$id){
    		$this->error('参数错误！');
    	}
    	$re = $this->OrderMod->where(array('id'=>$id))->setField('status','-1');
    	if($re){
    		$this->success('删除订单成功！');
    	}
    	else{
    		$this->error('删除订单失败！');
    	}
    }
    
    public function payOrder(){
    	$GoodSkuMod = M('GoodSku');
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	if(IS_POST){
    		$order_sn = think_decrypt($osm);
    		$order = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid,'status'=>1))->find();
    		if(!$order){
    			$this->error("订单不存在,或者已经支付过了!");
    		}
    		$pay_cate = I('pay_cate');
    		if(!$pay_cate){
    			$this->error("支付方式不存在，请选择!");
    		}
    		$productList = $this->OrderProductMod->where(array('order_id'=>$order['id']))->select();
    		foreach ($productList as $key=>$val){
    			$price = $GoodSkuMod->where(array('properies'=>$val['props']))->getField('price');
    			if($price<=0){
    				$price = $this->MallMod->where(array('id'=>$val['product_id']))->getField('price');
    			}
    			if($val['sum_price'] != $price*$val['num']){
    				$this->OrderMod->where(array('id'=>$order['id']))->setField('status',0);
    				$this->error("该订单中的商品价格已发生变化，订单关闭，需要重新下单!",U('Order/index'));
    			}
    		}
    		//执行支付
    		switch($pay_cate){
    			case 'alipay'://支付宝
    				$this->success("正在跳转到支付宝",U('alipay',array('osm'=>$osm),'','',true));
    				break;
    			case 'weixin':// 微信
    				$this->success("正在跳转到微信",U('weixin',array('osm'=>$osm),'','',true));
    				break;
    			case 'cft'://财付通
    				$this->success("正在跳转到财付通",U('tenpay',array('osm'=>$osm),'','',true));
    				break;
    			case 'ylpay'://财付通
    				$this->success("正在跳转到银联支付",U('ylpay',array('osm'=>$osm),'','',true));
    				break;
    			case 'alipay_mobile'://支付宝
    				$this->success("正在跳转到支付宝",U('alipay_mobile',array('osm'=>$osm),'','',true));
    				break;
    			case 'weixin_mobile'://微信
    				session('osm',$osm);
    				$this->success("正在跳转到微信",U('weixin_mobile','','','',true).'/');
    				break;
    			default:
    				$this->error("支付方式暂未开通，敬请期待!");
    		}
    		
    		$this->error("支付错误!".$pay_cate);
    	}
    	$this->assign('osm',$osm);
    	$this->display();
    }
    
    public function confirmReceipt(){
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	$order_sn = think_decrypt($osm);
    	$re = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid))->setField('status','4');
    	if($re){
    		$this->success('确认收货成功！');
    	}
    	else{
    		$this->error('确认收货失败！');
    	}
    }
    
    public function weixin(){
    	header("Content-type: text/html; charset=utf-8");
    	
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	$order_sn = think_decrypt($osm);
    	$order = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid,'status'=>1))->find();
    	if(!$order){
    		$this->error("订单不存在!");
    	}
    	$ShopCartMod = M('ShopCart');
    	$GoodSkuMod = M('GoodSku');
    	$count_price = $this->OrderProductMod->where(array('order_id'=>$order['id']))->sum('sum_price');
    	if($count_price <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	$order['count_price'] = sprintf("%.2f", $count_price);
    	$this->assign('order',$order);
    	
    	$pay = new WeixinpayApi();
    	$parms['out_trade_no'] = $order_sn;
    	$parms['subject'] = "黑金杰尼商城订单-".$order_sn;
    	$parms['total_fee'] = sprintf("%.2f", $count_price);
    	$parms['body'] = "黑金杰尼商城订单-".$order_sn;
    	$parms['notify_url'] = U('ReturnPay/wxpay_notify_url',"","",true);
    	$result = $pay->doPay($parms);
    	if($result['result_code'] == 'FAIL'){
    		$this->error($result['err_code_des']);
    	}
    	else{
    		$url = $result["code_url"];
    		$this->assign('url',$url);
    		$this->display('weixinpay');
    	}
    	
    }
    
    public function weixin_mobile(){
    	header("Content-type: text/html; charset=utf-8");
    	$osm = session('osm');
    	$uid = sp_get_current_userid();
    	$order_sn = think_decrypt($osm);
    	$order = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid,'status'=>1))->find();
    	if(!$order){
    		$this->error("订单不存在!");
    	}
    	$ShopCartMod = M('ShopCart');
    	$GoodSkuMod = M('GoodSku');
    	$count_price = $this->OrderProductMod->where(array('order_id'=>$order['id']))->sum('sum_price');
    	if($count_price <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	$order['count_price'] = sprintf("%.2f", $count_price);
    	$this->assign('order',$order);
    	 
    	$pay = new WeixinpayApi();
    	$parms['out_trade_no'] = $order_sn;
    	$parms['subject'] = "黑金杰尼商城订单-".$order_sn;
    	$parms['total_fee'] = sprintf("%.2f", $count_price);
    	$parms['body'] = "黑金杰尼商城订单-".$order_sn;
    	$parms['notify_url'] = U('ReturnPay/wxpay_notify_url',"","",true);
    	try {
    		$result = $pay->domobile($parms);
    	} catch (\Exception $e) {
    		$this->error($e->getMessage());
    	}
    	
    	$this->assign('jsApiParameters',$result[1]);
    	$this->assign('editAddress',$result[2]);
    	$this->display('weixinpay');
    	
    	/*if($result['result_code'] == 'FAIL'){
    		$this->error($result['err_code_des']);
    	}
    	else{
    		$url = $result["code_url"];
    		$this->assign('url',$url);
    		$this->display('weixinpay');
    	}*/
    }
    
    function wxpay_inquiry_order(){
    	$out_trade_no = I("post.out_trade_no");
    	$pay = new WeixinpayApi();
    	echo $pay->inquiry_order($out_trade_no);
    }
    
    public function ylpay(){
    	header("Content-type:text/html;charset=utf-8");
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	$order_sn = think_decrypt($osm);
    	$order = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid,'status'=>1))->find();
    	if(!$order){
    		$this->error("订单不存在!");
    	}
    	
    	$ShopCartMod = M('ShopCart');
    	$GoodSkuMod = M('GoodSku');
    	$count_price = $this->OrderProductMod->where(array('order_id'=>$order['id']))->sum('sum_price');
    	
    	if($count_price <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	$pay = new YlpayApi();
    	$parms['orderId'] = $order_sn;
    	$parms['txnAmt'] = $count_price*100;
    	$parms['txnTime'] = date('YmdHis');
    	$parms['frontUrl'] = 'http://www.blackgoldmall.com/index.php/Mall/ReturnPay/ylpay_return_url';
    	$parms['backUrl'] = 'http://www.blackgoldmall.com/index.php/Mall/ReturnPay/ylpay_notify_url';
    	
    	//$parms['frontUrl'] = U('ReturnPay/ylpay_notify_url',"","",true);
    	//$parms['backUrl'] = U('ReturnPay/ylpay_return_url',"","",true);
    	$url = $pay->dopay($parms);
    	
    	echo $url;
    }
    
    public function alipay(){
    	header("Content-type:text/html;charset=utf-8");
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	$order_sn = think_decrypt($osm);
    	$order = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid,'status'=>1))->find();
    	if(!$order){
    		$this->error("订单不存在!");
    	}
    	$ShopCartMod = M('ShopCart');
    	$GoodSkuMod = M('GoodSku');
    	$count_price = $this->OrderProductMod->where(array('order_id'=>$order['id']))->sum('sum_price');
    	if($count_price <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	
    	$pay = new AlipayApi();
    	$order_def['out_trade_no'] = $order_sn;
    	$order_def['subject'] = "黑金杰尼商城订单-".$order_sn;
    	$order_def['total_fee'] = sprintf("%.2f", $count_price);
    	$order_def['body'] = "黑金杰尼商城订单-".$order_sn;
    	$order_def['notify_url'] = U('ReturnPay/alipay_notify_url',"","",true);
    	$order_def['return_url'] = U('ReturnPay/alipay_return_url',"","",true);
    	$url = $pay->doalipay($order_def);
    	echo $url;
    }
    
    public function alipay_mobile(){
    	header("Content-type:text/html;charset=utf-8");
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	$order_sn = think_decrypt($osm);
    	$order = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid,'status'=>1))->find();
    	if(!$order){
    		$this->error("订单不存在!");
    	}
    	$ShopCartMod = M('ShopCart');
    	$GoodSkuMod = M('GoodSku');
    	$count_price = $this->OrderProductMod->where(array('order_id'=>$order['id']))->sum('sum_price');
    	if($count_price <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	
    	$pay = new AlipayApi();
    	$order_def['WIDout_trade_no'] = $order_sn;
    	$order_def['WIDsubject'] = "黑金杰尼商城订单-".$order_sn;
    	$order_def['WIDtotal_amount'] = sprintf("%.2f", $count_price);
    	$order_def['WIDbody'] = "黑金杰尼商城订单-".$order_sn;
    	$order_def['notify_url'] = U('ReturnPay/alipay_mobile_notify',"","",true);
    	$order_def['return_url'] = U('ReturnPay/alipay_return_url',"","",true);
    	$url = $pay->mobilepay($order_def);
    	echo $url;
    }
    
    public function tenpay(){
    	header("Content-type:text/html;charset=utf-8");
    	$osm = I('osm');
    	$uid = sp_get_current_userid();
    	$order_sn = think_decrypt($osm);
    	$order = $this->OrderMod->where(array('order_sn'=>$order_sn,'uid'=>$uid,'status'=>1))->find();
    	if(!$order){
    		$this->error("订单不存在!");
    	}
    	$ShopCartMod = M('ShopCart');
    	$GoodSkuMod = M('GoodSku');
    	$count_price = $this->OrderProductMod->where(array('order_id'=>$order['id']))->sum('sum_price');
    	if($count_price <= 0){
    		$this->error("订单价格不正确，请重新下单!");
    	}
    	
    	$tenpay = new TenpayApi();
    	$parm['out_trade_no'] = $order_sn;
    	$parm['total_fee'] = $count_price*100;
    	$parm['body'] = "黑金杰尼商城订单-".$order_sn;
    	$parm['subject'] = "黑金杰尼商城订单-".$order_sn;
    	$parm['notify_url'] = U('ReturnPay/tenpay_notify_url',"","",true);
    	$parm['return_url'] = U('ReturnPay/tenpay_return_url',"","",true);
    	$url = $tenpay->dopay($parm);
    	redirect($url);
    	//var_dump($url);
    	//$this->assign('url',$url);
    	//$this->display();
    }
    
    public function saleSupport($id = null){
    	if(!$id){
    		$this->error('参数错误！');
    	}
    	$data = $this->OrderProductMod->find($id);
    	$uid = sp_get_current_userid();
    	$order = $this->OrderMod->where(array('id'=>$data['order_id'],'uid'=>$uid,'status'=>array('in',array(0,2,3,4))))->find();
    	if(!$order){
    		$this->error('订单已删除或者未支付，不支持售后服务！');
    	}
    	$this->assign('order',$order);
    	
		$product = array();
		$product = $this->MallViewMod->field('price,title,img')->find($data['product_id']);
		$data = array_merge($data,$product);
		$data['attr_info'] = implode('<br>', $this->getAttrInfo($data['props']));
		
		$this->assign('data',$data);
		$this->assign('line_step',1);
		if($data['refund_id']){
			$refund = $this->OrderRefundMod->find($data['refund_id']);
			$this->assign('refund',$refund);
			if($refund){
				if($refund['step_id'] == 1){
					$info = "正在等待商家处理售后申请...";
					$this->assign('info',$info);
					$this->assign('line_step',2);
					$this->display('saleInfo');
					exit();
				}
				else if($refund['step_id'] == 2){
					$this->assign('line_step',2);
					$this->display('confirmReturnInfo');
					exit();
				}
				else if($refund['step_id'] == 3){
					$info = "正在等待商家确认收货...";
					$this->assign('info',$info);
					$this->assign('line_step',2);
					$this->display('saleInfo');
					exit();
				}
				else if($refund['step_id'] == 4){
					$info = "退款已完成,款项原路退回到您的支付账户...";
					$this->assign('info',$info);
					$this->assign('line_step',3);
					$this->display('refundSuccess');
					exit();
				}
				else if($refund['step_id'] == -1){
					$info = "商家拒绝退款";
					$this->assign('info',$info);
					$this->assign('line_step',3);
					$this->display('saleInfo');
					exit();
				}
			}
		}
		$supportType = 1;
		if(I('supportType')){
			$supportType = I('supportType');
		}
		$this->assign('supportType',$supportType);
		$this->display();
    }
    
    function editSaleSupport($id = null){
    	if(!$id){
    		$this->error('参数错误！');
    	}
    	$data = $this->OrderProductMod->find($id);
    	if($data['shouhou'] == '-1'){
    		$this->error('商家禁止该商品继续申请退款！');
    	}
    	$uid = sp_get_current_userid();
    	$order = $this->OrderMod->where(array('id'=>$data['order_id'],'uid'=>$uid,'status'=>array('egt',1)))->find();
    	if(!$order){
    		$this->error('订单已删除或者未支付，不支持售后服务！');
    	}
    	$this->assign('order',$order);
    	 
    	$product = array();
    	$product = $this->MallViewMod->field('price,title,img')->find($data['product_id']);
    	$data = array_merge($data,$product);
    	$data['attr_info'] = implode('<br>', $this->getAttrInfo($data['props']));
    	$this->assign('data',$data);
    	$this->assign('line_step',1);
    	$supportType = 1;
    	if(I('supportType')){
    		$supportType = I('supportType');
    	}
    	$this->assign('supportType',$supportType);
    	$this->display('saleSupport');
    }
    
    function createRefund(){
    	$_POST['uid'] = sp_get_current_userid();
    	$img_list = $_POST['img_list'];
    	foreach ($img_list as $key=>$val){
    		$_POST['img'.($key+1)] = $val;
    	}
    	$product = $this->OrderProductMod->find($_POST['pack_id']);
    	if(!$product){
    		$this->error('参数错误');
    	}
    	if(I('type_id') == 1){
    		$status = $this->OrderMod->where(array('id'=>$product['order_id']))->getField('status');
    		if($status <= 2){
    			$this->error('还没有发货，不需要退货，请选择仅退款');
    		}
    	}
    	if($_POST['return_money'] > $product['sum_price']){
    		$this->error('退款金额不能大于￥'.$product['sum_price']);
    	}
    	else if($_POST['return_money'] <= 0){
    		$this->error('退款金额不能小于￥0.00');
    	}
    	$_POST['refund_sn'] = sp_get_order_sn();
    	$data = $this->OrderRefundMod->create();
    	if($data){
    		$re = $this->OrderRefundMod->add();
	    	if($re){
	    		$save['id'] = $data['pack_id'];
	    		$save['refund_id'] = $re;
	    		$save['shouhou'] = 1;
	    		$this->OrderProductMod->save($save);
	    		$this->success('提交成功！',U('Order/index'));
	    	}
	    	else{
	    		$this->error('提交失败！');
	    	}
    	}
    	else{
    		$this->error($this->OrderRefundMod->getError());
    	}
    }
    
    function confirmReturnInfo(){
    	$uid = sp_get_current_userid();
    	$old_data = $this->OrderRefundMod->where(array('uid'=>$uid,'id'=>$_POST['id']))->find();
    	if(!$old_data){
    		$this->error('不是您的退货信息！');
    	}
    	$data['id'] = I('id');
    	$data['express'] = I('express');
    	if(empty($data['express'])){
    		$this->error('请填写快递公司！');
    	}
    	$data['express_sn'] = I('express_sn');
    	if(empty($data['express'])){
    		$this->error('请填写物流编号！');
    	}
    	$data['step_id'] = 3;
	   	$re = $this->OrderRefundMod->save($data);
	   	if($re){
	   		$this->success('提交物流成功！');
	   	}
	   	else{
	   		$this->error('提交物流失败！');
	   	}
    }
}