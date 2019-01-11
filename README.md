# DIB.GG 接口SDK封装
SDK for DIB-An open, reliable and decentralized gaming-items platform

## Usage

基本使用:

```php
<?php

use dib\DIB;;

//用户accesstoken
$ak='dfsfdfg2332';

$dib=new DIB($ak);

//获取某用户名下装备信息,$steamuid要索要人的steamuid
$steamuid="45646312465312";
$res=$dib->getEquips($steamuid);


//主动向某用户索取装备
//items:要索要的装备信息，键为E开头,数字前两位为装备大类 之后两位为装备小类，最后两位是装备等级,值为装备的数量
//flag_code:订单标识码，当订单成功或失败，用于回调验证
$items=[
    "E030603"=>1,
    "E030602"=>2
    ];
$flag_code=46335321;
$res=$dib->demandEquips($steamuid,$items,$flag_code);


//获取某用户名下装备信息
$res=$dib->presentEquips($steamuid,$items,$flag_code);

```

更多请参考 [https://github.com/DIBGG/dib/wiki](https://github.com/DIBGG/dib/wiki)。
