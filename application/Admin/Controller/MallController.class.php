<?php
/**
 * MallCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Common\Model\AlbumModel;
use Common\Model\CategoryModel;
use Common\Api\ExcelApi;
use Common\Model\FileModel;

class MallController extends AdminbaseController {

    protected $MallMod;
    protected $MallViewMod;
    protected $MallCateMod;
    protected $AlbumMod;

    public function _initialize() {
        parent::_initialize();
        $this->MallMod = D("Common/Mall");
        $this->MallViewMod = D("Common/MallView");
        $this->MallCateMod = D("Common/MallCate");
        $this->AlbumMod = new AlbumModel();
    }
    
    // 后台菜单列表
    public function index() {
    	$cate_id = I('request.cate_id',0,'intval');
    	if(!empty($cate_id)){
    		$map['parentspath'] = array('like','%'.$cate_id.'%');
    		$map['cate_id'] = $cate_id;
    		$map['_logic'] = 'OR';
    		$where['_complex'] = $map; 
    		$this->assign("cate_id",$cate_id);
    	}
    	$where['status'] = array('egt',0);
    	
    	$keyword=I('request.keyword');
    	if(!empty($keyword)){
    		$where['title']=array('like',"%$keyword%");
    		$formget['keyword'] = $keyword;
    	}
    	$orig=I('orig');
    	if(!empty($orig)){
    		$where['orig']=array('like',"%$orig%");
    		$formget['orig'] = $orig;
    	}
    	$seo_title=I('seo_title');
    	if(!empty($seo_title)){
    		$where['seo_title']=array('like',"%$seo_title%");
    		$formget['seo_title'] = $seo_title;
    	}
    	$start_time=I('request.start_time');
    	$end_time=I('request.end_time');
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
    	
    	$this->MallViewMod
    	->where($where);
    	
    	$count=$this->MallViewMod->count();
    	$page = $this->page($count, 20);
    	
    	$this->MallViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order("sort_order DESC");
    	
    	$list = $this->MallViewMod->select();
    	
    	foreach ($list as $key=>$val){
    		$list[$key]['status'] = $val['status'] ? 'fa-check' : 'fa-close';
    		$list[$key]['is_hot'] = $val['is_hot'] ? 'fa-check' : 'fa-close';
    		$list[$key]['is_best'] = $val['is_best'] ? 'fa-check' : 'fa-close';
    		$list[$key]['is_top'] = $val['is_top'] ? 'fa-check' : 'fa-close';
    		$list[$key]['is_new'] = $val['is_new'] ? 'fa-check' : 'fa-close';
    	}
    	
    	$this->assign("formget",$formget);
    	$this->_getCateTree($cate_id,'&nbsp;');
    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	$alias_template = $this->MallCateMod->where(array('id'=>$cate_id))->getField('alias_template');
    	if($alias_template){
    		$this->display(CONTROLLER_NAME.'/'.$alias_template.'/index');
    	}
    	else{
    		$this->display();
    	}
    }
	
    public function prop(){
    	$id = I('id',0,'intval');
    	$this->assign('attr_id',$id);
    	$this->display();
    }
    
    public function main(){
    	$this->treeData="[" . $this->display_tree(0) . "]";
    	$this->display();
    }
    
    public function add(){
    	if(IS_POST){
    		M()->startTrans();
    		$_POST['user_id'] = session('ADMIN_ID');
    		$data = $this->MallMod->create();
    		if(!$data){
    			$this->error($this->MallMod->getError());
    		}
    		$data['id'] = $this->MallMod->add(array('status'=>1));
    		
    		$article_en = D('Common/MallEn')->create($_POST['MallEn']);
    		if(!$article_en){
    			$this->error(D('Common/MallEn')->getError());
    		}
    		$article_en['id'] = $data['id'];
    		$data['MallEn'] = $article_en;
    		
    		
    		if($data['id']){
    			
    			$re = $this->MallMod->relation(true)->save($data);
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
    			$this->error($this->MallMod->getError());
    		}
    	}
    	$cate_id = I('request.cate_id',0,'intval');
    	if(!empty($cate_id)){
    		$this->assign("cate_id",$cate_id);
    	}
    	$this->_getCateTree($cate_id);
    	$this->meta_title = "添加";
    	$alias_template = $this->MallCateMod->where(array('id'=>$cate_id))->getField('alias_template');
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
    		$data = $this->MallMod->create();
    		if(!$data){
    			$this->error($this->MallMod->getError());
    		}
    		
    		$article_en = D('Common/MallEn')->create($_POST['MallEn']);
    		if(!$article_en){
    			$this->error(D('Common/MallEn')->getError());
    		}
    		$article_en['id'] = $data['id'];
    		$data['MallEn'] = $article_en;
    		
    		if($data){
    			
    			$re = $this->MallMod->relation(true)->save($data);
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
    			$this->error($this->MallMod->getError());
    		}
    	}
    	$id = I('request.id',0,'intval');
    	$data = $this->MallMod->relation(true)->find($id);
    	$cate_id = $data['cate_id'];
    	if(!empty($cate_id)){
    		$this->assign("cate_id",$cate_id);
    	}
    	$this->_getCateTree($cate_id);
    	$this->assign('data',$data);
    	$this->meta_title = "编辑";
    	$alias_template = $this->MallCateMod->where(array('id'=>$cate_id))->getField('alias_template');
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
    	$re = $this->MallMod->relation(true)->where(array('id'=>array('in',$ids)))->delete();
    	if($re){
    		$this->success('删除成功!');
    	}
    	else{
    		$this->error("删除失败!");
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
    		$AlbumMod = M('Album');
    		$CategoryMod = new CategoryModel();
    		 
    		foreach($res as $key =>$val){
    			foreach ($val as $k=>$v){
    				if($field[$k] == 'img'){
    					$v = $ImagesMod->add(array('url'=>$v,'status'=>1));
    				}
    				if($field[$k] == 'product_cate'){
    					$v = $CategoryMod->where(array('type_id'=>1,'name'=>$v))->getField('id');
    				}
    				if($field[$k] == 'cate_id'){
    					if(!is_numeric($v)){
    						$v = $this->MallCateMod->where(array('name'=>$v))->getField('id');
    					}
    				}
    				if($field[$k] == 'album_id'){
    					if(!empty($v)){
    						$album_id = $AlbumMod->add(array('name'=>'Mall专辑'));
    						$arr = explode(',', $v);
    						foreach ($arr as $vvv){
    							$ImagesMod->add(array('url'=>$vvv,'album_id'=>$album_id,'status'=>1));
    						}
    						$v = $album_id;
    					}
    				}
    				$list[$key][$field[$k]] = $v;
    			}
    			$list[$key]['add_time'] = date('Y-m-d H:i:s',time());
    		}
    		foreach ($list as $key=>$val){
    			$data = $this->MallMod->create($val);
    			if(!empty($data)){
    				M()->startTrans();
    				$data['id'] = $this->MallMod->add(array('status'=>1));
    
    				$mall_zh = D('Common/MallEn')->create($val);
    				$mall_zh['id'] = $data['id'];
    				$data['MallEn'] = $mall_zh;
    
    				if($data['id']){
    					$re = $this->MallMod->relation(true)->save($data);
    				}
    				if($re){
    					M()->commit();
    				}
    				else{
    					M()->rollback();
    				}
    			}
    		}
    		$fileMod = new FileModel();
    		$fileMod->deleteLocal($file);
    		$this->success("导入完成！");
    	}
    	$this->display();
    }
    
    // 获取文章分类树结构
    private function _getCateTree($cate_id,$nbsp = "&nbsp;&nbsp;&nbsp;"){
    	$result = $this->MallCateMod->where(array('status'=>1))->order(array("sort_order"=>"asc"))->select();
    	
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
    
    private function display_tree($classid) {
    	$article_cate_mod = $this->MallCateMod;
    	$data['pid'] = $classid;
    	$data['status'] = 1;
    	$result = $article_cate_mod->where($data)->order('sort_order asc,id asc')->select();
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
    		}else{
    			//$url = U('index',array('cate_id'=>$row['id'],'alias_template'=>$row['alias_template']));
    			//$retStr .= ",\"url\":\"".$url."\", \"target\":\"".CONTROLLER_NAME."_iframe_content\",\"click\":\"changeUrl('#')\"";
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
    	$re = $this->MallMod->where(array('id'=>array('in',$ids)))->setField($type,$value);
    	if ($re) {
    		$this->success("更新成功！");
    	} else {
    		$this->error("更新失败！");
    	}
    }
    
    public function update_num(){
    	$ids = I('ids');
    	$id_strs = implode(',', $ids);
	    $Model = new \Think\Model();
	    $sql = "update ".sp_table_name('MallCate')." a set a.record_nums = (select count(*) from ".sp_table_name('Mall')." b where a.id = b.cate_id) where id in ($id_strs)";
	    $Model->execute($sql);
	    $this->success("操作成功!");
    }
    
}
