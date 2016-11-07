<?php
namespace Home\Controller;
use Think\Controller;

class MessageController extends Controller{

    public function message(){
        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);

        $message=D('message');
        $messageData=$message->field('id,title,createtime')->order(array('createtime'=>'desc'))->limit(8)->select();
        $this->assign('messageData',$messageData);

        $this->display('index');
    }

    public function setMessage(){


        $message=D('message');
        $message->title=trim(I('post.title'));
        $message->content=trim(I('post.content'));
        $message->phone=trim(I('post.phone'));
        $message->createtime=date('Y-m-d h-i-s',time());
        $rs = $message->add();
        if($rs>0){
            $data=array(
                'status'=>1,
                'msg'=>'留言成功',
            );
            $this->ajaxReturn($data);
        }else{
            $data=array(
                'status'=>0,
                'msg'=>'留言失败',
            );
            $this->ajaxReturn($data);
        }

    }
}