<?php
/**
 * ApplyCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class ApplyController extends AdminbaseController {

    protected $ApplyModel;

    public function _initialize() {
        parent::_initialize();
        $this->ApplyModel = M("Apply");
    }
    
    // 后台菜单列表
    public function index() {
    	$where['status'] = array('egt',0);
    	
    	$title = I('request.title');
    	if($title){
    		$where['title'] = array('like','%'.$title.'%');
    		$this->assign('title',$title);
    	}
    	
    	$this->ApplyModel
    	->where($where);
    	
    	$count=$this->ApplyModel->count();
    	$page = $this->page($count, 20);
    	
    	$this->ApplyModel
    	->where($where)
    	->limit($page->firstRow , $page->listRows)
    	->order("id desc");
    	
    	$list = $this->ApplyModel->select();
    	
    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	$this->display();
    }
    
    public function delete(){
    	$ids = I('ids');
    	if(!$ids){
    		$this->error("请选择数据!");
    	}
    	M()->startTrans();
    	$re = $this->ApplyModel->where(array('id'=>array('in',$ids)))->delete();
    	if($re){
    		M()->commit();
    		$this->success('删除成功!');
    	}
    	else{
    		M()->rollback();
    		$this->error("删除失败!");
    	}
    }
    
}