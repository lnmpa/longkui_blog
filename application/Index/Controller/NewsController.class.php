<?php
namespace Index\Controller;

class NewsController extends HomeController {
    
    protected $ArticleMod;
    protected $ArticleCateMod;
    protected $ArticleViewMod;
    
	function _initialize() {
		parent::_initialize();
		$this->ArticleMod = D("Common/Article");
		$this->ArticleCateMod = D("Common/ArticleCate");
		switch (LANG_SET){
			case 'en-us':
				$this->ArticleViewMod = D("Common/ArticleEnView");
				break;
			default:
				$this->ArticleViewMod = D("Common/ArticleView");
		}
	}
	
	public function about(){
		$cate_id = "101";
		$list = $this->ArticleCateMod->field('id,name,name_en')->where(array('pid'=>$cate_id,'status'=>1))->order('sort_order asc')->select();
		foreach ($list as $key=>$val){
			$list[$key]['_child'] = $this->ArticleViewMod->where(array('cate_id'=>$val['id'],'status'=>1))->order('sort_order asc')->limit(9)->select();
		}
		$this->assign('list',$list);
		
		
		$parent_cate =  $this->ArticleCateMod->field('name,name_en,img')->find($cate_id);
		$this->assign("parent_cate",$parent_cate);
		$this->display();
	}
	
	public function qywh(){
		$cate_id = "112";
		$list = $this->ArticleCateMod->field('id,name,name_en')->where(array('pid'=>$cate_id,'status'=>1))->order('sort_order asc')->select();
		foreach ($list as $key=>$val){
			$list[$key]['_child'] = $this->ArticleViewMod->where(array('cate_id'=>$val['id'],'status'=>1))->order('sort_order asc')->limit(9)->select();
		}
		$this->assign('list',$list);
		
		
		$cate_info = $this->ArticleCateMod->field('name,name_en,pid')->find($cate_id);
    	$this->assign("cate_info",$cate_info);
    	
    	$parent_cate =  $this->ArticleCateMod->field('name,name_en,img')->find($cate_info['pid']);
    	$this->assign("parent_cate",$parent_cate);
    	
		$this->display();
	}
	
	public function cybj(){
		$nid = I('nid');
		$this->assign("nid",$nid);
		
		$nav = M('Nav')->where(array('parentid'=>$nid,'status'=>1))->select();
		foreach ($nav as $key=>$val){
			$arrs = $this->_parse_str_to_arr($val['href']);
			$list[$key] = $this->ArticleViewMod->where(array('cate_id'=>$arrs['cate_id'],'status'=>1))->order('sort_order desc')->find();
			$list[$key]['nid'] = $val['id'];
		}
		$this->assign('list',$list);
		
		$cate_id = "119";
		$parent_cate =  $this->ArticleCateMod->field('name,name_en,img')->find($cate_id);
		$this->assign("parent_cate",$parent_cate);
		
		$this->display();
	}
	
	public function djyd(){
		$nid = I('nid');
		$this->assign("nid",$nid);
		
		$nav = M('Nav')->where(array('parentid'=>$nid,'status'=>1))->select();
		foreach ($nav as $key=>$val){
			$arrs = $this->_parse_str_to_arr($val['href']);
			$list[$key]['_child'] = $this->ArticleViewMod->where(array('cate_id'=>$arrs['cate_id'],'status'=>1))->order('sort_order desc')->limit(9)->select();
			$list[$key]['nid'] = $val['id'];
			$list[$key]['href'] = M('Nav')->where(array('id'=>$val['id']))->getField('href');
			$list[$key]['href'] = sp_get_nav_url($list[$key]['href'], array('nid'=>$val['id']));
			$list[$key]['name'] = $this->ArticleCateMod->where(array('id'=>$arrs['cate_id']))->getField('name');
			$list[$key]['name_en'] = $this->ArticleCateMod->where(array('id'=>$arrs['cate_id']))->getField('name_en');
		}
		
		$this->assign('list',$list);
		
		$cate_id = "132";
		$parent_cate =  $this->ArticleCateMod->field('name,name_en,img')->find($cate_id);
		$this->assign("parent_cate",$parent_cate);
		
		$this->display();
	}
	
	public function dqfw(){
		
		$cate_id = "132";
		$parent_cate =  $this->ArticleCateMod->field('name,name_en,img')->find($cate_id);
		$this->assign("parent_cate",$parent_cate);
		
		$this->display();
	}
	
	public function apply(){
		$applyMod = M('apply');
		if(IS_POST){
			$_POST['add_time'] = date('Y-m-d');
			$data = $applyMod->create();
			if(empty($data['name'])){
				$this->error('请填写姓名！');
			}
			if(empty($data['phone'])){
				$this->error('请填写手机！');
			}
			if(empty($data['email'])){
				$this->error('请填写邮箱！');
			}
			if(empty($data['address'])){
				$this->error('请填写地址！');
			}
			if(empty($data['content'])){
				$this->error('请填写内容！');
			}
			$re = $applyMod->add($data);
			if($re){
				$this->success('添加成功！');
			}
			else{
				$this->error('添加失败！');
			}
		}
		$this->display();
	}
	
	public function contact(){
		
		$this->display();
	}
	
	public function simple($cate_id = null){
		$this->_simple($cate_id);
	}
	
	public function company_show($cate_id = null){
		$this->_simple($cate_id);
	}
	
    public function index($cate_id = null){
    	$this->_list($cate_id,9);
    }
	
    public function pic_news($cate_id = null){
    	$this->_list($cate_id,9);
    }
    
    public function news($cate_id = null){
    	$this->_list($cate_id,9);
    }
    
    public function tzgg($cate_id = null){
    	$this->_list($cate_id,9);
    }
    
    public function video($cate_id = null){
    	$this->_list($cate_id,12);
    }
    
    public function paper($cate_id = null){
    	$date = I('date');
    	$this->assign('date',$date);
    	$where['date'] = array('like',$date.'%');
    	
    	$start_yeay = "2014";
    	$now_year = date('Y');
    	for ($i = $now_year; $i >= $start_yeay; $i--) {
    		$year_arr[] = $i.'';
    	}
    	$this->assign('year_arr',$year_arr);
    	$this->_list($cate_id,12,$where);
    }
    
    public function gysy($cate_id = null){
    	$this->_list($cate_id,4);
    }
    
    public function tzzgx($cate_id = null){
    	$this->_list($cate_id,9);
    }
    
    public function job($cate_id = null){
    	$this->_list($cate_id,9);
    }
    
    public function dj_work($cate_id = null){
    	$this->_list($cate_id,12);
    }
    
    public function dj_list($cate_id = null){
    	$this->_list($cate_id,9);
    }
    
    public function news_show($id){
    	$this->_show($id);
    }
    
    public function video_show($id){
    	$this->_show($id);
    }
    
    private function _simple($cate_id = null){
    	if(!$cate_id){
    		$this->error("参数错误");
    	}
    	$where['cate_id'] = $cate_id;
    	$where['status'] = 1;
    
    	$this->assign("cate_id",$cate_id);
    	$data = $this->ArticleViewMod
    	->order('sort_order desc')
    	->where($where)
    	->find();
    	$this->assign("data",$data);
    
    	$cate_info = $this->ArticleCateMod->field('name,name_en,pid')->find($cate_id);
    	$this->assign("cate_info",$cate_info);
    		
    	$parent_cate =  $this->ArticleCateMod->field('name,name_en,img')->find($cate_info['pid']);
    	$this->assign("parent_cate",$parent_cate);
    		
    	$nid = I('nid');
    	$this->assign("nid",$nid);
    	$p_nid = M('Nav')->where(array('id'=>$nid))->getField('parentid');
    	$sub_menu = M('Nav')->where(array('cid'=>1,'parentid'=>$p_nid,'status'=>1))->order('listorder asc')->select();
    	$this->assign("sub_menu",$sub_menu);
    		
    	$this->display();
    }
    
    private function _list($cate_id = null,$page_num = 9,$map = null,$sort = "add_time desc,sort_order desc"){
    	if(!empty($cate_id)){
    		$where['cate_id'] = $cate_id;
    		$this->assign("cate_id",$cate_id);
    	}
    	$where['status'] = array('egt',1);
    	if($map){
    		$where = array_merge($where,$map);
    	}
    		
    	$this->ArticleViewMod->where($where);
    
    	$count=$this->ArticleViewMod->count();
    
    	$page = $this->page($count, $page_num);
    
    	$this->ArticleViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order($sort);
    
    	$list = $this->ArticleViewMod->select();
    
    	$this->assign("page", $page->show('default'));
    	$this->assign("page2", $page->show('mobile'));
    	$this->assign("list",$list);
    		
    	$cate_info = $this->ArticleCateMod->field('name,name_en,pid')->find($cate_id);
    	$this->assign("cate_info",$cate_info);
    		
    	$parent_cate =  $this->ArticleCateMod->field('name,name_en,img')->find($cate_info['pid']);
    	$this->assign("parent_cate",$parent_cate);
    		
    	$nid = I('nid');
    	$this->assign("nid",$nid);
    	$p_nid = M('Nav')->where(array('id'=>$nid))->getField('parentid');
    	$sub_menu = M('Nav')->where(array('cid'=>1,'parentid'=>$p_nid,'status'=>1))->order('listorder asc')->select();
    	$this->assign("sub_menu",$sub_menu);
    		
    	$this->display();
    }
    
    private function _show($id = null){
    	if(!$id){
    		$this->error('参数错误');
    	}
    	$data = $this->ArticleViewMod->find($id);
    	$data['hits'] = $data['hits'] + 1;
    	$this->assign("data",$data);
    	$this->ArticleMod->where(array('id'=>$data['id']))->save(array('hits'=>$data['hits']));
    		
    	$where['cate_id'] = $data['cate_id'];
    		
    	$where['sort_order'] = array('lt',$data['sort_order']);
    	$next = $this->ArticleViewMod
    	->where($where)
    	->order('sort_order desc')
    	->find();
    	$this->assign("next",$next);
    		
    	$where['sort_order'] = array('gt',$data['sort_order']);
    	$prev = $this->ArticleViewMod
    	->where($where)
    	->order('sort_order asc')
    	->find();
    	$this->assign("prev",$prev);
    		
    	if(!empty($data['seo_title'])){
    		$this->seo_title = $data['seo_title'];
    	}
    	else if(!empty($data['title'])){
    		$this->seo_title = $data['title'];
    	}
    	if(!empty($data['seo_keys'])){
    		$this->seo_keys = $data['seo_keys'];
    	}
    	if(!empty($data['seo_desc'])){
    		$this->seo_desc = $data['seo_desc'];
    	}
    		
    	$nid = I('nid');
    	$this->assign("nid",$nid);
    	$this->assign('location',$this->location($nid));
    		
    	$this->display();
    }
    
    private function _parse_str_to_arr($url,$vars){
    	$info   =  parse_url($url);
    	$url    =  $info['path'];
    
    	$carrs = explode('/', $url);
    	unset($carrs[0]);
    	unset($carrs[1]);
    	unset($carrs[2]);
    	foreach ($carrs as $key=>$val){
    		if($key%2==1){
    			$arrs[$val] = $carrs[$key+1];
    		}
    	}
    
    	if(isset($info['query']) && $arrs) { // 解析地址里面参数 合并到vars
    		parse_str($info['query'],$params);
    		$arrs = array_merge($params,$arrs);
    	}
    	else if(isset($info['query'])){
    		parse_str($info['query'],$params);
    		$arrs = $params;
    	}
    	// 解析参数
    	if(is_string($vars)) { // aaa=1&bbb=2 转换成数组
    		parse_str($vars,$vars);
    	}elseif(!is_array($vars)){
    		$vars = array();
    	}
    	if(isset($arrs)) { // 解析地址里面参数 合并到vars
    		$vars = array_merge($arrs,$vars);
    	}
    	return $vars;
    }
}