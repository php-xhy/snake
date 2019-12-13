<?php
namespace app\index\controller;

use think\Controller;
use think\Db;
use think\Request;
use app\index\model\Demo;

class Index extends Controller
{

    public function index(){
        return view();
    }

    public function index2(){
         $arr = model('IndexModel')->getID(1);
        var_dump($arr);
        exit();
        $link = Db::connect('db2');
        $list = $link->name('wuxingzuohao')
            ->field('id')
            ->where('jiousha','偶偶偶偶偶')
            ->where('zhihesha','合合合合合')
            ->fetchSql(true)
            ->select();
        print_r($list);
//        echo $link->getLastSql()."<br>"; //获取执行的sql语句
        echo "<br>";

        $list2 = Db::name('demo')
             ->field('id')
             ->where('age',10)
             ->fetchSql(true)
             ->select();
        print_r($list2);
//        echo "<br>";
//        print_r(Db::table('demo')->getLastSql());
    }


    public  function my_val(){
        $data = [
            'userName' => 'jjj_11就',
            'password' => 'open123_456',
            'code'     => '111',
        ];
        $validate = validate('IndexValidate');
        if($validate->check($data)){
            echo "ok";
        }else{
            $this->error($validate->getError());
        }

    }

    public function weixin_Pay() {
        require_once APP_PATH.'common/WxpayAPI/lib/WxPay.Api.php';
        require_once APP_PATH.'common/WxpayAPI/lib/WxPay.Config.php';
        $input = new \WxPayUnifiedOrder();
        //设置商品描述
        $input->SetBody('测试商品');
        //设置订单号
        $input->SetOut_trade_no(date('YmdHis'));
        //设置订单金额(单位:分)
        $input->SetTotal_fee('1');
        //设置异步通知地址
        $input->SetNotify_url('http://shop.com/index/index/test');
        //设置交易类型
        $input->SetTrade_type('NATIVE');
        //设置商品ID
        $input->SetProduct_id('123456789');
        //调用统一下单API
        $config = new \WxPayConfig();
        $result = \WxPayApi::unifiedOrder($config,$input);
        //生成二维码图片
        $code_url = $result['code_url'];
        $img = '<img src=http://paysdk.weixin.qq.com/example/qrcode.php?data='.urlencode($code_url).'/>';

        echo $img;
        /*
        $request = request();
        $this->success('welcome', $request->root(true) . '/admin/login');*/
    }



}
