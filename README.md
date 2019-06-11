# DIB PHP SDK
SDK for DIB-An open, reliable and decentralized gaming-items platform

## Usage

Basic Usage

```php
<?php
use dib\DIB;;

//user access key
$ak='dfsfdfg2332';

$dib=new DIB($ak);


//1、get all items detail info
$res=$dib->getItemsInfo();


//2、get dib wallet address by user steam openid
$steamuid="45646312465312";
$res=$dib->getAccountBySteamUID($steamuid);


//3、get user balance by wallet address
$address="0x25af22cddf09beaaa0d7a932e2702475d936754c";
$res=$dib->getBalance($address);


//4、send transaction
$action="transfer";
$from="0x88d60210d5c690d7191957246706d1658157340e";
$to="0x88d60210d5c690d7191957246706d1658157340e";
$item_code= ["E020401","E030304"];
$item_value= ["1","2"];
$privateKey='0x61c5c7cef76f518ef75a7e40549d9efdf42fb627be0d2dad3836b43e7e784552';
$res=$dib->sendRawTransaction($action,$from,$to,$item_code,$item_value,$privateKey);


//5、check transaction status
$hash='0x88df016429689c079f3b2f6ad39fa052532c56795b733da78a91ebe6a713944b';
$res=$dib->getTransactionByHash($hash);


```
more info [https://github.com/DIBGG/dib/wiki](https://github.com/DIBGG/dib/wiki)。
