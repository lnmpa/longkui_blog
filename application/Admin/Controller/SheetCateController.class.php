<?php
/**
 * SheetCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class SheetCateController extends AdminbaseController {

    protected $SheetCateMod;
    protected $SheetAttrMod;

    public $type_arr = array(
    		'text'=>array('title'=>'文本','type'=>'varchar'),
    		'textarea'=>array('title'=>'大文本','type'=>'text'),
    		'num'=>array('title'=>'数字','type'=>'int'),
    		'date'=>array('title'=>'日期','type'=>'date'),
    		'time'=>array('title'=>'时间','type'=>'datetime'),
    		'img'=>array('title'=>'图片','type'=>'int'),
    		'file'=>array('title'=>'附件','type'=>'int'),
    );

    public function _initialize() {
        parent::_initialize();
        $this->SheetCateMod = D("Common/SheetCate");
        $this->SheetAttrMod = D("Common/SheetAttr");
    }
    
    // 后台菜单列表
    public function index() {
    	session('admin_menu_index','SheetCate/index');
        $result = $this->SheetCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
        
        $tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("SheetCate/add", array("pid" => $r['id'])) . '">添加子菜单</a>
					 | <a href="' . U("SheetCate/edit", array("id" => $r['id'])) . '">编辑</a>
					 | <a class="js-ajax-delete" href="' . U("SheetCate/delete", array("id" => $r['id'])) . ' " data-callback="removeAll" data-msg="将删除所有下级子菜单，确认删除？">删除</a>';
			$url=U('SheetCate/edit',array('id'=>$r['id']));
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
    		$_POST['parentspath'] = I("request.pid",0,"intval");
    		$data = $this->SheetCateMod->create();
    		if($data){
    			M()->startTrans();
    			$id = $this->SheetCateMod->add($data);
    			if($id){
    				try{
    					$tmpl = I('tmpl');
    					if($tmpl){
    						$attrList = M('SheetTmplAttr')->where(array('cate_id'=>$tmpl))->order('sort asc')->select();
    						foreach ($attrList as $k=>$v){
    							$attrList[$k]['cate_id'] = $id;
    							unset($attrList[$k]['id']);
    						}
    						$this->SheetAttrMod->addAll($attrList);
    					}
    						
    					$common_mod = sp_model('SheetCate');
    					$table_name = "SheetTable".$id;
    					$common_mod->create_table($table_name);
    					$mod = sp_model($table_name);
    					$attr_list = $this->SheetAttrMod->where(array('cate_id'=>$id))->select();
    					foreach ($attr_list as $key=>$val){
    						$mod->alert_field($table_name,$val['name'],"",$this->type_arr[$val['attr_type']]['type']);
    					}
    				}catch(\Exception $e) {
    					$this->error($e->getMessage());
    				}
    				
    				$return_data['id'] = $id;
    				$return_data['click'] = "changeUrl('".U('Sheet/index?cate_id='.$id)."')";
    				
    				M()->commit();
    				$this->success("添加成功!",U('index'),$return_data);
    			}
    			else{
    				M()->rollback();
    				$this->error("添加失败!");
    			}
    		}
    		else{
    			$this->error($this->SheetCateMod->getError());
    		}
    	}
    	$tree = new \Tree();
    	$pid = I("get.pid",0,'intval');
    	$result = $this->SheetCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
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
    		$_POST['parentspath'] = I("post.pid",0,"intval");
    		if($this->SheetCateMod->create()){
    			if($this->SheetCateMod->save()){
    				$this->success("修改成功!",U('index'));
    			}
    			else{
    				$this->error("修改失败!");
    			}
    		}
    		else{
    			$this->error($this->SheetCateMod->getError());
    		}
    	}
    	$id = I("id","","intval");
    	$data = $this->SheetCateMod->find($id);
    	
    	$tree = new \Tree();
    	$result = $this->SheetCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
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
		$this->SheetCateMod->findChildIds($id);
		$re = $this->SheetCateMod->where(array('id'=>array('in',$this->SheetCateMod->getDelArr())))->setField('status',-1);
		if($re){
			$this->success('删除成功!');
		}
		else{
			$this->error("删除失败!");
		}
	}
	
	public function sort_order() {
		$listorders = I('listorders');
		$i = 0;
		foreach ($listorders as $key=>$val){
			$i++;
			$this->SheetCateMod->where(array('id'=>$val))->setField('sort_order',$i);
		}
		$this->success("排序更新成功！");
	}
	
	public function status(){
		$value = I('post.value');
		$id = I('post.id');
		$type = I('post.type');
		$re = $this->SheetCateMod->where(array('id'=>$id))->setField($type,$value);
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
				$sort_order = $this->SheetCateMod->max('sort_order');
				preg_match('/^-+/', $v,$input);
				$coun = substr_count($input[0],'-');
				$vt = preg_replace('/^-+/', '$1', $v);
				$vv = str_replace("\r","",$vt);
				
				if(0==$coun){
					if($parentid){
						$fath = $this->SheetCateMod->find($parentid);
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
					$re = $this->SheetCateMod->add($data);
					$id_arrs[$coun][] = $re;
				}else{
					$pid = $id_arrs[$coun-1][count($id_arrs[$coun-1])-1];
					$fath = $this->SheetCateMod->find($pid);
					$data['name'] = $vv;
					$data['pid'] = $pid;
					$data['parentspath'] = $fath['parentspath'].$pid.",";
					$data['sort_order'] = $sort_order+1;
					$data['status'] = 1;
					$re = $this->SheetCateMod->add($data);
					$id_arrs[$coun][] = $re;
				}
		
			}
			$this->success("添加成功");
		}else{
			$tree = new \Tree();
			$pid = I("get.pid",0,'intval');
			$result = $this->SheetCateMod->order(array("sort_order" => "ASC"))->where(array('status'=>array('egt','0')))->select();
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
	
	public function design($id = null){
		if(IS_POST){
			$sort = I('sort_order');
			if($sort){
				$sort_list = explode('|', $sort);
				$i = 0;
				foreach ($sort_list as $val){
					$i++;
					$this->SheetAttrMod->where(array('id'=>$val))->setField('sort',$i);
				}
			}
			$this->success("修改成功！");
		}
		if(!$id){
			$this->error('参数错误！');
		}
		$this->assign('id',$id);
		
		
		$table_name = "SheetTable".$id;
		$common_mod = sp_model('SheetCate');
		if(!$common_mod->table_exists($table_name)){
			$common_mod->create_table($table_name);
		}
		$list = $this->SheetAttrMod->where(array('cate_id'=>$id))->order('sort asc')->select();
		foreach ($list as $key=>$val){
			$list[$key]['attr_type'] = $this->type_arr[$val['attr_type']]['title'];
		}
		$this->assign('list',$list);
		$this->display();
	}
	
	public function edit_field($id = null){
		if(!$id){
			$this->error('参数错误！');
		}
		$data = $this->SheetAttrMod->find($id);
		$table_name = "SheetTable".$data['cate_id'];
		if(IS_POST){
			try {
				M()->startTrans();
				$mod = sp_model($table_name);
				$old_field = $this->SheetAttrMod->where(array('id'=>$id))->getField('name');
				$field_name = I('name');
				$attr_type = I('attr_type');
				$re = $mod->alert_field($table_name,$field_name,$old_field,$this->type_arr[$attr_type]['type']);
					
				$data = $this->SheetAttrMod->create();
				$re2 = $this->SheetAttrMod->save($data);
					
				if($re && $re2){
					M()->commit();
					$this->success("新增字段成功！");
				}
				else{
					M()->rollback();
					$this->error('新增字段失败！');
				}
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
		}
		
		$this->assign('data',$data);
		$this->assign('taxonomys',$this->_get_attr_type_list($data['attr_type']));
		$this->display();
	}
	
	public function add_field($cate_id = null){
		if(!$cate_id){
			$this->error('参数错误！');
		}
		$table_name = "SheetTable".$cate_id;
		if(IS_POST){
			try {
				M()->startTrans();
				$mod = sp_model($table_name);
				$field_name = I('name');
				$attr_type = I('attr_type');
				if(!($field_name&&$attr_type&&I('title'))){
					$this->error('参数错误！');
				}
					
				$re = $mod->alert_field($table_name,$field_name,"",$this->type_arr[$attr_type]['type']);
					
				$data = $this->SheetAttrMod->create();
				$data['sort'] = $this->SheetAttrMod->where(array('cate_id'=>$cate_id))->max('sort');
				$data['sort'] = $data['sort']==null?1:$data['sort']+1;
				$re2 = $this->SheetAttrMod->add($data);
					
				if($re && $re2){
					M()->commit();
					$return_data['id'] = $re2;
					$return_data['title'] = $data['title'];
					$return_data['name'] = $data['name'];
					$return_data['attr_type'] = $this->type_arr[$data['attr_type']]['title'];
					$return_data['edit_url'] = U('edit_field?id='.$re2);
					$return_data['delete_url'] = U('delete_field?id='.$re2);
					$return_data['type'] = 'add';
					$this->success("新增字段成功！","",$return_data);
				}
				else{
					M()->rollback();
					$this->error('新增字段失败！');
				}
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
		}
		$data['cate_id'] = $cate_id;
		$mod = sp_model($table_name);
		$count = count($mod->get_fields($table_name));
		$data['title'] = "新增字段".$count;
		$data['name'] = "field".$count;
		$this->assign('data',$data);
		$this->assign('taxonomys',$this->_get_attr_type_list('text'));
		$this->display('edit_field');
	}
	
	public function delete_field($id = null){
		if(!$id){
			$this->error('参数错误！');
		}
		$data = $this->SheetAttrMod->find($id);
		$table_name = "SheetTable".$data['cate_id'];
		$mod = sp_model($table_name);
		M()->startTrans();
		$re = $mod->delete_field($table_name, $data['name']);
		$re2 = $this->SheetAttrMod->delete($id);
		if($re && $re2){
			M()->commit();
			$this->success("删除字段成功！");
		}
		else{
			M()->rollback();
			$this->error('删除字段失败！');
		}
	}
	
	private function _get_attr_type_list($type){
		$mod = sp_model('SheetCate');
		
		foreach ($this->type_arr as $key=>$val){
			$selected = "";
			if($key == $type){
				$selected = 'selected';
			}
			$result .="<option value='".$key."' ".$selected.">".$val['title']."</option>";
		}
		return $result;
	}
}
