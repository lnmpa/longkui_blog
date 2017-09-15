<?php 
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2017 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Dean <zxxjjforever@163.com>
// +----------------------------------------------------------------------
return [
    'appid'     => [// 在后台插件配置表单中的键名 ,会是config[text]
        'title' => 'appid', // 表单的label标题
        'type'  => 'text',// 表单的类型：text,password,textarea,checkbox,radio,select等
        'value' => '',// 表单的默认值
        'tip'   => '绑定支付的appid（必须配置，开户邮件中可查看）' //表单的帮助提示
    ],
    'mch_id'     => [// 在后台插件配置表单中的键名 ,会是config[text]
        'title' => 'mch_id', // 表单的label标题
        'type'  => 'text',// 表单的类型：text,password,textarea,checkbox,radio,select等
        'value' => '',// 表单的默认值
        'tip'   => '商户号（必须配置，开户邮件中可查看）' //表单的帮助提示
    ],
     'partnerkey'     => [// 在后台插件配置表单中的键名 ,会是config[text]
        'title' => 'partnerkey', // 表单的label标题
        'type'  => 'text',// 表单的类型：text,password,textarea,checkbox,radio,select等
        'value' => '',// 表单的默认值
        'tip'   => '商户支付密钥，参考开户邮件设置（必须配置，登录商户平台自行设置）设置地址：<a href="https://pay.weixin.qq.com/index.php/account/api_cert" target="_blank">设置</a>' //表单的帮助提示
    ],
    'appsecret'     => [// 在后台插件配置表单中的键名 ,会是config[text]
        'title' => 'appsecret', // 表单的label标题
        'type'  => 'text',// 表单的类型：text,password,textarea,checkbox,radio,select等
        'value' => '',// 表单的默认值
        'tip'   => '公众帐号secert（仅JSAPI支付的时候需要配置,登录公众平台，进入开发者中心可设置）获取地址：<a href="https://mp.weixin.qq.com/advanced/advanced?action=dev&t=advanced/dev&token=2005451881&lang=zh_CN" target="_blank">前往</a>' 
    ],
    
];
					