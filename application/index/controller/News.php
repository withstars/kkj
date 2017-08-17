<?php
/**
 * Created by PhpStorm.
 * User: 君行天下
 * Date: 2017/8/15
 * Time: 15:20
 */

namespace app\index\controller;
use think\Controller;
use think\Db;

class News extends Controller
{
    public function index()
    {
        $newsid=input('id');
        $news=Db::name('kkj_news')->where('id',$newsid)->find();
        $catename=Db::name('kkj_cate')->where('id',$news['cateid'])->column('catename');
        $comment_count=Db::name('kkj_comment')->where('news_id',$newsid)->count();
        $comments=Db::name('kkj_comment')->where('news_id',$newsid)->order('support desc')->limit(5)->select();
        $this->assign('comments',$comments);
        $this->assign('comment_count',$comment_count);
        $this->assign('catename',$catename);
        $this->assign('news',$news);
        return $this->fetch('index');
    }
}