<?php
/**
 * ArticleCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Common\Model\AlbumModel;
use Common\Api\ExcelApi;

class ArticleController extends AdminbaseController {

    protected $ArticleMod;
    protected $ArticleViewMod;
    protected $ArticleCateMod;
    protected $AlbumMod;

    public function _initialize() {
        parent::_initialize();
        $this->ArticleMod = D("Common/Article");
        $this->ArticleViewMod = D("Common/ArticleView");
        $this->ArticleCateMod = D("Common/ArticleCate");
        $this->AlbumMod = new AlbumModel();
    }
    
    // 后台菜单列表
    public function index() {
    	cookie('edit_url',$_SERVER['PHP_SELF']);
    	
    	$cate_id = I('cate_id',0,'intval');
    	if(!empty($cate_id)){
    		$map['parentspath'] = array('like','%'.$cate_id.'%');
    		$map['cate_id'] = $cate_id;
    		$map['_logic'] = 'OR';
    		$where['_complex'] = $map; 
    		$this->assign("cate_id",$cate_id);
    	}
    	$where['status'] = array('egt',0);
    	
    	$keyword=I('keyword');
    	if(!empty($keyword)){
    		$where['title']=array('like',"%$keyword%");
    		$formget['keyword'] = $keyword;
    	}
    	
    	$start_time=I('start_time');
    	$end_time=I('end_time');
    	if(!empty($start_time) || !empty($end_time)){
    		if(!empty($start_time) && !empty($end_time)){
    			$where['add_time']=array(array('egt',$start_time),array('elt',$end_time),'AND');
    		}
    		else if(!empty($start_time)){
    			$where['add_time'] = array('egt',$start_time);
    		}
    		else if(!empty($end_time)){
    			$where['add_time'] = array('elt',$end_time);
    		}
    		
    		$formget['start_time'] = $start_time;
    		$formget['end_time'] = $end_time;
    	}
    	
    	$this->ArticleViewMod
    	->where($where);
    	
    	$count=$this->ArticleViewMod->count();
    	$page = $this->page($count, 20);
    	
    	$this->ArticleViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order("sort_order DESC");
    	
    	$list = $this->ArticleViewMod->select();
    	
    	foreach ($list as $key=>$val){
    		$list[$key]['status'] = $val['status'] ? 'fa-check' : 'fa-close';
    		$list[$key]['is_hot'] = $val['is_hot'] ? 'fa-check' : 'fa-close';
    		$list[$key]['is_best'] = $val['is_best'] ? 'fa-check' : 'fa-close';
    		$list[$key]['is_top'] = $val['is_top'] ? 'fa-check' : 'fa-close';
    	}
    	
    	$this->assign("formget",$formget);
    	$this->_getCateTree($cate_id,'&nbsp;');
    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	$alias_template = $this->ArticleCateMod->where(array('id'=>$cate_id))->getField('alias_template');
    	
    	if($alias_template){
    		$this->display(CONTROLLER_NAME.'/'.$alias_template.'/index');
    	}
    	else{
    		$this->display();
    	}
    }
	
    private function _getGroupCate($field,$cate_id){
    	$list = $this->ArticleViewMod
    	->where(array('cate_id'=>$cate_id))
    	->field($field)
    	->group($field)
    	->select();
    	$list = array_column($list, $field);
    	return $list;
    }
    
    public function main(){
    	$this->treeData="[" . $this->display_tree(0) . "]";
    	$this->display();
    }
    
    public function add(){
    	if(IS_POST){
    		M()->startTrans();
    		$_POST['user_id'] = sp_get_current_admin_id();
    		$data = $this->ArticleMod->create();
    		if(!$data){
    			$this->error($this->ArticleMod->getError());
    		}
    		$data['id'] = $this->ArticleMod->add(array('status'=>1));
    		
    		$article_en = D('Common/ArticleEn')->create($_POST['ArticleEn']);
    		if(!$article_en){
    			$this->error(D('Common/ArticleEn')->getError());
    		}
    		$article_en['id'] = $data['id'];
    		$data['ArticleEn'] = $article_en;
    		
    		if($data['id']){
    			
    			$re = $this->ArticleMod->relation(true)->save($data);
    			if($re){
    				M()->commit();
    				$this->success("新增成功！");
    			}
    			else{
    				M()->rollback();
    				$this->error("新增失败！");
    			}
    		}
    		else{
    			M()->rollback();
    			$this->error($this->ArticleMod->getError());
    		}
    	}
    	$cate_id = I('cate_id',0,'intval');
    	if(!empty($cate_id)){
    		$this->assign("cate_id",$cate_id);
    	}
    	$this->_getCateTree($cate_id);
    	$this->meta_title = "添加";
    	$alias_template = $this->ArticleCateMod->where(array('id'=>$cate_id))->getField('alias_template');
    	if($alias_template){
    		$this->display(CONTROLLER_NAME.'/'.$alias_template.'/edit');
    	}
    	else{
    		$this->display('edit');
    	}
    }
    
    public function edit(){
    	if(IS_POST){
    		M()->startTrans();
    		
    		$data = $this->ArticleMod->create();
    		if(!$data){
    			$this->error($this->ArticleMod->getError());
    		}
    		
    		$article_en = D('Common/ArticleEn')->create($_POST['ArticleEn']);
    		if(!$article_en){
    			$this->error(D('Common/ArticleEn')->getError());
    		}
    		$article_en['id'] = $data['id'];
    		$data['ArticleEn'] = $article_en;
    		
    		if($data){
    			$re = $this->ArticleMod->relation(true)->save($data);
    			if($re){
    				M()->commit();
    				$this->success("修改成功！");
    			}
    			else{
    				M()->rollback();
    				$this->error("修改失败！");
    			}
    		}
    		else{
    			$this->error($this->ArticleMod->getError());
    		}
    	}
    	$id = I('request.id',0,'intval');
    	$data = $this->ArticleMod->relation(true)->find($id);
    	$cate_id = $data['cate_id'];
    	if(!empty($cate_id)){
    		$this->assign("cate_id",$cate_id);
    	}
    	$this->_getCateTree($cate_id);
    	$this->assign('data',$data);
    	$this->meta_title = "编辑";
    	$alias_template = $this->ArticleCateMod->where(array('id'=>$cate_id))->getField('alias_template');
    	if($alias_template){
    		$this->display(CONTROLLER_NAME.'/'.$alias_template.'/edit');
    	}
    	else{
    		$this->display('edit');
    	}
    }
    
    public function delete(){
    	$ids = I('ids');
    	if(!$ids){
    		$this->error("请选择数据!");
    	}
    	$re = $this->ArticleMod->relation(true)->where(array('id'=>array('in',$ids)))->delete();
    	if($re){
    		$this->success('删除成功!');
    	}
    	else{
    		$this->error("删除失败!");
    	}
    }
    
    public function shows(){
    	$id = I('id',0,'intval');
    	$data = $this->ArticleViewMod->field('id,title,img,add_time,info')->find($id);
    	$this->assign('data',$data);
    	$this->display();
    }
    
    // 获取文章分类树结构
    private function _getCateTree($cate_id,$nbsp = "&nbsp;&nbsp;&nbsp;"){
    	$result = $this->ArticleCateMod->where(array('status'=>1))->order(array("sort_order"=>"asc"))->select();
    	
    	$tree = new \Tree();
    	$tree->icon = array('│ ','├─ ', '└─ ');
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
    
    private function display_tree($classid) {
    	$Mod = $this->ArticleCateMod;
    	$data['pid'] = $classid;
    	$data['status'] = 1;
    	$result = $Mod->where($data)->order('sort_order asc,id asc')->select();
    	$retStr = "";
    	foreach($result as $row){
    		$retStr .= "{name:\"".$row['name'] . "\"";
    		$url = U('index',array('cate_id'=>$row['id'],'alias_template'=>$row['alias_template']));
    		$retStr .= ",\"url\":\"".$url."\", \"target\":\"".CONTROLLER_NAME."_iframe_content\",\"click\":\"changeUrl('#')\"";
    		
    		if($row['pid']==0)
    		{
    			$retStr .=",open:true";
    		}
    		if($this->display_tree($row['id']) != "")
    		{
    			$retStr .= ",children:[";
    			$retStr .= $this->display_tree($row['id']);
    			$retStr .= "]";
    		}
    		$retStr .= "},";
    	}
    	return  $retStr;
    }
    
    public function status(){
    	$value = I('request.value',0,'intval');
    	$ids = I('request.ids');
    	$type = I('request.type');
    	if(!$ids){
    		$this->error("请至少选择一项！");
    	}
    	$re = $this->ArticleMod->where(array('id'=>array('in',$ids)))->setField($type,$value);
    	if ($re) {
    		$this->success("更新成功！");
    	} else {
    		$this->error("更新失败！");
    	}
    }
    
    public function autoload() {
    	if(IS_POST){
    			
    		$file = I('file');
    		if(empty($file)){
    			$this->error("请上传文件");
    		}
    		$filepath = sp_get_file_link($file);
    		$excel = new ExcelApi();
    		$res = $excel->read($filepath);
    		$keyNav = $res[1];
    		foreach ($keyNav as $key=>$val){
    			$arr = array();
    			$arr = explode('-', $val);
    			$field[$key] = $arr[1];
    		}
    		unset($res[1]);
    			
    		$ImagesMod = M('Images');
    			
    		foreach($res as $key =>$val){
    			foreach ($val as $k=>$v){
    				if($field[$k] == 'img'){
    					$v = $ImagesMod->add(array('url'=>$v,'status'=>1));
    				}
    				if($field[$k] == 'cate_id'){
    					if(!is_numeric($v)){
    						$v = $this->ArticleCateMod->where(array('name'=>$v))->getField('id');
    					}
    				}
    				$list[$key][$field[$k]] = $v;
    			}
    		}
    			
    		foreach ($list as $key=>$val){
    			$data = $this->ArticleMod->create($val);
    			if(!empty($data)){
    				M()->startTrans();
    				$re = $this->ArticleMod->add($data);
    				if($re){
    					M()->commit();
    				}
    				else{
    					M()->rollback();
    				}
    			}
    		}
    		$this->success("导入完成！");
    	}
    	$this->display();
    }
}
