<?php
namespace Vendor\Ylpay\sdk;
header ( 'Content-type:text/html;charset=utf-8' );
include_once 'SDKConfig.php';

class LogUtil
{
	private static $_logger = null;
	public static function getLogger()
	{
		if (LogUtil::$_logger == null ) {
			LogUtil::$_logger = new PhpLog ( SDK_LOG_FILE_PATH, "PRC", SDK_LOG_LEVEL );
		}
		return self::$_logger;
	}
}
