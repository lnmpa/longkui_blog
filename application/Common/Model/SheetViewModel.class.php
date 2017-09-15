<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model\ViewModel;
class SheetViewModel extends ViewModel {
	
	public $viewFields = array(
			'Sheet'=>array(
				'id'=>'id',
				'title'=>'title',
				'add_time'=>'add_time',
				'sort_order'=>'sort_order',
				'status'=>'status',
				'_type'=>'LEFT'),
			'SheetCate'=>array(
				'name'=>'name',
				'parentspath'=>'likes',
				'alias'=>'alias',
				'_on'=>'Sheet.cate_id=SheetCate.id',
				'_type'=>'LEFT'),
	);
	
}