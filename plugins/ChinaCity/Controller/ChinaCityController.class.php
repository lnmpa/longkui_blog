<?php
// +----------------------------------------------------------------------
// | zzc
// +----------------------------------------------------------------------
// | 
// +----------------------------------------------------------------------
// | Author: zzc <352800686@qq.com> 
// +----------------------------------------------------------------------
// 

/**
 * 中国省市区三级联动插件
 * @author i友街
 */

namespace plugins\ChinaCity\Controller;
use Api\Controller\PluginController;
/*use Home\Controller\AddonsController;*/


class ChinaCityController extends PluginController{
	
	//获取中国省份信息
	public function getProvince(){
		if (IS_AJAX){
			$pid = I('pid');  //默认的省份id

			/*if( !empty($pid) ){
				$map['id'] = $pid;
			}*/
			$map['level'] = 1;
			$map['upid'] = 0;
			/*var_dump($map);exit;*/
			$plugin_demo_model=D("plugins://ChinaCity/PluginDistrict");
			$list = $plugin_demo_model->_list($map);

			$data = "<option value =''>-省份-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $pid == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$re['status'] = 1;
			$re['data'] = $data;
			$this->ajaxReturn($re);
		}
	}

	//获取城市信息
	public function getCity(){
		if (IS_AJAX){
			$cid = I('cid');  //默认的城市id
			$pid = I('pid');  //传过来的省份id

			/*if( !empty($cid) ){
				$map['id'] = $cid;
			}*/
			$map['level'] = 2;
			$map['upid'] = $pid;

			$list = D('plugins://ChinaCity/PluginDistrict')->_list($map);

			$data = "<option value =''>-城市-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $cid == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$re['status'] = 1;
			$re['data'] = $data;
			$this->ajaxReturn($re);
		}
	}

	//获取区县市信息
	public function getDistrict(){
		if (IS_AJAX){
			$did = I('did');  //默认的城市id
			$cid = I('cid');  //传过来的城市id

			/*if( !empty($did) ){
				$map['id'] = $did;
			}*/
			$map['level'] = 3;
			$map['upid'] = $cid;

			$list = D('plugins://ChinaCity/PluginDistrict')->_list($map);

			$data = "<option value =''>-区县-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $did == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$re['status'] = 1;
			$re['data'] = $data;
			$this->ajaxReturn($re);
		}
	}

	//获取乡镇信息
	public function getCommunity(){
		if (IS_AJAX){
			$coid = I('coid');  //默认的乡镇id
			$did = I('did');  //传过来的区县市id

			//$where['city_id'] = $cid;

			/*if( !empty($coid) ){
				$map['id'] = $coid;
			}*/
			$map['level'] = 4;
			$map['upid'] = $did;

			$list = D('plugins://ChinaCity/PluginDistrict')->_list($map);

			$data = "<option value =''>-乡镇-</option>";
			foreach ($list as $k => $vo) {
				$data .= "<option ";
				if( $coid == $vo['id'] ){
					$data .= " selected ";
				}
				$data .= " value ='" . $vo['id'] . "'>" . $vo['name'] . "</option>";
			}
			$re['status'] = 1;
			$re['data'] = $data;
			$this->ajaxReturn($re);
		}
	}
}