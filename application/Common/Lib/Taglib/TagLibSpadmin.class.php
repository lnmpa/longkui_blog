<?php

/**
 */
namespace Common\Lib\TagLib;
use Think\Template\TagLib;
class TagLibSpadmin extends TagLib {

    /**
     * @var type 
     * 标签定义： 
     *                  attr         属性列表 
     *                  close      标签是否为闭合方式 （0闭合 1不闭合），默认为不闭合 
     *                  alias       标签别名 
     *                  level       标签的嵌套层次（只有不闭合的标签才有嵌套层次）
     * 定义了标签属性后，就需要定义每个标签的解析方法了，
     * 每个标签的解析方法在定义的时候需要添加“_”前缀，
     * 可以传入两个参数，属性字符串和内容字符串（针对非闭合标签）。
     * 必须通过return 返回标签的字符串解析输出，在标签解析类中可以调用模板类的实例。
     */
    protected $tags = array(
        //后台模板标签
        'admintpl' => array("attr" => "file", "close" => 0),
		'imagetpl'=>array('attr'=>'id,name,value','close'=>0),
		'filetpl'=>array('attr'=>'id,name,value,type','close'=>0),
		'albumtpl'=>array('attr'=>'id,name,value','close'=>0),
		'ueditortpl'=>array('attr'=>'id,name,value,more','close'=>0),
		'selecttpl'=>array('attr'=>'id,name,value,type,style,class','close'=>0),
		'checkboxtpl'=>array('attr'=>'id,name,value,type,style,class','close'=>0),
		'radiotpl'=>array('attr'=>'id,name,value,type,style,class','close'=>0),
    	'taxonomystpl'=>array('attr'=>'id,name,value,type,style,class,more,data','close'=>0)
    );

    /**
     * 模板包含标签 
     * 格式
     * <admintpl file="APP/模块/模板"/>
     * @staticvar array $_admintemplateParseCache
     * @param type $attr 属性字符串
     * @param type $content 标签内容
     * @return array 
     */
    public function _admintpl($tag, $content) {
        $file = $tag['file'];
        $counts = count($file);
        if ($counts < 3) {
            $file_path = "Admin" .  "/" . $tag['file'];
        } else {
            $file_path = $file[0] . "/" . "Tpl" . "/" . $file[1] . "/" . $file[2];
        }
        //模板路径
        $TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
        //判断模板是否存在
        if (!file_exists_case($TemplatePath)) {
            return false;
        }
        //读取内容
        $tmplContent = file_get_contents($TemplatePath);
        //解析模板内容
        $parseStr = $this->tpl->parse($tmplContent);
        return $parseStr;
    }
    
    /**
     * 单图片上传模板
     * 格式
     * <imagetpl id="" name="" value="$img_id"/>
     * @param type $tag 属性字符串
     * @param type $content 标签内容
     * @return string
     */
    public function _imagetpl($tag,$content){
    	$data['images_id']	 	=	$tag['id'];
    	$data['images_name']   	=	$tag['name'];
    	$data['images_label'] 	=	think_encrypt($tag['name']);
    	$data['images_value']   =	$tag['value'];
    	
    	$file_path = "Asset" .  "/" . "images";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
        $tmplContent = file_get_contents($TemplatePath);
        //解析模板内容
        $tmplContent = sp_array_replace($data, $tmplContent);
        $parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
	
    /**
     * 单文件上传模板
     * 格式
     * <imagetpl id="" name="" value="$file_id"/>
     * @param type $tag 属性字符串
     * @param type $content 标签内容
     * @return string
     */
    public function _filetpl($tag,$content){
    	$data['files_id']	 	=	$tag['id'];
    	$data['files_name']   	=	$tag['name'];
    	$data['files_label'] 	=	think_encrypt($tag['name']);
    	$data['files_value']	=	$tag['value'];
    	$data['files_type']		=	empty($tag['type'])?'file':$tag['type'];
    	 
    	$file_path = "Asset" .  "/" . "files";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板内容
    	$tmplContent = sp_array_replace($data, $tmplContent);
    	$parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
    
    /**
     * 图片相册上传模板
     * 格式
     * <albumtpl id="" name="" value="$album_id"/>
     * @param type $tag 属性字符串
     * @param type $content 标签内容
     * @return string
     */
    public function _albumtpl($tag,$content){
    	$data['album_id']	 	=	$tag['id'];
    	$data['album_name']   	=	$tag['name'];
    	$data['album_label'] 	=	think_encrypt($tag['name']);
    	$data['album_md5'] 		=	md5($tag['name']);
    	$data['album_value']	=	$tag['value'];
    	
    	$file_path = "Asset" .  "/" . "album";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板内容
    	$tmplContent = sp_array_replace($data, $tmplContent);
    	$parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
    
    /**
     * 百度UEditor编辑器模板
     * 格式
     * <ueditortpl id="" name="" value="$album_id"/>
     * @param type $tag 属性字符串
     * @param type $content 标签内容
     * @return string
     */
    public function _ueditortpl($tag,$content){
    	$data['ueditor_id']	 	=	$tag['id'];
    	$data['ueditor_name']   =	$tag['name'];
    	$data['ueditor_label'] 	=	md5($tag['name']);
    	$data['ueditor_value']	=	$tag['value'];
    	$data['ueditor_more']	=	empty($tag['more'])?false:true;
    	$file_path = "Asset" .  "/" . "ueditor";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板内容
    	$tmplContent = sp_array_replace($data, $tmplContent);
    	$parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
    
    /**
     * select模板
     * 格式
     * <selecttpl id="" name="" value="$select_id" style="" class="" type=""/>
     * @param type $tag 属性字符串
     * @return string
     */
    public function _selecttpl($tag,$content){
    	$data['select_id']	 	=	$tag['id'];
    	$data['select_name']   =	$tag['name'];
    	$data['select_label'] 	=	md5($tag['name']);
    	$data['select_value']	=	empty($tag['value'])?0:$tag['value'];
    	$data['select_style']	=	$tag['style'];
    	$data['select_class']	=	$tag['class'];
    	$data['select_type']	=	$tag['type'];
    	 
    	$file_path = "Asset" .  "/" . "select";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板内容
    	$tmplContent = sp_array_replace($data, $tmplContent);
    	$parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
    
    /**
     * checkbox模板
     * 格式
     * <checkboxtpl id="" name="" value="$checkbox_id" style="" class="" type=""/>
     * @param type $tag 属性字符串
     * @return string
     */
    public function _checkboxtpl($tag,$content){
    	$data['checkbox_id']	 	=	$tag['id'];
    	$data['checkbox_name']   =	$tag['name'];
    	$data['checkbox_label'] 	=	think_encrypt($tag['name']);
    	$data['checkbox_md5'] 		=	md5($tag['name']);
    	$data['checkbox_value']	=	empty($tag['value'])?0:$tag['value'];
    	$data['checkbox_style']	=	$tag['style'];
    	$data['checkbox_class']	=	$tag['class'];
    	$data['checkbox_type']	=	$tag['type'];
    	
    
    	$file_path = "Asset" .  "/" . "checkbox";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板内容
    	$tmplContent = sp_array_replace($data, $tmplContent);
    	$parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
    
    /**
     * radio模板
     * 格式
     * <radiotpl id="" name="" value="$radio_id" style="" class="" type=""/>
     * @param type $tag 属性字符串
     * @return string
     */
    public function _radiotpl($tag,$content){
    	$data['radio_id']	 	=	$tag['id'];
    	$data['radio_name']   =	$tag['name'];
    	$data['radio_label'] 	=	md5($tag['name']);
    	$data['radio_value']	=	empty($tag['value'])?0:$tag['value'];
    	$data['radio_style']	=	$tag['style'];
    	$data['radio_class']	=	$tag['class'];
    	$data['radio_type']	=	$tag['type'];
    
    
    	$file_path = "Asset" .  "/" . "radio";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板内容
    	$tmplContent = sp_array_replace($data, $tmplContent);
    	$parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
    
    /**
     * 级联分类菜单模板
     * 格式
     * <taxonomystpl id="" name="" value="$radio_id" style="" class="" type="" data=""/>
     * @param type $tag 属性字符串
     * $tag['data'] 数据源$list = array(array('id'=>'','name'=>'','pid'=>''),.....);
     * @return string
     */
    public function _taxonomystpl($tag,$content){
    	$data['taxonomys_id']	 	=	$tag['id'];
    	$data['taxonomys_name']   =	$tag['name'];
    	$data['taxonomys_label'] 	=	md5($tag['name']);
    	$data['taxonomys_value']	=	empty($tag['value'])?0:$tag['value'];
    	$data['taxonomys_style']	=	$tag['style'];
    	$data['taxonomys_class']	=	$tag['class'];
    	$data['taxonomys_type']	=	$tag['type'];
    	$data['taxonomys_more']	=	$tag['more']==true?true:false;
    	$data['treeData']	=	$tag['data'];
    	
    	$file_path = "Asset" .  "/" . "taxonomys";
    	$TemplatePath = sp_add_template_file_suffix( C("SP_ADMIN_TMPL_PATH") .C("SP_ADMIN_DEFAULT_THEME")."/". $file_path );
    	//读取内容
    	$tmplContent = file_get_contents($TemplatePath);
    	//解析模板内容
    	$tmplContent = sp_array_replace($data, $tmplContent);
    	$parseStr = $this->tpl->parse($tmplContent);
    	return $parseStr;
    }
}

