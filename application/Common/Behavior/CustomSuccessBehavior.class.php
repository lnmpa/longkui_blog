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
use Common\Model\AlbumModel;

// 初始化钩子信息
class CustomSuccessBehavior extends Behavior {
	
    // 行为扩展的执行入口必须是run
    public function run(&$data){
    	if(IS_POST){
    		$list = I('post.');
    		foreach ($list as $key=>$val){
    			if(strstr($key,'ImagesSet-')){
    				//$field = think_decrypt(str_replace('ImagesSet-','', $key));
    				$ImagesMod = M('Images');
    				$ImagesMod->where(array('id'=>$val))->setField('status',1);
    			}
    			if(strstr($key,'FilesSet-')){
    				//$field = think_decrypt(str_replace('FilesSet-','', $key));
    				$FilesMod = M('File');
    				$FilesMod->where(array('id'=>$val))->setField('status',1);
    			}
    			if(strstr($key,'AlbumSet-')){
    				$field = think_decrypt(str_replace('AlbumSet-','', $key));
    				$AlbumMod = new AlbumModel();
    				if(strstr($field,'[') && strstr($field,']')){
    					$strlen = strlen($field);  //全部字符长度
    					$tp = strpos($field,"[");  //limit之前的字符长度
    					$arr1 = substr($field,0,$tp);  //从头开始截取到指字符位置。
    					$arr2 = substr($field,$tp+1,$strlen-($tp+2));
    					$album_id = $_POST[$arr1][$arr2];
    				}
    				else{
    					$album_id = I($field);
    				}
    				$album = array();
    				if(!empty($album_id)){
    					$album['imgList'] = $val;
    					$album['name'] = CONTROLLER_NAME.'专辑';
    					$album['album_id'] = $album_id;
    					$AlbumMod->saveAlbum($album);
    				}
    			}
    		}
    	}
    }
}