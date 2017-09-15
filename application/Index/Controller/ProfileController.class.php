<?php
namespace Index\Controller;

class ProfileController extends HomeController {
	
	function _initialize(){
		parent::_initialize();
		$this->check_login($this->ignore_arr);
	}
	
    // 编辑用户资料
	public function edit() {
		
		$this->assign($this->user);
		$this->menu_id = 1;
    	$this->display();
    }
    
    // 编辑用户资料提交
    public function edit_post() {
    	if(IS_POST){
    		$_POST['id']=$this->userid;
    		$email = I('user_email');
    		I('mobile')||$this->error('请填写手机号码!');
    		empty($email) && $this->error('请填写邮箱!');
    		$pattern = "/^([0-9A-Za-z\\-_\\.]+)@([0-9a-z]+\\.[a-z]{2,3}(\\.[a-z]{2})?)$/i";
    		preg_match($pattern, $email) || $this->error('格式不正确!');
    		$data = $this->users_model->field('id,user_nicename,sex,birthday,mobile,user_email,signature')->create();
    		if ($data!==false) {
				if ($this->users_model->save($data)!==false) {
					$this->user=$this->users_model->find($this->userid);
					sp_update_current_user($this->user);
					$this->success("保存成功！",U("Profile/edit"));
				} else {
					$this->error("保存失败！");
				}
			} else {
				$this->error($this->users_model->getError());
			}
    	}
    	
    }
    
    // 个人中心修改密码
    public function password() {
		$this->assign($this->user);
		$this->menu_id = 1;
    	$this->display();
    }
    
    // 个人中心修改密码提交
    public function password_post() {
    	if (IS_POST) {
    	    $old_password=I('post.old_password');
    		if(empty($old_password)){
    			$this->error("原始密码不能为空！");
    		}
    		
    		$password=I('post.password');
    		if(empty($password)){
    			$this->error("新密码不能为空！");
    		}
    		
    		$uid=sp_get_current_userid();
    		$admin=$this->users_model->where(array('id'=>$uid))->find();
    		if(sp_compare_password($old_password, $admin['user_pass'])){
    			if($password==I('post.repassword')){
    				if(sp_compare_password($password, $admin['user_pass'])){
    					$this->error("新密码不能和原始密码相同！");
    				}else{
    					$data['user_pass']=sp_password($password);
    					$data['id']=$uid;
    					$r=$this->users_model->save($data);
    					if ($r!==false) {
    						$this->success("修改成功！",U('password'));
    					} else {
    						$this->error("修改失败！");
    					}
    				}
    			}else{
    				$this->error("密码输入不一致！");
    			}
    	
    		}else{
    			$this->error("原始密码不正确！");
    		}
    	}
    	 
    }
    
    // 第三方账号绑定
    public function bang(){
    	$oauth_user_model=M("OauthUser");
    	$uid=sp_get_current_userid();
    	$oauths=$oauth_user_model->where(array("uid"=>$uid))->select();
    	$new_oauths=array();
    	foreach ($oauths as $oa){
    		$new_oauths[strtolower($oa['from'])]=$oa;
    	}
    	$this->assign("oauths",$new_oauths);
    	$this->display();
    }
    
    // 用户头像编辑
    public function avatar(){
		$this->assign($this->user);
		$this->menu_id = 1;
    	$this->display();
    }
    
    // 用户头像上传
    public function avatar_upload(){
    	$config=array(
    			'rootPath' => './'.C("UPLOADPATH"),
    			'savePath' => './avatar/',
    			'maxSize' => 512000,//500K
    			'saveName'   =>    array('uniqid',''),
    			'exts'       =>    array('jpg', 'png', 'jpeg'),
    			'autoSub'    =>    false,
    	);
    	$upload = new \Think\Upload($config,'Local');//先在本地裁剪
    	$info=$upload->upload();
    	//开始上传
    	if ($info) {
    	//上传成功
    	//写入附件数据库信息
    		$first=array_shift($info);
    		$file=$first['savename'];
    		session('avatar',$file);
    		$this->ajaxReturn(sp_ajax_return(array("file"=>$file),"上传成功！",1),"AJAX_UPLOAD");
    	} else {
    		//上传失败，返回错误
    		$this->ajaxReturn(sp_ajax_return(array(),$upload->getError(),0),"AJAX_UPLOAD");
    	}
    }
    
    // 用户头像裁剪
    public function avatar_update(){
        $session_avatar=session('avatar');
    	if(!empty($session_avatar)){
    		$targ_w = I('post.w',0,'intval');
    		$targ_h = I('post.h',0,'intval');
    		$x = I('post.x',0,'intval');
    		$y = I('post.y',0,'intval');
    		$jpeg_quality = 90;
    		
    		$avatar=$session_avatar;
    		$avatar_dir=C("UPLOADPATH")."avatar/";
    		
    		$avatar_path=$avatar_dir.$avatar;
    		
    		$image = new \Think\Image();
    		$image->open($avatar_path);
    		$image->crop($targ_w, $targ_h,$x,$y);
    		$image->save($avatar_path);
    		
    		$result=true;
    		
    		$file_upload_type=C('FILE_UPLOAD_TYPE');
    		if($file_upload_type=='Qiniu'){
    		    $upload = new \Think\Upload();
    		    $file=array('savepath'=>'','savename'=>'avatar/'.$avatar,'tmp_name'=>$avatar_path);
    		    $result=$upload->getUploader()->save($file);
    		}
    		if($result===true){
    		    $userid=sp_get_current_userid();
    		    $result=$this->users_model->where(array("id"=>$userid))->save(array("avatar"=>'avatar/'.$avatar));
    		    session('user.avatar','avatar/'.$avatar);
    		    if($result){
    		        $this->success("头像更新成功！");
    		    }else{
    		        $this->error("头像更新失败！");
    		    }
    		}else{
    		    $this->error("头像保存失败！");
    		}
    		
    	}
    }
    
    // 保存用户头像
    public function do_avatar() {
		$imgurl=I('post.imgurl');
		//去'/'
		$imgurl=str_replace('/','',$imgurl);
		$old_img=$this->user['avatar'];
		$this->user['avatar']=$imgurl;
		$res=$this->users_model->where(array("id"=>$this->userid))->save($this->user);		
		if($res){
			//更新session
			session('user',$this->user);
			//删除旧头像
			sp_delete_avatar($old_img);
		}else{
			$this->user['avatar']=$old_img;
			//删除新头像
			sp_delete_avatar($imgurl);
		}
		$this->ajaxReturn($res);
	}
	
	public function learnCenter(){
		$video_mod = D('video');
		$video_time_mod = D('video_time');
		$uid = sp_get_current_userid();
		
		$year_select = I('year_select');
		if(!$year_select){
			$year_select = date('Y',NOW_TIME);
		}
		$this->assign('year_select',$year_select);
		
		$year_start = $year_select."-01-01 00:00:00";
		$year_end = $year_select."-12-31 23:59:59";
		
		$count=$video_time_mod
		->where(array('uid'=>$uid,'t.add_time'=>array(array('egt',$year_start),array('elt',$year_end),'and')))
		->alias('as t')
		->join("join __VIDEO__ as vd on t.video_id = vd.id ")
		->count();
		
		$page = $this->page($count, 20);
		
		$learn_list = $video_time_mod
		->where(array('uid'=>$uid,'t.add_time'=>array(array('egt',$year_start),array('elt',$year_end),'and')))
		->alias('as t')
		->join("join __VIDEO__ as vd on t.video_id = vd.id ")
		->limit($page->firstRow , $page->listRows)
		->order("t.add_time desc")
		->select();
		foreach ($learn_list as $key=>$val){
			$learn_list[$key]['hisTime'] = $this->Sec2Time($val['time']);
		}
		
		$this->assign('learn_list',$learn_list);
		$this->assign("page", $page->show('default'));
		$this->display();
	}
	
	public function taxInquiry(){
		$tax_mod = M('Tax');
		$uid = sp_get_current_userid();
		$map = array();
		$map['status'] = array('eq',1);
		$map['user_id'] = array('eq',$uid);
		$year = date('Y',NOW_TIME);
		if(I('year')){
			$year = I('year');
		}
		$this->assign('year',$year);
		$map['year'] = $year;
		
		$user = M('Users')->where(array('id'=>$uid))->find();
		$user['org_name'] = M('Organization')->where(array('id'=>$user['org_id']))->getField('name');
		
		$count=$tax_mod->where($map)->count();
		$page = $this->page($count, 20);
		
		$list = $tax_mod->where($map)->limit($page->firstRow , $page->listRows)->select();
		foreach ($list as $key=>$val){
			$list[$key]['user'] = $user;
			$list[$key]['price'] = sprintf("%.2f", $val['price']);//交易金额
		}
		$this->assign('_list',$list);
		$this->assign("page", $page->show('default'));
		$this->display();
	}
	
	function activityCenter(){
		$ActivityLogMod = M('ActivityLog');
		$uid = sp_get_current_userid();
		if(IS_POST){
			$_POST['uid'] = $uid;
			$_POST['add_time'] = date('Y-m-d');
			$data = $ActivityLogMod->create();
			if(empty($data['title'])){
				$this->error('请填写活动标题！');
			}
			if(empty($data['date'])){
				$this->error('请填写活动日期！');
			}
			if(empty($data['content'])){
				$this->error('请填写活动内容！');
			}
			$re = $ActivityLogMod->add($data);
			if($re){
				$this->success('添加成功！',U('activityCenter'));
			}
			else{
				$this->error('添加失败！');
			}
		}
		$where['status'] = 1;
		$where['uid'] = $uid;
		
		$count=$ActivityLogMod
		->where($where)
		->count();
		
		$page = $this->page($count, 20);
		
		$list = $ActivityLogMod
		->where($where)
		->limit($page->firstRow , $page->listRows)
		->select();
		
		$this->assign('_list',$list);
		$this->assign("page", $page->show('default'));
		$this->display();
	}
	
	function Sec2Time($time){
		if(is_numeric($time)){
			$value = array(
					"hours" => 0,"minutes" => 0, "seconds" => 0,
			);
			if($time >= 3600){
				$value["hours"] = floor($time/3600);
				$time = ($time%3600);
			}
			if($time >= 60){
				$value["minutes"] = floor($time/60);
				$time = ($time%60);
			}
			$value["seconds"] = floor($time);
			$t=$value["hours"] ."小时". $value["minutes"] ."分".$value["seconds"]."秒";
			Return $t;
	
		}else{
			return (bool) FALSE;
		}
	}
	
}