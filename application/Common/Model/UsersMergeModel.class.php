<?php
namespace Common\Model;
use Think\Model\MergeModel;
class UsersMergeModel extends MergeModel
{
	
	protected $modelList = array('Users','UsersInfo');
	protected $fk = 'id';
	protected $mapFields    =   array(
			'id' => 'Users.id');
	
}