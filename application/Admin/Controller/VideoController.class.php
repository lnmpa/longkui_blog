<?php
/**
 * VideoCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class VideoController extends AdminbaseController {

    protected $VideoMod;
    protected $VideoViewMod;
    protected $VideoCateMod;

    public function _initialize() {
        parent::_initialize();
        $this->VideoMod = D("Common/Video");
        $this->VideoViewMod = D("Common/VideoView");
        $this->VideoCateMod = D("Common/VideoCate");
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
    	
    	$this->VideoViewMod
    	->where($where);
    	
    	$count=$this->VideoViewMod->count();
    	$page = $this->page($count, 20);
    	
    	$this->VideoViewMod
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order("sort_order DESC");
    	
    	$list = $this->VideoViewMod->select();
    	
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
    		if($_POST['img']){
    			$_POST['img'] = sp_asset_relative_url($_POST['img']);
    		}
    		$data = $this->VideoMod->create();
    		if(!$data){
    			$this->error($this->VideoMod->getError());
    		}
    		$data['id'] = $this->VideoMod->add(array('status'=>1));
    		
    		if($data['id']){
    			$re = $this->VideoMod->save($data);
    			
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
    			$this->error($this->VideoMod->getError());
    		}
    	}
    	$cate_id = I('request.cate_id',0,'intval');
    	if(!empty($cate_id)){
    		$this->assign("cate_id",$cate_id);
    	}
    	$this->_getCateTree($cate_id);
    	$this->meta_title = "添加";
    	$alias_template = $this->VideoCateMod->where(array('id'=>$cate_id))->getField('alias_template');
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
    		if($_POST['img']){
    			$_POST['img'] = sp_asset_relative_url($_POST['img']);
    		}
    		$data = $this->VideoMod->create();
    		if(!$data){
    			$this->error($this->VideoMod->getError());
    		}
    		
    		if($data){
    			$re = $this->VideoMod->save($data);
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
    			$this->error($this->VideoMod->getError());
    		}
    	}
    	$id = I('request.id',0,'intval');
    	$data = $this->VideoMod->find($id);
    	$cate_id = $data['cate_id'];
    	if(!empty($cate_id)){
    		$this->assign("cate_id",$cate_id);
    	}
    	$this->_getCateTree($cate_id);
    	$this->assign('data',$data);
    	$this->meta_title = "编辑";
    	$alias_template = $this->VideoCateMod->where(array('id'=>$cate_id))->getField('alias_template');
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
    	$re = $this->VideoMod->where(array('id'=>array('in',$ids)))->delete();
    	if($re){
    		$this->success('删除成功!');
    	}
    	else{
    		$this->error("删除失败!");
    	}
    }
    
    // 获取文章分类树结构
    private function _getCateTree($cate_id,$nbsp = "&nbsp;&nbsp;&nbsp;"){
    	$result = $this->VideoCateMod->where(array('status'=>1))->order(array("sort_order"=>"asc"))->select();
    	
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
    	$Mod = $this->VideoCateMod;
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
    	$value = intval($_REQUEST['value']);
    	$ids = I('post.ids');
    	$type = I('request.type');
    	if(!$ids){
    		$this->error("请至少选择一项！");
    	}
    	$re = $this->VideoMod->where(array('id'=>array('in',$ids)))->setField($type,$value);
    	if ($re) {
    		$this->success("更新成功！");
    	} else {
    		$this->error("更新失败！");
    	}
    }
    
}