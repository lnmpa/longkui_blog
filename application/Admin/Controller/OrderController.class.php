<?php
/**
 * ActivityCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Common\Api\AlipayApi;
use Common\Api\WeixinpayApi;
use Common\Api\YlpayApi;

class OrderController extends AdminbaseController {

    protected $OrderMod;
	protected $OrderProductMod;
	protected $OrderRefundMod;
	protected $MallMod;
	protected $UsersMod;
	protected $MallViewMod;
	
    public function _initialize() {
    	header("Content-type:text/html;charset=utf-8");
        parent::_initialize();
        $this->OrderMod = D('Common/Order');
		$this->OrderProductMod = D('Common/OrderProduct');
		$this->OrderRefundMod = D('Common/OrderRefund');
		$this->MallMod = D("Common/Mall");
		$this->UsersMod = D("Common/Users");
		$this->MallViewMod = D("Common/MallView");
    }
    
    // 后台菜单列表
    public function index() {
    	$where['status'] = array('egt',0);
    	if(I('type')){
    		$where['status'] = array('eq',I('type'));
    	}
    	
    	if(I('order_sn')){
    		$where['order_sn'] = array('eq',I('order_sn'));
    		$this->assign('order_sn',I('order_sn'));
    	}
    	if(I('start_time') || I('end_time')){
    		if(I('start_time')){
    			$map[] = array('egt',I('start_time'));
    		}
    		if(I('end_time')){
    			$map[] = array('elt',I('end_time'));
    		}
    		$map[] = 'and';
    		$where['create_time'] = $map;
    		$this->assign('start_time',I('start_time'));
    		$this->assign('end_time',I('end_time'));
    	}
    	
    	$count=$this->OrderMod->where($where)->count();
    	$page = $this->page($count, 20);
    	$list = $this->OrderMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order("create_time DESC")
    	->select();
    	
    	foreach ($list as $key=>$val){
    		$list[$key]['status_info'] = $this->OrderMod->get_status_info($val['status']);
    		$list[$key]['user_name'] = $this->UsersMod->where(array('id'=>$val['uid']))->getField('mobile');
    		$list[$key]['pack_num'] = $this->OrderProductMod->where(array('order_id'=>$val['id']))->count();
    		$list[$key]['shouhou_pack_num'] = $this->OrderProductMod->where(array('order_id'=>$val['id'],'shouhou'=>1))->count();
    	}
    	
    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	$this->display();
    }
    
    public function waitSendList(){
    	$where['status'] = array('eq',2);
    	
    	if(I('order_sn')){
    		$where['order_sn'] = array('eq',I('order_sn'));
    		$this->assign('order_sn',I('order_sn'));
    	}
    	if(I('start_time') || I('end_time')){
    		if(I('start_time')){
    			$map[] = array('egt',I('start_time'));
    		}
    		if(I('end_time')){
    			$map[] = array('elt',I('end_time'));
    		}
    		$map[] = 'and';
    		$where['create_time'] = $map;
    		$this->assign('start_time',I('start_time'));
    		$this->assign('end_time',I('end_time'));
    	}
    	
    	$count=$this->OrderMod->where($where)->count();
    	$page = $this->page($count, 20);
    	 
    	$list = $this->OrderMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order("create_time DESC")
    	->select();
    	 
    	foreach ($list as $key=>$val){
    		$list[$key]['status_info'] = $this->OrderMod->get_status_info($val['status']);
    		$list[$key]['user_name'] = $this->UsersMod->where(array('id'=>$val['uid']))->getField('mobile');
    		$list[$key]['pack_num'] = $this->OrderProductMod->where(array('order_id'=>$val['id']))->count();
    		$list[$key]['shouhou_pack_num'] = $this->OrderProductMod->where(array('order_id'=>$val['id'],'shouhou'=>1))->count();
    	}
    	 
    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	$this->display();
    }
    
    public function refundList(){
    	$where['r.type_id'] = array('eq',1);
    	$where['r.step_id'] = array('in',array(1,2,3));
    	
    	if(I('order_sn')){
    		$where['o.order_sn'] = array('eq',I('order_sn'));
    		$this->assign('order_sn',I('order_sn'));
    	}
    	if(I('start_time') || I('end_time')){
    		if(I('start_time')){
    			$map[] = array('egt',I('start_time'));
    		}
    		if(I('end_time')){
    			$map[] = array('elt',I('end_time'));
    		}
    		$map[] = 'and';
    		$where['o.create_time'] = $map;
    		$this->assign('start_time',I('start_time'));
    		$this->assign('end_time',I('end_time'));
    	}
    	
    	$count=$this->OrderProductMod
    	->alias('p')
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->where($where)
    	->count();
    	$page = $this->page($count, 20);
    
    	$list = $this->OrderProductMod
    	->alias('p')
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->where($where)
    	->field('p.id,o.order_sn,o.uid,o.name,o.mobile,o.create_time,p.refund_id,p.order_id,p.product_id,p.num,p.one_price,p.sum_price,r.return_money,r.remark,r.step_id,r.express,r.express_sn,r.img1,r.img2,r.img3')
    	->limit($page->firstRow , $page->listRows)
    	->order("r.update_time DESC")
    	->select();
    
    	foreach ($list as $key=>$val){
    		$mall_info = array();
    		$mall_info = $this->MallViewMod->where(array('id'=>$val['product_id']))->field('title,img')->find();
    		$list[$key] = array_merge($list[$key],$mall_info);
    		$list[$key]['user_name'] = $this->UsersMod->where(array('id'=>$val['uid']))->getField('mobile');
    	}
    	
    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	$this->display();
    }

    public function agreeRefundGoods($id = null){
    	if(!$id){
    		$this->error("参数错误!");
    	}
    	if(IS_AJAX){
    		$pack = $this->OrderProductMod->find($id);
    		if(!$pack){
    			$this->error("参数错误!");
    		}
    		$data['id'] = $pack['refund_id'];
    		$data['step_id'] = 2;
    		$data['update_time'] = date('Y-m-d H:i:s',time());
    		$re = $this->OrderRefundMod->save($data);
    		if($re){
    			$this->success('操作成功');
    		}
    		else{
    			$this->error('操作失败');
    		}
    	}
    }
    
    public function agreeRefundMoney($id = null){
    	if(!$id){
    		$this->error("参数错误!");
    	}
    	if(IS_AJAX){
    		$data = $this->OrderProductMod
    		->alias('p')
    		->join("__ORDER__ as o on o.id = p.order_id")
    		->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    		->where(array('p.id'=>$id))
    		->find();
    		if($data['type_id'] == 4){
    			$this->error('已经退款成功，请刷新页面，不要重复操作!');
    		}
    		if($data['pay_type'] == 'alipay'){
    			$this->success('正在跳转到支付宝退款',U('aliRefund?id='.$id));
    		}
    		else if($data['pay_type'] == 'wxpay'){
    			if($this->wxRefund($id)){
    				$OrderProductMod = M('OrderProduct');
    				$OrderRefundMod = M('OrderRefund');
    				$data2['id'] = $data['refund_id'];
    				$data2['step_id'] = 4;
    				$data2['update_time'] = date('Y-m-d H:i:s',time());
    				$OrderRefundMod->save($data2);
    				$refund = $OrderRefundMod->find($data['refund_id']);
    				$order_id = $OrderProductMod->where(array('id'=>$refund['pack_id']))->getField('order_id');
    				$count = $OrderProductMod->where(array('order_id'=>$order_id,'shouhou'=>array('not in',array(1,2))))->count();
    				if($count <= 0){
    					M('Order')->where(array('id'=>$order_id))->setField('status',0);
    				}
    				$OrderProductMod->where(array('id'=>$refund['pack_id']))->setField('shouhou',2);
    				$this->success('微信退款成功!');
    			}
    			else{
    				$this->error('微信退款失败!');
    			}
    			//$this->success('正在跳转到微信退款',U('wxRefund?id='.$id));
    		}
    		else if($data['pay_type'] == 'ylpay'){
    			$result = $this->ylRefund($id);
    			if($result['status'] == 1){
    				$this->success('银联退款成功!');
    			}
    			else{
    				$this->error($result['error']);
    			}
    			//$this->success('正在跳转到银联退款',U('ylRefund?id='.$id));
    		}
    		else if($data['pay_type'] == 'alipay_mobile'){
    			//$this->success('正在跳转',U('alipayMobileRefund?id='.$id));
    			$result = $this->alipayMobileRefund($id);
    			if($result['code'] == '10000'){
    				$OrderProductMod = M('OrderProduct');
    				$OrderRefundMod = M('OrderRefund');
    				$data2['id'] = $data['refund_id'];
    				$data2['step_id'] = 4;
    				$data2['update_time'] = date('Y-m-d H:i:s',time());
    				$OrderRefundMod->save($data2);
    				$refund = $OrderRefundMod->find($data['refund_id']);
    				$order_id = $OrderProductMod->where(array('id'=>$refund['pack_id']))->getField('order_id');
    				$count = $OrderProductMod->where(array('order_id'=>$order_id,'shouhou'=>array('not in',array(1,2))))->count();
    				if($count <= 0){
    					M('Order')->where(array('id'=>$order_id))->setField('status',0);
    				}
    				$OrderProductMod->where(array('id'=>$refund['pack_id']))->setField('shouhou',2);
    				$this->success('支付宝退款成功!');
    			}
    			else{
    				$this->error($result['sub_msg']);
    			}
    		}
    		else{
    			$this->error('无支付方式,请联系客服解决');
    		}
    	}
    }
    
    public function aliRefund($id = null){
    	if(!$id){
    		$this->error("参数错误!");
    	}
    	$data = $this->OrderProductMod
    	->alias('p')
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->where(array('p.id'=>$id))
    	->find();
    	
    	$pay = new AlipayApi();
    	$params['WIDbatch_no'] = sp_get_order_sn();
    	$this->OrderRefundMod->where(array('id'=>$data['refund_id']))->setField('refund_sn',$params['WIDbatch_no']);
    	$params['WIDbatch_num'] = 1;
    	$params['WIDdetail_data'] = $data['trade_no'].'^'.$data['return_money'].'^交易退款';
    	$params['notify_url'] = U('Api/PayRefund/aliRefundNotify',array('refund_id'=>think_encrypt($data['refund_id'])),"",true);
    	$url = $pay->doRefund($params);
    	echo $url;
    }
    
    private function alipayMobileRefund($id = null){
    	if(!$id){
    		$this->error("参数错误!");
    	}
    	$data = $this->OrderProductMod
    	->alias('p')
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->where(array('p.id'=>$id))
    	->find();
		
    	$pay = new AlipayApi();
    	$params['WIDout_trade_no'] = $data['order_sn'];
    	$params['WIDtrade_no'] = $data['trade_no'];
    	$params['WIDrefund_amount'] = $data['return_money'];
    	$params['WIDrefund_reason'] = "交易退款";
    	$params['WIDout_request_no'] = $data['refund_sn']?$data['refund_sn']:sp_get_order_sn();
    	return $pay->mobile_refund($params);
    }
    
    private function wxRefund($id = null){
    	if(!$id){
    		$this->error("参数错误!");
    	}
    	$data = $this->OrderProductMod
    	->alias('p')
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->where(array('p.id'=>$id))
    	->find();
    	
    	$pay = new WeixinpayApi();
    	$params['transaction_id'] = $data['trade_no'];
    	$params['total_fee'] = $data['pay_money']*100;
    	$params['refund_fee'] = $data['return_money']*100;
    	 
    	$result = $pay->doRefund($params);
    	if($result['return_code'] == 'SUCCESS'){
    		return true;
    	}
    	else{
    		return false;
    	}
    }
    
    private function ylRefund($id = null){
    	if(!$id){
    		$this->error("参数错误!");
    	}
    	$data = $this->OrderProductMod
    	->alias('p')
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->where(array('p.id'=>$id))
    	->find();
    	
    	$pay = new YlpayApi();
    	$params['backUrl'] = U('Api/PayRefund/ylRefundNotify',array('refund_id'=>think_encrypt($data['refund_id'])),"",true);
    	$params['orderId'] = $data['refund_sn']?$data['refund_sn']:sp_get_order_sn();
    	$params['origQryId'] = $data['trade_no'];
    	$params['txnTime'] = date('YmdHis');
    	$params['txnAmt'] = $data['return_money']*100;
    	
    	return $pay->doRefund($params);
    }
    
    public function rejectRefund(){
    	$id = I('id');
    	if(!$id){
    		$this->error('参数错误');
    	}
    	if(IS_POST){
    		$reject_reason = I('reject_reason');
    		if(!$reject_reason){
    			$this->error('请填写拒绝原因');
    		}
    		M()->startTrans();
    		$data['id'] = $id;
    		$data['step_id'] = -1;
    		$data['reject_reason'] = $reject_reason;
    		$re = $this->OrderRefundMod->save($data);
    		$pack_id = $this->OrderRefundMod->where(array('id'=>$id))->getField('pack_id');
    		$is_forbid = I('is_forbid');
    		if($is_forbid){
    			$this->OrderProductMod->where(array('id'=>$pack_id))->setField('shouhou',-1);
    		}
    		else{
    			$this->OrderProductMod->where(array('id'=>$pack_id))->setField('shouhou',0);
    		}
    		if($re){
    			M()->commit();
    			$this->success("操作成功！");
    		}
    		else{
    			M()->rollback();
    			$this->error("操作失败！");
    		}
    	}
    }
    
    public function refundMoneyList(){
    	$where['r.type_id'] = array('eq',2);
    	$where['r.step_id'] = array('eq',1);
    	
    	if(I('order_sn')){
    		$where['o.order_sn'] = array('eq',I('order_sn'));
    		$this->assign('order_sn',I('order_sn'));
    	}
    	if(I('start_time') || I('end_time')){
    		if(I('start_time')){
    			$map[] = array('egt',I('start_time'));
    		}
    		if(I('end_time')){
    			$map[] = array('elt',I('end_time'));
    		}
    		$map[] = 'and';
    		$where['o.create_time'] = $map;
    		$this->assign('start_time',I('start_time'));
    		$this->assign('end_time',I('end_time'));
    	}
    	
    	$count=$this->OrderProductMod
    	->alias('p')
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->where($where)
    	->count();
    	$page = $this->page($count, 20);
    	
    	$list = $this->OrderProductMod
    	->alias('p')
    	->join("__ORDER_REFUND__ as r on r.id = p.refund_id")
    	->join("__ORDER__ as o on o.id = p.order_id")
    	->where($where)
    	->field('p.id,o.order_sn,o.uid,o.name,o.mobile,o.create_time,p.refund_id,p.order_id,p.product_id,p.num,p.one_price,p.sum_price,r.return_money,r.remark,r.img1,r.img2,r.img3')
    	->limit($page->firstRow , $page->listRows)
    	->order("r.update_time DESC")
    	->select();
    	foreach ($list as $key=>$val){
    		$mall_info = array();
    		$mall_info = $this->MallViewMod->where(array('id'=>$val['product_id']))->field('title,img')->find();
    		$list[$key] = array_merge($list[$key],$mall_info);
    		$list[$key]['user_name'] = $this->UsersMod->where(array('id'=>$val['uid']))->getField('mobile');
    	}
    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	$this->display();
    }
    
    public function sendGoods($id = null){
    	if(!$id){
    		$this->error('参数错误');
    	}
    	if(IS_POST){
    		$data['id'] = $id;
    		$data['send_express'] = I('send_express');
    		$data['send_express_sn'] = I('send_express_sn');
    		$data['status'] = 3;
    		$re = $this->OrderMod->save($data);
    		if($re){
    			$this->success("发货成功！");
    		}
    		else{
    			$this->error('发货失败！');
    		}
    	}
    	$data = $this->OrderMod->find($id);
    	$this->assign('data',$data);
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
    
    public function showOrder($id = null){
    	if(!$id){
    		$this->error('参数错误');
    	}
    	$data = $this->OrderMod->find($id);
    	$data['user_name'] = $this->UsersMod->where(array('id'=>$data['uid']))->getField('mobile');
    	$this->assign('data',$data);
    	
    	$list = $this->OrderProductMod->where(array('order_id'=>$id))->select();
    	foreach ($list as $key=>$val){
    		$product = array();
    		$product = $this->MallViewMod->field('price,title,img')->find($val['product_id']);
    		$list[$key] = array_merge($list[$key],$product);
    		$refund = array();
    		$refund = $this->OrderRefundMod->field('step_id,type_id,is_receive,return_money,remark,img1,img2,img3')->find($val['refund_id']);
    		$list[$key]['refund'] = $refund;
    		$list[$key]['attr_info'] = implode('<br>', $this->getAttrInfo($val['props']));
    	}
    	$this->assign('list',$list);
    	$this->display();
    }
    
    public function add(){
    	//$this->error("添加失败！");
    	if(IS_POST){
    		if($_POST['img']){
    			$_POST['img'] = sp_asset_relative_url($_POST['img']);
    		}
    		$data = $this->ActivityModel->create();
    		if(!$data){
    			$this->error($this->ActivityModel->getError());
    		}
    		$data['status'] = 1;
    		$re = $this->ActivityModel->add($data);
    		if($re){
    			
    			if($re){
    				$this->success("新增成功！");
    			}
    			else{
    				$this->error("新增失败！");
    			}
    		}
    		else{
    			$this->error($this->ActivityModel->getError());
    		}
    	}
    	$this->meta_title = "添加活动";
    	$this->display('edit');
    }
    
    public function edit(){
    	if(IS_POST){
    		if($_POST['img']){
    			$_POST['img'] = sp_asset_relative_url($_POST['img']);
    		}
    		$data = $this->ActivityModel->create();
    		if(!$data){
    			$this->error($this->ActivityModel->getError());
    		}
    		
    		if($data){
    			$re = $this->ActivityModel->save($data);
    			if($re){
    				$this->success("修改成功！");
    			}
    			else{
    				$this->error("修改失败！");
    			}
    		}
    		else{
    			$this->error($this->ActivityModel->getError());
    		}
    	}
    	$id = I('request.id',0,'intval');
    	$data = $this->ActivityModel->find($id);
    	$this->assign('data',$data);
    	$this->meta_title = "编辑活动";
    	$this->display('edit');
    }
    
    public function delete(){
    	$ids = I('ids');
    	if(!$ids){
    		$this->error("请选择数据!");
    	}
    	M()->startTrans();
    	$re = $this->ActivityModel->where(array('id'=>array('in',$ids)))->delete();
    	$re2 = $this->ActivityOrderModel->where(array('activity_id'=>array('in',$ids)))->delete();
    	if($re){
    		M()->commit();
    		$this->success('删除成功!');
    	}
    	else{
    		M()->rollback();
    		$this->error("删除失败!");
    	}
    }
    
    // 获取文章分类树结构
    private function _getCateTree($cate_id,$nbsp = "&nbsp;&nbsp;&nbsp;"){
    	$result = $this->ActivityCate_model->where(array('status'=>1))->order(array("sort_order"=>"asc"))->select();
    	
    	$tree = new \Tree();
    	$tree->icon = array($nbsp.'│ ', $nbsp.'├─ ', $nbsp.'└─ ');
    	$tree->nbsp = $nbsp;
    	foreach ($result as $r) {
    		$r['parentid']=$r['pid'];
    		$r['selected']= $cate_id==$r['id']?"selected":"";
    		$array[] = $r;
    	}
    	
    	$tree->init($array);
    	$str="<option value='\$id' \$selected>\$spacer\$name</option>";
    	$taxonomys = $tree->get_tree(0, $str);
    	$this->assign("taxonomys", $taxonomys);
    }
    
    function display_tree($classid) {
    	$article_cate_mod = $this->ActivityCate_model;
    	$data['pid'] = $classid;
    	$data['status'] = 1;
    	$result = $article_cate_mod->where($data)->order('sort_order asc,id asc')->select();
    	$retStr = "";
    	foreach($result as $row){
    		$retStr .= "{name:\"".$row['name'] . "\"";
    		$retStr .= ",\"url\":\"".U('index',array('cate_id'=>$row['id'],'alias_template'=>$row['alias_template']))."\", \"target\":\"Activity_content\",\"click\":\"changeUrl('#')\"";
    		
    		if($row['pid']==0)
    		{
    			$retStr .=",open:true";
    		}
    		if($this->display_tree($row['id']) != "")
    		{
    			$retStr .= ",children:[";
    			$retStr .= $this->display_tree($row['id']);
    			$retStr .= "]";
    		}else{
    			$retStr .= ",\"url\":\"".U('index',array('cate_id'=>$row['id'],'alias_template'=>$row['alias_template']))."\", \"target\":\"Activity_content\",\"click\":\"changeUrl('#')\"";
    		}
    		$retStr .= "},";
    	}
    	return  $retStr;
    }
    
    public function status(){
    	$value = intval($_REQUEST['value']);
    	$ids = I('post.ids');
    	$type = I('request.type');
    	if(!$ids){
    		$this->error("请至少选择一项！");
    	}
    	$re = $this->ActivityModel->where(array('id'=>array('in',$ids)))->setField($type,$value);
    	if ($re) {
    		$this->success("更新成功！");
    	} else {
    		$this->error("更新失败！");
    	}
    }
    
}