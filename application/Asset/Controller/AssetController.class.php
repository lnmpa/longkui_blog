<?php
namespace Asset\Controller;

use Common\Controller\AdminbaseController;
use Common\Model\ImagesModel;
use Common\Model\FileModel;

class AssetController extends AdminbaseController {

    function _initialize() {
    	$adminid=sp_get_current_admin_id();
    	$userid=sp_get_current_userid();
    	if(empty($adminid) && empty($userid)){
    		exit("非法上传！");
    	}
    }
    
    
    // 文件上传
    public function plupload(){
        $upload_setting=sp_get_upload_setting();
        
        $filetypes=array(
            'image'=>array('title'=>'Image files','extensions'=>$upload_setting['image']['extensions']),
            'video'=>array('title'=>'Video files','extensions'=>$upload_setting['video']['extensions']),
            'audio'=>array('title'=>'Audio files','extensions'=>$upload_setting['audio']['extensions']),
            'file'=>array('title'=>'Custom files','extensions'=>$upload_setting['file']['extensions'])
        );
        
        $image_extensions=explode(',', $upload_setting['image']['extensions']);
        
        if (IS_POST) {
        	
        	D('Common/Images')->deleteExprie();
            $all_allowed_exts=array();
            foreach ($filetypes as $mfiletype){
                array_push($all_allowed_exts, $mfiletype['extensions']);
            }
            $all_allowed_exts=implode(',', $all_allowed_exts);
            $all_allowed_exts=explode(',', $all_allowed_exts);
            $all_allowed_exts=array_unique($all_allowed_exts);
            
            $file_extension=sp_get_file_extension($_FILES['file']['name']);
            $upload_max_filesize=$upload_setting['upload_max_filesize'][$file_extension];
            $upload_max_filesize=empty($upload_max_filesize)?2097152:$upload_max_filesize;//默认2M
            
            $app=I('post.app/s','');
            if(!in_array($app, C('MODULE_ALLOW_LIST'))){
                $app='default';
            }else{
                $app= strtolower($app);
            }
            
			$savepath=$app.'/'.date('Ymd').'/';
            //上传处理类
            $config=array(
            		'rootPath' => './'.C("UPLOADPATH"),
            		'savePath' => $savepath,
            		'maxSize' => $upload_max_filesize,
            		'saveName'   =>    array('uniqid',''),
            		'exts'       =>    $all_allowed_exts,
            		'autoSub'    =>    false,
            );
			$upload = new \Think\Upload($config);// 
			$info=$upload->upload();
            //开始上传
            if ($info) {
                //上传成功
                $oriName = $_FILES['file']['name'];
                //写入附件数据库信息
                $first=array_shift($info);
                if(!empty($first['url'])){
                	$url=$first['url'];
                	$storage_setting=sp_get_cmf_settings('storage');
                	$qiniu_setting=$storage_setting['Qiniu']['setting'];
                	$url=preg_replace('/^https/', $qiniu_setting['protocol'], $url);
                	$url=preg_replace('/^http/', $qiniu_setting['protocol'], $url);
                	
                	$preview_url=$url;
                	
                	if(in_array($file_extension, $image_extensions)){
                	    if(C('FILE_UPLOAD_TYPE')=='Qiniu' && $qiniu_setting['enable_picture_protect']){
                	        $preview_url = $url.$qiniu_setting['style_separator'].$qiniu_setting['styles']['thumbnail300x300'];
                	        $url= $url.$qiniu_setting['style_separator'].$qiniu_setting['styles']['watermark'];
                	    }
                	}else{
                	    $preview_url='';
                	    $url=sp_get_file_download_url($first['savepath'].$first['savename'],3600*24*365*50);//过期时间设置为50年
                	}
                	
                }else{
                	$url=C("TMPL_PARSE_STRING.__UPLOAD__").$savepath.$first['savename'];
                	$preview_url=$url;
                }
                $filepath = $savepath.$first['savename'];
                
                $img_data['title'] = $oriName;
                $img_data['url'] = $filepath;
                $adminid=sp_get_current_admin_id();
                $img_data['uid'] = !empty($adminid)?$adminid:sp_get_current_userid();
                $img_data['ext'] = $first['ext'];
                $img_data['mime'] = $first['type'];
                $img_data['size'] = $first['size'];
                $img_data['add_time'] = date('Y-m-d H:i:s',time());
                $img_data['update_time'] = date('Y-m-d H:i:s',time());
                $img_data['status'] = 0;
                $images_mod = M('images');
                if($images_mod->create($img_data)){
                	$re = $images_mod->add();
                }
                else{
                	$this->ajaxReturn(array('name'=>'','status'=>0,'message'=>$images_mod->getError()));
                }
                
                if($re){
                	$return['id'] = $re;
                	$return['preview_url'] = $preview_url;
                	$return['filepath'] = $filepath;
                	$return['url'] = $url;
                	$return['name'] = $oriName;
                	$return['status'] = 1;
                	$return['message'] = 'success';
                	//$return['ext'] = $first['ext'];
                	//$return['size'] = $first['size'];
                	//$return['type'] = $first['type'];
                	//$return['icon'] = __ROOT__."/public/js/ueditor/dialogs/attachment/fileTypeImages/icon_".$first['ext'].".gif";
                	$this->ajaxReturn($return);
                }
                else{
                	$this->ajaxReturn(array('name'=>'','status'=>0,'message'=>"数据库插入失败"));
                }
                
                
				//$this->ajaxReturn(array('preview_url'=>$preview_url,'filepath'=>$filepath,'url'=>$url,'name'=>$oriName,'status'=>1,'message'=>'success'));
            } else {
                $this->ajaxReturn(array('name'=>'','status'=>0,'message'=>$upload->getError()));
            }
        } else {
            $filetype = I('get.filetype/s','image');
            $mime_type=array();
            if(array_key_exists($filetype, $filetypes)){
                $mime_type=$filetypes[$filetype];
            }else{
                $this->error('上传文件类型配置错误！');
            }
            
            $multi=I('get.multi',0,'intval');
            $app=I('get.app/s','');
            $upload_max_filesize=$upload_setting[$filetype]['upload_max_filesize'];
            $this->assign('extensions',$upload_setting[$filetype]['extensions']);
            $this->assign('upload_max_filesize',$upload_max_filesize);
            $this->assign('upload_max_filesize_mb',intval($upload_max_filesize/1024));
            $this->assign('mime_type',json_encode($mime_type));
            $this->assign('multi',$multi);
            $this->assign('app',$app);
            $this->display(':plupload');
        }
    }
    
    public function plupload_file(){
    	$upload_setting=sp_get_upload_setting();
    	
    	$filetypes=array(
    			'image'=>array('title'=>'Image files','extensions'=>$upload_setting['image']['extensions']),
    			'video'=>array('title'=>'Video files','extensions'=>$upload_setting['video']['extensions']),
    			'audio'=>array('title'=>'Audio files','extensions'=>$upload_setting['audio']['extensions']),
    			'file'=>array('title'=>'Custom files','extensions'=>$upload_setting['file']['extensions'])
    	);
    	
    	$image_extensions=explode(',', $upload_setting['image']['extensions']);
    	
    	if (IS_POST) {
    		D('Common/File')->deleteExprie();
    		
    		$all_allowed_exts=array();
    		foreach ($filetypes as $mfiletype){
    			array_push($all_allowed_exts, $mfiletype['extensions']);
    		}
    		$all_allowed_exts=implode(',', $all_allowed_exts);
    		$all_allowed_exts=explode(',', $all_allowed_exts);
    		$all_allowed_exts=array_unique($all_allowed_exts);
    	
    		$file_extension=sp_get_file_extension($_FILES['file']['name']);
    		$upload_max_filesize=$upload_setting['upload_max_filesize'][$file_extension];
    		$upload_max_filesize=empty($upload_max_filesize)?2097152:$upload_max_filesize;//默认2M
    	
    		$app=I('post.app/s','');
    		if(!in_array($app, C('MODULE_ALLOW_LIST'))){
    			$app='default';
    		}else{
    			$app= strtolower($app);
    		}
    	
    		$savepath=$app.'/'.date('Ymd').'/';
    		//上传处理类
    		$config=array(
    				'rootPath' => './'.C("UPLOADPATH"),
    				'savePath' => $savepath,
    				'maxSize' => $upload_max_filesize,
    				'saveName'   =>    array('uniqid',''),
    				'exts'       =>    $all_allowed_exts,
    				'autoSub'    =>    false,
    		);
    		$upload = new \Think\Upload($config);//
    		$info=$upload->upload();
    		//开始上传
    		if ($info) {
    			//上传成功
    			$oriName = $_FILES['file']['name'];
    			//写入附件数据库信息
    			$first=array_shift($info);
    			if(!empty($first['url'])){
    				$url=$first['url'];
    				$storage_setting=sp_get_cmf_settings('storage');
    				$qiniu_setting=$storage_setting['Qiniu']['setting'];
    				$url=preg_replace('/^https/', $qiniu_setting['protocol'], $url);
    				$url=preg_replace('/^http/', $qiniu_setting['protocol'], $url);
    				 
    				$preview_url=$url;
    				 
    				if(in_array($file_extension, $image_extensions)){
    					if(C('FILE_UPLOAD_TYPE')=='Qiniu' && $qiniu_setting['enable_picture_protect']){
    						$preview_url = $url.$qiniu_setting['style_separator'].$qiniu_setting['styles']['thumbnail300x300'];
    						$url= $url.$qiniu_setting['style_separator'].$qiniu_setting['styles']['watermark'];
    					}
    				}else{
    					$preview_url='';
    					$url=sp_get_file_download_url($first['savepath'].$first['savename'],3600*24*365*50);//过期时间设置为50年
    				}
    				 
    			}else{
    				$url=C("TMPL_PARSE_STRING.__UPLOAD__").$savepath.$first['savename'];
    				$preview_url=$url;
    			}
    			$filepath = $savepath.$first['savename'];
    			
    			$file_data['title'] = $oriName;
    			$file_data['url'] = $filepath;
    			$adminid=sp_get_current_admin_id();
    			$file_data['uid'] = !empty($adminid)?$adminid:sp_get_current_userid();
    			$file_data['ext'] = $first['ext'];
    			$file_data['mime'] = $first['type'];
    			$file_data['size'] = $first['size'];
    			$file_data['add_time'] = date('Y-m-d H:i:s',time());
    			$file_data['update_time'] = date('Y-m-d H:i:s',time());
    			$file_data['status'] = 0;
    			$file_mod = M('file');
    			if($file_mod->create($file_data)){
	    			$re = $file_mod->add($file_data);
    			}
    			else{
    				$this->ajaxReturn(array('name'=>'','status'=>0,'message'=>$file_mod->getError()));
    			}
    			
    			if($re){
    				$return['id'] = $re;
    				$return['preview_url'] = $preview_url;
    				$return['filepath'] = $filepath;
    				$return['url'] = U('Asset/Asset/downloadFile',array('id'=>$re));
    				$return['name'] = $oriName;
    				$return['status'] = 1;
    				$return['message'] = 'success';
    				$return['ext'] = $first['ext'];
    				$return['size'] = $first['size'];
    				$return['type'] = $first['type'];
    				$return['icon'] = sp_get_file_icon($first['ext']);
    				$this->ajaxReturn($return);
    			}
    			else{
    				$this->ajaxReturn(array('name'=>'','status'=>0,'message'=>"文件上传成功，但数据库插入失败"));
    			}
    		} else {
    			$this->ajaxReturn(array('name'=>'','status'=>0,'message'=>$upload->getError()));
    		}
        } else {
			$filetype = I ( 'get.filetype/s', 'image' );
			$mime_type = array ();
			if (array_key_exists ( $filetype, $filetypes )) {
				$mime_type = $filetypes [$filetype];
			} else {
				$this->error ( '上传文件类型配置错误！' );
			}
			
			$multi = I ( 'get.multi', 0, 'intval' );
			$app = I ( 'get.app/s', '' );
			$upload_max_filesize = $upload_setting [$filetype] ['upload_max_filesize'];
			$this->assign ( 'extensions', $upload_setting [$filetype] ['extensions'] );
			$this->assign ( 'upload_max_filesize', $upload_max_filesize );
			$this->assign ( 'upload_max_filesize_mb', intval ( $upload_max_filesize / 1024 ) );
			$this->assign ( 'mime_type', json_encode ( $mime_type ) );
			$this->assign ( 'multi', $multi );
			$this->assign ( 'app', $app );
			$this->display ( ':plupload_file' );
		}
    }
    
    public function downloadFile($id,$rootpath = null){
    	if(!$id){
    		$this->error('参数错误！');
    		return false;
    	}
    	if(!$rootpath){
    		$rootpath = "data/upload/";
    	}
    	$file = M('File')->find($id);
    	if(is_file($rootpath.$file['url'])){
    		/* 执行下载 */ //TODO: 大文件断点续传
    		header("Content-Description: File Transfer");
    		header('Content-type: ' . $file['mime']);
    		header('Content-Length:' . $file['size']);
    		if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
    			header('Content-Disposition: attachment; filename="' . rawurlencode($file['title']) . '"');
    		} else {
    			header('Content-Disposition: attachment; filename="' . $file['title'] . '"');
    		}
    		readfile($rootpath.$file['url']);
    		exit;
    	} else {
    		$this->error('文件已被删除！');
    		return false;
    	}
    }
	
    public function delete_file($id){
    	if(!$id){
    		$this->error('参数错误！');
    		return false;
    	}
    	$FileMod = new FileModel();
    	$re = $FileMod->deleteLocal($id);
    	if($re){
    		$this->success('删除成功！');
    	}
    	else{
    		$this->error('删除失败！');
    	}
    }
    
    public function change_image_label($id,$name){
    	if(!($id||$name)){
    		$this->error('参数错误！');
    	}
    	$ImagesMod = M('Images');
    	$re = $ImagesMod->where(array('id'=>$id))->setField('title',$name);
    	if($re){
    		$this->success('修改成功！','',true);
    	}
    	else{
    		$this->error('修改失败！','',true);
    	}
    }
    
    public function change_image_color($id,$bg_color){
    	if(!($id||$bg_color)){
    		$this->error('参数错误！');
    	}
    	$ImagesMod = M('Images');
    	$re = $ImagesMod->where(array('id'=>$id))->setField('bg_color',$bg_color);
    	if($re){
    		$this->success('修改成功！','',true);
    	}
    	else{
    		$this->error('修改失败！','',true);
    	}
    }
    
    public function change_image_sort($id,$sort){
    	if(!($id||$sort)){
    		$this->error('参数错误！');
    	}
    	$ImagesMod = M('Images');
    	$re = $ImagesMod->where(array('id'=>$id))->setField('sort',$sort);
    	if($re){
    		$this->success('修改成功！','',true);
    	}
    	else{
    		$this->error('修改失败！','',true);
    	}
    }
    
    public function delete_image($id){
    	if(!$id){
    		$this->error('参数错误！');
    		return false;
    	}
    	$ImagesMod = new ImagesModel();
    	$re = $ImagesMod->deleteLocal($id);
    	if($re){
    		$this->success('删除成功！');
    	}
    	else{
    		$this->error('删除失败！');
    	}
    }
}
