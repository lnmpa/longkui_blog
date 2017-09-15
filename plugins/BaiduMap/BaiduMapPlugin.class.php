<?php

namespace plugins\BaiduMap;//Demo插件英文名，改成你的插件英文就行了
use Common\Lib\Plugin;


    class BaiduMapPlugin extends Plugin{

        public $info = array(
            'name'=>'BaiduMap',
            'title'=>'百度地图坐标定位',
            'description'=>'百度地图坐标定位',
            'status'=>1,
            'author'=>'lhb',
            'version'=>'0.1'
        );

        public function install(){
            return true;
        }

        public function uninstall(){
            return true;
        }

        //实现的UploadFiles钩子方法
        public function BaiduMap($param){
//            if (empty($param['value'])) {
//                $param['value'] = json_encode(array());
//            }
            $this->assign('param', $param);
            $this->display('index');
        }

    }