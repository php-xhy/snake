<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/16
 * Time: 16:33
 */

namespace app\api\controller;


use think\Controller;

class Time extends Controller
{
   public function  index(){
     return show(1,'ok',time());
   }




}