<?php
namespace Home\Controller;
use Think\Controller;

class NewsController extends Controller{

    public function news(){
        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);
        $lanmu_id=I('get.lid');
        //判断是否传子栏目过来，如果传过来就查出该栏目的新闻，否则查出全部新闻（不分类）
        if($lanmu_id){
            $_SESSION['lanmu_id']=$lanmu_id;
        }
        else{
            $_SESSION['lanmu_id']='';
        }
       /* $news=D('news');
        $lanmu_id=I('get.lid');
        //判断是否传子栏目过来，如果传过来就查出该栏目的新闻，否则查出全部新闻（不分类）
        if($lanmu_id){
            $where['lanmu_id']=$lanmu_id;
            $newsList=$news->where($where)->field('news_id,title,pulish_time,lanmu_id')->order(array('pulish_time'=>'desc'))->limit(8)->select();
            //把该新闻所属栏目名称查出来
            $cName= $column->where($where)->field('name')->select();
            $this->assign('columnName',$cName[0]['name']);

        }else{
            $newsList=$news->field('news_id,title,pulish_time,lanmu_id')->order(array('pulish_time'=>'desc'))->limit(8)->select();
            $this->assign('columnName','公司新闻');
        }
        $this->assign('newsList',$newsList);*/

        $this->display('index');
    }

    public function ajaxNewList($lanmu_id=''){
        $news=D('news');
        $lanmu_id=$_SESSION['lanmu_id'];
//        $lanmu_id=I('request.lid');
        //判断是否传子栏目过来，如果传过来就查出该栏目的新闻，否则查出全部新闻（不分类）
        if($lanmu_id){
            $where['lanmu_id']=$lanmu_id;
            $per=6;
            $totle=$news->where($where)->count();
            $page_obj=new \Think\AjaxPage($totle,$per);
            $pageList=$page_obj->show();
            $newsList= $news->where($where)->order(array('pulish_time'=>'desc'))->field('news_id,title,pulish_time,lanmu_id')->limit($page_obj->firstRow.','.$page_obj->listRows)->select();
            $column = D('column');
            $cName= $column->where($where)->field('name')->select();
            $this->assign('columnName',$cName[0]['name']);
        }else{
//            $newsList=$news->field('news_id,title,pulish_time,lanmu_id')->order(array('pulish_time'=>'desc'))->limit(8)->select();
            $per=6;
            $totle=$news->count();
            $page_obj=new \Think\AjaxPage($totle,$per);
            $pageList=$page_obj->show();
            $newsList= $news->order(array('pulish_time'=>'desc'))->field('news_id,title,pulish_time,lanmu_id')->limit($page_obj->firstRow.','.$page_obj->listRows)->select();
            $this->assign('pageList',$pageList);
            $this->assign('columnName','新闻动态');
        }

        $this->assign('pageList',$pageList);
        $this->assign('newList',$newsList);

        $this->display();
    }


    public function detailNew(){
        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);

        $where['news_id']=I('get.nid');
        $newInfo=D('news');
        $rs=$newInfo->where($where)->select();
        $clicked=$rs[0]['clicked']+1;
        $newInfo->where($where)->save(array('clicked'=>$clicked));
        $lanmu_id=$rs[0]['lanmu_id'];
        //把该新闻所属栏目名称查出来
        $cName= $column->where(array('lanmu_id'=>$lanmu_id))->field('name')->select();
        $this->assign('columnName',$cName);
        $this->assign('newInfo',$rs);
        $this->display('detailNew');
    }
}