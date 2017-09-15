<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model;
class AlbumModel extends Model {
	
	/**
	 *
	 * @param array $album = array('album_id'=>'','imgList'=>array(),......)
	 * @return boolean $return
	 */
	public function saveAlbum($album){
		$imgList = $album['imgList'];
		unset($album['imgList']);
		$album_id = $album['album_id'];
		if(empty($album_id)){
			$album_id = $this->add($album);
		}
		$ImagesMod = D('Images');
		if(empty($imgList)){
			$deleteIds = $ImagesMod->where(array('album_id'=>$album_id))->getField('id',true);
			$ImagesMod->deleteLocal($deleteIds);
		}
		else{
			$data['album_id'] = $album_id;
			$data['status'] = 1;
			$ImagesMod->where(array('id'=>array('in',$imgList)))->save($data);
			$deleteIds = $ImagesMod->where(array('id'=>array('not in',$imgList),'album_id'=>$album_id))->getField('id',true);
			$ImagesMod->deleteLocal($deleteIds);
		}
		return $album_id;
	}
	
	
	public function getAlbum($album_id = 0,$field = null,$where = array()){
		if(empty($album_id)){
			return false;
		}
		$where['album_id'] = $album_id;
		$ImagesMod = M('Images');
		$ImagesMod->where($where);
		if(!empty($field)){
			$ImagesMod->field($field);
		}
		return $ImagesMod->select();
	}
}