<?php 
class AuthExtend{

    //默认配置
    protected $_config = array(
        'AUTH_ON' => true, //认证开关
        'AUTH_TYPE' => 1, // 认证方式，1为时时认证；2为登录认证。
        'AUTH_GROUP' => 'think_auth_group', //用户组数据表名
        'AUTH_GROUP_ACCESS' => 'think_auth_group_access', //用户组明细表
        'AUTH_RULE' => 'think_auth_rule', //权限规则表
        'AUTH_USER' => 'think_members'//用户信息表
    );

    public function __construct() {
        if (C('AUTH_CONFIG')) {
            //可设置配置项 AUTH_CONFIG, 此配置项为数组。
            $this->_config = array_merge($this->_config, C('AUTH_CONFIG'));
        }        
    }

    public function getGroups($uid) {
    	static $groups = array();
    	if (isset($groups[$uid]))
    		return $groups[$uid];
    	$user_groups = M()->table($this->_config['AUTH_GROUP_ACCESS'] . ' a')->where("a.uid='$uid' and g.status='1'")->join($this->_config['AUTH_GROUP']." g on a.group_id=g.id")->select();
    	$groups[$uid]=$user_groups?$user_groups:array();
    	return $groups[$uid];
    }
    //获得权限列表
    public function getAuthExtendList($uid) {
    
    	static $_AuthExtendList = array();
    
    	if (isset($_AuthExtendList[$uid])) {
    		return $_AuthExtendList[$uid];
    	}
    
    	if(isset($_SESSION['_AUTH_EXTEND_LIST_'.$uid])){
    		return $_SESSION['_AUTH_EXTEND_LIST_'.$uid];
    	}
    	//读取用户所属用户组
    	$groups = $this->getGroups($uid);
    	$ids = array();
    	foreach ($groups as $g) {
    		$ids[] =  $g['group_id'];
    	}
    	$ids = array_unique($ids);
    
    	if (empty($ids)) {
    		$_AuthExtendList[$uid] = array();
    		return array();
    	}
    	//读取用户组所有权限规则
    	$map=array(
    			'group_id'=>array('in',$ids)
    	);
    	$extends = M()->table($this->_config['AUTH_EXTEND'])->where($map)->select();
    
    	//循环规则，判断结果。
    	$AuthExtendList = array();
    	foreach ($extends as $r) {
    		//生成数组
    		$AuthExtendList[$r['table_name']][] = $r['extend_id'];    
    	}
    
    	foreach ($AuthExtendList as $key =>$val) {
    		//提取主key
    		$table_name[]=$key;
    	}
    	foreach ($table_name as $key =>$val) {
    		//排重
    		$AuthExtendList[$val] = array_unique($AuthExtendList[$val]);
    	}
    	//获得了所有用户组的栏目权限，现在要获得扩展权限，明天再做。
    	foreach ($table_name as $key =>$val) {
    		//循环表，得到单表
    		$parentspath=array();
    		foreach ($AuthExtendList[$val] as $key2 =>$val2) {
    			//循环单表，得到id  $AuthExtendList[aritcle_cate]
    			$parentspath[]= '%,'.$val2.',%';
    		}
    		$map2['parentspath'] =array('like',$parentspath,'OR');
    		$inherit = M($val)->field('id')->where($map2)->select();
    		$AuthExtendList[$val.'_self']=$AuthExtendList[$val];
    		foreach($inherit as $key3 =>$val3)
    		{
    			$AuthExtendList[$val][]=$val3['id'];
    		}
    	}
    
    	$_AuthExtendList[$uid] = $AuthExtendList;
    	if($this->_config['AUTH_TYPE']==2){
    		//session结果
    		$_SESSION['_AUTH_EXTEND_LIST_'.$uid]=$AuthExtendList;
    	}    
    	return $_AuthExtendList[$uid];
    }
    
    public function check($ids, $uid, $table_name,$relation='or')
     { 
    	if (!$this->_config['AUTH_ON'])
    	{return true;}
    	if (!isset($table_name) || empty($table_name))
    	{return false;}
    	$authExtendList = $this->getAuthExtendList($uid);    
    	if(!is_array($authExtendList[$table_name]))
    	{return false;}
    	$authExtendListFull=$authExtendList[$table_name];
    	$authExtendListSelf=$authExtendList[$table_name.'_self'];   
    	//输入的ids变成数组
    	//print_r($authExtendListFull);
    
    	if (!is_array($ids)) {
    		if (strpos($ids, ',') !== false) {
    			$ids = explode(',', $ids);
    		} else {
    			$ids=array(0=>$ids);;
    		}    
    	}    
    	$list = array(); //有权限的name
    	foreach ($authExtendListFull as $val) {
    		if (in_array($val, $ids))
    			$list[] = $val;
    	}    
    	if ($relation=='or' and !empty($list)) {
    		return true;
    	}    	
    	$diff = array_diff($ids, $list);
    	if ($relation=='and' and empty($diff)) {
    		return true;
    	}
    	return false;
    }    
}
