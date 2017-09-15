<?php
// 密码相关程序 英 [en'krɪpt]  美 [ɪn'krɪpt] 
// 				vendor('Juchuang.Encrypt');
// 				$Encrypt = new Encrypt();
// 				$salt=$Encrypt->getSalt(6);
namespace Vendor\Juchuang;

class Encrypt{
	//AES加密--依赖PHP自身的mcrypt扩展
	private $_aes_secret_key ='4P1]tHaA0n(:r8{G]\#/a6[!2xDt9F-YknteO=29+aUTc~Z[nV)jqBj62)~8tZoH5lOM!Q_kzuxh#bB$@`fpm-Lms]0}xJ[*I3]\O%M~kl:^y`3GF]I\i+,8!sk(P3,/'; //128位加密密钥 'default_secret_key';	 
	public function aessetKey($key) {
		$this->_aes_secret_key = $key;
	}
	public function aes_encode($data) {
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
		$iv = mcrypt_create_iv(mcrypt_enc_get_iv_size($td),MCRYPT_RAND);
		mcrypt_generic_init($td,$this->_aes_secret_key,$iv);
		$encrypted = mcrypt_generic($td,$data);
		mcrypt_generic_deinit($td);		 
		return $iv . $encrypted;
	}
	public function aes_decode($data) {
		$td = mcrypt_module_open(MCRYPT_RIJNDAEL_256,'',MCRYPT_MODE_CBC,'');
		$iv = mb_substr($data,0,32,'latin1');
		mcrypt_generic_init($td,$this->_aes_secret_key,$iv);
		$data = mb_substr($data,32,mb_strlen($data,'latin1'),'latin1');
		$data = mdecrypt_generic($td,$data);
		mcrypt_generic_deinit($td);
		mcrypt_module_close($td);
		return trim($data);
	}	
// 	function enaes($code)
// 	{//限单次调用
// 		$code=base64_encode($code);
// 		$code=$this->aes_encode($code);
// 		$code=$this->nickencode($code);
// 		$code=base64_encode($code);
// 		return $code;
// 	}
// 	function deaes($code)
// 	{//限单次调用
// 		//$this->aessetKey('newkey');
// 		//$code=$this->aes_decode($code);
// 		$code=base64_decode($code);
// 		$code=$this->nickdecode($code);
// 		$code=$this->aes_decode($code);
// 		$code=base64_decode($code);
// 		return $code;
// 	}
// 	//配合 AES使用
// 	function nickencode($password)
// 	{
// 		$password=base64_encode($password);
// 		$arr0=array();
// 		$arr2=array();
	
	
// 		$str_salt=md5("当前时间：".date('Y-m-d',time()).$password);
// 		$password=$str_salt.$password;
// 		$arr0=str_split($password);
	
// 		$maxi=7;
// 		$count=0;
// 		$result="";
// 		$maxj=ceil(count($arr0)/$maxi);
	
// 		//echo $password;
// 		for ($i = 0;$i < $maxi;$i++)
// 		{
// 		for ($j = 0;$j <$maxj;$j++)
// 		{
// 		if(isset($arr0[$count]))
// 		{
// 		$arr2[$j][$maxi-$i-1]=$arr0[$count];
// 		}
// 		else
// 		{
// 			$arr2[$j][$maxi-$i-1]=' ';
// 			}
// 			$count++;
// 			}
// 		}
// 		//var_dump($arr2);
	
// 		for ($j = 0;$j <$maxj;$j++)
// 		{
// 		for ($i = 0;$i < $maxi;$i++)
// 		{
// 		$result.=$arr2[$j][$i];
// 		$count++;
// 		}
// 		}
// 		return $result;
// 		}
	
// 		function nickdecode($password)
// 		{
// 		$arr0=array();
// 		$arr2=array();
// 		//$userip=leipi_client_ip();
// 		//$str_salt=md5($userip."当前时间：".date('Y-m-d',time()));
// 		//$password=$str_salt.$password;
// 		$fors='';
// 		$arr0=str_split($password);
	
// 		$maxj=7;
// 		$count=0;
// 		$result="";
// 		$maxi=ceil(count($arr0)/$maxj);
	
// 		// echo $maxi.'<p>';
// 		for ($i = 0;$i < $maxi;$i++)
// 		{
// 		for ($j = 0;$j <$maxj;$j++)
// 		{
// 		if(isset($arr0[$count]))
// 			{
// 			$arr1[$i][$j]=$arr0[$count];
// 				$arr2[$maxj-$j-1][$i]=$arr0[$count];
// 				}
// 				else
// 				{
// 				//$arr2[$maxj-$j-1][$i]=' ';
// 				}
// 				//	$fors.='$arr1['.$i.']['.$j.']='.$arr1[$i][$j].'                $arr2['.($maxj-$j-1).']['.$i.']='.$arr2[$maxj-$j-1][$i].'<br>';
	
// 				$count++;
// 			}
// 			}
// 			for ($i = 0;$i <$maxj;$i++)
// 			{
// 				for ($j = 0;$j < $maxi;$j++)
// 				{
// 				$result.=$arr2[$i][$j];
// 				$count++;
// 				}
// 				}
// 				$result=substr($result,32,strlen($result));
// 				$result=base64_decode($result);
// 				return $result;
// 		}
	
	
	
	
	
	
	
	//md5加密
	function getSalt( $length = 6 ) {
		// 密码字符集，可任意添加你需要的字符
		if($length<4){$length=4;}
		$length-=3;
		$chars = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789!@#$%^&*()-_ []{}<>~`+=,.;:/?|';
		$chars2 = '0123456789';
		$chars3 = '!@#$%^&*()-_[]{}<>~`+=,.;:/?|';
		$chars4 = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
		$password = '';
		for ( $i = 0; $i < $length; $i++ )
		{
			// 这里提供两种字符获取方式
			// 第一种是使用 substr 截取$chars中的任意一位字符；
			// 第二种是取字符数组 $chars 的任意元素
			// $password .= substr($chars, mt_rand(0, strlen($chars) - 1), 1);
			$password .= $chars[ mt_rand(0, strlen($chars) - 1) ];
		}
		$password .= $chars2[ mt_rand(0, strlen($chars2) - 1) ];
		$password .= $chars3[ mt_rand(0, strlen($chars3) - 1) ];
		$password .= $chars4[ mt_rand(0, strlen($chars4) - 1) ];
		return str_shuffle($password);
	}
	function Saltmd5($pass,$salt)
	{
    	$result = trim($pass);
    	$result = strrev($result);
    	$result = hash('haval256,5',$result);
    	//     	$result = $salt.hash('tiger192,4',$result);
    	//     	$result = hash('whirlpool',$result);
    	//     	$result = strtoupper($result).strrev($pass);
    	//     	$result = hash('gost',$result);
    	//     	$result = $salt.strrev($result);
    	$result = strrev($salt).hash('snefru',$result);
    	$result = hash('sha512',$result);
    	$result = md5($result.$salt);
    	return $result;
	}

}
?>