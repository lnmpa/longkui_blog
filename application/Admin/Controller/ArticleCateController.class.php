<?php
/**
 * ArticleCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class ArticleCateController extends AdminbaseController {

    protected $ArticleCateMod;

    public function _initialize() {
        parent::_initialize();
        $this->ArticleCateMod = D("Common/ArticleCate");
    }
    
    // 后台菜单列表
    public function index() {
        $result = $this->ArticleCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
        
        $tree = new \Tree();
		$tree->icon = array('│ ', '├─ ', '└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("ArticleCate/add", array("pid" => $r['id'])) . '" title="添加子菜单"><i class="fa fa-plus-square-o" style="color:#0dd441;"></i></a>
					&nbsp;&nbsp;&nbsp;<a href="' . U("ArticleCate/edit", array("id" => $r['id'])) . '" title="修改"><i class="fa fa-edit"></i></a>
					&nbsp;&nbsp;&nbsp;<a class="js-ajax-delete" href="' . U("ArticleCate/delete", array("id" => $r['id'])) . ' " data-callback="removeAll" data-msg="将删除所有下级子菜单，确认删除？" title="删除"><i class="fa fa-trash-o" style="color:#d86c5b"></i></a>';
			$url=U('ArticleCate/edit',array('id'=>$r['id']));
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
					<td>\$record_nums</td>
					<td><input name='sort_order[\$id]' data-type='sort_order' type='text' size='3' value='\$sort_order' class='form-control input-sm input-order input-ajax'></td>
					<td style='text-align:center;'><i class='fa \$status'></i></td>
					<td>\$str_manage</td>
				</tr>";
		$taxonomys = $tree->get_tree(0, $str);
		$this->assign("taxonomys", $taxonomys);
		$this->display();
    }
    
    public function add(){
    	if(IS_POST){
    		$_POST['parentspath'] = I("pid",0,"intval");
    		$data = $this->ArticleCateMod->create();
    		if($data){
    			if($this->ArticleCateMod->add($data)){
    				
    				$this->success("添加成功!",U('index'));
    			}
    			else{
    				$this->error("添加失败!");
    			}
    		}
    		else{
    			$this->error($this->ArticleCateMod->getError());
    		}
    	}
    	$tree = new \Tree();
    	$pid = I("get.pid",0,'intval');
    	$result = $this->ArticleCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
    	foreach ($result as $r) {
    		$r['selected'] = $r['id'] == $pid ? 'selected' : '';
    		$r['parentid'] = $r['pid'];
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$select_categorys = $tree->get_tree(0, $str);
    	$this->assign("select_categorys", $select_categorys);
    	$this->meta_title = "添加";
    	$this->display('edit');
    }
    
    public function edit(){
    	if(IS_POST){
    		$_POST['parentspath'] = I("pid",0,"intval");
    		if($this->ArticleCateMod->create()){
    			if($this->ArticleCateMod->save()){
    				
    				$this->success("修改成功!",U('index'));
    			}
    			else{
    				$this->error("修改失败!");
    			}
    		}
    		else{
    			$this->error($this->ArticleCateMod->getError());
    		}
    	}
    	$id = I("id","","intval");
    	$data = $this->ArticleCateMod->find($id);
    	
    	$tree = new \Tree();
    	$result = $this->ArticleCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
    	foreach ($result as $r) {
    		$r['selected'] = $r['id'] == $data['pid'] ? 'selected' : '';
    		$r['parentid'] = $r['pid'];
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$select_categorys = $tree->get_tree(0, $str);
    	$this->assign("select_categorys", $select_categorys);
    	
    	$this->assign('data',$data);
    	$this->meta_title = "修改";
    	$this->display();
    }
    
	public function delete(){
		$id = I('id',0,'intval');
		if(!$id){
			$this->error("请选择数据!");
		}
		$this->ArticleCateMod->findChildIds($id);
		$re = $this->ArticleCateMod->where(array('id'=>array('in',$this->ArticleCateMod->getDelArr())))->setField('status',-1);
		if($re){
			$this->success('删除成功!');
		}
		else{
			$this->error("删除失败!");
		}
	}
	
	public function status(){
		$value = I('post.value');
		$id = I('post.id');
		$type = I('post.type');
		$re = $this->ArticleCateMod->where(array('id'=>$id))->setField($type,$value);
		if ($re) {
			$this->success("更新成功！");
		} else {
			$this->error("更新失败！");
		}
	}
	
	public function add_all(){
		if(IS_POST){
			$parentid = I('pid');
			$cate_name = I('cate_name');
			$temp = explode("\n",$cate_name);
			foreach($temp as $k=>$v){
				$sort_order = $this->ArticleCateMod->max('sort_order');
				preg_match('/^-+/', $v,$input);
				$coun = substr_count($input[0],'-');
				$vt = preg_replace('/^-+/', '$1', $v);
				$vv = str_replace("\r","",$vt);
				
				if(0==$coun){
					if($parentid){
						$fath = $this->ArticleCateMod->find($parentid);
						$data['pid'] = $parentid;
						$data['parentspath'] = $fath['parentspath'].$parentid.",";
					}
					else{
						$data['pid'] = 0;
						$data['parentspath'] = "0,";
					}
					$data['name'] = $vv;
					$data['sort_order'] = $sort_order+1;
					$data['status'] = 1;
					$re = $this->ArticleCateMod->add($data);
					$id_arrs[$coun][] = $re;
				}else{
					$pid = $id_arrs[$coun-1][count($id_arrs[$coun-1])-1];
					$fath = $this->ArticleCateMod->find($pid);
					$data['name'] = $vv;
					$data['pid'] = $pid;
					$data['parentspath'] = $fath['parentspath'].$pid.",";
					$data['sort_order'] = $sort_order+1;
					$data['status'] = 1;
					$re = $this->ArticleCateMod->add($data);
					$id_arrs[$coun][] = $re;
				}
		
			}
			$this->success("添加成功");
		}else{
			$tree = new \Tree();
			$pid = I("get.pid",0,'intval');
			$result = $this->ArticleCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
			foreach ($result as $r) {
				$r['selected'] = $r['id'] == $pid ? 'selected' : '';
				$r['parentid'] = $r['pid'];
				$array[] = $r;
			}
			$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
			$tree->init($array);
			$select_categorys = $tree->get_tree(0, $str);
			$this->assign("select_categorys", $select_categorys);
			$this->display();
		}
	}
	
	public function update_num(){
		$ids = I('ids');
		$id_strs = implode(',', $ids);
		$Model = new \Think\Model();
		
		$sql = "update ".sp_table_name('ArticleCate')." a set a.record_nums = (select count(*) from ".sp_table_name('Article')." b where a.id = b.cate_id) where id in ($id_strs)";
		$Model->execute($sql);
		$this->success("操作成功!");
	}
}
