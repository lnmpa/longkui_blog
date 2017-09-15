<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Common\Model;
use Think\Model;

/**
 * 图片模型
 * 负责图片的管理
 */

class ImagesModel extends Model{
    
	public function deleteLocal($ids){
		if(empty($ids)){
			return false;
		}
		if(!is_array($ids)){
			$ids = array($ids);
		}
		foreach ($ids as $id){
			$url = $this->where(array('id'=>$id))->getField('url');
			$file = sp_get_file_link($url);
			if(file_exists($file)){
				$return = unlink($file);
				if($return){
					$this->delete($id);
				}
			}
			else{
				$this->delete($id);
			}
		}
		return true;
	}
	
	public function deleteExprie(){
		$exprie_time = date('Y-m-d H:i:s',time()-3600);
		$deleteIds2 = $this->where(array('add_time'=>array('lt',$exprie_time),'status'=>0))->getField('id',true);
		$this->deleteLocal($deleteIds2);
	}
	
}
