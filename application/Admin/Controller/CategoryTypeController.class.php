<?php
namespace Admin\Controller;
use Common\Controller\AdminbaseController;

class CategoryTypeController extends AdminbaseController{
	
	protected $CategoryTypeMod;
	
	public function _initialize() {
		parent::_initialize();
		$this->CategoryTypeMod = D("Common/CategoryType");
	}
	
	// 分类类型列表
	public function index(){
		$list=$this->CategoryTypeMod->where(array('status'=>array('egt',0)))->select();
		foreach ($list as $key=>$val){
			$list[$key]['status'] = $val['status'] ? 'fa-check' : 'fa-close';
		}
		$this->assign("list",$list);
		$this->display();
	}
	
	// 分类类型添加
    public function add() {
    	if (IS_POST) {
    		if ($this->CategoryTypeMod->create()!==false) {
    			if ($this->CategoryTypeMod->add()!==false) {
    				$this->success("添加成功！", U("CategoryType/index"));
    			} else {
    				$this->error("添加失败！");
    			}
    		} else {
    			$this->error($this->CategoryTypeMod->getError());
    		}
    	}
        $this->display('edit');
    }
    
    // 分类类型编辑
	public function edit(){
		if (IS_POST) {
			if ($this->CategoryTypeMod->create()!==false) {
				if ($this->CategoryTypeMod->save()!==false) {
					$this->success("保存成功！", U("CategoryType/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->CategoryTypeMod->getError());
			}
		}
		$id= I("get.id",0,'intval');
		$data=$this->CategoryTypeMod->where(array('cid'=>$id))->find();
		$this->assign('data',$data);
		$this->display();
	}
	
	public function status(){
		$value = I('post.value');
		$id = I('post.id');
		$type = I('post.type');
		$re = $this->CategoryTypeMod->where(array('id'=>$id))->setField($type,$value);
		if ($re) {
			$this->success("更新成功！");
		} else {
			$this->error("更新失败！");
		}
	}
	
	public function delete(){
		$ids = I('ids');
		if(!$ids){
			$this->error("请选择数据!");
		}
		$re = $this->CategoryTypeMod->where(array('id'=>array('in',$ids)))->setField('status',-1);
		if($re){
			M("Category")->where(array('type_id'=>array('in',$ids)))->setField('status',-1);
			$this->success('删除成功!');
		}
		else{
			$this->error("删除失败!");
		}
	}
	
	
}