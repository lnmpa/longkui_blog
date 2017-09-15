<?php
namespace Mall\Controller;

class ProductController extends HomeController {
	
	protected $MallMod;
	protected $MallCateMod;
	protected $MallViewMod;
	
	function _initialize() {
		parent::_initialize();
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
	
    public function index($cate_id = null){
    	if(empty($cate_id)){
    		$this->error('参数错误');
    	}
    	$where['cate_id'] = $cate_id;
    	$cate_info = $this->MallCateMod->find($cate_id);
    	$cate_info = $this->MallCateMod->parseFieldsMap($cate_info);
		$this->assign('cate_info',$cate_info);
    	$this->assign("cate_id",$cate_id);
    	
    	$where['status'] = array('egt',1);
    	$where['title'] = array('neq','');
    	if(I('sex')){
    		$where['sex'] = I('sex');
    		$this->assign('sex',I('sex'));
    	}
    	$order = 'sort_order';
    	$sort = 'desc';
    	if(I('order')){
    		$order = I('order');
    		$this->assign('order',I('order'));
    	}
    	if(I('sort')){
    		$sort = I('sort');
    		$this->assign('sort',I('sort'));
    	}
    	
    	$this->MallViewMod->where($where);
    	
    	$count=$this->MallViewMod->count();
    	
    	$page = $this->page($count, 12);
    	
    	$this->MallViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order($order.' '.$sort);
    	 
    	$list = $this->MallViewMod->select();
    	
    	$this->assign("page", $page->show('default'));
    	$this->assign("list",$list);
    	$this->display();
    }
    
    public function index_all($cate_id = null){
    	if(!empty($cate_id)){
    		$this->error('参数错误');
	    	$where['cate_id'] = $cate_id;
    	}
    	$cate_info = $this->MallCateMod->find($cate_id);
    	$cate_info = $this->MallCateMod->parseFieldsMap($cate_info);
    	$this->assign('cate_info',$cate_info);
    	$this->assign("cate_id",$cate_id);
    	 
    	$where['status'] = array('egt',1);
    	$where['title'] = array('neq','');
    	if(I('sex')){
    		$where['sex'] = I('sex');
    		$this->assign('sex',I('sex'));
    	}
    	$order = 'sort_order';
    	$sort = 'desc';
    	if(I('order')){
    		$order = I('order');
    		$this->assign('order',I('order'));
    	}
    	if(I('sort')){
    		$sort = I('sort');
    		$this->assign('sort',I('sort'));
    	}
    	 
    	$this->MallViewMod->where($where);
    	 
    	$count=$this->MallViewMod->count();
    	 
    	$page = $this->page($count, 12);
    	 
    	$this->MallViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order($order.' '.$sort);
    
    	$list = $this->MallViewMod->select();
    	 
    	$this->assign("page", $page->show('default'));
    	$this->assign("list",$list);
    	$this->display();
    }
    
    public function hotList(){
    	$where['is_hot'] = 1;
    	$where['status'] = array('egt',1);
    	$where['title'] = array('neq','');
    	if(I('sex')){
    		$where['sex'] = I('sex');
    		$this->assign('sex',I('sex'));
    	}
    	$order = 'sort_order';
    	$sort = 'desc';
    	if(I('order')){
    		$order = I('order');
    		$this->assign('order',I('order'));
    	}
    	if(I('sort')){
    		$sort = I('sort');
    		$this->assign('sort',I('sort'));
    	}
    	 
    	$this->MallViewMod->where($where);
    	 
    	$count=$this->MallViewMod->count();
    	 
    	$page = $this->page($count, 12);
    	 
    	$this->MallViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order($order.' '.$sort);
    
    	$list = $this->MallViewMod->select();
    	 
    	$this->assign("page", $page->show('default'));
    	$this->assign("list",$list);
    	$this->meta_title = "爆款热卖";
    	$this->display('best');
    }
    
    public function newList(){
    	$where['is_new'] = 1;
    	$where['status'] = array('egt',1);
    	$where['title'] = array('neq','');
    	if(I('sex')){
    		$where['sex'] = I('sex');
    		$this->assign('sex',I('sex'));
    	}
    	$order = 'sort_order';
    	$sort = 'desc';
    	if(I('order')){
    		$order = I('order');
    		$this->assign('order',I('order'));
    	}
    	if(I('sort')){
    		$sort = I('sort');
    		$this->assign('sort',I('sort'));
    	}
    	 
    	$this->MallViewMod->where($where);
    	 
    	$count=$this->MallViewMod->count();
    	 
    	$page = $this->page($count, 12);
    	 
    	$this->MallViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order($order.' '.$sort);
    
    	$list = $this->MallViewMod->select();
    	 
    	$this->assign("page", $page->show('default'));
    	$this->assign("list",$list);
    	$this->meta_title = "新品发布";
    	$this->display('best');
    }
    
    public function search(){
    	$where['status'] = array('egt',1);
    	$where['title'] = array('neq','');
    	$keywords = I('keywords');
    	if($keywords){
    		$where['title'] = array('like','%'.$keywords.'%');
    		$this->assign('keywords',$keywords);
    	}
    	
    	if(I('sex')){
    		$where['sex'] = I('sex');
    		$this->assign('sex',I('sex'));
    	}
    	$order = 'sort_order';
    	$sort = 'desc';
    	if(I('order')){
    		$order = I('order');
    		$this->assign('order',I('order'));
    	}
    	if(I('sort')){
    		$sort = I('sort');
    		$this->assign('sort',I('sort'));
    	}
    
    	$this->MallViewMod->where($where);
    
    	$count=$this->MallViewMod->count();
    
    	$page = $this->page($count, 12);
    
    	$this->MallViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order($order.' '.$sort);
    
    	$list = $this->MallViewMod->select();
    
    	$this->assign("page", $page->show('default'));
    	$this->assign("list",$list);
    	$this->meta_title = "搜索:".$keywords;
    	$this->display('best');
    }
    
    function product_show(){
    	$id = I('id');
    	if(!$id){
    		$this->error('参数错误!');
    	}
    	$data = $this->MallViewMod->find($id);
    	$data['hits'] = $data['hits'] + 1;
    	$this->MallViewMod->where(array('id'=>$data['id']))->save(array('hits'=>$data['hits']));
    	$pic = $this->MallMod->relation('photos')->field('id')->find($data['id']);
    	$data = array_merge($data,$pic);
    	$this->assign("data",$data);
    	
    	$best_list = $this->MallViewMod
    	->where(array('is_best'=>1,'cate_id'=>$data['cate_id'],'status'=>1))
    	->limit(4)
    	->order('sort_order DESC')
    	->select();
    	$this->assign("best_list",$best_list);
    	
    	$attr_id = $data['id'];
    	$property = M ( 'good_property' )->select ();
    	$this->assign ( 'property', $property );
		$a = M('GoodAttr')->where (array('attr_id' =>$attr_id))->order ('id')->select ();
		foreach ( $a as $v ) {
			$proper [$v ['property']] [] = $v ['property_value'];
		}
		$a = M ('GoodSku')->where (array('attr_id'=>$attr_id))->select();
		foreach ( $a as $v ) {
			$proper_value_price [$v ['properies']] = $v ['price'];
			$proper_value_sku [$v ['properies']] = $v ['sku'];
		}
		$proper_value_price = json_encode ( $proper_value_price );
		$proper_value_sku = json_encode ( $proper_value_sku );
		$this->assign ( 'proper_value_price', $proper_value_price );
		$this->assign ( 'proper_value_sku', $proper_value_sku );
		$this->assign ( 'proper', $proper );
		
    	$this->display();
    }
    
}