<?php

namespace plugins\Goodattr\Controller;
use Api\Controller\PluginController;//插件控制器基类

class GoodattrController extends PluginController{
	
	public function proper(){
		$where['name'] =$_POST['value'];
		$proper = M('good_property_value')->where($where)->getField('id');
		if(!$proper){
			$proper = M('good_property_value')->add($where);
		}
		$data['id'] = $proper;
		$data['value'] =$_POST['value'];
		$this->ajaxReturn($data);
	}
	
	public function pro_add(){
		$where['name'] =$_POST['name'];
		$proper = M('good_property')->where($where)->getField('id');
		if(!$proper){
			$proper = M('good_property')->add($where);
		}
		$data['id'] = $proper;
		$data['name'] =$_POST['name'];
		$this->ajaxReturn($data);
	}
	
	public function ajax(){
		if($_POST['data']==''){
			echo '';
			die;
		}
		$array = explode(',',rtrim($_POST['data'],','));
		foreach($array as $k=> $v){
			$new_array = explode(':',$v);
			$shuxing[$new_array[0]][]=$new_array[1];
		}
		$string = '';
		$nums = 1;
		$head = "<tr>";
		foreach($shuxing as $k => $v){
				$nums*=count($v);
				$head .='<th>'.get_spe($k).'</th>';
		}
		$head .='<th>价格<input type="text" placeholder="设置所有价格" class="input-text set_price_value"></th>';
		$head .='<th>库存</th>';
		$head .='</tr>';
		$string .= $head;
		
		foreach($shuxing as $v){
				
				$a[]=$v;
		}
	
		foreach($a[0] as $v1){
				
				if($a[1]){
						foreach($a[1] as $v2){
							if($a[2]){
									foreach($a[2] as $v3){
										$print_id[]=$v1.'-'.$v2.'-'.$v3;
										
									}
							}else{
								$print_id[]=$v1.'-'.$v2;
							}
						}
				}else{
						$print_id[]=$v1;
				}
		}
		for($i=0;$i<$nums;$i++){
				$string .= '<tr>';
				$rowspan = $nums;
				foreach($shuxing as $k => $v){
					$rowspan = $rowspan/count($v);
					if($i==0||$i%$rowspan == 0){
						$value=$i/$rowspan%count($v);
					$string .= '<td rowspan='.$rowspan.'>'.get_spe_son($v[$value]).'</td>';
					}
				}
				$string .= "<td><input class='specifications_price input-text' id='".$print_id[$i]."' type='text'></td>";
				$string .= "<td><input class='specifications_kucun input-text'  id='".$print_id[$i]."'   type='text'></td>";
			}
		echo $string;
	}
	
	public  function save_attr(){
		I('price')||die;
		I('attr_id')||die;
		$attr_id = I('attr_id');
		M('good_sku')->where(array('attr_id'=>$attr_id))->delete();
		M('good_attr')->where(array('attr_id'=>$attr_id))->delete();
		//$attr_id = time().sp_get_current_userid();
		
		$price = explode(',',rtrim(I('price'),','));
		$attr = explode(',',rtrim(I('string'),','));
		
		try{
			foreach($attr as $v){
				$a = explode(':',$v);
				$data_attr['attr_id'] = $attr_id;
				$data_attr['property'] = $a[0];
				$data_attr['property_value'] = $a[1];
				M('good_attr')->add($data_attr);
			}
			foreach($price as $v){
				$a = explode('-',$v);
				$data['attr_id'] = $attr_id;
				$data['properies'] = $a[0];
				$data['price'] = $a[1];
				$data['sku'] = $a[2];
				M('good_sku')->add($data);
			}
		}catch (\Exception $e){
			$this->error($e->getMessage());
		}
		$this->success('保存成功!');
		//echo $attr_id;
	}
	
}
