<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class NavController extends AdminbaseController {
	
	protected $nav_model;
	protected $navcat_model;
	
	public function _initialize() {
		parent::_initialize();
		$this->nav_model = D("Common/Nav");
		$this->navcat_model =D("Common/NavCat");
	}
	
	// 导航菜单列表
	public function index() {
		$cid=I('request.cid',0,'intval');
		if(empty($cid)){
			$navcat=$this->navcat_model->find();
			$cid=$navcat['navcid'];
		}
		
		$result = $this->nav_model->where(array('cid'=>$cid))->order(array("listorder" => "ASC"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;&nbsp;&nbsp;│ ', '&nbsp;&nbsp;&nbsp;├─ ', '&nbsp;&nbsp;&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("nav/add", array("parentid" => $r['id'],"cid"=>$r['cid'])) . '">'.L('ADD_SUB_NAV').'</a> | <a href="' . U("nav/edit", array("id" => $r['id'],"parentid"=>$r['parentid'],"cid"=>$r['cid'])) . '">'.L('EDIT').'</a> | <a class="js-ajax-delete" href="' . U("nav/delete", array("id" => $r['id'])) . '">'.L('DELETE').'</a> ';
			//$r['status'] = $r['status'] ? L('DISPLAY') : L('HIDDEN');
			$r['status'] = $r['status'] ? 'fa-check' : 'fa-close';
			$array[] = $r;
		}
	
		$tree->init($array);
		$str = "<tr data-id='\$id'>
				<td><input name='listorders[\$id]' type='text' size='3' value='\$listorder' class='form-control input-sm input-order input-ajax'></td>
				<td>\$id</td>
				<td >\$spacer\$label</td>
			    <td><i class='fa \$status' data-type='status'></i></td>
				<td>\$str_manage</td>
			</tr>";
		$categorys = $tree->get_tree(0, $str);
		$this->assign("categorys", $categorys);
		
		$cats=$this->navcat_model->select();
		$this->assign("navcats",$cats);
		$this->assign("navcid",$cid);
		
		$this->display();
	}
	
	// 导航菜单添加
	public function add() {
		if (IS_POST) {
			$data=I("post.");
			if ($this->nav_model->create($data)!==false) {
				$result=$this->nav_model->add();
				if ($result!==false) {
					$parentid=I('post.parentid',0,'intval');
					if(empty($parentid)){
						$data['path']="0-$result";
					}else{
						$parent=$this->nav_model->where(array('id'=>$parentid))->find();
						$data['path']=$parent[path]."-$result";
					}
					$data['id']=$result;
					$this->nav_model->save($data);
					F("site_nav_".intval($data['cid']),null);
					F("site_nav_main",null);
					$this->success("添加成功！", U("nav/index"));
				} else {
					$this->error("添加失败！");
				}
			} else {
				$this->error($this->nav_model->getError());
			}
		}
		$cid=I('request.cid',0,'intval');
		$result = $this->nav_model->where(array('cid'=>$cid))->order(array("listorder" => "ASC"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;│ ', '&nbsp;├─ ', '&nbsp;└─ ');
		$tree->nbsp = '&nbsp;';
		$parentid=I("get.parentid",0,'intval');
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("Menu/add", array("parentid" => $r['id'], "menuid" => I("get.menuid"))) . '">添加子菜单</a> | <a href="' . U("Menu/edit", array("id" => $r['id'], "menuid" => I("get.menuid"))) . '">修改</a> | <a class="js-ajax-delete" href="' . U("Menu/delete", array("id" => $r['id'], "menuid" => I("get.menuid"))) . '">删除</a> ';
			$r['selected'] = $r['id']==$parentid?"selected":"";
			$array[] = $r;
		}
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$label</option>";
		$nav_trees = $tree->get_tree(0, $str);
		$this->assign("nav_trees", $nav_trees);
	   
		$cats=$this->navcat_model->select();
		$this->assign("navcats",$cats);
		
		$this->assign("navcid",$cid);
		$this->display('edit');
	}
	
	// 导航菜单编辑
	public function edit() {
		if (IS_POST) {
			$parentid=empty($_POST['parentid'])?"0":$_POST['parentid'];
			if(empty($parentid)){
				$_POST['path']="0-".$_POST['id'];
			}else{
				$parent=$this->nav_model->where("id=$parentid")->find();
					
				$_POST['path']=$parent['path']."-".$_POST['id'];
			}
				
			$data=I("post.");
			if ($this->nav_model->create($data)!==false) {
				if ($this->nav_model->save() !== false) {
					F("site_nav_".intval($data['cid']),null);
					F("site_nav_main",null);
					$this->success("保存成功！", U("nav/index"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->nav_model->getError());
			}
		}
		$cid=I('request.cid',0,'intval');;
		$id=I("get.id",0,'intval');
		$result = $this->nav_model->where("cid=$cid and id!=$id")->order(array("listorder" => "ASC"))->select();
		$tree = new \Tree();
		$tree->icon = array('&nbsp;│ ', '&nbsp;├─ ', '&nbsp;└─ ');
		$tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
		$parentid= I("get.parentid",0,'intval');
		foreach ($result as $r) {
			$r['str_manage'] = '<a href="' . U("Menu/add", array("parentid" => $r['id'], "menuid" => I("get.menuid"))) . '">添加子菜单</a> | <a href="' . U("Menu/edit", array("id" => $r['id'], "menuid" => I("get.menuid"))) . '">修改</a> | <a class="js-ajax-delete" href="' . U("Menu/delete", array("id" => $r['id'], "menuid" => I("get.menuid"))) . '">删除</a> ';
			$r['status'] = $r['status'] ? "显示" : "隐藏";
			$r['selected'] = $r['id']==$parentid?"selected":"";
			$array[] = $r;
		}
		
		$tree->init($array);
		$str="<option value='\$id' \$selected>\$spacer\$label</option>";
		$nav_trees = $tree->get_tree(0, $str);
		$this->assign("nav_trees", $nav_trees);
		
		
		$cats=$this->navcat_model->select();
		$this->assign("navcats",$cats);
			
		$nav=$this->nav_model->where(array('id'=>$id))->find();
		$nav['hrefold']=$nav['href'];
		$this->assign($nav);
		
		$this->assign("navcid",$cid);
		$this->display();
	}
	
	public function add_all(){
		$cid=I('request.cid',0,'intval');
		if(IS_POST){
			$NavMod = M('Nav');
			$parentid = I('parentid');
			$cate_name = I('cate_name');
			$temp = explode("\n",$cate_name);
			foreach($temp as $k=>$v){
				$listorder = $NavMod->max('listorder');
				preg_match('/^-+/', $v,$input);
				$coun = substr_count($input[0],'-');
				$vt = preg_replace('/^-+/', '$1', $v);
				$vv = str_replace("\r","",$vt);
				if(0==$coun){
					$data = array();
					$data['label'] = $vv;
					$data['cid'] = $cid;
					$data['parentid'] = empty($parentid)?0:$parentid;
					$data['listorder'] = $listorder+1;
					$data['status'] = 1;
					$result = $NavMod->add($data);
					$data['id'] = $result;
					if($parentid){
						$fath = $NavMod->find($parentid);
						$data['path'] = $fath['path']."-".$result;
					}
					else{
						$data['path'] = "0-".$result;
					}
					$NavMod->save($data);
					$id_arrs[$coun][] = $result;
				}else{
					$pid = $id_arrs[$coun-1][count($id_arrs[$coun-1])-1];
					$fath = $NavMod->find($pid);
					$data = array();
					$data['label'] = $vv;
					$data['cid'] = $cid;
					$data['parentid'] = $pid;
					$data['listorder'] = $listorder+1;
					$data['status'] = 1;
					$result = $NavMod->add($data);
					$data['id'] = $result;
					$data['path'] = $fath['path'].'-'.$result;
					$NavMod->save($data);
				}
	
			}
			$this->success("添加成功");
		}else{
			$id=I("get.id",0,'intval');
			$result = $this->nav_model->where("cid=$cid and id!=$id")->order(array("listorder" => "ASC"))->select();
			$tree = new \Tree();
			$tree->icon = array('&nbsp;│ ', '&nbsp;├─ ', '&nbsp;└─ ');
			$tree->nbsp = '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
			$parentid= I("get.parentid",0,'intval');
			foreach ($result as $r) {
				$r['str_manage'] = '<a href="' . U("Menu/add", array("parentid" => $r['id'], "menuid" => I("get.menuid"))) . '">添加子菜单</a> | <a href="' . U("Menu/edit", array("id" => $r['id'], "menuid" => I("get.menuid"))) . '">修改</a> | <a class="js-ajax-delete" href="' . U("Menu/delete", array("id" => $r['id'], "menuid" => I("get.menuid"))) . '">删除</a> ';
				$r['status'] = $r['status'] ? "显示" : "隐藏";
				$r['selected'] = $r['id']==$parentid?"selected":"";
				$array[] = $r;
			}
			
			$tree->init($array);
			$str="<option value='\$id' \$selected>\$spacer\$label</option>";
			$nav_trees = $tree->get_tree(0, $str);
			$this->assign("nav_trees", $nav_trees);
			
			$cats=$this->navcat_model->select();
			$this->assign("navcats",$cats);
			
			$this->assign('cid',$cid);
			$this->display();
		}
	}
	
	public function status(){
		$value = intval($_REQUEST['value']);
		$ids = I('post.ids');
		$type = I('request.type');
		if(!$ids){
			$this->error("请至少选择一项！");
		}
		$re = $this->nav_model->where(array('id'=>array('in',$ids)))->setField($type,$value);
		if ($re) {
			$this->success("更新成功！");
		} else {
			$this->error("更新失败！");
		}
	}
	
	// 导航菜单排序
	public function listorders() {
		$status = parent::_listorders($this->nav_model);
		if ($status) {
			$this->success("排序更新成功！");
		} else {
			$this->error("排序更新失败！");
		}
	}
	
	// 导航菜单删除
	public function delete() {
		$id = I("get.id",0,'intval');
		$count = $this->nav_model->where(array("parentid" => $id))->count();
		if ($count > 0) {
			$this->error("该菜单下还有子菜单，无法删除！");
		}
		
		if ($this->nav_model->delete($id)!==false) {
			$this->success("删除菜单成功！");
		} else {
			$this->error("删除失败！");
		}
	}
	
	/**
	 * 获取所有应用可用的导航菜单
	 */
	private function _select(){
		$apps=sp_scan_dir(SPAPP."*");
		$navs=array();
		foreach ($apps as $a){
		
			if(is_dir(SPAPP.$a)){
				if(!(strpos($a, ".") === 0)){
					$navfile=SPAPP.$a."/nav.php";
					$app=$a;
					if(file_exists($navfile)){
						$navgeturls=include $navfile;
						foreach ($navgeturls as $url){
							$nav = R("$app/$url");
							$navs[]=$nav;
						}
					}
				}
			}
		}
		return $navs;
	}

}