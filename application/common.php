<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006-2016 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: 流年 <liu21st@gmail.com>
// +----------------------------------------------------------------------

// 应用公共文件

/**
 * 发送加密URL请求
 * @param $post_arr
 * @param string $requestUrl
 * @return mixed|type
 */
function requireUrl($post_arr, $requestUrl = '',$pub ,$token){

    //转成json
    $str2 = json_encode($post_arr);
    //加密
    $str = sodium_crypto_box_seal($str2, base64_decode($pub));
    //设置header头 传输token令牌
    $headers = [
        "token:".$token
    ];
    //发送请求
    $dat = cUrlGetData($requestUrl, $str, $headers);
    //json转码
    $dat = json_decode($dat);

    return $dat;
}

/**
 * Curl发送函数
 * @param string $url
 * @param string|array $post_fields
 * @param array $headers
 * @return type
 */
function cUrlGetData($url, $post_fields = null, $headers = null) {
    $ch = curl_init();
    $timeout = 5;
    curl_setopt($ch, CURLOPT_URL, $url);
    if ($post_fields && !empty($post_fields)) {
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $post_fields);
    }
    if ($headers && !empty($headers)) {
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
    }
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
    curl_setopt($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $data = curl_exec($ch);
    /*if (curl_errno($ch)) {
        echo 'Error:' . curl_error($ch);
    }*/
    curl_close($ch);
    return $data;
}

/**
 * redis 初始化连接
 * @return bool|Redis
 */
function redisInit(){
    try{
        $redis = new \Redis();
        //php客户端设置的ip及端口
        $redis->connect(config('Redis.REDIS_HOST'), config('Redis.REDIS_PORT'));
        $redis->auth(config('Redis.REDIS_AUTH')); //设置密码
        if ($redis){
            return $redis;
        }else{
            exception('连接redis失败');
        }
    } catch (Exception $e) {
        return false;
    }

}

/**判断$str中是否存在$needle
 * @param $str
 * @param $needle
 * @return bool
 */
function checkstr($str,$needle){
    $tmparray = explode($needle,$str);
    if(count($tmparray)>1){
        return true;
    } else{
        return false;
    }
}

/**
 * @param $a
 * @return mixed
 * 数字字符串排序
 */
function strsort($a){
    for($i=0;$i>-1;$i++){
        if(@$a[$i] == null) break;
        for($k=0;$k>-1;$k++){
            if(@$a[$k] == null) break;
            if($a[$i] < $a[$k]){
                $c = $a[$i];
                $a[$i] = $a[$k];
                $a[$k] = $c;
            }
        }
    }
    return $a;
}

/**
 * php过滤字符串中重复的字符（包含中文）
 * @param $string
 * @return string
 */
function mb_str_split( $string ) {
    return implode('', array_unique(preg_split('/(?<!^)(?!$)/u', $string )));
}

/**
 * 通过IP接口获取IP地理位置
 * @param string $ip
 * @return: string
 **/
function getCityCurl($ip)
{
    $url="http://ip.taobao.com/service/getIpInfo.php?ip=".$ip;
    $ch = curl_init();
    $timeout = 5;
    curl_setopt ($ch, CURLOPT_URL, $url);
    curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt ($ch, CURLOPT_CONNECTTIMEOUT, $timeout);
    $file_contents = curl_exec($ch);
    curl_close($ch);
    $ipinfo=json_decode($file_contents);
    if($ipinfo->code=='1'){
        return false;
    }
    $city = $ipinfo->data->region.$ipinfo->data->city;
    return $city;
}
/**
 * 通用化API接口数据输出
 * @param int $status 业务状态码
 * @param string $message 信息提示
 * @param [] $data  数据
 * @param int $httpCode http状态码
 * @return array
 */
function show($status, $message, $data=[], $httpCode=200) {

    $data = [
        'status' => $status,
        'message' => $message,
        'data' => $data,
    ];

    return json($data, $httpCode);
}
