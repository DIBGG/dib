<?php

namespace dib;
class DIB
{
    public $prefix = 'https://api.dib.gg/v1';
    private $AK;

    public function __construct($AK)
    {
        $this->AK = $AK;
        return $this;
    }

    /*
     * 获取某用户名下装备信息
     * */
    public function getEquips($steamuid)
    {
        $url = '/equips/info';
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
    public function demandEquips(string $steamuid, array $items, $flag_code)
    {
        $url = '/equips/demand';
        $time = time();
        $trade_info = [
            'steamuid' => $steamuid,
            'items' => $items,
            'sign' => $this->_sign($items, $time),
            'time' => $time,
            'flag_code' => $flag_code
        ];
        return $this->_post_url($this->prefix . $url, $trade_info);
    }

    /*
     * 向某用户赠送装备
     * */
    public function presentEquips(string $steamuid, array $items, $flag_code)
    {
        $url = '/equips/demand';
        $time = time();
        $trade_info = [
            'steamuid' => $steamuid,
            'items' => $items,
            'sign' => $this->_sign($items, $time),
            'time' => $time,
            'flag_code' => $flag_code
        ];
        return $this->_post_url($this->prefix . $url, $trade_info);
    }

    /*
     * 请求
     * */
    private function _get_url($url, $trade_info)
    {
        return $this->_curl($url, ['trade_info' => json_encode($trade_info)]);
    }

    private function _post_url($url, $trade_info)
    {
        return $this->_curl($url, ['trade_info' => json_encode($trade_info)], 1);
    }

    private function _curl($url, $params = false, $ispost = 0)
    {
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
