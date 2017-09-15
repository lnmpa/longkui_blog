<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class OrganizationController extends AdminbaseController{

	protected $OrganizationModel;

	public function _initialize() {
		parent::_initialize();
		$this->OrganizationModel = D("Common/Organization");
	}

	public function index(){
		
		$list = $this->OrganizationModel->where(array('status'=>array('egt',0),'pid'=>0))->order('sort asc')->select();
		foreach ($list as $key=>$val){
			$list[$key]['status'] = $val['status'] ? '显示' : '不显示';
			$count = $this->OrganizationModel->where(array('status'=>1,'pid'=>$val['id']))->count();
			$list[$key]['hasChild'] = $count ? "hasChild=\"true\"" : "";
			$list[$key]['status'] = $val['status'] ? 'fa-check' : 'fa-close';
		}
		$this->assign("list", $list);
		$this->display();
	}
	
	public function geiChilds($id = null){
		if(!$id){
			$this->error('参数错误');
		}
		$list = $this->OrganizationModel->where(array('status'=>array('egt',0),'pid'=>$id))->order('sort asc')->select();
		foreach ($list as $key=>$val){
			$list[$key]['status'] = $val['status'] ? '显示' : '不显示';
			$count = $this->OrganizationModel->where(array('status'=>1,'pid'=>$val['id']))->count();
			$list[$key]['hasChild'] = $count ? "hasChild=\"true\"" : "";
			$list[$key]['status'] = $val['status'] ? 'fa-check' : 'fa-close';
		}
		$this->assign("list", $list);
		$this->display();
	}
	
	public function findDistrict($pid = null){
		$list = $this->OrganizationModel->where(array('status'=>array('egt',0),'pid'=>$pid))->field('id,name,alias,sort')->order('sort asc')->select();
		foreach ($list as $key=>$val){
			$val['key'] = $key + 10000;
			$fix[$val['key']]['id'] = $val['id'];
			$fix[$val['key']]['name'] = $val['alias']? $val['alias']:$val['name'];
		}
		$this->success($fix);
	}
	
	public function status(){
		$value = I('post.value');
		$id = I('post.id');
		$type = I('post.type');
		$re = $this->OrganizationModel->where(array('id'=>$id))->setField($type,$value);
		if ($re) {
			$this->success("更新成功！");
		} else {
			$this->error("更新失败！");
		}
	}
	
	public function update(){
	
		$this->success('更新成功');
	}
	
	public function delete(){
		$id = I('id',0,'intval');
		if(!$id){
			$this->error("请选择数据!");
		}
		$this->OrganizationModel->findChildIds($id);
		$re = $this->OrganizationModel->where(array('id'=>array('in',$this->OrganizationModel->getDelArr())))->setField('status',-1);
		if($re){
			$this->success('删除成功!');
		}
		else{
			$this->error("删除失败!");
		}
	}
	
	//党组织添加
	public function add(){
		if(IS_POST){
			$data = $this->OrganizationModel->create();
			
			if(!$data){
				$this->error($this->OrganizationModel->getError());
			}
			$re = $this->OrganizationModel->add();
			if($re){
				$this->success('新增成功！');
			}
			else{
				$this->error('新增失败！');
			}
		}
		$pid = I("pid","","intval");
		$this->assign('pid',$pid);
		$org_list = $this->OrganizationModel->where(array('status'=>1))->select();
		$this->assign('org_list',$org_list);
		/*
		$data['pid'] = $pid;
		$data['parents_path'] = $this->OrganizationModel->getPath($pid);
		$path = explode(',', $data['parents_path']);
		foreach ($path as $key=>$val){
			$list = null;
			$list = $this->OrganizationModel->where(array('pid'=>$val,'status'=>1))->select();
			if($list){
				foreach ($list as $k=>$v){
					if($v['id'] == $path[$key+1]){
						$list[$k]['selected'] = 'selected';
					}
				}
				$region_list[$key]['_list'] = $list;
			}
		}
		$this->assign('region_list',$region_list);*/
		
		$this->assign('data',$data);
		$this->meta_title = "添加";
		$this->display('edit');
	}
		
	//党组织编辑
	public function edit(){
		if(IS_POST){
			$data = $this->OrganizationModel->create();
			
			if(!$data){
				$this->error($this->OrganizationModel->getError());
			}
			if(in_array($data['id'], explode(',', $data['parents_path']))){
				$this->error('上级组织不能包含自己，请重新选择！');
			}
			$re = $this->OrganizationModel->save();
			if($re){
				$this->success('保存成功！');
			}
			else{
				$this->error('保存失败！');
			}
		}
		$id = I("id","","intval");
		$data = $this->OrganizationModel->find($id);
		$this->assign('data',$data);
		
		$pid = $data['pid'];
		$this->assign('pid',$pid);
		$org_list = $this->OrganizationModel->where(array('status'=>1))->select();
		$this->assign('org_list',$org_list);
		
		$this->meta_title = "修改";
		$this->display();
	}
}