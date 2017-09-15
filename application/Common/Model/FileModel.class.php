<?php
// +----------------------------------------------------------------------
// | OneThink [ WE CAN DO IT JUST THINK IT ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013 http://www.onethink.cn All rights reserved.
// +----------------------------------------------------------------------
// | Author: 麦当苗儿 <zuojiazi@vip.qq.com> <http://www.zjzit.cn>
// +----------------------------------------------------------------------

namespace Common\Model;
use Think\Model;
use Think\Upload;

/**
 * 文件模型
 * 负责文件的下载和上传
 */

class FileModel extends Model{
    /**
     * 文件模型自动完成
     * @var array
     */
    protected $_auto = array(
        array('update_time', NOW_TIME, self::MODEL_INSERT),
    );
	
    public function deleteLocal($ids){
    	if(empty($ids)){
    		return false;
    	}
    	if(!is_array($ids)){
    		$ids = array($ids);
    	}
    	foreach ($ids as $id){
    		$url = $this->where(array('id'=>$id))->getField('url');
    		$file = sp_get_file_link($url);
    		if(file_exists($file)){
    			$return = unlink($file);
    			if($return){
    				$this->delete($id);
    			}
    		}
    		else{
    			$this->delete($id);
    		}
    	}
    	return true;
    }
    
    public function deleteExprie(){
    	$exprie_time = date('Y-m-d H:i:s',time()-3600);
    	$deleteIds2 = $this->where(array('add_time'=>array('lt',$exprie_time),'status'=>0))->getField('id',true);
    	$this->deleteLocal($deleteIds2);
    }
    
    /**
     * 文件上传
     * @param  array  $files   要上传的文件列表（通常是$_FILES数组）
     * @param  array  $setting 文件上传配置
     * @param  string $driver  上传驱动名称
     * @param  array  $config  上传驱动配置
     * @return array           文件上传成功后的信息
     */
    public function upload($files, $setting, $driver = 'Local', $config = null){
        /* 上传文件 */
        $setting['callback'] = array($this, 'isFile');
		$setting['removeTrash'] = array($this, 'removeTrash');
        $Upload = new Upload($setting, $driver, $config);
        $info   = $Upload->upload($files);

        /* 设置文件保存位置 */
		$this->_auto[] = array('location', 'ftp' === strtolower($driver) ? 1 : 0, self::MODEL_INSERT);

        if($info){ //文件上传成功，记录文件信息
            foreach ($info as $key => &$value) {
                /* 已经存在文件记录 */
                if(isset($value['id']) && is_numeric($value['id'])){
                    $value['path'] = substr($setting['rootPath'], 1).$value['savepath'].$value['savename']; //在模板里的url路径
                    continue;
                }

                $value['path'] = substr($setting['rootPath'], 1).$value['savepath'].$value['savename']; //在模板里的url路径
                $value['extend_id'] = I('get.extend_id',0);
                $value['status'] = 1;
                /* 记录文件信息 */
                if($this->create($value) && ($id = $this->add())){
                    $value['id'] = $id;
                }else {
                    //TODO: 文件上传成功，但是记录文件信息失败，需记录日志
                    unset($info[$key]);
                }
            }
            return $info; //文件上传成功
        } else {
            $this->error = $Upload->getError();
            return false;
        }
    }

    /**
     * 下载指定文件
     * @param  number  $root 文件存储根目录
     * @param  integer $id   文件ID
     * @param  string   $args     回调函数参数
     * @return boolean       false-下载失败，否则输出下载文件
     */
    public function download($root, $id, $callback = null, $args = null){
        /* 获取下载文件信息 */
        $file = $this->find($id);
        if(!$file){
            $this->error = '不存在该文件！';
            return false;
        }

        /* 下载文件 */
        switch ($file['location']) {
            case 0: //下载本地文件
                $file['rootpath'] = $root;
                return $this->downLocalFile($file, $callback, $args);
			case 1: //下载FTP文件
				$file['rootpath'] = $root;
				return $this->downFtpFile($file, $callback, $args);
                break;
            default:
                $this->error = '不支持的文件存储类型！';
                return false;

        }

    }
	
    public function getFile($extend_id = null,$module_name = null){
    	if($extend_id && $module_name){
    		$list = $this->where(array('extend_id'=>$extend_id,'module_name'=>$module_name,'status'=>1))->select();
    	}
    	return $list;
    }
    
    /**
     * 下载本地文件
     * @param  array    $file     文件信息数组
     * @param  callable $callback 下载回调函数，一般用于增加下载次数
     * @param  string   $args     回调函数参数
     * @return boolean            下载失败返回false
     */
    private function downLocalFile($file, $callback = null, $args = null){
        if(is_file($file['rootpath'].$file['savepath'].$file['savename'])){
            /* 调用回调函数新增下载数 */
            is_callable($callback) && call_user_func($callback, $args);

            /* 执行下载 */ //TODO: 大文件断点续传
            header("Content-Description: File Transfer");
            header('Content-type: ' . $file['type']);
            header('Content-Length:' . $file['size']);
            if (preg_match('/MSIE/', $_SERVER['HTTP_USER_AGENT'])) { //for IE
                header('Content-Disposition: attachment; filename="' . rawurlencode($file['name']) . '"');
            } else {
                header('Content-Disposition: attachment; filename="' . $file['name'] . '"');
            }
            readfile($file['rootpath'].$file['savepath'].$file['savename']);
            exit;
        } else {
            $this->error = '文件已被删除！';
            return false;
        }
    }

	/**
	 * 清除数据库存在但本地不存在的数据
	 * @param $data
	 */
	public function removeTrash($data){
		$this->where(array('id'=>$data['id'],))->delete();
	}

}
