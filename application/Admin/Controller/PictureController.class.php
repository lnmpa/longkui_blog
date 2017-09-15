<?php
/**
 * ArticleCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Common\Model\ImagesModel;

class PictureController extends AdminbaseController {
	
	protected $ImageMod;
	
    public function _initialize() {
        parent::_initialize();
        $this->ImageMod = new ImagesModel();
    }
    
    public function index() {
    	
    	$where['status'] = 1;
    	$count = $this->ImageMod->where($where)->count();
    	
    	$page = $this->page($count, 12);
    	$list = $this->ImageMod->where($where)->limit($page->firstRow,$page->listRows)->order(array('add_time'=>'desc'))->select();

    	$this->assign("page", $page->show('Admin'));
    	$this->assign("list",$list);
    	
    	$this->display();
    }
    
    public function delete($id = null) {
    	$this->ImageMod->deleteLocal($id);
    	$this->success('删除成功');
    }
    
}
