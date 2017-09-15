<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model\ViewModel;
class MallEnViewModel extends ViewModel {
	
	public $viewFields = array(
			'Mall'=>array(
				'id'=>'id',
				'add_time'=>'add_time',
				'sort_order'=>'sort_order',
				'is_hot'=>'is_hot',
				'is_best'=>'is_best',
				'is_top'=>'is_top',
				'is_new'=>'is_new',
				'status'=>'status',
				'hits'=>'hits',
				'img'=>'img',
				'bimg'=>'bimg',
				'model'=>'model',
				'price'=>'price',
				'cate_id'=>'cate_id',
				'file_id'=>'file_id',
				'_type'=>'LEFT'),
			'MallEn'=>array(
				'title'=>'title',
				'pretitle'=>'pretitle',
				'subtitle'=>'subtitle',
				'keywords'=>'keywords',
				'orig'=>'orig',
				'url'=>'url',
				'abst'=>'abst',
				'info'=>'info',
				'seo_title'=>'seo_title',
				'seo_keys'=>'seo_keys',
				'seo_desc'=>'seo_desc',
				'album'=>'album',
				'banner_img'=>'banner_img',
				'background'=>'background',
				'_on'=>'Mall.id=MallEn.id',
				'_type'=>'LEFT'),
			'MallCate'=>array(
				'name_en'=>'name',
				'parentspath'=>'parentspath',
				'_on'=>'Mall.cate_id=MallCate.id',
				'_type'=>'LEFT'),
	);
	
}