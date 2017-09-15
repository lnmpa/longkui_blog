<?php
/**
 * CategoryType文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Common\Model\CategoryModel;

class CategoryController extends AdminbaseController {

    protected $CategoryMod;
    protected $CategoryTypeMod;

    public function _initialize() {
        parent::_initialize();
        $this->CategoryMod = new CategoryModel();
        $this->CategoryTypeMod = D("Common/CategoryType");
    }
    
    // 后台菜单列表
    public function index() {
    	$type_id = I('request.type_id',0,'intval');
    	if(!$type_id){
    		$type_id = $this->CategoryTypeMod->where(array('status'=>1))->order('id asc')->getField('id');
    	}
    	$this->assign('type_id',$type_id);
    	$cate_list = $this->CategoryTypeMod->where(array('status'=>1))->select();
    	$this->assign('cate_list',$cate_list);
    	
    	$result = $this->CategoryMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0'),'type_id'=>$type_id))->select();
    	$tree = new \Tree();
		$tree->icon = array('│ ', '├─ ', '└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['id'] = $r['kid'];
			$r['str_manage'] = '<a href="' . U("Category/add", array("pid" => $r['id'],"type_id"=>$type_id)) . '">添加子菜单</a>
					 | <a href="' . U("Category/edit", array("id" => $r['id'],"type_id"=>$type_id)) . '">编辑</a>
					 | <a class="js-ajax-delete" href="' . U("Category/delete", array("id" => $r['id'],"type_id"=>$type_id)) . ' " data-callback="removeAll" data-msg="将删除所有下级子菜单，确认删除？">删除</a>';
			$url=U('Category/edit',array('id'=>$r['id']));
			$r['url'] = $url;
			$r['parentid'] = $r['pid'];
			$r['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . '"' : '';
			$r['status'] = $r['status'] ? 'fa-check' : 'fa-close';
			$array[] = $r;
		}
		$tree->init($array);
		$str = "<tr id='node-\$id' \$parentid_node data-id='\$id'>
					<td style='text-align:center;'><input type='checkbox' class='js-check' data-yid='js-check-y' data-xid='js-check-x' name='ids[]' value='\$id'></td>
					<td>\$id</td>
					<td>\$spacer <a href='\$url'>\$name</a></td>
					<td><input name='alias[\$id]' data-type='alias' type='text' value='\$alias' class='form-control input-sm input-alias input-ajax'></td>
					<td>\$parentspath</td>
					<td><input name='sort_order[\$id]' data-type='sort_order' type='text' size='3' value='\$sort_order' class='form-control input-sm input-order input-ajax'></td>
					<td style='text-align:center;'><i class='fa \$status' data-type='status'></i></td>
					<td>\$str_manage</td>
				</tr>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
		$this->display();
    }
    
    public function add(){
    	$type_id = I('request.type_id',0,'intval');
    	if(!$type_id){
    		$type_id = $this->CategoryTypeMod->where(array('status'=>1))->order('id asc')->getField('id');
    	}
    	$this->assign('type_id',$type_id);
    	if(IS_POST){
    		$pid = I("request.pid",0,"intval");
    		$_POST['parentspath'] = $this->CategoryMod->where(array('kid'=>$pid,'type_id'=>$type_id))->getField('id');
    		$_POST['kid'] = $this->CategoryMod->where(array('type_id'=>$type_id))->max('kid');
    		$_POST['kid'] ++;
    		$data = $this->CategoryMod->create();
    		if($data){
    			if($this->CategoryMod->add($data)){
    				$this->success("添加成功!",U('index',array('type_id'=>$type_id)));
    			}
    			else{
    				$this->error("添加失败!");
    			}
    		}
    		else{
    			$this->error($this->CategoryMod->getError());
    		}
    	}
    	$pid = I("get.pid",0,'intval');
    	$this->assign("select_categorys", $this->CategoryMod->getCateByTypeId($type_id,$pid));
    	$this->meta_title = "添加";
    	$this->display('edit');
    }
    
    public function edit(){
    	$type_id = I('request.type_id',0,'intval');
    	if(!$type_id){
    		$type_id = $this->CategoryTypeMod->where(array('status'=>1))->order('id asc')->getField('id');
    	}
    	$this->assign('type_id',$type_id);
    	if(IS_POST){
    		$pid = I("request.pid",0,"intval");
    		$_POST['parentspath'] = $this->CategoryMod->where(array('kid'=>$pid,'type_id'=>$type_id))->getField('id');
    		if($this->CategoryMod->create()){
    			if($this->CategoryMod->save()){
    				$this->success("修改成功!",U('index',U('index',array('type_id'=>$type_id))));
    			}
    			else{
    				$this->error("修改失败!");
    			}
    		}
    		else{
    			$this->error($this->CategoryMod->getError());
    		}
    	}
    	$kid = I("id","","intval");
    	$data = $this->CategoryMod->where(array('kid'=>$kid,'type_id'=>$type_id))->find();
    	$this->assign("select_categorys", $this->CategoryMod->getCateByTypeId($type_id,$data['pid']));
    	$this->assign('data',$data);
    	$this->meta_title = "修改";
    	$this->display();
    }
    
    public function status(){
    	$value = I('post.value');
    	$id = I('post.id');
    	$type = I('post.type');
    	$re = $this->CategoryMod->where(array('id'=>$id))->setField($type,$value);
    	if ($re) {
    		$this->success("更新成功！");
    	}else {
    		$this->error("更新失败！");
    	}
    }
    
    public function delete(){
    	$id = I('id',0,'intval');
    	if(!$id){
    		$this->error("请选择数据!");
    	}
    	try {
    		$arr = $this->CategoryMod->getFullChilds($id);
    		$re = $this->CategoryMod->where(array('id'=>array('in',$arr)))->delete();
    	} catch (\Exception $e) {
    		$this->error($e->getMessage());
    	}
    	if($re){
    		$this->success('删除成功!');
    	}
    	else{
    		$this->error("删除失败!");
    	}
    }
}
