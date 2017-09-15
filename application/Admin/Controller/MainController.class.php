<?php
namespace Admin\Controller;

use Common\Controller\AdminbaseController;

class MainController extends AdminbaseController {
	
    public function index(){
    	
    	$this->assign("commend_menus", D("Common/Menu")->menu_commend());
        
    	$this->display();
    }
    
    public function getList(){
    	$lists = S('Weather_content');
    	if(!$lists){
    		$config = C('Weather');
    		
    		$url = "http://api.map.baidu.com/telematics/v2/weather?location=".$config['city']."&ak=".$config['ak']."";
    		$result = file_get_contents($url);
    		$content = simplexml_load_string($result);
    		$lists['city'] = (string)$content->currentCity;
    		$lists['showday'] = $config['showday'];
    		foreach($content->results->result as $result){
    			$lists['date'][] = (string)$result->date;
    			$lists['weather'][] = (string)$result->weather;
    			$lists['wind'][] = (string)$result->wind;
    			$lists['temperature'][] = (string)$result->temperature;
    			$lists['pictureUrl'][] = (string)$result->dayPictureUrl;
    		}
    	}
    	if($lists){
    		$this->success('成功', '', array('data'=>$lists));
    	}else{
    		$this->error('天气列表失败');
    	}
    	$this->assign('weather_list', $lists);
    }
}