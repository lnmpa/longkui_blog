<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model\ViewModel;
class UsersViewModel extends ViewModel {
	
	public $viewFields = array(
		'Users'=>array(
			'id'=>'id',
			'user_login'=>'user_login',
			'user_nicename'=>'user_nicename',
			'user_email'=>'user_email',
			'user_type'=>'user_type',
			'last_login_time'=>'last_login_time',
			'org_id'=>'org_id',
			'sex'=>'sex',
			'birthday'=>'birthday',
			'mobile'=>'mobile',
			'user_status'=>'user_status',
			'group_id'=>'group_id',
			'create_time'=>'create_time',
			'_type'=>'LEFT'),
		'UsersInfo'=>array(
			'idcard'=>'idcard',
			'address'=>'address',
			'nation'=>'nation',
			'origin'=>'origin',
			'join_time'=>'join_time',
			'become_time'=>'become_time',
			'work_address'=>'work_address',
			'record'=>'record',
			'remark'=>'remark',
			'address'=>'address',
			'address'=>'address',
			'_on'=>'Users.id=UsersInfo.id',
			'_type'=>'LEFT'),
		'Organization'=>array(
			'name'=>'user_org_name',
			'alias'=>'user_org_alias',
			'parents_path'=>'parents_path',
			'_on'=>'Users.org_id=Organization.id')
	);
}