<?php

/* * 
 * 菜单
 */
namespace Common\Model;
use Think\Model;
class CategoryModel extends Model {

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

    function update_time(){
    	return date('Y-m-d H:i:s',time());
    }

    function get_path($pid){
    	$path = $this->where(array('id'=>$pid))->getField('parentspath');
    	$parentid = $this->where(array('id'=>$pid))->getField('kid');
    	if(!$pid){
    		$path = "0,";
    	}
    	else{
    		$path .= $parentid.",";
    	}
    	return $path;
    }
    
    protected $child_arr = array();
    protected function findChildArr($id){
    	$this->child_arr[] = $id;
    	$list = $this->where(array('pid'=>$id))->field('id')->select();
    	if(!empty($list)){
    		foreach ($list as $key=>$val){
    			$this->findChildArr($val['id']);
    		}
    	}
    }
    
    public function getFullChilds($id){
    	$this->findChildArr($id);
    	return $this->child_arr;
    }
    
    public function getCateArrBySign($sign = null,$field = null){
    	if(empty($sign)){
    		return false;
    	}
    	$type_id = M('CategoryType')->where(array('label'=>$sign))->order('id asc')->getField('id');
    	
    	if(empty($type_id)){
    		return false;
    	}
    	$this
    	->order(array("sort_order" => "ASC",'kid'=>'asc'))
    	->where(array('status'=>1,'type_id'=>$type_id));
    	if(!empty($field)){
    		$this->field($field);
    	}
    	$result = $this->select();
    	
    	$tree = new \Tree();
    	$tree->icon = array('│ ', '├─ ', '└─ ');
    	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
    	foreach ($result as $r) {
    		$r['id'] = $r['kid'];
    		$r['parentid'] = $r['pid'];
    		$r['parentid_node'] = ($r['parentid']) ? ' class="child-of-node-' . $r['parentid'] . '"' : '';
    		$array[] = $r;
    	}
    	$tree->init($array);
    	$taxonomys = $tree->get_tree_array(0);
    	
    	return $taxonomys;
    }
    
    public function getCateBySign($sign = null,$pid = null){
    	if(empty($sign)){
    		return false;
    	}
    	$type_id = M('CategoryType')->where(array('label'=>$sign))->order('id asc')->getField('id');
    	
    	if(empty($type_id)){
    		return false;
    	}
    	$result = $this
    	->order(array("sort_order" => "ASC"))
    	->where(array('status'=>1,'type_id'=>$type_id))
    	->select();
    	
    	$tree = new \Tree();
    	$tree->icon = array('│ ', '├─ ', '└─ ');
    	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
    	foreach ($result as $r) {
    		$r['id'] = $r['kid'];
    		$r['selected'] = $r['id'] == $pid ? 'selected' : '';
    		$r['parentid'] = $r['pid'];
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$select_categorys = $tree->get_tree(0, $str);
    	return $select_categorys;
    }
    
    public function getCateByTypeId($type_id = null,$pid = null){
    	if(empty($type_id)){
    		return false;
    	}
    	
    	$result = $this
    	->order(array("sort_order" => "ASC"))
    	->where(array('status'=>1,'type_id'=>$type_id))
    	->select();
    	 
    	$tree = new \Tree();
    	$tree->icon = array('│ ', '├─ ', '└─ ');
    	$tree->nbsp = '&nbsp;&nbsp;&nbsp;';
    	foreach ($result as $r) {
    		$r['id'] = $r['kid'];
    		$r['selected'] = $r['id'] == $pid ? 'selected' : '';
    		$r['parentid'] = $r['pid'];
    		$array[] = $r;
    	}
    	$str = "<option value='\$id' \$selected>\$spacer \$name</option>";
    	$tree->init($array);
    	$select_categorys = $tree->get_tree(0, $str);
    	return $select_categorys;
    }
    
    public function getCateNameBySignAndId($id,$sign){
    	if(empty($sign)){
    		return false;
    	}
    	$type_id = M('CategoryType')->where(array('label'=>$sign))->order('id asc')->getField('id');
    	if(empty($type_id)){
    		return false;
    	}
    	$name = $this->where(array('type_id'=>$type_id,'kid'=>$id))->getField('name');
    	return $name;
    }
    
    public function getIdBySignAndName($sign=null,$name){
    	if(empty($sign)){
    		return false;
    	}
    	$type_id = M('CategoryType')->where(array('label'=>$sign))->order('id asc')->getField('id');
    	if(empty($type_id)){
    		return false;
    	}
    	$id = $this->where(array('type_id'=>$type_id,'name'=>$name))->getField('id');
    	return $id;
    }
    
}