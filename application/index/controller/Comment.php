<?php
/**
 * Created by PhpStorm.
 * User: 君行天下
 * Date: 2017/8/15
 * Time: 17:52
 */

namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Response;
class Comment extends Controller
{
    //最新评论页面
    public function index(){
        $news_id=input('id');
        $comments=Db::name('kkj_comment')->where('news_id',$news_id)->order('time desc')->select();
        $news=Db::name('kkj_news')->where('id',$news_id)->find();
        $catename=Db::name('kkj_cate')->where('id',$news['cateid'])->column('catename');
        $this->assign('style',1);
        $this->assign('catename',$catename);
        $this->assign('news',$news);
        $this->assign('comments',$comments);
        return $this->fetch('index');
    }

    //最热评论页面
    public function hot(){
        $news_id=input('id');
        $comments=Db::name('kkj_comment')->where('news_id',$news_id)->order('support desc')->select();
        $news=Db::name('kkj_news')->where('id',$news_id)->find();
        $catename=Db::name('kkj_cate')->where('id',$news['cateid'])->column('catename');
        $this->assign('style',2);
        $this->assign('catename',$catename);
        $this->assign('news',$news);
        $this->assign('comments',$comments);
        return $this->fetch('index');
    }
    //我的评论
    public function me(){

    }

    //评论赞，反对 通过前台ajax提交
    public function attitude(Request $request,Response $response){
        $req=$request->param();
        $userid=$req['userid'];
        $commentid=$req['commentid'];
        $attitude=$req['attitude'];
        $response->contentType('text/plain;charset=UTF-8');

        $response->data($commentid);
        $response->send();


    }





}