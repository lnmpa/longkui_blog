<?php
if(file_exists("data/conf/db.php")){
	$db=include "data/conf/db.php";
}else{
	$db=array();
}
if(file_exists("data/conf/config.php")){
	$runtime_config=include "data/conf/config.php";
}else{
    $runtime_config=array();
}

if (file_exists("data/conf/route.php")) {
    $routes = include 'data/conf/route.php';
} else {
    $routes = array();
}

$configs= array(
        "LOAD_EXT_FILE"=>"extend",
        'UPLOADPATH' => 'data/upload/',
        //'SHOW_ERROR_MSG'        =>  true,    // 显示错误信息
        //'SHOW_PAGE_TRACE'		=> false,
        'TMPL_STRIP_SPACE'		=> true,// 是否去除模板文件里面的html空格与换行
        'THIRD_UDER_ACCESS'		=> false, //第三方用户是否有全部权限，没有则需绑定本地账号
        /* 标签库 */
        'TAGLIB_BUILD_IN' => THINKCMF_CORE_TAGLIBS,
        'MODULE_ALLOW_LIST'  => array('Index','Mall','Admin','Asset','Api','User'),
        'TMPL_DETECT_THEME'     => false,       // 自动侦测模板主题
        'TMPL_TEMPLATE_SUFFIX'  => '.html',     // 默认模板文件后缀
        'DEFAULT_MODULE'        =>  'Index',  // 默认模块
        'DEFAULT_CONTROLLER'    =>  'Index', // 默认控制器名称
        'DEFAULT_ACTION'        =>  'index', // 默认操作名称
        'DEFAULT_M_LAYER'       =>  'Model', // 默认的模型层名称
        'DEFAULT_C_LAYER'       =>  'Controller', // 默认的控制器层名称
        
        'DEFAULT_FILTER'        =>  'htmlspecialchars', // 默认参数过滤方法 用于I函数...htmlspecialchars
        
        'LANG_SWITCH_ON'        =>  true,   // 开启语言包功能
        'DEFAULT_LANG'          =>  'zh-cn', // 默认语言
        'LANG_LIST'				=>  'zh-cn,en-us,zh-tw',
        'LANG_AUTO_DETECT'		=>  true,
        'ADMIN_LANG_SWITCH_ON'        =>  false,   // 后台开启语言包功能
        
        'VAR_MODULE'            =>  'g',     // 默认模块获取变量
        'VAR_CONTROLLER'        =>  'm',    // 默认控制器获取变量
        'VAR_ACTION'            =>  'a',    // 默认操作获取变量
        
        'APP_USE_NAMESPACE'     =>   true, // 关闭应用的命名空间定义
        'APP_AUTOLOAD_LAYER'    =>  'Controller,Model', // 模块自动加载的类库后缀
        
        'SP_TMPL_PATH'     		=> 'themes/',       // 前台模板文件根目录
        'SP_DEFAULT_THEME'		=> 'simplebootx',       // 前台模板文件
        'SP_TMPL_ACTION_ERROR' 	=> 'error', // 默认错误跳转对应的模板文件,注：相对于前台模板路径
        'SP_TMPL_ACTION_SUCCESS' 	=> 'success', // 默认成功跳转对应的模板文件,注：相对于前台模板路径
        'SP_ADMIN_STYLE'		=> 'flat',
        'SP_ADMIN_TMPL_PATH'    => 'admin/themes/',       // 各个项目后台模板文件根目录
        'SP_ADMIN_DEFAULT_THEME'=> 'simplebootx',       // 各个项目后台模板文件
        'SP_ADMIN_TMPL_ACTION_ERROR' 	=> 'Admin/error.html', // 默认错误跳转对应的模板文件,注：相对于后台模板路径
        'SP_ADMIN_TMPL_ACTION_SUCCESS' 	=> 'Admin/success.html', // 默认成功跳转对应的模板文件,注：相对于后台模板路径
        'TMPL_EXCEPTION_FILE'   => SITE_PATH.'public/exception.html',
        
        'AUTOLOAD_NAMESPACE' => array('plugins' => './plugins/'), //扩展模块列表
        
        'ERROR_PAGE'            =>'',//不要设置，否则会让404变302
        
        'VAR_SESSION_ID'        => 'session_id',
        
        "UCENTER_ENABLED"		=>0, //UCenter 开启1, 关闭0
        "COMMENT_NEED_CHECK"	=>0, //评论是否需审核 审核1，不审核0
        "COMMENT_TIME_INTERVAL"	=>60, //评论时间间隔 单位s
        
        /* URL设置 */
        'URL_CASE_INSENSITIVE'  => true,   // 默认false 表示URL区分大小写 true则表示不区分大小写
        'URL_MODEL'             => 0,       // URL访问模式,可选参数0、1、2、3,代表以下四种模式：
        // 0 (普通模式); 1 (PATHINFO 模式); 2 (REWRITE  模式); 3 (兼容模式)  默认为PATHINFO 模式，提供最好的用户体验和SEO支持
        'URL_PATHINFO_DEPR'     => '/',	// PATHINFO模式下，各参数之间的分割符号
        'URL_HTML_SUFFIX'       => '',  // URL伪静态后缀设置
        
        'VAR_PAGE'				=>"p",
        
        'URL_ROUTER_ON'			=> true,
        'URL_ROUTE_RULES'       => $routes,

        /*性能优化*/
        'OUTPUT_ENCODE'			=>true,// 页面压缩输出
        
        'HTML_CACHE_ON'         =>    false, // 开启静态缓存
        'HTML_CACHE_TIME'       =>    60,   // 全局静态缓存有效期（秒）
        'HTML_FILE_SUFFIX'      =>    '.html', // 设置静态缓存文件后缀
        
		'DATA_AUTH_KEY'			=>'QUnG^{fOx)]|.20k"V:7[$TEmAy}l@*Lo(g;#HvC',
		
		'DB_DEBUG'  			=>  false,
		
        'TMPL_PARSE_STRING'=>array(
        	'__UPLOAD__' => __ROOT__.'/data/upload/',
        	'__STATICS__' => __ROOT__.'/statics/',
            '__WEB_ROOT__'=>__ROOT__
        ),
		
		'ALIPAY_CONFIG' =>array(
			'partner' =>'2088521170985475',   //这里是你在成功申请支付宝接口后获取到的PID；
			'key'=>'79em2b54yhhtbbeesslxwthr68sf8jy6',//这里是你在成功申请支付宝接口后获取到的Key
			'sign_type'=>strtoupper('MD5'),
			'input_charset'=> strtolower('utf-8'),
			'cacert'=> getcwd().'/public/cacert/Alipay/cacert.pem',
			'transport'=> 'http',
			'payment_type'=>'1',
			'service'=>'create_direct_pay_by_user',
		),
		
		'ALIREFUND_CONFIG' =>array(
			'partner' =>'2088521170985475',   //这里是你在成功申请支付宝接口后获取到的PID；
			'key'=>'79em2b54yhhtbbeesslxwthr68sf8jy6',//这里是你在成功申请支付宝接口后获取到的Key
			'sign_type'=>strtoupper('MD5'),
			'input_charset'=> strtolower('utf-8'),
			'cacert'=> getcwd().'/public/cacert/Alipay/cacert.pem',
			'transport'=> 'http',
			'payment_type'=>'1',
			'service'=>'refund_fastpay_by_platform_pwd',
			'refund_date'=>date("Y-m-d H:i:s",time()),
		),
		
		/*'ALIMOBILE_CONFIG' => array (
				//应用ID,您的APPID。
				'app_id' => "2016073100131846",
				//商户私钥，您的原始格式RSA私钥
				'merchant_private_key' => "MIICdwIBADANBgkqhkiG9w0BAQEFAASCAmEwggJdAgEAAoGBAIQhN6T5hZWnYfeII3qS+7nt3Qor8rKF8UMdhJHuCnRtUTlcAl+k+Yhzl24TvavpPZ0BFkGpCLLLwv7RvccufJEMdpwQnZvykyJrk+czSytIbS09EuqTc7c+eyIAcxl5mFV6fF9tIBuHc3YzkTks+dx8Vr16WpmO0z9CRcmLZwdjAgMBAAECgYBbD0F4Evb7UmXz4AEDgrS1SLbjQbJ7UlAZfwhUQgc2gfhOXZjNLbdDUNZ16Gj5Rz9NKuiZy9LQ1hjG4Om3kdQKa/wO2MTcgrusxQof2SN60zZkezpgoEw8PKAFDFHus1x0nMGKud/Af5geuUtdYIhvaf6OC6uuSfSAyFjTIdqwkQJBAMwHkFZLXxIfE/teV5yPl1t4xRogzfTE+E0wwwFwPNmmS0162TKCYcSy9ObBzxXf+GzZeR0y3E4tCX9s+EGpFbcCQQClyS9Fz9gl0SlVofYu9LBIxONfM+3gu3wFgEaCL3Oil257GTgsQDDE9X+3YQsvp+h3vw+MYeSaCkeZXvKT8ru1AkEAyCm3geGJ0LZqnRYuL6tzm0q9W+fJBpRi4R+wgG3DVOffQpD+Gp5tGlNTDjwfVN+Y0fj86BdoqM1oXvniCFDAuwJBAJ80JwBciw4t4QrJ4NbQxWTsJgjrnlk80emaeJtWJC6US1VNL6NW9T5/Humj+JEIJnav9Kdz7op6qq0+/6ZR6C0CQEtproaFwcjIWeAt426S8Mn8J9fpyqdhhlqXXgzR3ywCGa6+nRqFbUE9wcyyAdfqxqMRGTx5Z6veMtVjfAsrQ10=",
				//编码格式
				'charset' => "UTF-8",
				//签名方式
				'sign_type'=>"RSA",
				//支付宝网关
				'gatewayUrl' => "https://openapi.alipaydev.com/gateway.do",
				//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
				'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDIgHnOn7LLILlKETd6BFRJ0GqgS2Y3mn1wMQmyh9zEyWlz5p1zrahRahbXAfCfSqshSNfqOmAQzSHRVjCqjsAw1jyqrXaPdKBmr90DIpIxmIyKXv4GGAkPyJ/6FTFY99uhpiq0qadD/uSzQsefWo0aTvP/65zi3eof7TcZ32oWpwIDAQAB",
		),*/
		
		'ALIMOBILE_CONFIG' => array (
			//应用ID,您的APPID。
			'app_id' => "2016123104765334",
			//商户私钥，您的原始格式RSA私钥
			'merchant_private_key' => "MIICXAIBAAKBgQCwzuo4D2uz0t9LYipZ0uqRr7amVyrvyB1YFtSERF3Gotp5cbyTpRR0jxbeXnWKEA3qXMG814RR2ANZ8VdELs63ggLvaNhKlqbg9LVrf0bNt4qNJsp3a+I2HyQnwqR6Ll7bCAJfwtnlmqSlwlgFiYst8UZ5JJPTaiv/+Em8r24TMwIDAQABAoGBAIu351THsteWowgCGe+DggQAc/i811xGqhGrcOLY17YZiUYBAAE4qZJ2ZJ7yzDV+/FAgXqTpNlIqvnM8CTcDOixvR2xplf6l9ZtSsAXCfiHw4R0ZrHGh/jvXZrbTzM8seSWKs8qdPf1pZMwZBUSjUOHZfCnx2dV5j9oIJc5p7JzhAkEA2YfLa3ZECR0T/vLLtdlZkxTm1VV0Dh3TJBljk4es6xxGu6JobifzOaVqt6m5tBEEK1yIzf94QOZdzKHoP7spMQJBANATg6Tyvp2csmOicTC3AqSetRvuHQ23+u3wpAgGJIH2T8R4vA//VA2nmy/Ecra1ZBhnoDM1IUPosJHj6nHKKaMCQAuMKOFIgu4U7BXRn7zEj/u91U8n3SROswGsk1umjShh9ONLCM4oMsIxpMuhJ+mGKbl/jQeaczDGyd3uDl0ru1ECQD35kfxPUPcg9QE4IP6hg+gEXW00PvMXGWZFhpXdPoJ3GssqKtmY8zAd+9r+aCyDWozqUIzwBjhz1iOd/vZlgIECQFMm6nl3avNuQ3woXX1p6McKlTLtNgnl1mtP2R7RfibeunMO/AMcmbLkkumEcTvsIeZJ/ZBoI1lQ4CBc2e7jjOg=",
			//编码格式
			'charset' => "UTF-8",
			//签名方式
			'sign_type'=>"RSA",
			//支付宝网关
			'gatewayUrl' => "https://openapi.alipay.com/gateway.do",
			//支付宝公钥,查看地址：https://openhome.alipay.com/platform/keyManage.htm 对应APPID下的支付宝公钥。
			'alipay_public_key' => "MIGfMA0GCSqGSIb3DQEBAQUAA4GNADCBiQKBgQDDI6d306Q8fIfCOaTXyiUeJHkrIvYISRcc73s3vF1ZT7XN8RNPwJxo8pWaJMmvyTn9N4HQ632qJBVHf8sxHi/fEsraprwCtzvzQETrNRwVxLO5jVmRGi60j8Ue1efIlzPXV9je9mkjzOmdssymZkh2QhUrCmZYI/FCEa3/cNMW0QIDAQAB",
		),
		
		'SMS_APP_KEY'			=>'23583193',
		'SMS_FFREE_SIGN_NAME'	=>'注册验证',
		'SMS_TEMPLATE_CODE'		=>'SMS_36310266',
		'SMS_APP_SECRET'		=>'83353c15bf3b56224aaf30ed652acf5d',
		
		'TENPAY_CONFIG' =>array(
			'partner' =>'1432641401',
			'key'=>'5a1a26f19bd2242dbe7d730016478da1',
		),
		
		'YLPAY_CONFIG' =>array(
			'merId' => '103330148160022',
			'cacert'=>getcwd().'/public/cacert/Ylpay/zhenshu.pfx',
			'pwd'=>'103330',
		),
		
		'DATA_BACKUP_PATH' => 'data/backup/',
		'DATA_BACKUP_PART_SIZE' => '20971520',
		'DATA_BACKUP_COMPRESS' => '1',//0:不压缩 1:启用压缩
		'DATA_BACKUP_COMPRESS_LEVEL' => '9',//1:普通 4:一般 9:最高
		
		'Weather' =>array(
				'city' => '萧山',
				'ak' => 'U9Ygb1AaTiFOnnaxEWZh79ckn6Ytr5tA',
				'showday' => '4',
		),
);

return  array_merge($configs,$db,$runtime_config);
