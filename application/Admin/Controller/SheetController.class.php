<?php
/**
 * SheetCate文章分类管理
 */
namespace Admin\Controller;

use Common\Controller\AdminbaseController;
use Common\Model\AlbumModel;
use Common\Api\ExcelApi;
use Common\Model\FileModel;

class SheetController extends AdminbaseController {
	
	protected $cate_id;
    //protected $SheetModel;
    protected $SheetTableMod;
    protected $SheetViewModel;
    protected $SheetCateMod;
    protected $SheetAttrMod;
    protected $AlbumMod;
	
    public $type_arr = array(
    		'text'=>array('title'=>'文本','type'=>'varchar'),
    		'textarea'=>array('title'=>'大文本','type'=>'text'),
    		'num'=>array('title'=>'数字','type'=>'int'),
    		'date'=>array('title'=>'日期','type'=>'date'),
    		'time'=>array('title'=>'时间','type'=>'datetime'),
    		'img'=>array('title'=>'图片','type'=>'int'),
    		'file'=>array('title'=>'附件','type'=>'int'),
    );
    
    public function _initialize() {
        parent::_initialize();
        
        //$this->SheetModel = D("Common/Sheet");
        $this->SheetViewModel = D("Common/SheetView");
        $this->SheetCateMod = D("Common/SheetCate");
        $this->SheetAttrMod = D("Common/SheetAttr");
        $this->AlbumMod = new AlbumModel();
        
        $this->cate_id = I('request.cate_id',0,'intval');
        $this->assign('cate_id',$this->cate_id);
        if($this->cate_id){
        	$table_name = "SheetTable".$this->cate_id;
        	$common_mod = sp_model('SheetCate');
        	$attr_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
        	try {
        		if($common_mod->table_exists($table_name)){
        			$this->SheetTableMod = sp_model($table_name);
        		}
        		else{
        			$common_mod->create_table($table_name);
        			$mod = sp_model($table_name);
        			$attr_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
        			foreach ($attr_list as $key=>$val){
        				$mod->alert_field($table_name,$val['name'],"",$this->type_arr[$val['attr_type']]['type']);
        			}
        			$this->SheetTableMod = sp_model($table_name);
        		}
        	} catch (\Exception $e) {
        		$this->error($e->getMessage());
        	}
        }
    }
    
    // 后台菜单列表
    public function index() {
    	if(!$this->cate_id){
    		
    		exit();
    	}
    	$field_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
    	$this->assign('field_list',$field_list);
    	$col_arr = array();
    	$col_arr[] = "{ label: 'ID', name: 'id', key: true, width: 50}";
    	foreach ($field_list as $key=>$val){
    		$col_arr[] = "{ label: '".$val['title']."', name: '".$val['name']."', width: 150}";
    	}
    	$col_model = implode(',', $col_arr);
    	$this->assign('col_model',$col_model);
    	
    	$searchField = I('request.searchField');
    	$this->assign('searchField',$searchField);
    	$searchOper = I('request.searchOper');
    	$this->assign('searchOper',$searchOper);
    	$searchString = I('request.searchString');
    	$this->assign('searchString',$searchString);
    	
    	if(IS_AJAX){
    		$page = I('request.page','1');
    		$_GET['p'] = $page;
    		$limit = I('request.rows','10');
    		$sidx = I('request.sidx','id');
    		if(!$sidx) $sidx = 'id';
    		$sord = I('request.sord','desc');
    		
    		if($searchField&&$searchOper&&$searchString){
    			switch ($searchOper) {
    				case 'cn':
    					$where[$searchField]=array('like',"%$searchString%");
						break;
    				case 'nc':
    					$where[$searchField]=array('exp',"not like '%".$searchString."%'");
						break;
					case 'eq':
						$where[$searchField]=array('eq',$searchString);
						break;
					case 'ne':
						$where[$searchField]=array('neq',$searchString);
						break;
					case 'bw':
						$where[$searchField]=array('like',"$searchString%");
						break;
					case 'ew':
						$where[$searchField]=array('like',"%$searchString");
						break;
					case 'in':
						$searchArr = explode(' ', $searchString);
						$where[$searchField]=array('in',$searchArr);
						break;
					case 'ni':
						$searchArr = explode(' ', $searchString);
						$where[$searchField]=array('not in',$searchArr);
						break;
					default:
						$where[$searchField]=array('like',"%$searchString%");
    			}
    			
    		}
    		
    		$count = $this->SheetTableMod->where($where)->count();
    		if( $count >0 ) {
    			$total_pages = ceil($count/$limit);
    		} else {
    			$total_pages = 0;
    		}
    		$page_info = $this->page($count, $limit,$page);
    		
    		$this->SheetTableMod
    		->where($where)
    		->limit($page_info->firstRow , $page_info->listRows)
    		->order(array($sidx=>$sord));
    		
    		$result = $this->SheetTableMod->select();
    		$responce->page = $page;
    		$responce->total = $total_pages;
    		$responce->records = $count;
    		foreach ($result as $key=>$val){
    			$responce->rows[$key]['id']=$val['id'];
    			$arr = array();
    			$arr[] = $val['id'];
    			foreach ($field_list as $field){
    				if($field['attr_type'] == 'img'){
    					if($val[$field['name']]){
	    					$arr[] = "<a class=\"js-fancybox\" href=\"".sp_get_image_url($val[$field['name']])."\"><i class=\"fa fa-file-photo-o\"></i>".sp_get_image_field($val[$field['name']],'title')."</a>";
    					}
    					else{
    						$arr[] = '';
    					}
    				}
    				else if($field['attr_type'] == 'file'){
    					if($val[$field['name']]){
	    					$this_arr = "<a class=\"pull-left\" href=\"".U('Asset/Asset/downloadFile',array('id'=>$val[$field['name']]))."\">";
	    					$this_arr .= "<img src=\"".sp_get_file_icon($val[$field['name']])."\" style=\"height:16px;width: 16px;\">".sp_get_file_field($val[$field['name']],'title');
	    					$this_arr .= "</a>";
	    					$arr[] = $this_arr;
    					}
    					else{
    						$arr[] = '';
    					}
    				}else{
	    				$arr[] = $val[$field['name']]==null?'':$val[$field['name']];
    				}
    			}
    			$responce->rows[$key]['cell'] = $arr;
    		}
    		
    		echo json_encode($responce);
    		exit();
    		
    	}
    	
    	$cate_info = $this->SheetCateMod->find($this->cate_id);
    	$this->assign('cate_info',$cate_info);
    	
    	$this->display();
    }
    
    public function main(){
    	$this->treeData="[" . $this->display_tree(0) . "]";
    	
    	$tmplList = M('SheetTmpl')->where(array('status'=>1))->select();
    	foreach ($tmplList as $key=>$val){
    		$tmplSelect .= "<option value=\"".$val['id']."\">".$val['name']."</option>";
    	}
    	$this->assign('tmplSelect',$tmplSelect);
    	$this->display();
    }
    
    public function add(){
    	if(!$this->cate_id){
    		exit();
    	}
    	$field_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
    	if(IS_POST){
    		$data = $this->SheetTableMod->create();
    		if(!$data){
    			$this->error($this->SheetTableMod->getError());
    		}
    		$re = $this->SheetTableMod->add($data);
    		
    		if($re){
    			$arr = array();
    			$arr['id'] = $re;
    			foreach ($field_list as $field){
    				if($field['attr_type'] == 'img'){
    					if($data[$field['name']]){
	    					$value = "<a class=\"js-fancybox\" href=\"".sp_get_image_url($data[$field['name']])."\"><i class=\"fa fa-file-photo-o\"></i>".sp_get_image_field($data[$field['name']],'title')."</a>";
    					}
    					else{
    						$value = '';
    					}
    				}
    				else if($field['attr_type'] == 'file'){
    					if($data[$field['name']]){
    						$this_arr = "<a class=\"pull-left\" href=\"".U('Asset/Asset/downloadFile',array('id'=>$data[$field['name']]))."\">";
	    					$this_arr .= "<img src=\"".sp_get_file_icon($data[$field['name']])."\" style=\"height:16px;width: 16px;\">".sp_get_file_field($data[$field['name']],'title');
	    					$this_arr .= "</a>";
	    					$value = $this_arr;
    					}
    					else{
    						$value = '';
    					}
    				}else{
    					$value = $data[$field['name']]==null?'':$data[$field['name']];
    				}
    				$arr[$field['name']] = $value;
    			}
    			$this->success("添加成功！",'',array('attr'=>$arr));
    		}
    		else{
    			$this->error("添加失败！");
    		}
    	}
    	$this->assign('field_list',$field_list);
    	
    	$this->display('edit');
    }
    
    public function edit($id = null){
    	if(!$this->cate_id){
    		$this->error('参数错误');
    	}
    	if(empty($id)){
    		$this->error('参数错误');
    	}
    	$field_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
    	if(IS_POST){
    		$data = $this->SheetTableMod->create();
    		if(!$data){
    			$this->error($this->SheetTableMod->getError());
    		}
    		$re = $this->SheetTableMod->save($data);
    		
    		if($re){
    			$arr = array();
    			$arr['id'] = $data['id'];
    			foreach ($field_list as $field){
    				if($field['attr_type'] == 'img'){
    					if($data[$field['name']]){
	    					$value = "<a class=\"js-fancybox\" href=\"".sp_get_image_url($data[$field['name']])."\"><i class=\"fa fa-file-photo-o\"></i>".sp_get_image_field($data[$field['name']],'title')."</a>";
    					}
    					else{
    						$value = '';
    					}
    				}
    				else if($field['attr_type'] == 'file'){
    					if($data[$field['name']]){
    						$this_arr = "<a class=\"pull-left\" href=\"".U('Asset/Asset/downloadFile',array('id'=>$data[$field['name']]))."\">";
	    					$this_arr .= "<img src=\"".sp_get_file_icon($data[$field['name']])."\" style=\"height:16px;width: 16px;\">".sp_get_file_field($data[$field['name']],'title');
	    					$this_arr .= "</a>";
	    					$value = $this_arr;
    					}
    					else{
    						$value = '';
    					}
    				}else{
    					$value = $data[$field['name']]==null?'':$data[$field['name']];
    				}
    				$arr[$field['name']] = $value;
    			}
    			$this->success("修改成功！",'',array('attr'=>$arr));
    		}
    		else{
    			$this->error("修改失败！");
    		}
    	}
    	$this->assign('field_list',$field_list);
    	
    	$data = $this->SheetTableMod->find($id);
    	$this->assign('data',$data);
    	
    	$this->display('edit');
    }
    
    public function delete($id = null){
    	if(!$this->cate_id){
    		$this->error("参数错误!");
    	}
    	if(empty($id)){
    		$this->error("请选择数据!");
    	}
    	$re = $this->SheetTableMod->delete($id);
    	if($re){
    		$this->success('删除成功!');
    	}
    	else{
    		$this->error("删除失败!");
    	}
    }
    
    public function loadout(){
    	if(!$this->cate_id){
	    	$this->error('参数错误!');
    	}
    	 
    	$searchField = I('request.searchField');
    	$searchOper = I('request.searchOper');
    	$searchString = I('request.searchString');
    	
    	if($searchField&&$searchOper&&$searchString){
    		switch ($searchOper) {
    			case 'cn':
    				$where[$searchField]=array('like',"%$searchString%");
    				break;
    			case 'nc':
    				$where[$searchField]=array('exp',"not like '%".$searchString."%'");
    				break;
    			case 'eq':
    				$where[$searchField]=array('eq',$searchString);
    				break;
    			case 'ne':
    				$where[$searchField]=array('neq',$searchString);
    				break;
    			case 'bw':
    				$where[$searchField]=array('like',"$searchString%");
    				break;
    			case 'ew':
    				$where[$searchField]=array('like',"%$searchString");
    				break;
    			case 'in':
    				$searchArr = explode(' ', $searchString);
    				$where[$searchField]=array('in',$searchArr);
    				break;
    			case 'ni':
    				$searchArr = explode(' ', $searchString);
    				$where[$searchField]=array('not in',$searchArr);
    				break;
    			default:
    				$where[$searchField]=array('like',"%$searchString%");
    		}
    	
    	}
    	 
    	$this->SheetTableMod
    	->where($where)
    	->order(array('id'=>'asc'));
    	
    	$list = $this->SheetTableMod->select();
    	
    	$field_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
    	
    	$cate_info = $this->SheetCateMod->find($this->cate_id);
    	$this->assign('cate_info',$cate_info);
    	
    	$ExcelApi = new ExcelApi();
    	try {
	    	$ExcelApi->loadout($list, $field_list,$cate_info['name']);
    		
    	} catch (\Exception $e) {
    		$this->error($e->getMessage());
    	}
    }
    
    public function loadin(){
    	if(!$this->cate_id){
    		$this->error('参数错误!');
    	}
    	$field_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
    	if(IS_POST){
    		try {
	    		$file = I('file');
	    		if(empty($file)){
	    			$this->error("请上传文件");
	    		}
	    		$filepath = sp_get_file_link($file);
	    		$excel = new ExcelApi();
	    		
	    		$res = $excel->read($filepath);
	    		
	    		
	    		unset($res[1]);
	    		
	    		
	    		foreach($res as $key =>$val){
	    			$i = 0;
	    			foreach ($field_list as $k=>$v){
	    				if($v['attr_type'] == 'img' || $v['attr_type'] == 'file'){
	    					$list[$key][$v['name']] = 0;
	    				}
	    				else{
		    				$list[$key][$v['name']] = $val[$i];
	    				}
	    				$i++;
	    			}
	    		}
	    		
	    		foreach ($list as $key=>$val){
	    			$data[] = $this->SheetTableMod->create($val);
	    		}
    			if(!empty($data)){
    				$re = $this->SheetTableMod->addAll($data);
    			}
    		} catch (\Exception $e) {
    			
    			$this->error($e->getMessage());
    		} finally {
    			$fileMod = new FileModel();
    			$fileMod->deleteLocal($file);
    		}
    		$this->success("导入完成！");
    	}
    	$cate_info = $this->SheetCateMod->find($this->cate_id);
    	$this->assign('cate_info',$cate_info);
    	$this->display();
    }
    
    public function get_tmpl(){
    	if(!$this->cate_id){
    		$this->error('参数错误!');
    	}
    	$field_list = $this->SheetAttrMod->where(array('cate_id'=>$this->cate_id))->order('sort asc')->select();
    	$cate_info = $this->SheetCateMod->find($this->cate_id);
    	$this->assign('cate_info',$cate_info);
    	
    	$ExcelApi = new ExcelApi();
    	try {
	    	$ExcelApi->get_tmpl($field_list,'模版-'.$cate_info['name']);
    		
    	} catch (\Exception $e) {
    		$this->error($e->getMessage());
    	}
    }
    
    // 获取文章分类树结构
    private function _getCateTree($cate_id,$nbsp = "&nbsp;&nbsp;&nbsp;"){
    	$result = $this->SheetCateMod->where(array('status'=>1))->order(array("sort_order"=>"asc"))->select();
    	
    	$tree = new \Tree();
    	$tree->icon = array($nbsp.'│ ', $nbsp.'├─ ', $nbsp.'└─ ');
    	$tree->nbsp = $nbsp;
    	foreach ($result as $r) {
    		$r['parentid']=$r['pid'];
    		$r['selected']= $cate_id==$r['id']?"selected":"";
    		$array[] = $r;
    	}
    	
    	$tree->init($array);
    	$str="<option value='\$id' \$selected>\$spacer\$name</option>";
    	$taxonomys = $tree->get_tree(0, $str);
    	$this->assign("taxonomys", $taxonomys);
    }
    
	private function display_tree($classid) {
    	$article_cate_mod = $this->SheetCateMod;
    	$data['pid'] = $classid;
    	$data['status'] = 1;
    	$result = $article_cate_mod->where($data)->order('sort_order asc,id asc')->select();
    	$retStr = "";
    	foreach($result as $row){
    		$retStr .= "{name:\"".$row['name'] . "\"";
    		$url = U('index',array('cate_id'=>$row['id'],'alias_template'=>$row['alias_template']));
    		$retStr .= ",\"url\":\"".$url."\", \"target\":\"".CONTROLLER_NAME."_iframe_content\",\"click\":\"changeUrl('".$url."')\",\"cid\":\"".$row['id']."\"";
    
    		if($row['pid']==0)
    		{
    			$retStr .=",open:true";
    		}
    		if($this->display_tree($row['id']) != "")
    		{
    			$retStr .= ",children:[";
    			$retStr .= $this->display_tree($row['id']);
    			$retStr .= "]";
    		}else{
    			//$url = U('index',array('cate_id'=>$row['id'],'alias_template'=>$row['alias_template']));
    			//$retStr .= ",\"url\":\"".$url."\", \"target\":\"".CONTROLLER_NAME."_iframe_content\",\"click\":\"changeUrl('#')\",\"cate_id\":\"".$row['id']."\"";
    		}
    		$retStr .= "},";
    	}
    	return  $retStr;
    }
    
    /*public function status(){
    	$value = I('request.value');
    	$ids = I('request.ids');
    	$type = I('request.type');
    	if(!$ids){
    		$this->error("请至少选择一项！");
    	}
    	$re = $this->SheetModel->where(array('id'=>array('in',$ids)))->setField($type,$value);
    	if ($re) {
    		$this->success("更新成功！");
    	} else {
    		$this->error("更新失败！");
    	}
    }*/
}
