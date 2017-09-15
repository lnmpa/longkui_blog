<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model\ViewModel;
class ArticleEnViewModel extends ViewModel {
	
	public $viewFields = array(
			'Article'=>array(
				'id'=>'id',
				'add_time'=>'add_time',
				'sort_order'=>'sort_order',
				'is_hot'=>'is_hot',
				'is_best'=>'is_best',
				'is_top'=>'is_top',
				'status'=>'status',
				'hits'=>'hits',
				'img'=>'img',
				'bimg'=>'bimg',
				'cate_id'=>'cate_id',
				'file_id'=>'file_id',
				'_type'=>'LEFT'),
			'ArticleEn'=>array(
				'title'=>'title',
				'pretitle'=>'pretitle',
				'subtitle'=>'subtitle',
				'keywords'=>'keywords',
				'orig'=>'orig',
				'abst'=>'abst',
				'info'=>'info',
				'm_info'=>'m_info',
				'seo_title'=>'seo_title',
				'seo_keys'=>'seo_keys',
				'seo_desc'=>'seo_desc',
				'_on'=>'Article.id=ArticleEn.id',
				'_type'=>'LEFT'),
			'ArticleCate'=>array(
				'name_en'=>'name',
				'parentspath'=>'parentspath',
				'parentspath'=>'likes',
				'_on'=>'Article.cate_id=ArticleCate.id',
				'_type'=>'LEFT'),
	);
	
}