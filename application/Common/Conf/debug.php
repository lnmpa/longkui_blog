<?php
return array(
		'TMPL_DETECT_THEME'     => false,       // 自动侦测模板主题
		//'SHOW_PAGE_TRACE'		=> true,
		'SHOW_RUN_TIME'			=> false,
		'TMPL_STRIP_SPACE'      => false,
		'HTML_CACHE_ON'         => false, // 开启静态缓存
	    'LOG_RECORD'            =>  false,  // 进行日志记录
	    'LOG_EXCEPTION_RECORD'  =>  false,    // 是否记录异常信息日志
    	'LOG_LEVEL'             =>  'EMERG,ALERT,CRIT,ERR,WARN,DEBUG,SQL',  // 允许记录的日志级别
);