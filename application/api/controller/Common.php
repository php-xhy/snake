<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/13
 * Time: 17:59
 */

namespace app\api\controller;


use app\common\lib\exception\ApiException;
use think\Controller;
use app\common\lib\Aes;
use app\common\lib\IAuth;
use app\common\lib\Time;
use think\Cache;


/**
 * API模块 公共的控制器
 * Class Common
 * @package app\api\controller
 */
class Common extends Controller
{

    /**
     * headers信息
     * @var string
     */
    public $headers = "";

    public $page = 1;
    public $size = 10;
    public $from = 0;

    /**
     * 初始化
     */
    public function _initialize(){
    $this->checkRequestAuth();
    //$this->setAes();
    }

    /**
     * 检查每次app请求的数据是否合法
     */
    public function checkRequestAuth(){

        // 首先需要获取headers
     $request = request()->header();
        // todo

        // sign 加密需要 客户端工程师 ， 解密：服务端工程师
        // 1 headers body 仿照sign 做参数的加解密
        // 2
        //  3
        // 基础参数校验
         if(empty($request['sign'])){
             throw new ApiException('sign不存在',400);
         }

         if(!in_array($request['apptype'],config('app.apptypes'))){
             throw new ApiException('app_type不合法',400);
         }
        // 需要sign
        if(!IAuth::checkSignPass($request)) {
            throw new ApiException('授权码sign失败', 401);
        }

        Cache::set($request['sign'], 1, config('app.app_sign_cache_time'));

        // 1、文件  2、mysql 3、redis
        $this->headers = $request;

    }

     public function setAes(){
         //加密
         //$str = "id=1&name=xiaosu&ms=45";
         //echo (new Aes())->encrypt($str); exit();
         //解密
         //$str = "0cInAwqoUDfkLi4gTvbRRvI6zpqoUb/aTSku3IhbDEE=";
         //echo (new Aes())->decrypt($str);

         $data = [
             'id'=>1,
             'name'=>'xiaosu',
             'ms'=>'45',
              'time'=>Time::get13TimeStamp()
         ];
        echo  IAuth::setSign($data);
     }

    /**
     * 获取处理的新闻的内容数据
     * @param array $news
     * @return array
     */
    protected  function getDealNews($news = []) {
        if(empty($news)) {
            return [];
        }
        $cats = config('cat.lists');


//       $cats= Array
//        [1] => 综艺
//        [2] => 明星
//        [3] => 韩娱
//        [4] => 看点
        foreach($news as $key => $new) {

            $news[$key]['catname'] = $cats[$new['catid']] ? $cats[$new['catid']] : '-';
        }
        return $news;
    }

    /**
     * 获取分页page size 内容
     */
    public function getPageAndSize($data) {
        $this->page = !empty($data['page']) ? $data['page'] : 1;
        $this->size = !empty($data['size']) ? $data['size'] : config('paginate.list_rows');
        $this->from = ($this->page - 1) * $this->size;
    }


}