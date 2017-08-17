<?php
namespace app\index\validate;
use think\Validate;
class Register extends Validate
{
    protected $rule = [
        'username|用户名'=>'require|max:15|chsAlphaNum',
        'password|密码'=>'require|confirm|length:8,15',
        'password_confirm|确认密码项'=>'require|confirm',
        'email|邮箱'=>'require|email',
    ];
    protected $message = [
        'password.confirm' => '两次输入的密码不相同!',
        'password.length' => '密码长度在不能小于八位!',
        'email.email'=>'请输入正确的邮箱格式',
        'username.max'=>'用户名长度超出范围',
    ];
}