<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2019/8/8
 * Time: 18:12
 */

namespace app\index\validate;


use think\Validate;

class IndexValidate extends Validate
{
    protected $rule = [
        'userName' => 'require|alphaDash',
        'password' => 'require|min:11|alphaDash',
        'code'     => 'require',
    ];

    protected $message = [
        'userName.require' => '用户名不能为空',
        'password.require' => '密码不能为空',
        'code.require'     => '验证码不能为空',
    ];
}