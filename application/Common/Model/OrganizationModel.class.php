<?php

/* * 
 * 菜单
 */
namespace Common\Model;
use Common\Model\CommonModel;
class OrganizationModel extends CommonModel {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
    	array('pid', 'require', '上级组织不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('name', 'require', '组织名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
    );
    //自动完成
    protected $_auto = array(
            //array(填充字段,填充内容,填充条件,附加规则)
    	array('update_time','update_time',3,'callback'),
    	array('status','1'),
    	array('parents_path','get_path',3,'callback'),
    );
	
    function update_time(){
    	return date('Y-m-d H:i:s',time());
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
    
    public function get_path(){
    	return $this->getPath($this->data['pid']);
    }
    
    protected $path_arr = array();
    public function getPath($pid){
    	if(empty($pid)){
    		$pid = 0;
    	}
    	$this->findPath($pid,0);
    	$this->path_arr[] = 0;
    	$path = implode(',', array_reverse($this->path_arr));
    	return $path;
    }
    public function findPath($pid = null){
    	if(!empty($pid)){
    		$this->path_arr[] = $pid;
    		$pid = $this->where(array('id'=>$pid))->getField('pid');
    		$this->findPath($pid);
    	}
    }
}