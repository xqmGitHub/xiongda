<?php
namespace Admin\Controller;
use Think\Controller;

class MessageController extends Controller{

    public function messageList(){
        $message=D('message');
        $messageList=$message->select();
        $this->assign('messageList',$messageList);
        $this->display();
    }

    public function removeMessage(){
        $id=I('post.id');
        $message=D('message');
        $rs=$message->delete($id);
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

    public function showMessageDetail(){
        $where['id']=I('get.id');
        $message=D('message');
        $rs=$message->where($where)->select();
        $this->assign('messageInfo',$rs);
        $this->display();
    }

    public function editMessage(){
        $where['id']=I('post.id');
        $set['title']=I('post.title');
        $set['content']=I('post.content');
        $set['phone']=I('post.phone');
        $message=D('message');
        $rs=$message->where($where)->save($set);
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

    public function showAddMessage(){
        $this->display('addNew');
    }

    public function addMessage(){
        $message=D('message');
        $message->title=I('post.title');
        $message->content=I('post.content');
        $message->phone=I('post.phone');
        $message->createtime=date('Y-m-d h-i-s',time());
        $rs= $message->add();
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