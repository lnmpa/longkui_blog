<?php
namespace Mall\Controller;

class IndexController extends HomeController {
	
	protected $ArticleMod;
	protected $ArticleCateMod;
	protected $ArticleViewMod;
	protected $MallViewMod;
	
	function _initialize() {
		parent::_initialize();
		$this->ArticleMod = D("Common/Article");
		$this->ArticleCateMod = D("Common/ArticleCate");
		switch (LANG_SET){
			case 'en-us':
				$this->ArticleViewMod = D("Common/ArticleEnView");
				$this->MallViewMod = D("Common/MallEnView");
				break;
			default:
				$this->ArticleViewMod = D("Common/ArticleView");
				$this->MallViewMod = D("Common/MallView");
		}
	}
	
    public function index(){
    	
    	$slides = D('Common/Slide')->where(array('slide_status'=>1,'slide_cid'=>1))->order('listorder asc,slide_id asc')->select();
    	$this->assign('slides',$slides);
    	$mslides = D('Common/Slide')->where(array('slide_status'=>1,'slide_cid'=>4))->order('listorder asc,slide_id asc')->select();
    	$this->assign('mslides',$mslides);
    	$slides_product = D('Common/Slide')->where(array('slide_status'=>1,'slide_cid'=>2))->order('listorder asc,slide_id asc')->select();
    	$this->assign('slides_product',$slides_product);
    	$mslides_product = D('Common/Slide')->where(array('slide_status'=>1,'slide_cid'=>5))->order('listorder asc,slide_id asc')->select();
    	$this->assign('mslides_product',$mslides_product);
    	//$newsList[104] = $this->getList(104,3);
    	//$newsList[105] = $this->getList(105,3);
    	//$newsList[107] = $this->getList(107,1);
    	$newsList[114] = $this->getList(114,3);
    	$this->assign('newsList',$newsList);
    	$topList = $this->getList2(array('is_top'=>1),3);
    	$this->assign('topList',$topList);
        $this->display();
    }
    
	public function getList($cate_id,$limit = 6){
        $where['status'] = 1;
        $where['cate_id'] = $cate_id;
        $where['title'] = array('neq','');
        $list = $this->ArticleViewMod
        ->where($where)
        ->limit($limit)
        ->order('sort_order desc,add_time desc')
        ->select();
        return $list;
    }
    
    public function getList2($where,$limit){
    	$where['status'] = 1;
    	$where['title'] = array('neq','');
    	$list = $this->MallViewMod
    	->where($where)
    	->limit($limit)
    	->order('sort_order desc,add_time desc')
    	->select();
    	
    	return $list;
    }
    
    public function activity(){
    	$where['cate_id'] = 114;
    	$where['status'] = array('egt',1);
    	$where['title'] = array('neq','');
    	$this->ArticleViewMod->where($where);
    	
    	$count=$this->ArticleViewMod->count();
    	
    	$page = $this->page($count, 5);
    	
    	$this->ArticleViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order("add_time desc,sort_order desc");
    	 
    	$list = $this->ArticleViewMod->select();
    	
    	$this->assign("page", $page->show('default'));
    	$this->assign("list",$list);
    	
    	$this->display();
    }
    
    public function question(){
    	$where['cate_id'] = 115;
    	$where['status'] = array('egt',1);
    	$where['title'] = array('neq','');
    
    	$this->ArticleViewMod
    	->where($where)
    	->order("add_time desc,sort_order desc");
    	 
    	$list = $this->ArticleViewMod->select();
    
    	$this->assign("list",$list);
    
    	$this->display();
    }
    
    public function news_detail(){
    	$id = I('id');
    	if(!$id){
    		$this->error('参数错误');
    	}
    	$data = $this->ArticleViewMod->find($id);
    	$data['hits'] = $data['hits'] + 1;
    	$this->assign("data",$data);
    	$this->ArticleMod->where(array('id'=>$data['id']))->save(array('hits'=>$data['hits']));
    	 
    	$keywords_arr = explode(' ', $data['keywords']);
    	foreach ($keywords_arr as $key=>$val){
    		$keylike[$key] = array('like','%'.$val.'%');
    		$keylike[] = 'OR';
    	}
    	 
    	$key_list = $this->ArticleViewMod
    	->where(array('keywords'=>array($keylike),'cate_id'=>$data['cate_id'],'status'=>1))
    	->limit(5)
    	->order('add_time DESC')
    	->select();
    	$this->assign("key_list",$key_list);
    	 
    	 
    	$this->display();
    }
    
    public function app(){
    
    	$this->display();
    }
    
}