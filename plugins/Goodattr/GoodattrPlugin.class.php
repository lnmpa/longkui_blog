<?php

namespace plugins\Goodattr;

use Common\Lib\Plugin;

/**
 * 商品属性插件
 * 
 * @author 尤金251
 */
class GoodattrPlugin extends Plugin {
	public $info = array (
			'name' => 'Goodattr',
			'title' => '商品属性',
			'description' => '商品属性',
			'status' => 1,
			'author' => '尤金251',
			'version' => '0.1' 
	);
	public $admin_list = array (
			'model' => 'Attr', // 要查的表
			'fields' => '*', // 要查的字段
			'map' => '', // 查询条件, 如果需要可以再插件类的构造方法里动态重置这个属性
			'order' => 'id desc', // 排序,
			'list_grid' => array ( // 这里定义的是除了id序号外的表格里字段显示的表头名和模型一样支持函数和链接
					'cover_id|preview_pic:封面',
					'title:书名',
					'description:描述',
					'link_id|get_link:外链',
					'update_time|time_format:更新时间',
					'id:操作:[EDIT]|编辑,[DELETE]|删除' 
			) 
	);
	public function install() {
		return true;
	}
	public function uninstall() {
		return true;
	}
	
	// 实现的Goodattr钩子方法
	public function Goodattr($param) {
		$property = M ( 'good_property' )->select ();
		$this->assign ( 'property', $property );
		$this->assign ( 'name', $param ['name'] );
		if ($param ['value'] != 0) {
			$a = M('GoodAttr')->where (array('attr_id' =>$param ['value']))->order ('id')->select ();
			foreach ( $a as $v ) {
				$proper [$v ['property']] [] = $v ['property_value'];
			}
			$a = M('good_sku')->where(array('attr_id'=>$param['value']))->select();
			
			foreach ( $a as $v ) {
				$proper_value_price [$v ['properies']] = $v ['price'];
				$proper_value_sku [$v ['properies']] = $v ['sku'];
			}
			$proper_value_price = json_encode ( $proper_value_price );
			$proper_value_sku = json_encode ( $proper_value_sku );
			$this->assign ( 'proper_value_price', $proper_value_price );
			$this->assign ( 'proper_value_sku', $proper_value_sku );
			$this->assign ( 'proper', $proper );
		}
		
		$this->assign ( 'value', $param ['value'] );
		$this->display ( 'attr' );
	}
}