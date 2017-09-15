<?php
namespace Common\Api;

/**
 * 阿里大鱼发送短信
 * 
 * @author Administrator
 *        
 */
class AlidayuApi
{

    /**
     * 发送短信
     * 
     * @param unknown $config
     *            如：
     *            $config=array(
     *            'appkey' => '23381982', //TOP分配给应用的AppKey
     *            'secretKey' => 'be286ddfff45a9b217630488ee5b7d8d',
     *            'Extend' => '123456', //可传入才参数，如用户ID
     *            'SmsType' => 'normal', //短信类型，传入值请填写normal
     *            'SmsFreeSignName'=>'阿里大鱼', // 短信签名
     *            'SmsParam' => "{\"code\":\"1234\",\"product\":\"alidayu\"}" , //短信模板变量[Json格式]
     *            'RecNum' => '13000000000', //短信接收号码。支持单个或多个手机号码.示例：18600000000,13911111111,13322222222
     *            'SmsTemplateCode'=>'SMS_10330289', //短信模板ID
     *            );
     * @return Ambigous <unknown, ResultSet, mixed>
     */
    function do_send($config)
    {
        include 'simplewind/Core/Library/Think/Alidayu/TopSdk.php';
        date_default_timezone_set('Asia/Shanghai');
        
        $c = new \TopClient();
        $c->appkey = $config['appkey'];
        $c->secretKey = $config['secretKey'];
        $req = new \AlibabaAliqinFcSmsNumSendRequest();
        $req->setExtend($config['Extend']);
        $req->setSmsType($config['SmsType']);
        $req->setSmsFreeSignName($config['SmsFreeSignName']);
        $req->setSmsParam($config['SmsParam']);
        $req->setRecNum($config['RecNum']);
        $req->setSmsTemplateCode($config['SmsTemplateCode']);
        $resp = $c->execute($req);
        
         
        
        // 转为数组
        $rel=$this->object_array($resp);
        if($rel['result']['success']!='true'){
            $rel['err_str']=$this->err_string($rel['sub_code']);
        }
        return $rel;
    }

    
    
    /**
     * 对象转数组
     * @param unknown $array  对象
     * @return array
     */
    function object_array($array)
    {
        if (is_object($array)) {
            $array = (array) $array;
        }
        if (is_array($array)) {
            foreach ($array as $key => $value) {
                $array[$key] = $this->object_array($value);
            }
        }
        return $array;
    }
    
    
    /**
     * 错误说明
     * @param unknown $msg 错误代码
     */
    function err_string($msg){
        $str='';
        switch ($msg) {
            case 'isv.OUT_OF_SERVICE':
                $str.='业务停机';
            break;
            case 'isv.PRODUCT_UNSUBSCRIBE':
                $str.='产品服务未开通';
            break;
            case 'isv.ACCOUNT_NOT_EXISTS':
                $str.='账户信息不存在';
            break;
            case 'isv.ACCOUNT_ABNORMAL':
                $str.='账户信息异常';
            break;
            case 'isv.SMS_TEMPLATE_ILLEGAL':
                $str.='模板不合法';
                break;
            case 'isv.SMS_SIGNATURE_ILLEGAL':
                $str.='签名不合法';
                break;
            case 'isv.MOBILE_NUMBER_ILLEGAL':
                $str.='手机号码格式错误';
                break;
            case 'isv.MOBILE_COUNT_OVER_LIMIT':
                $str.='手机号码数量超过限制';
            break;
            case 'isv.TEMPLATE_MISSING_PARAMETERS':
                $str.='短信模板变量缺少参数';
                break;
            case 'isv.INVALID_PARAMETERS':
                $str.='参数异常';
                break;
            case 'isv.BUSINESS_LIMIT_CONTROL':
//                 $str.='触发业务流控限制';
                $str.='发送太过平凡，或此段时间不能发送';
                break;
            case 'isv.INVALID_JSON_PARAM':
                $str.='JSON参数不合法';
            break;
            case 'isp.SYSTEM_ERROR':
                $str.='系统错误';
            break;
            case 'isv.BLACK_KEY_CONTROL_LIMIT':
                $str.='模板变量中存在黑名单关键字';
            break;
            case 'isv.PARAM_NOT_SUPPORT_URL':
                $str.='不支持url为变量';
                break;
            case 'isv.PARAM_LENGTH_LIMIT':
                $str.='变量长度受限';
                break;
            
            default:
                $str.='未知错误[ '.$msg.' ]';
            break;
        }
        
        return $str;
    }
}