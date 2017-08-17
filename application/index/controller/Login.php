<?php
/**
 * Created by PhpStorm.
 * User: 君行天下
 * Date: 2017/8/17
 * Time: 17:39
 */

namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Loader;
use think\Request;
use think\Response;
use think\Session;

class Login extends Controller
{
    //进入登陆页面和登陆处理
    public function index()
    {
        if($this->request->isPost()){
            $username=input('username');
            $password=input('password');
            $sql="select username,id from kkj_users where username = ? and password = ? ";
            $res=Db::query($sql,[$username,sha1($password)]);

            if($res!=null){
                $this->success('登陆成功','index/index');
                Session::set('userid',$res['id']);
                Session::set('username',$res['username']);
            }else{
                $this->error('用户名或密码错误');
            }
        }
        return $this->fetch('index');
    }
    //进入注册页面和注册处理
    public function register()
    {
        if($this->request->isPost()){
            $username=input('username');
            $passwd=input('passwd');
            $repasswd=input('repasswd');
            $email=input('email');
            //要验证的数据
            $checkdata=['username' => $username, 'password' => $passwd,'password_confirm'=>$repasswd,'email'=>$email];
            $validate=Loader::validate('Register');
            if($validate->check($checkdata)){
                //要插入的数据
                $data = ['username' => $username, 'password' => sha1($passwd),'email'=>$email,'register_time'=>date("Y-m-d H:i:s",time())];
                $res=Db::name('kkj_users')->insert($data);
                if($res==1){
                    $this->success('注册成功，请登录','login/index');
                }else{
                    $this->error('注册失败，请重试','login/index');
                }
            }else{
                return $this->error($validate->getError());
            }
        }
        return $this->fetch('register');
    }
    //注册页面主体，包含在register中
    public function reg()
    {
        return $this->fetch('reg');
    }


}