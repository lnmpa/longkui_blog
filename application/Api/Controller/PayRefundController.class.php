<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------

namespace Api\Controller;

use Common\Controller\HomebaseController;
use Common\Api\AlipayApi;
use Common\Api\YlpayApi;

class PayRefundController extends HomebaseController {
	
	public function _initialize() {
		
	}
	
	public function aliRefundNotify(){
		$post=I('post.');
		
		$alipay=new AlipayApi();
		$alipay_status=$alipay->refund_verify_result();
		
		if($alipay_status){//验证数据成功
			M('Options')->add(array('option_name'=>time(),'option_value'=>json_encode($_REQUEST)));
			$refund_id = think_decrypt($_REQUEST['refund_id']);
			if(is_numeric($refund_id)){
				$OrderProductMod = M('OrderProduct');
				$OrderRefundMod = M('OrderRefund');
				$data['id'] = $refund_id;
				$data['step_id'] = 4;
				$data['update_time'] = date('Y-m-d H:i:s',time());
				$OrderRefundMod->save($data);
				$refund = $OrderRefundMod->find($refund_id);
				$order_id = $OrderProductMod->where(array('id'=>$refund['pack_id']))->getField('order_id');
				$count = $OrderProductMod->where(array('order_id'=>$order_id,'shouhou'=>array('not in',array(1,2))))->count();
				if($count <= 0){
					M('Order')->where(array('id'=>$order_id))->setField('status',0);
				}
				$OrderProductMod->where(array('id'=>$refund['pack_id']))->setField('shouhou',2);
			}
			$rel="success";		//请不要修改或删除
		}else{
			$rel="fail";        //请不要修改或删除
		}
		
		echo $rel;//请不要修改或删除
	}
	
	public function ylRefundNotify(){
		$post=I('post.');
		$pay = new YlpayApi();
		if($pay->validate($post)){
			M('Options')->add(array('option_name'=>time(),'option_value'=>json_encode($_REQUEST)));
			$refund_id = think_decrypt($_REQUEST['refund_id']);
			if(is_numeric($refund_id)){
				$OrderProductMod = M('OrderProduct');
				$OrderRefundMod = M('OrderRefund');
				$data['id'] = $refund_id;
				$data['step_id'] = 4;
				$data['update_time'] = date('Y-m-d H:i:s',time());
				$OrderRefundMod->save($data);
				$refund = $OrderRefundMod->find($refund_id);
				$order_id = $OrderProductMod->where(array('id'=>$refund['pack_id']))->getField('order_id');
				$count = $OrderProductMod->where(array('order_id'=>$order_id,'shouhou'=>array('not in',array(1,2))))->count();
				if($count <= 0){
					M('Order')->where(array('id'=>$order_id))->setField('status',0);
				}
				$OrderProductMod->where(array('id'=>$refund['pack_id']))->setField('shouhou',2);
			}
		}
	}
	
	public function wxRefundNotify(){
		
	}
	
	public function tenRefundNotify(){
	
	}
}