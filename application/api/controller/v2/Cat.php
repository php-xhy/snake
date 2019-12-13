<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/13
 * Time: 17:59
 */

namespace app\api\controller\v2;

use app\api\controller\Common;
use app\common\lib\exception\ApiException;
use app\common\lib\Aes;



/**
 *
 */
class Cat extends Common
{
  public function  read(){
      $cats = config('cat.lists');

      $result[]=[
         'catid'=>0,
          'catname'=>'首页',
      ];

      foreach ($cats as $catid=>$catname){
          $result[]=[
              'catid'=>$catid,
              'catname'=>$catname,
          ];
      }

       return show(1,'ok',$result,200);
  }



}