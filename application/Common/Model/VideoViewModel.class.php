<?php

/* * 
 * 资讯管理
 */
namespace Common\Model;
use Think\Model\ViewModel;
class VideoViewModel extends ViewModel {
	
	public $viewFields = array(
			'Video'=>array(
				'id'=>'id',
				'cate_id'=>'cate_id',
				'title'=>'title',
				'img'=>'img',
				'hits'=>'hits',
				'is_best'=>'is_best',
				'is_hot'=>'is_hot',
				'is_top'=>'is_top',
				'seo_title'=>'seo_title',
				'seo_keys'=>'seo_keys',
				'seo_desc'=>'seo_desc',
				'subject_cate'=>'subject_cate',
				'study_time'=>'study_time',
				'subject_info'=>'subject_info',
				'video'=>'video',
				'video_time'=>'video_time',
				'speaker'=>'speaker',
				'studyEndNum'=>'studyEndNum',
				'add_time'=>'add_time',
				'status'=>'status',
				'edit_time'=>'edit_time',
				'sort_order'=>'sort_order',
				'album'=>'album',
				'_type'=>'LEFT'),
			'VideoCate'=>array(
				'name'=>'name',
				'parentspath'=>'parentspath',
				'_on'=>'Video.cate_id=VideoCate.id',
				'_type'=>'LEFT'),
	);
}