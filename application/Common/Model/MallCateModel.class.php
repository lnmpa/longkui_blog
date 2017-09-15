<?php

/* * 
 * 菜单
 */
namespace Common\Model;
use Think\Model;
class MallCateModel extends Model {
	
    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '分类名称不能为空！', 1, 'regex', self:: MODEL_BOTH ),
    );
    //自动完成
    protected $_auto = array(
            //array(填充字段,填充内容,填充条件,附加规则)
    	array('add_time','update_time',1,'callback'),
    	array('update_time','update_time',3,'callback'),
    	array('parentspath','get_path',3,'callback'),
    );
	
    public function setLang($lang){
    	switch ($lang){
    		case 'en-us':
    			$this->_map = array('items_name' =>'name_en','items_abst'  =>'abst_en',);
    			break;
    		default:
    			$this->_map = array('items_name' =>'name','items_abst'  =>'abst',);
    	}
    }
    
    function update_time(){
    	return date('Y-m-d H:i:s',time());
    }

    function get_path($pid){
    	$path = $this->where(array('id'=>$pid))->getField('parentspath');
    	if(!$pid){
    		$path = "0,";
    	}
    	else{
    		$path .= $pid.",";
    	}
    	return $path;
    }
    
    protected $del_arr = array();
    
    public function getDelArr(){
    	return $this->del_arr;
    }
    
    public function findChildIds($id){
    	$this->del_arr[] = $id;
    	$list = $this->where(array('pid'=>$id))->field('id')->select();
    	if($list){
    		foreach ($list as $key=>$val){
    			$this->findChildIds($val['id']);
    		}
    	}
    }
}