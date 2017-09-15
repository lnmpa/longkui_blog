<?php
return array(
	/* 模板相关配置 */
    'TMPL_PARSE_STRING' => array(
    	'__WEB_ROOT__'=>__ROOT__,
    	'__UPLOAD__' => __ROOT__.'/data/upload/',
        '__STATICS__' => __ROOT__.'/statics/',
        '__IMG__'    => __TMPL__ . 'Index/Public/images',
        '__CSS__'    => __TMPL__ . 'Index/Public/css',
        '__JS__'     => __TMPL__ . 'Index/Public/js',
    ),
);