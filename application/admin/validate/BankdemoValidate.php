<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/3/13
 * Time: 11:23
 */

namespace app\admin\validate;
use think\Validate;

class BankdemoValidate extends Validate
{
    protected $rule = [
        'test1' => 'require|alphaDash|min:11',
        'test2' => 'require|alphaDash',
        'test3' => 'require',
        'test4' => 'require',
        'test5' => 'require',
        'test6' => 'require|max:1|between:1,2' //规定长度不能超过1且取值范围在1和2之间
    ];
    protected $message = [
        'test1.require' => 'test1不能为空',
        'test2.require' => 'test2不能为空',
        'test3.require' => 'test3不能为空',
        'test4.require' => 'test4不能为空',
        'test5.require' => 'test5不能为空',
        'test6.require' => 'test6不能为空',
    ];
}