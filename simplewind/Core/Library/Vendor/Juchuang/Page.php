<?php
// 密码相关程序 英 [en'krɪpt]  美 [ɪn'krɪpt] 
class Page{
    function setPageurl()
    {
    	$pageurl='http://'.$_SERVER['SERVER_NAME'].':'.$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
    	cookie('pageurl',$pageurl,600);
    }
    function getPageurl()
    {
    	 $pageurl = $_COOKIE['pageurl'];
    	 if(!isset($pageurl)){$pageurl=U('public/main');}
    	 return $pageurl;
    }
}
?>