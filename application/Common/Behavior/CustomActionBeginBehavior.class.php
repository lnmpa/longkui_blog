<?php
// +---------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +---------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +---------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +---------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +---------------------------------------------------------------------
namespace Common\Behavior;
use Think\Behavior;

// 初始化钩子信息
class CustomActionBeginBehavior extends Behavior {
	
    // 行为扩展的执行入口必须是run
    public function run(&$data){
    	if(IS_POST){
    		$list = I('post.');
    		foreach ($list as $key=>$val){
	    		if(strstr($key,'AlbumSet-')){
		    		$field = think_decrypt(str_replace('AlbumSet-','', $key));
		    		if(strstr($field,'[') && strstr($field,']')){
		    			$strlen = strlen($field);  //全部字符长度
						$tp = strpos($field,"[");  //limit之前的字符长度
						$arr1 = substr($field,0,$tp);  //从头开始截取到指字符位置。
		    			$arr2 = substr($field,$tp+1,$strlen-($tp+2));
		    			$album_id = $_POST[$arr1][$arr2];
		    			$album = array();
		    			if(empty($album_id)){
		    				$album['name'] = CONTROLLER_NAME.'专辑';
		    				$album_id = M('Album')->add($album);
		    				$_POST[$arr1][$arr2] = $album_id;
		    			}
		    		}
		    		else{
		    			$album_id = I($field);
		    			$album = array();
		    			if(empty($album_id)){
		    				$album['name'] = CONTROLLER_NAME.'专辑';
		    				$album_id = M('Album')->add($album);
		    				$_POST[$field] = $album_id;
		    			}
		    		}
	    		}
	    		if(strstr($key,'CheckboxSet-')){
	    			$field = think_decrypt(str_replace('CheckboxSet-','', $key));
	    			if(strstr($field,'[') && strstr($field,']')){
	    				$strlen = strlen($field);  //全部字符长度
	    				$tp = strpos($field,"[");  //limit之前的字符长度
	    				$arr1 = substr($field,0,$tp);  //从头开始截取到指字符位置。
	    				$arr2 = substr($field,$tp+1,$strlen-($tp+2));
	    				$result = $_POST[$key];
	    				if(count($result) > 1){
	    					foreach ($result as $k=>$v){
	    						if($v==''){
	    							unset($result[$k]);
	    						}
	    					}
	    				}
	    				$_POST[$arr1][$arr2] = implode(',', $result);
	    			}
	    			else{
	    				$result = I($key);
	    				if(count($result) > 1){
	    					foreach ($result as $k=>$v){
	    						if($v==''){
	    							unset($result[$k]);
	    						}
	    					}
	    				}
	    				$_POST[$field] = implode(',', $result);
	    			}
	    		}
    		}
    	}
    }
}