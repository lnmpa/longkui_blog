<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model\RelationModel;
class SheetModel extends RelationModel {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
    	array('cate_id', 'require', '请选择分类！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        //array('title', 'require', '标题不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
    );
    //自动完成
    protected $_auto = array(
            //array(填充字段,填充内容,填充条件,附加规则)
    	array('edit_time','edit_time',3,'callback'),
    	array('sort_order','sort_order',1,'callback'),
    	array('status','1',1),
    );
    
    function edit_time(){
    	return date('Y-m-d H:i:s',time());
    }
    
    function sort_order($sort){
    	if(empty($sort)){
    		$sort = $this->max('id');
    	}
    	return $sort+1;
    }
    
    protected function _after_find(&$result,$options){
    	parent::_after_find($result,$options);
    	if($result['album_id']){
    		$result['Photos'] = D('Common/Album')->getAlbum($result['album_id'],'id,title,url as img');
    	}
    	if($result['file_id']){
    		$result['File'] = M('File')->find($result['file_id']);
    	}
    	$this->data     =   $result;
    }
}