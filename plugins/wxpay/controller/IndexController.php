<?php
namespace plugins\wxpay\controller; 
use cmf\controller\PluginBaseController;
use think\Db;
use wechat\Loader;

class IndexController extends PluginBaseController
{		
	 public $config;

	  function _initialize()
    {
       $config = Db::name("plugin")->where(array('name'=>'Wxpay'))->field('config')->find();

        $this->config =json_decode($config['config'],true);

    }
    /**
     * 订单号
     * @id string 订单号
     */
    function wxpay($id)
    {


		$code = isset($_GET['code']) ? $_GET['code'] : '';

		$oauth = & \Wechat\Loader::get('Oauth',$this->config);

        if (empty($code)) {  

        	$out_trade_no = $this->request->param("id");   //从数据库查出相关信息 

			$callback = 'http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];

			$state = urlencode($out_trade_no);

			$url = $oauth->getOauthRedirect($callback, $state);	

			if($url===FALSE){

			    return false;
			}else{
				Header("Location: $url");
				exit();
			}
		}
		
		$data = $oauth->getOauthAccessToken();

		if($data===FALSE){

		   $data = $oauth->getOauthRefreshToken($data['refresh_token']);
		}

		$pay = & \Wechat\Loader::get('pay',$this->config);
		
		$openid = $data['openid'];
		$out_trade_no = urldecode($this->request->param("state"));
		
		$body = '测试商品';

		$total_fee = round(1); //可以通过订单号到数据库取查出来

		$notify_url = cmf_plugin_url('Wxpay://Index/notify',array(),true);
		//file_put_contents('notify_url.txt', $notify_url);
		$result = $pay->getPrepayId($openid, $body, $out_trade_no, $total_fee, $notify_url, $trade_type = "JSAPI");

		if($result===FALSE){

			echo json_encode($result);

		}else{
			$options = $pay->createMchPay($result);
			$jsApiParameters = json_encode($options);
		}

        $this->assign('jsApiParameters',$jsApiParameters);

        return $this->fetch("/widget");
    }

    public function notify(){
				// 实例支付接口
				$pay = & \Wechat\Loader::get('pay',$this->config);
				// 获取支付通知
				$notifyInfo = $pay->getNotify();
				/*
				$notifyInfo = array (
				  'appid'          => 'wx3581ccf368729be3',
				  'bank_type'      => 'CFT',
				  'cash_fee'	   => '1',
				  'fee_type' 	  => 'CNY',
				  'is_subscribe'   => 'Y',
				  'mch_id'	     => '1307539701',
				  'nonce_str'      => 'api268huedasmkfgdjofzwitpuaqjl0c',
				  'openid'         => 'o9j5kw-B8ZCp_FWLBmnSkrr1qHRE',
				  'out_trade_no'   => '959947360',
				  'result_code'    => 'SUCCESS',
				  'return_code'    => 'SUCCESS',
				  'sign'           => '43C91961D389D0A9FC480BC5B13592E6',
				  'time_end'       => '20161011103317',
				  'total_fee'      => '1',
				  'trade_type'     => 'NATIVE',
				  'transaction_id' => '4008082001201610116370274372',
				)
				 */
				// 支付通知数据获取失败
				if($notifyInfo===FALSE){
					// 接口失败的处理
				    echo $pay->errMsg;
				}else{
					//file_put_contents('notifyInfo.txt', json_encode($notifyInfo));
					//支付通知数据获取成功
				     if ($notifyInfo['result_code'] == 'SUCCESS' && $notifyInfo['return_code'] == 'SUCCESS') {
				   		/*在这更新你的数据库订单状态*/
				        $pay->replyXml(['return_code' => 'SUCCESS', 'return_msg' => 'DEAL WITH SUCCESS']);
				     }
				}
			}
    }


