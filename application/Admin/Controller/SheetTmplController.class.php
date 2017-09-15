<?php
/**
 * SheetCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class SheetTmplController extends AdminbaseController {
	
    protected $SheetTmplModel;
    protected $SheetTmplAttrModel;
	
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
        $this->SheetTmplModel = D("Common/SheetTmpl");
        $this->SheetTmplAttrModel = D("Common/SheetTmplAttr");
    }
	
    public function index() {
    	$where['status'] = array('egt',0);
    	$count = $this->SheetTmplModel->where($where)->count();
    	$page = $this->page($count,20);

    	$list = $this->SheetTmplModel->where($where)->limit($page->firstRow,$page->listRows)->select();
    	foreach ($list as $key=>$val){
    		$list[$key]['status'] = $val['status'] ? 'fa-check' : 'fa-close';
    		$field_list = $this->SheetTmplAttrModel->where(array('cate_id'=>$val['id']))->order(array('sort'=>'asc'))->select();
    		$field_arr = array();
    		foreach ($field_list as $field){
    			$field_arr[] = $field['title'].':'.$field['name'];
    		}
    		$list[$key]['fields'] = implode('|', $field_arr);
    	}
    	$this->assign('page',$page->show('Admin'));
    	$this->assign('list',$list);
    	
    	$this->display();
    }
    
    public function add(){
    	if(IS_POST){
    		$_POST['update_time'] = date('Y-m-d H:i:s');
    		$data = $this->SheetTmplModel->create();
    		if(empty($data['name'])){
    			$this->error("请填写模版名称!");
    		}
    		if(!$data){
    			$this->error($this->SheetTmplModel->getError());
    		}
    		$re = $this->SheetTmplModel->add($data);
    		if($re){
    			$this->success('修改成功!');
    		}
    		else{
    			$this->error("修改失败!");
    		}
    	}
    	$this->display('edit');
    }
    
    public function edit($id = null){
    	if(IS_POST){
    		$_POST['update_time'] = date('Y-m-d H:i:s');
    		$data = $this->SheetTmplModel->create();
    		if(!$data){
    			$this->error($this->SheetTmplModel->getError());
    		}
    		$re = $this->SheetTmplModel->save($data);
    		$sort = I('sort_order');
    		if($sort){
    			$sort_list = explode('|', $sort);
    			$i = 0;
    			foreach ($sort_list as $val){
    				$i++;
    				$this->SheetTmplAttrModel->where(array('id'=>$val))->setField('sort',$i);
    			}
    		}
    		if($re){
    			$this->success('修改成功!');
    		}
    		else{
    			$this->error("修改失败!");
    		}
    	}
    	$data = $this->SheetTmplModel->find($id);
    	$list = $this->SheetTmplAttrModel->where(array('cate_id'=>$data['id']))->order(array('sort'=>'asc'))->select();
    	foreach ($list as $key=>$val){
    		$list[$key]['attr_type'] = $this->type_arr[$val['attr_type']]['title'];
    	}
    	$this->assign('data',$data);
    	$this->assign('list',$list);
    	$this->display();
    }
    
	public function delete(){
    	$ids = I('ids');
    	if(!$ids){
    		$this->error("请选择数据!");
    	}
    	$re = $this->SheetTmplModel->where(array('id'=>array('in',$ids)))->delete();
    	if($re){
    		$this->success('删除成功!');
    	}
    	else{
    		$this->error("删除失败!");
    	}
    }
    
	public function status(){
		$value = I('request.value');
		$id = I('request.id');
		$type = I('request.type');
		$re = $this->SheetTmplModel->where(array('id'=>$id))->setField($type,$value);
		if ($re) {
			$this->success("更新成功！");
		} else {
			$this->error("更新失败！");
		}
	}
	
	public function edit_field($id = null){
		if(!$id){
			$this->error('参数错误！');
		}
		$data = $this->SheetTmplAttrModel->find($id);
		if(IS_POST){
			M()->startTrans();
			$old_field = $this->SheetTmplAttrModel->where(array('id'=>$id))->getField('name');
			$field_name = I('name');
			$attr_type = I('attr_type');
			
			$data = $this->SheetTmplAttrModel->create();
			$re = $this->SheetTmplAttrModel->save($data);
				
			if($re){
				M()->commit();
				$this->success("修改字段成功！");
			}
			else{
				M()->rollback();
				$this->error('修改字段失败！');
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
		if(IS_POST){
			try {
				$field_name = I('name');
				$attr_type = I('attr_type');
				if(!($field_name&&$attr_type&&I('title'))){
					$this->error('参数错误！');
				}
				
				$data = $this->SheetTmplAttrModel->create();
				$data['sort'] = $this->SheetTmplAttrModel->where(array('cate_id'=>$cate_id))->max('sort');
				$data['sort'] = $data['sort']==null?1:$data['sort']+1;
				$re = $this->SheetTmplAttrModel->add($data);
				
				if($re){
					$return_data['id'] = $re;
					$return_data['title'] = $data['title'];
					$return_data['name'] = $data['name'];
					$return_data['attr_type'] = $this->type_arr[$data['attr_type']]['title'];
					$return_data['edit_url'] = U('edit_field?id='.$re);
					$return_data['delete_url'] = U('delete_field?id='.$re);
					$return_data['type'] = 'add';
					$this->success("新增字段成功！","",$return_data);
				}
				else{
					$this->error('新增字段失败！');
				}
			} catch (\Exception $e) {
				$this->error($e->getMessage());
			}
			
		}
		$data['cate_id'] = $cate_id;
		$count = $this->SheetTmplAttrModel->where(array('cate_id'=>$cate_id))->count();
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
		$data = $this->SheetTmplAttrModel->find($id);
		$re = $this->SheetTmplAttrModel->delete($id);
		if($re){
			$this->success("删除成功！");
		}
		else{
			$this->error('删除失败！');
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
