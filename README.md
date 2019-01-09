# DIB.GG 接口SDK封装
SDK for DIB-An open, reliable and decentralized gaming-items platform

## Usage

基本使用（以服务端为例）:

```php
<?php

use dib\DIB;;

//用户accesstoken
$ak='dfsfdfg2332';

$dib=new DIB($ak);

//获取某用户名下装备信息,$steamuid要索要人的steamuid
$steamuid="45646312465312";
$dib->getEquips($steamuid);

```

更多请参考 [https://github.com/eschain/dib.gg/wiki/](https://github.com/eschain/dib.gg/wiki/%E7%AC%AC%E4%B8%89%E6%96%B9%E6%8E%A5%E5%8F%A3%E8%AF%B4%E6%98%8E)。