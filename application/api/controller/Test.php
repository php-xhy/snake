<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/13
 * Time: 17:59
 */

namespace app\api\controller;

use app\common\lib\IAuth;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;
use think\Controller;
use ali\top\TopClient;
use ali\top\request\AlibabaAliqinFcSmsNumSendRequest;
use app\common\lib\Alidayu;

class Test extends Controller
{
    public function index(){
        return [
            'asfafsdf',
            'fghregfhfgh',
        ];
    }
    public function update($id=0){
      //echo $id;
      return input('put.');

    }

    public function dalete($id){

        return $id;
    }

    public function save(){
        /*   $data = [
            'status'=>1,
            'message'=>'ok',
            'data'=>input('post.'),
        ];
        return json($data,201);*/
        $data = input('post.');
        if($data['number']!=1){
          //exception('数据不合法');
            throw  new ApiException('数据number:'.$data['number'].'不合法',401);
        }
        return show(1000,'success',(new Aes())->encrypt(json_encode(input('post.'))),201);
    }

    /**
     * 发送短信测试场景
     */
    public function sendSms() {
        $c = new TopClient;
        $c->appkey = "24528979";
        $c->secretKey = "ec6d90dc7e93b4cc824183f71710e1ee";
        $req = new AlibabaAliqinFcSmsNumSendRequest;
        $req->setExtend("123456");
        $req->setSmsType("normal");
        $req->setSmsFreeSignName("singwa娱乐app");
        $req->setSmsParam("{\"number\":\"4567\"}");
        $req->setRecNum("18618158941");
        $req->setSmsTemplateCode("SMS_75915048");
        $resp = $c->execute($req);
        halt($resp);
    }

    public function testsend() {

        Alidayu::getInstance()->setSmsIdentify('18618158941');
    }

    ///  APP登录和web
    // web phpsessionid  , app -> token(唯一性) ，在登录状态下 所有的请求必须带token, token-》失效时间

    public function token() {
        echo IAuth::setAppLoginToken();
    }

}