<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Response;


class Index extends Controller
{
    //进入主页
    public function index()
    {
        $sql="select count(b.id) pls,a.id wzid,title,admin,a.time fbsj,stick,desci from kkj_news a LEFT JOIN kkj_comment b on a.id=b.news_id GROUP by a.id ORDER BY a.time desc limit 1;";
        $res=Db::query($sql);
        $sql_lunbo="select id,title from kkj_news where lunbo = 1 ";
        $lunbo=Db::query($sql_lunbo);
        $lunbo_count=Db::name('kkj_news')->where('lunbo',1)->count();
        $this->assign('lunbocount',$lunbo_count);
        $this->assign('lunbo',$lunbo);
        $this->assign('newses',$res);
        return $this->fetch('index');
    }
    //首页每个栏目下的文章
    public function cate()
    {
        $cateid=input('id');
        $sql="select count(b.id) pls,a.id wzid,title,admin,a.time fbsj,stick from kkj_news a,kkj_comment b where a.id=b.news_id and cateid = ? GROUP by a.id ORDER BY a.time desc limit 1; ";
        $res=Db::query($sql,[$cateid]);
        $sql_lunbo="select id,title from kkj_news where lunbo = 1 ";
        $lunbo=Db::query($sql_lunbo);
        $lunbo_count=Db::name('kkj_news')->where('lunbo',1)->count();
        $this->assign('lunbocount',$lunbo_count);
        $this->assign('lunbo',$lunbo);
        $this->assign('newses',$res);
        return $this->fetch('index');
    }

    //加载更多文章通过ajax传回主页
    public function getmore(Request $request,Response $response){
        if($request->isAjax()){
            $req=$request->param();
            $lasttime=Db::table('kkj_news')->where('id',$req['id'])->value('time');
            $sql="select count(b.id) pls,a.id wzid,title,admin,a.time fbsj,stick,desci from kkj_news a LEFT JOIN kkj_comment b on a.id=b.news_id where a.time< ? GROUP by a.id ORDER BY a.time desc limit 1;";
            $res=Db::query($sql,[$lasttime]);
            $data='';
            foreach ($res as  $vo){
            $data.="<li data-id='".$vo['wzid']."'>
            <span class='newstnopic'>
                <a href='/index/news/index/id/".$vo['wzid']."html'>".$vo['title']."</a>
            </span>
            <span class='newsimg1'><a href='/index/news/index/id/".$vo['wzid']."html'>"."<img src=''><img src='' ><img src='' ></a></span>
            <span class='newsTips'> 
                <ul>
                    <li class='tname'>".$vo['admin']."｜</li>
                    <li class='ttime'>".
                        $vo['fbsj']."
                </li>
                    <li style='float:right;'>
                        <div class='tpinglun'><a href='/index/news/index/id/'".$vo['wzid']."html'>".$vo['pls']."</a></div>
                    </li>
                </ul>
            </span>
        </li>";

            }
            $response->contentType('text/plain;charset=UTF-8');
            $response->data($data);
            $response->send();
        }
    }







}
