<h1 align="center"> easyip </h1>

<p align="center"> IP SDK.</p>

![StyleCI build status](https://github.styleci.io/repos/181667367/shield) 


## 安装

```shell
$ composer require yzh52521/easyip -vvv
```

## 介绍
目前支持 5 家平台  
* 腾讯 [Tencent](https://lbs.qq.com/webservice_v1/guide-ip.html)
* 淘宝 [Taobao](http://ip.taobao.com/)
* 百度 [Baidu](http://lbsyun.baidu.com/index.php?title=webapi/ip-api)
* 聚合 [Juhe](https://www.juhe.cn/docs/api/id/1)
* 高德 [Amap](https://lbs.amap.com/api/webservice/guide/api/ipconfig)

## 使用

```php
$config = [
    'provider' => 'tencent',
    'tencent' => [
        'key' => '',
    ],
    
    ...
    ...
    ...
];

$ip = new \yzh52521\easyIp\EasyIp($config);

$result = $ip->parse('');
```

进入 config/easyip.php
```php
return [
    'provider' => 'tencent',


    'tencent' => [
        'key' => '',
    ],
    
    ...
    ...
    ...
]
```

在think6中使用
```bash
app('EasyIp')->parse('')

...
...
```

数据返回格式
```
# 如果想要 api 原生格式，在 config/easyip.php 中，把 format 改为 false

[
     "provider" => "Tencent",
     "ip" => "",
     "postcode" => 440300,
     "country" => "中国",
     "province" => "广东省",
     "city" => "深圳市",
     "district" => "南山区",
     "implode" => "中国广东省深圳市南山区",
     "location" => [
       "latitude" => 22.55329,
       "longitude" => 113.88308,
     ],
]
```

## License

MIT
