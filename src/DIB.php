<?php

namespace dib;
class DIB
{
    public $prefix = 'https://gg.com/index.php/v1/';
    private $AK;

    public function __construct($AK)
    {
        $this->AK = $AK;
        return $this;
    }

    /*
     * 获取装备分类
     * */
    public function get_info()
    {
        $url = 'get_info';
        $time = time();
        $trade_info = [
            'sign' => $this->_sign([], $time),
            'time' => $time
        ];
        return $this->_get_url($this->prefix . $url, $trade_info);
    }

    /*
     * 获取某用户名下装备信息
     * */
    public function get_account($steamuid)
    {
        $url = 'get_account';
        $time = time();
        $trade_info = [
            'steamuid' => $steamuid,
            'sign' => $this->_sign([], $time),
            'time' => $time
        ];
        return $this->_get_url($this->prefix . $url, $trade_info);
    }

    /*
     * 向某人索要装备
     * */
    public function push_transaction($from, $to, array $items)
    {
        $url = 'push_transaction';
        $time = time();
        $trade_info = [
            'from' => $from,
            'to' => $to,
            'items' => $items,
            'sign' => $this->_sign($items, $time),
            'time' => $time,
        ];
        return $this->_post_url($this->prefix . $url, $trade_info);
    }

    /*
     * 查询状态
     * */
    public function get_status($order_no)
    {
        $url = 'get_status';
        $time = time();
        $trade_info = [
            'sign' => $this->_sign([], $time),
            'time' => $time,
            'order_no' => $order_no
        ];
        return $this->_post_url($this->prefix . $url, $trade_info);
    }

    /*
     * 请求
     * */
    private function _get_url($url, $trade_info)
    {
        return $this->_curl($url, json_encode($trade_info), 1);
    }

    private function _post_url($url, $trade_info)
    {
        return $this->_curl($url, json_encode($trade_info), 1);
    }

    private function _curl($url, $params = false, $ispost = 0)
    {
        echo $params;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization:' . $this->AK]);
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

    /*
     * sign
     * */
    private function _sign($items, $time)
    {
        $string = '';
        foreach ($items as $key => $value) {
            foreach ($value as $k => $vv) {
                $string .= $k . ':' . $vv;
            }
        }
        return md5($string . $this->AK . $time);
    }
}