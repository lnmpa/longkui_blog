<?php
namespace Mall\Controller;

class UserController extends HomeController {
	
	protected $user_model;
	protected $user;
	protected $userid;
	protected $UserAddressMod;
	protected $MallViewMod;
	
	function _initialize() {
		parent::_initialize();
		$this->check_login();
		$this->check_user();
		if(sp_is_user_login()){
			$this->userid=sp_get_current_userid();
			$this->users_model=D("Common/Users");
			$this->user=$this->users_model->where(array("id"=>$this->userid))->find();
		}
		$this->UserAddressMod = D('Common/UserAddress');
		switch (LANG_SET){
			case 'en-us':
				$this->MallViewMod = D("Common/MallEnView");
				break;
			default:
				$this->MallViewMod = D("Common/MallView");
		}
	}
	
	public function index(){
		
		$this->display();
	}
	
	public function address(){
		$uid = sp_get_current_userid();
		$list=$this->UserAddressMod->where(array('uid'=>$uid,'status'=>1))->order('id desc')->select();
		
		
		$this->assign('list',$list);
		$this->display();
	}
	
	public function addressAdd(){
		if(IS_POST){
			$_POST['uid'] = sp_get_current_userid();
			$count = $this->UserAddressMod->where(array('uid'=>$_POST['uid'],'status'=>1))->count();
			if($count <= 0){
				$_POST['default'] = 1;
			}
			$_POST['area_ids'] = implode(',', I('area_ids'));
			if(!str_replace(',', '', $_POST['area_ids'])){
				$_POST['area_ids'] = null;
			}
			$data = $this->UserAddressMod->create();
			if(!$data){
				$this->error($this->UserAddressMod->getError());
			}
			$re = $this->UserAddressMod->add();
			if($re){
				$data['info'] = "添加成功！";
				$data['id'] = $re;
				$data['status'] = 1;
				$data['area'] = get_area($data['area_ids']);
				$data['mobile'] = do_mi($data['mobile']);
				$this->ajaxReturn($data);
				//$this->success('添加成功！');
			}
			else{
				$this->error('添加失败！');
			}
		}
		//$user = sp_get_current_user();
		//$data['name'] = $user['user_nicename'];
		//$data['mobile'] = $user['mobile'];
		//$this->assign('data',$data);
		$this->display('addressEdit');
	}
	
	public function addressEdit($id = null){
		if(IS_POST){
			$_POST['uid'] = sp_get_current_userid();
			$_POST['area_ids'] = implode(',', I('area_ids'));
			if(!str_replace(',', '', $_POST['area_ids'])){
				$_POST['area_ids'] = null;
			}
			if(!$this->UserAddressMod->create()){
				$this->error($this->UserAddressMod->getError());
			}
			if($this->UserAddressMod->save()){
				$this->success('修改成功！');
			}
			else{
				$this->error('修改失败！');
			}
		}
		$data = $this->UserAddressMod->find($id);
		$data['area_ids'] = explode(',', $data['area_ids']);
		$this->assign('data',$data);
		$this->display();
	}
	
	public function addressDelete($id = null){
		if(!$id){
			$this->error('参数错误！');
		}
		if($this->UserAddressMod->where(array('id'=>$id))->setField('status',0)){
			$this->success('删除成功！');
		}
		else{
			$this->error('删除失败！');
		}
	}
	
	public function addressDefault($id = null){
		$uid = sp_get_current_userid();
		M()->startTrans();
		$re = $this->UserAddressMod->where(array('uid'=>$uid,'id'=>array('neq',$id)))->setField('default',0);
		$re2 = $this->UserAddressMod->where(array('id'=>$id))->setField('default',1);
		if($re2){
			M()->commit();
			$this->success('设置成功！');
		}
		else{
			M()->rollback();
			$this->error('设置失败！');
		}
		
	}
	
	public function cart(){
		$ShopCartMod = M('ShopCart');
		$GoodSkuMod = M('GoodSku');
		$where['uid'] = sp_get_current_userid();
		$where['status'] = 1;
		$ShopCartMod
		->where($where)
		->order('update_time desc');
		$list = $ShopCartMod->select();
		foreach ($list as $key=>$val){
			$product = array();
			$product = $this->MallViewMod->field('price,title,img')->find($val['product_id']);
			$list[$key] = array_merge($list[$key],$product);
			$price = $GoodSkuMod->where(array('properies'=>$val['props']))->getField('price');
			if($price>0){$list[$key]['price'] = $price;}
			$list[$key]['attr_info'] = implode('<br>', $this->getAttrInfo($val['props']));
			$price_list[$val['id']] = $list[$key]['price'];
		}
		$this->assign('list',$list);
		$this->assign('price_list',json_encode($price_list));
		
		$map['uid'] = sp_get_current_userid();
		$map['status'] = 1;
		$cart_count = $ShopCartMod->where($map)->count();
		$this->assign('cart_count',$cart_count);
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
	
	public function cart_remove($id = null){
		if(!$id){
			$this->error('参数错误！');
		}
		$ShopCartMod = M('ShopCart');
		$re = $ShopCartMod->delete($id);
		if($re){
			$this->success('删除成功！');
		}
		else{
			$this->error('删除失败，请刷新页面重试！');
		}
		
	}
	
	public function update_cart_num($id = null,$num = null){
		if(!($id||num)){
			$this->error('参数错误！');
		}
		$ShopCartMod = M('ShopCart');
		$ShopCartMod->where(array('id'=>$id))->setField('num',$num);
		$this->success('修改成功！');
	}
	
	public function add_to_cart(){
		$ShopCartMod = M('ShopCart');
		$data['props'] = I('props');
		$sku = M('GoodSku')->where(array('properies'=>$data['props']))->find();
		if(!$sku){
			$this->error('请选择商品属性！');
		}
		if(!I('product_id')){
			$this->error('商品参数错误!');
		}
		$data['product_id'] = I('product_id');
		$data['uid'] = sp_get_current_userid();
		
		$old_data = $ShopCartMod->where($data)->find();
		if($old_data){
			$data['update_time'] = date('Y-m-d H:i:s',time());
			$data['num'] = $old_data['num'] + 1;
			$data['id'] = $old_data['id'];
			$re = $ShopCartMod->save($data);
		}
		else{
			$data['create_time'] = date('Y-m-d H:i:s',time());
			$data['update_time'] = date('Y-m-d H:i:s',time());
			$data['status'] = 1;
			$re = $ShopCartMod->add($data);
		}
		if($re){
			$this->success('加入购物车成功！');
		}
		else{
			$this->error('加入购物车失败！');
		}
	}
	
	public function inquiry_cart(){
		$ShopCartMod = M('ShopCart');
		$where['uid'] = sp_get_current_userid();
		$where['status'] = 1;
		$count = $ShopCartMod->where($where)->count();
		$this->success($count);
	}
	
	public function cart_check_out(){
		$ShopCartMod = M('ShopCart');
		$ids = I('ids');
		$spm = think_encrypt(implode(',', $ids));
		$this->success("正在跳转",U('confirm_order',array('spm'=>$spm)));
	}
	
	public function confirm_order(){
		
		$uid = sp_get_current_userid();
		$ShopCartMod = M('ShopCart');
		$GoodSkuMod = M('GoodSku');
		if(IS_POST){
			$OrderMod = M('Order');
			$OrderProductMod = M('OrderProduct');
			$spm = I('spm');
			$ids = explode(',', think_decrypt($spm));
			M()->startTrans();
			$cart_where['uid'] = $uid;
			$cart_where['id'] = array('in',$ids);
			$list = $ShopCartMod->where($cart_where)->select();
			if(!$list){
				$this->error("购物车中没有选中的商品！");
			}
			$uid = sp_get_current_userid();
			$order['order_sn'] = sp_get_order_sn();
			$order['uid'] = $uid;
			$order['create_time'] = date('Y-m-d H:i:s',time());
			$order['update_time'] = date('Y-m-d H:i:s',time());
			$order['status'] = 1;
			if(I('is_invoice') == 1){
				$order['is_invoice'] = I('is_invoice');
				$order['invoice_title'] = I('invoice_title');
			}
			$order['message'] = I('message');
			$address_id = I('address_id');
			if(!$address_id){
				$this->error("请选择地址！");
			}
			$address = $this->UserAddressMod->field("area_ids,address,name,mobile,zip_code")->find($address_id);
			$order = array_merge($order,$address);
			$re = $OrderMod->add($order);
			foreach ($list as $key=>$val){
				$order_product[$key]['product_id'] = $val['product_id'];
				$order_product[$key]['order_id'] = $re;
				$order_product[$key]['num'] = $val['num'];
				$order_product[$key]['props'] = $val['props'];
				$price = 0;
				$price = $GoodSkuMod->where(array('properies'=>$val['props']))->getField('price');
				if($price<=0){
					$price = $this->MallViewMod->where(array('id'=>$val['product_id']))->getField('price');
				}
				$order_product[$key]['one_price'] = $price;
				$order_product[$key]['sum_price'] = $price*$val['num'];
			}
			$re2 = $OrderProductMod->addAll($order_product);
			$re3 = $ShopCartMod->where($cart_where)->delete();
			if($re && $re2 && $re3){
				M()->commit();
				$this->success("订单提交成功！",U('Order/payOrder',array('osm'=>think_encrypt($order['order_sn']))));
			}
			else{
				M()->rollback();
				$this->error("订单提交失败！");
			}
		}
		$spm = I('spm');
		$this->assign('spm',$spm);
		$ids = explode(',', think_decrypt($spm));
		$where['uid'] = $uid;
		$where['id'] = array('in',$ids);
		$list = $ShopCartMod->where($where)->select();
		if(!$list){
			$this->error("购物车中没有选中的商品！",U('User/cart'));
		}
		$count_price = 0;
		foreach ($list as $key=>$val){
			$product = array();
			$product = $this->MallViewMod->field('price,title,img')->find($val['product_id']);
			$list[$key] = array_merge($list[$key],$product);
			$price = $GoodSkuMod->where(array('properies'=>$val['props']))->getField('price');
			if($price>0){$list[$key]['price'] = $price;}
			$list[$key]['attr_info'] = implode('<br>', $this->getAttrInfo($val['props']));
			$list[$key]['sum_price'] = $list[$key]['price']*$val['num'];
			$count_price += $list[$key]['sum_price'];
		}
		$this->assign('count_price',$count_price);
		$this->assign('list',$list);
		
		$addressList = $this->UserAddressMod->where(array('uid'=>$uid,'status'=>1))->select();
		$this->assign('addressList',$addressList);
		
		$this->display();
	}
	
	// 编辑用户资料
	public function edit() {
		$this->assign($this->user);
		$this->menu_id = 1;
    	$this->display();
    }
    
    // 编辑用户资料提交
    public function edit_post() {
    	if(IS_POST){
    		$_POST['id']=$this->userid;
    		$data = $this->users_model->field('id,user_nicename,sex,birthday,mobile,user_email,signature')->create();
    		if ($data!==false) {
				if ($this->users_model->save($data)!==false) {
					$this->user=$this->users_model->find($this->userid);
					sp_update_current_user($this->user);
					$this->success("保存成功！",U("edit"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->users_model->getError());
			}
    	}
    	
    }
    
    // 个人中心修改密码
    public function password() {
    	$this->assign($this->user);
    	$this->menu_id = 1;
    	$this->display();
    }
    
    // 个人中心修改密码提交
    public function password_post() {
    	if (IS_POST) {
    		$old_password=I('post.old_password');
    		if(empty($old_password)){
    			$this->error("原始密码不能为空！");
    		}
    
    		$password=I('post.password');
    		if(empty($password)){
    			$this->error("新密码不能为空！");
    		}
    
    		$uid=sp_get_current_userid();
    		$admin=$this->users_model->where(array('id'=>$uid))->find();
    		if(sp_compare_password($old_password, $admin['user_pass'])){
    			if($password==I('post.repassword')){
    				if(sp_compare_password($password, $admin['user_pass'])){
    					$this->error("新密码不能和原始密码相同！");
    				}else{
    					$data['user_pass']=sp_password($password);
    					$data['id']=$uid;
    					$r=$this->users_model->save($data);
    					if ($r!==false) {
    						$this->success("修改成功！",U('password'));
    					} else {
    						$this->error("修改失败！");
    					}
    				}
    			}else{
    				$this->error("密码输入不一致！");
    			}
    			 
    		}else{
    			$this->error("原始密码不正确！");
    		}
    	}
    
    }
}