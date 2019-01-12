# DICB接口SDK封装
SDK for DIB-An open, reliable and decentralized gaming-items platform

## Usage

基本使用:

```php
<?php
use dib\DIB;;

//用户ak
$ak='dfsfdfg2332';

$dib=new DIB($ak);


//1、获取分类等级信息
$res=$dib->get_info();


//2、获取用户资产信息
$steamuid="45646312465312";
$res=$dib->get_account($steamuid);


//3、发起一笔交易
//items:要索要的装备信息，键为E开头,数字前两位为装备大类 之后两位为装备小类，最后两位是装备等级,值为装备的数量
$items=[
    "E030603"=>1,
    "E030602"=>2
    ];
$from=546532134853;
$to=546532134853;
$res=$dib->push_transaction($from,$to,$items);


//4、查询交易状态
$order_no=2313565633115;
$res=$dib->get_status($order_no);

```
更多请参考 [https://github.com/DIBGG/dib/wiki](https://github.com/DIBGG/dib/wiki)。