<?php
namespace Index\Controller;

class IndexController extends HomeController {
	
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
	
    public function index(){
    	
    	$news_list = $this->ArticleViewMod->field('id,title,abst,img,add_time')->where(array('status'=>1,'cate_id'=>108))->order('add_time desc,sort_order desc')->limit(12)->select();
    	$this->assign('news_list',$news_list);
    	
    	$cybj_nav = M('Nav')->where(array('parentid'=>16,'status'=>1))->select();
    	
    	/* $ss = parse_url('http://localhost/fyylyy.com/index.php/Admin/Index/index/nav_id/111111');
    	$url = $ss['path'];
    	$array = explode('/', $url);
    	var_dump($this->_array_remove($array, 5));
    	var_dump($array);die; */
    	
    	foreach ($cybj_nav as $key=>$val){
    		$arrs = $this->_parse_str_to_arr($val['href']);
    		$cybj_list[$key] = $this->ArticleViewMod->where(array('cate_id'=>$arrs['cate_id'],'status'=>1))->order('sort_order desc')->find();
    		$cybj_list[$key]['nid'] = $val['id'];
    		$cybj_list[$key]['name'] = $this->ArticleCateMod->where(array('id'=>$arrs['cate_id']))->getField('name');
    		$cybj_list[$key]['name_en'] = $this->ArticleCateMod->where(array('id'=>$arrs['cate_id']))->getField('name_en');
    	}
    	$this->assign('cybj_list',$cybj_list);
    	
        $this->display();
    }
    /*
    private function _array_remove(&$arr, $offset)
    {
        return array_splice($arr, $offset, 1);
    } 
    */
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