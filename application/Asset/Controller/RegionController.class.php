<?php
namespace Asset\Controller;

use Think\Controller;

class RegionController extends Controller {

    function _initialize() {
    	
    }
    
    function get_region($id= null,$model = null){
    	header("Content-type: text/html; charset=utf-8");
    	if(!$id){
    		$this->error("参数错误!");	
    	}
    	if(!$model){
    		$this->error("查询表不存在!");
    	}
    	$mod = D($model);
    	$list = $mod->where(array('pid'=>$id,'status'=>1))->select();
    	if($list){
    		$html = "";
    		$html .= "<tr>";
    		$html .= "<td>";
    		$html .= "<select name=\"path[]\" class=\"region_select\" style=\"width:400px;\">";
    		$html .= "<option value=\"0\">==请选择==</option>";
    		foreach ($list as $key=>$val){
    			$html .= "<option value=\"".$val['id']."\">".$val['name']."</option>";
    		}
    		$html .= "</select>";
    		$html .= "</td>";
    		$html .= "</tr>";
    		$this->success($html);
    	}
    	else{
    		$this->error("无下级组织!");
    	}
    }
}
