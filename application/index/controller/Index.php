<?php
namespace app\index\controller;
use think\Controller;
use think\Db;
use think\Request;
use think\Response;


class Index extends Controller
{
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

    public function cate()
    {
        $cateid=input('id');
        $sql="select count(b.id) pls,a.id wzid,title,admin,a.time fbsj from kkj_news a,kkj_comment b where a.id=b.news_id and cateid = ? GROUP by a.id";
        $res=Db::query($sql,[$cateid]);
        $this->assign('newses',$res);
        return $this->fetch('index');
    }


    public function getmore(Request $request,Response $response){
        if($request->isAjax()){
            $req=$request->param();
            $lasttime=Db::table('kkj_news')->where('id',$req['id'])->value('time');
            $sql="select count(b.id) pls,a.id wzid,title,admin,a.time fbsj,stick,desci from kkj_news a LEFT JOIN kkj_comment b on a.id=b.news_id where a.time< ? GROUP by a.id ORDER BY a.time desc limit 1;";
            $res=Db::query($sql,[$lasttime]);
            $data='';
            foreach ($res as  $vo)
                $data.="  <li data-id=\"\"><!--缩略图为3个或无时的列表样式-->
            <span class=\"newstnopic\">
                <a href=\"\"></a>
            </span>
            <span class=\"newsimg1\"><a href=\"\"><img src=\"\"><img src=\"\" ><img src=\"\" ></a></span>
            <span class=\"newsTips\"> <!--发布人,时间,评论数-->
                <ul>
                    <li class=\"tname\"> ｜</li>
                    <li class=\"ttime\">
                       
                    </li>
                    <li style=\"float:right;\">
                        <div class=\"tpinglun\"><a href=\"\"></a></div>
                    </li>
                </ul>
            </span>
        </li>";

            $response->contentType('text/plain;charset=UTF-8');
            $response->data($data);
            $response->send();
        }
    }


}
