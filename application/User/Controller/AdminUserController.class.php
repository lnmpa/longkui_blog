<?php
namespace User\Controller;

use Common\Controller\AdminbaseController;

class AdminUserController extends AdminbaseController {
    
	protected $UsersModel;
	protected $UsersViewModel;
	protected $OrganizationModel;
	
	public function _initialize() {
		parent::_initialize();
		$this->UsersModel = D("Common/Users");
		$this->UsersViewModel = D("Common/UsersView");
		$this->OrganizationModel = D("Common/Organization");
	}
	
	private function main(){
		
		$this->display();
	}
	
	private function cate(){
		
		$this->display();
	}
	
	private function ajaxGetOrgMenu(){
		$pid = "10001";
		if(array_key_exists( 'id',$_REQUEST)) {
			$pid=$_REQUEST['id'];
		}
		$list = $this->OrganizationModel->where(array('status'=>array('egt',1),'pid'=>$pid))->field('id,name,alias,sort')->order('sort asc')->select();
		foreach ($list as $key=>$val){
			$val['name'] = $val['alias']? $val['alias']:$val['name'];
			$count = $this->OrganizationModel->where(array('status'=>array('egt',1),'pid'=>$val['id']))->count();
			$isParent = $count?'true':'false';
			$html[$key] .= "{ id:'".$val['id']."',";
			$html[$key] .= "name:'".$val['name']."',";
			$html[$key] .= "url:'".U('User/AdminUser/index',array('org_id'=>$val['id']))."',";
			$html[$key] .= "isParent:".$isParent.",";
			$html[$key] .= "target:'".CONTROLLER_NAME."_iframe_content',";
			$html[$key] .= "}";
		}
		$html = implode(',', $html);
		echo "[".$html."]";
	}
	
    // 后台本站用户列表
    public function index(){
        $where=array();
        $request=I('request.');
        
        $where['user_status'] = array('egt',0);
        $where['user_type'] = 2;
        $user_login = I('idcard');
        if($user_login){
        	$where['user_login'] = array('like','%'.$user_login.'%');
        	$this->assign('idcard',$user_login);
        }
        $user_nicename = I('name');
        if($user_nicename){
        	$where['user_nicename'] = array('like','%'.$user_nicename.'%');
        	$this->assign('name',$user_nicename);
        }
        /*if(!empty($request['keyword'])){
            $keyword=$request['keyword'];
            $keyword_complex=array();
            $keyword_complex['user_login']  = array('like', "%$keyword%");
            $keyword_complex['user_nicename']  = array('like',"%$keyword%");
            $keyword_complex['user_email']  = array('like',"%$keyword%");
            $keyword_complex['_logic'] = 'or';
            $where['_complex'] = $keyword_complex;
        }*/
        $org_id = I('org_id');
        if($org_id){
        	$org_map['parents_path'] = array('like','%'.$org_id.'%');
        	$org_map['org_id'] = $org_id;
        	$org_map['_logic'] = 'or';
        	$where['_complex'] = $org_map;
        	$this->assign('org_id',$org_id);
        }
        
    	$count=$this->UsersViewModel->where($where)->count();
    	$page = $this->page($count, 20);
    	
    	$list = $this->UsersViewModel
    	->where($where)
    	->order("create_time DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	
    	foreach ($list as $key=>$val){
    		$list[$key]['user_status'] = $val['user_status'] ? 'fa-check' : 'fa-close';
    	}
    	
    	$this->assign('list', $list);
    	$this->assign("page", $page->show('Admin'));
    	
    	$this->display("index");
    }
    
    public function tax_list(){
    	$where=array();
    	
    	$where['user_status'] = array('egt',0);
    	$where['user_type'] = 2;
    	$user_login = I('idcard');
    	if($user_login){
    		$where['user_login'] = array('like','%'.$user_login.'%');
    		$this->assign('idcard',$user_login);
    	}
    	
    	$user_nicename = I('name');
    	if($user_nicename){
    		$where['user_nicename'] = array('like','%'.$user_nicename.'%');
    		$this->assign('name',$user_nicename);
    	}
    	
    	$count=$this->UsersViewModel->where($where)->count();
    	$page = $this->page($count, 20);
    	
    	$list = $this->UsersViewModel
    	->where($where)
    	->order("create_time DESC")
    	->limit($page->firstRow . ',' . $page->listRows)
    	->select();
    	
    	$taxMod = M('Tax');
    	$year = I('year',date('Y'));
    	$this->assign('year',$year);
    	
    	foreach ($list as $key=>$val){
    		$list[$key]['user_status'] = $val['user_status'] ? 'fa-check' : 'fa-close';
    		$tax = $taxMod->where(array('status'=>1,'year'=>$year))->select();
    		foreach ($tax as $k=>$v){
    			$list[$key]['tax'][$v['month']] += $v['price'];
    			$list[$key]['tax_count'] += $v['price'];
    		}
    	}
    	 
    	$this->assign('list', $list);
    	$this->assign("page", $page->show('Admin'));
    	
    	$this->display();
    }
    
    public function tax_show(){
    	$tax_mod = M('Tax');
    	$uid = I('uid');
    	if(!$uid){
    		$this->error('参数错误');
    	}
    	$this->assign('uid',$uid);
    	$map = array();
    	$map['status'] = array('eq',1);
    	$map['user_id'] = array('eq',$uid);
    	$year = I('year',date('Y'));
    	$this->assign('year',$year);
    	$map['year'] = $year;
    	
    	$user = M('Users')->where(array('id'=>$uid))->find();
    	
    	$count=$tax_mod->where($map)->count();
    	$page = $this->page($count, 20);
    	
    	$list = $tax_mod->where($map)->limit($page->firstRow , $page->listRows)->select();
    	foreach ($list as $key=>$val){
    		$list[$key]['user'] = $user;
    		$list[$key]['price'] = sprintf("%.2f", $val['price']);//交易金额
    	}
    	$this->assign('_list',$list);
    	$this->assign("page", $page->show('Admin'));
    	$this->display();
    }
    
    public function add(){
    	if(IS_POST){
    		
    		//$password=I('post.password');
    		$password= '111111';
    		$_POST['user_pass'] = sp_password($password);
    		$_POST['create_time'] = date("Y-m-d H:i:s",time());
    		$_POST['user_status'] = 0;
    		$_POST['user_type'] = 2;//会员
    		$data = $this->UsersModel->create();
    		
    		if($data===false){
    			$this->error($this->UsersModel->getError());
    		}
    		$data_info = M('UsersInfo')->create();
    		$data['UsersInfo'] = $data_info;
    		$re = $this->UsersModel->relation(true)->add($data);
    		if($re){
    			$this->success("新增成功！");
    		}
    		else{
    			$this->error("新增失败！");
    		}
    	}
    	else {
	    	/*$org_id = I("org_id","","intval");
			$parents_path = $this->OrganizationModel->getPath($org_id);
			$path = explode(',', $parents_path);
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
    		
    		$org_list = $this->OrganizationModel->where(array('status'=>1))->select();
    		$this->assign('org_list',$org_list);
    		
    		$this->meta_title = "新增";
    		$this->display('edit');
    	}
    }
    
    public function edit(){
    	if(IS_POST){
    		$data = $this->UsersModel->create();
    		
    		if($data===false){
    			$this->error($this->UsersModel->getError());
    		}
    		$data_info = M('UsersInfo')->create();
    		$data['UsersInfo'] = $data_info;
    		//$this->error($data);
    		$re = $this->UsersModel->relation(true)->save($data);
    		if($re){
    			$this->success("修改成功！");
    		}
    		else{
    			$this->error("修改失败！");
    		}
    	}
    	else {
    		$id = I('id');
    		
    		$data = $this->UsersViewModel->find($id);
    		$this->assign('data',$data);
    		
    		$org_list = $this->OrganizationModel->where(array('status'=>1))->select();
    		$this->assign('org_list',$org_list);
    		/*$path = explode(',', $data['parents_path'].','.$data['org_id']);
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
    		
    		$this->meta_title = "修改";
    		$this->display();
    	}
    }
    
    public function status(){
    	$value = I('request.value','','intval');
    	$ids = I('request.ids');
    	$type = I('request.type');
    	if(!$ids){
    		$this->error("请至少选择一项！");
    	}
    	$re = $this->UsersModel->where(array('id'=>array('in',$ids)))->setField($type,$value);
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
    	$re = $this->UsersModel->relation(true)->where(array('id'=>array('in',$ids)))->delete();
    	if($re){
    		$this->success('删除成功!');
    	}
    	else{
    		$this->error("删除失败!");
    	}
    }
}
