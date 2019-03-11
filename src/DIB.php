<?php

namespace dib;
require_once("../vendor/autoload.php");

use Web3p\RLP\RLP;
use Elliptic\EC;
use kornrunner\Keccak;

class DIB
{
    public $prefix = 'https://api.dib.sg/v1/';
    private $AccessKey;

    public function __construct($AccessKey)
    {
        $this->AccessKey = $AccessKey;
        return $this;
    }

    /*
     * 获取装备分类
     * */
    public function getItemsInfo()
    {
        return $this->_post_url('getItemTypes', []);
    }

    /*
     * 获取某用户名下装备信息
     * */
    public function getBalance($account)
    {
        return $this->_post_url('getBalance', $account);
    }

    /*
     * 获取某用户名下装备信息
     * */
    public function getAccountBySteamUID($account)
    {
        return $this->_post_url('getAccountBySteamUID', $account);
    }

    /*
     * 向某人索要装备
     * */
    public function sendRawTransaction($action, $from, $to, $item_code, $item_value, $privateKey, $nonce = null)
    {
        $actionData = [
            'action' => $action,
            'from' => $from,
            'to' => $to,
            'item_code' => $item_code,
            'item_value' => $item_value
        ];
        $rlp = new RLP;
        $actionDataHash = $rlp->encode($actionData)->toString("hex");
        $txData = [
            "nonce" => $nonce ?: ("0x" . dechex(intval(microtime(1) * 1000) + rand(10, 99))),
            "to" => "dib.contract", //fixed value
            "data" => "0x" . $actionDataHash
        ];
        $txDataEncode = $rlp->encode($txData)->toString("hex");
        $ec = new EC('secp256k1');
        $key = $ec->keyFromPrivate($privateKey);
        $txDataHash = Keccak::hash($txDataEncode, 256);
        $signature = $key->sign($txDataHash);
        $txData["v"] = "0x" . dechex($signature->recoveryParam);
        $txData["r"] = "0x" . $signature->r->toString("hex");
        $txData["s"] = "0x" . $signature->s->toString("hex");
        $rawTx = "0x" . $rlp->encode($txData)->toString("hex");
        return $this->_post_url('sendRawTransaction', $rawTx);
    }

    /*
     * 查询状态
     * */
    public function getTransactionByHash($hash)
    {
        return $this->_post_url('getTransactionByHash', $hash);
    }

    /*
     * 取消交易
     * */
    public function cancelTransaction($hash)
    {
        return $this->_post_url('cancelTransaction', $hash);
    }

    /*
     * 请求
     * */
    private function _post_url($method, $params)
    {
        $data = [
            'jsonrpc' => '2.0',
            'method' => $method,
            'params' => (array)$params,
            'id' => time()
        ];
        return $this->_curl($this->prefix, json_encode($data), 1);
    }

    private function _curl($url, $params = false, $ispost = 0)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:' . $this->AccessKey]);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
        if ($ispost) {
            curl_setopt($ch, CURLOPT_POST, true);
            curl_setopt($ch, CURLOPT_POSTFIELDS, $params);
            curl_setopt($ch, CURLOPT_URL, $url);
        } else {
            if ($params) {
                if (is_array($params)) {
                    $params = http_build_query($params);
                }
                curl_setopt($ch, CURLOPT_URL, $url . '?' . $params);
            } else {
                curl_setopt($ch, CURLOPT_URL, $url);
            }
        }
        $response = curl_exec($ch);
        curl_close($ch);
        $response = $response ? json_decode($response, 1) : [];
        return $response;
    }

}
