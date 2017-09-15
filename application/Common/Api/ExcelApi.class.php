<?php
namespace Common\Api;

class ExcelApi{
	
	/**
	 * 读取excel $filename 路径文件名 $encode 返回数据的编码 默认为utf8
	 * 以下基本都不要修改
	 */
	public function read($filename, $encode = 'utf-8') {
	
		include_once ('simplewind/Core/Library/Vendor/PHPExcel/PHPExcel.php');
		
		if(strrchr($filename, '.xls') == '.xls'){
			$objReader = \PHPExcel_IOFactory::createReader ('Excel5');
		}
		else if(strrchr($filename, '.xlsx') == '.xlsx'){
			$objReader = \PHPExcel_IOFactory::createReader ('Excel2007');
		}
		else{
			return false;
		}
		
		$objReader->setReadDataOnly(true);
		$objPHPExcel = $objReader->load ( $filename );
		$objWorksheet = $objPHPExcel->getActiveSheet ();
		$highestRow = $objWorksheet->getHighestRow ();
		$highestColumn = $objWorksheet->getHighestColumn ();
		$highestColumnIndex = \PHPExcel_Cell::columnIndexFromString ( $highestColumn );
		$excelData = array ();
		for($row = 1; $row <= $highestRow; $row ++) {
			for($col = 0; $col < $highestColumnIndex; $col ++) {
				$value = ( string ) $objWorksheet->getCellByColumnAndRow ( $col, $row )->getValue ();
				if(strrchr($filename, '.xls') == '.xls'){
					$value = iconv('gbk', 'utf-8', utf8_decode ($value));
				}
				$excelData [$row] [] = $value;
			}
		}
		return $excelData;
	}
	
	function characet($data){
		if( !empty($data) ){
			$fileType = mb_detect_encoding($data , array('UTF-8','GBK','LATIN1','BIG5')) ;
			var_dump($fileType);
			if( $fileType != 'UTF-8'){
				$data = mb_convert_encoding($data ,'utf-8' , $fileType);
			}
		}
		return $data;
	}
	
	/**
	 * 检测文件编码
	 * @param string $file 文件路径
	 * @return string|null 返回 编码名 或 null
	 */
	function detect_encoding($file) {
		$list = array('GBK', 'UTF-8', 'UTF-16LE', 'UTF-16BE', 'ISO-8859-1');
		$str = file_get_contents($file);
		foreach ($list as $item) {
			$tmp = mb_convert_encoding($str, $item, $item);
			if (md5($tmp) == md5($str)) {
				return $item;
			}
		}
		return null;
	}
	
	public function loadout($list,$field_list,$name)
	{
		include_once ('simplewind/Core/Library/Vendor/PHPExcel/PHPExcel.php');
		
		
		//加载
		$phpexcel =  new \PHPExcel();
		//创建人
		$phpexcel->getProperties()->setCreator("萧山八中档案管理系统");
		//最后修改人
		$phpexcel->getProperties()->setLastModifiedBy("萧山八中档案管理系统");
		//标题
		$phpexcel->getProperties()->setTitle($name);
		//题目
		$phpexcel->getProperties()->setSubject($name);
		//描述
		$phpexcel->getProperties()->setDescription($name);
		
		//设置当前的sheet
		$phpexcel->setActiveSheetIndex(0);
		//设置sheet的name
		$phpexcel->getActiveSheet()->setTitle($name);
		
		$col = "A";
		$phpexcel->getActiveSheet()->setCellValue($col.'1', 'ID');
		$col++;
		foreach ($field_list as $key=>$val){
			$phpexcel->getActiveSheet()->setCellValue($col.'1', $val['title']);
			$phpexcel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
			$col++;
		}
		
		$rowIndex = 2;
		$i = 0;
		foreach($list as $item){
			//一览表写入数据
			
			$col = "A";
			$phpexcel->getActiveSheet()->setCellValue($col.$rowIndex, $item['id']);
			$col++;
			foreach ($field_list as $key=>$val){
				if($val['attr_type'] == 'img'){
					if(!empty($item[$val['name']])){
						$value = sp_get_image_url($item[$val['name']]);
					}
					else{
						$value = '';
					}
				}
				else if($val['attr_type'] == 'file'){
					if(!empty($item[$val['name']])){
						$value = sp_get_asset_upload_path($item[$val['name']]);
					}
					else{
						$value = '';
					}
				}
				else{
					$value = $item[$val['name']];
				}
				$phpexcel->getActiveSheet()->setCellValue($col.$rowIndex, $value);
				$col++;
			}
			$rowIndex++;
		}
	
		$objWriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
	
		$fileName .= $name.'.xlsx';
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header('Content-Disposition:inline;filename="'.$fileName.'"');
		header("Content-Transfer-Encoding: binary");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		$objWriter->save('php://output');
		exit;
	}
	
	public function get_tmpl($field_list,$name)
	{
		include_once ('simplewind/Core/Library/Vendor/PHPExcel/PHPExcel.php');
	
		//加载
		$phpexcel =  new \PHPExcel();
		//创建人
		$phpexcel->getProperties()->setCreator("萧山八中档案管理系统");
		//最后修改人
		$phpexcel->getProperties()->setLastModifiedBy("萧山八中档案管理系统");
		//标题
		$phpexcel->getProperties()->setTitle($name);
		//题目
		$phpexcel->getProperties()->setSubject($name);
		//描述
		$phpexcel->getProperties()->setDescription($name);
	
		//设置当前的sheet
		$phpexcel->setActiveSheetIndex(0);
		//设置sheet的name
		$phpexcel->getActiveSheet()->setTitle($name);
	
		$col = "A";
		foreach ($field_list as $key=>$val){
			$phpexcel->getActiveSheet()->setCellValue($col.'1', $val['title']);
			$phpexcel->getActiveSheet()->getColumnDimension($col)->setWidth(20);
			$col++;
		}
	
		$objWriter = \PHPExcel_IOFactory::createWriter($phpexcel, 'Excel2007');
	
		$fileName .= $name.'.xlsx';
		header("Content-Type: application/force-download");
		header("Content-Type: application/octet-stream");
		header("Content-Type: application/download");
		header('Content-Disposition:inline;filename="'.$fileName.'"');
		header("Content-Transfer-Encoding: binary");
		header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
		header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
		header("Pragma: no-cache");
		$objWriter->save('php://output');
		exit;
	}
	
}
?>