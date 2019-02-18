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


//1、返回包含所有项目详细信息和供应信息的列表
$res=$dib->getItemsInfo();


//2、返回给定steam用户的dib wallet帐户
$steamuid="45646312465312";
$res=$dib->getAccountBySteamUID($steamuid);


//3、返回给定用户的项目余额
$account="45646312465312";
$res=$dib->getBalance($account);


//3、发送已签名的交易，向用户发送项目或从其他人提取项目
$action="transfer";
$from="0x88d60210d5c690d7191957246706d1658157340e";
$to="0x88d60210d5c690d7191957246706d1658157340f";
$item_code= ["E020401","E030304"];
$item_value= [1,2];
$privateKey='0x61c5c7cef76f518ef75a7e40549d9efdf42fb627be0d2dad3836b43e7e784552';
$res=$dib->sendRawTransaction($action,$from,$to,$item_code,$item_value,$privateKey);


//4、查询交易状态
$hash='0x88df016429689c079f3b2f6ad39fa052532c56795b733da78a91ebe6a713944b';
$res=$dib->getTransactionByHash($hash);

//5、取消交易
$hash='0x88df016429689c079f3b2f6ad39fa052532c56795b733da78a91ebe6a713944b';
$res=$dib->cancelTransaction($hash);

```
更多请参考 [https://github.com/DIBGG/dib/wiki](https://github.com/DIBGG/dib/wiki)。