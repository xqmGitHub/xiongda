<?php
namespace Admin\Controller;
use Think\Controller;

class NewController extends Controller{
    public function newList(){
        /*$news=D('news');
        $totle=$news->count();
        $per=6;
        $page_obj=new \Tool\Page($totle,$per);
        $sql="select * from news order by pulish_time desc  ".$page_obj->limit;
        $newsList= $news->query($sql);
        $pageList=$page_obj->fpage(array(3,4,5,6,7,8));
        $this->assign('newList',$newsList);
        $this->assign('pageList',$pageList);*/


        /*$news=D('news');
        $per=6;
        $totle=$news->count();
        $page_obj=new AjaxPage($totle,$per);
        $pageList=$page_obj->show();
        $newsList= $news->order(array('pulish_time'=>'desc'))->limit($page_obj->firstRow.','.$page_obj->listRows)->select();
        $this->assign('newList',$newsList);
        $this->assign('pageList',$pageList);*/

        $this->display('newList1');
    }

    public function ajaxNewList(){
        $news=D('news');
        $per=6;
        $totle=$news->count();
        $page_obj=new \Think\AjaxPage($totle,$per);
        $pageList=$page_obj->show();
        $newsList= $news->order(array('pulish_time'=>'desc'))->limit($page_obj->firstRow.','.$page_obj->listRows)->select();
        $this->assign('newList',$newsList);
        $this->assign('pageList',$pageList);

        $this->display();
    }

    public function removeNew(){
        $id=I('post.id');
        $new=D('news');
        $rs=$new->delete($id);
        if($rs>0){
            $data=array(
                'status'=>1,
                'msg'=>'removeSuccess',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }else{
            $data=array(
                'status'=>0,
                'msg'=>'removeError',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }
    }

    public function showNewDetail(){
        $where['news_id']=I('get.id');
        $new=D('news');
        $rs=$new->where($where)->select();
        $this->assign('newInfo',$rs);
        $this->display();
    }

    public function editNew(){
        $where['news_id']=I('post.id');
        $set['title']=I('post.title');
        $set['content']=I('post.content');
        $set['pulish_time']=I('post.pulish_time');
        $set['pulish_sr']=I('post.pulish_sr');
        $set['lanmu_id']=I('post.lanmu_id');
        $set['clicked']=I('post.clicked');
        $new=D('news');
        $rs=$new->where($where)->save($set);
        if($rs>0){
            $data=array(
                'status'=>1,
                'msg'=>'editSuccess',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }else{
            $data=array(
                'status'=>0,
                'msg'=>'editError',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }
    }

    public function showAddNew(){
        $this->display('addNew');
    }

    public function addNew(){
        $new=D('news');
        $new->title=I('post.title');
        $new->content=I('post.content');
        $new->pulish_time=date('Y-m-d h-i-s',time());
        $new->pulish_sr=I('post.pulish_sr');
        $new->lanmu_id=I('post.lanmu_id');
        $new->clicked=I('post.clicked');
        $rs= $new->add();
        if($rs>0){
            $data=array(
                'status'=>1,
                'msg'=>'addSuccess',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }else{
            $data=array(
                'status'=>0,
                'msg'=>'addError',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }
    }



}