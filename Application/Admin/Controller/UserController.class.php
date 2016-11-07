<?php
namespace Admin\Controller;
use Think\Controller;

class UserController extends Controller{
    public function userList(){
//        if($_SESSION['uName']=='' or !isset($_SESSION['uName'])){
////            redirect(U('Admin/Index/login'));
//            /*$this->display('Index/login');
//            return false;*/
//            $this->redirect('Index/login');
//        }
//        $this->assign('uName',$_SESSION['uName']);
//        $user=D('admin');
//        $rs = $user->select();
//        $this->assign('userList',$rs);
        $this->display();
    }

    public function ajaxUserList(){
        $user=D('admin');
        $per=6;
        $totle=$user->count();
        $page_obj=new \Think\AjaxPage($totle,$per);
        $pageList=$page_obj->show();
        $userList= $user->order(array('addTime'=>'asc'))->limit($page_obj->firstRow.','.$page_obj->listRows)->select();
        $this->assign('userList',$userList);
        $this->assign('pageList',$pageList);

        $this->display();
    }

    //删除
    public function removeUser(){
        $id=I('post.id');
        $user=D('admin');
        $rs=$user->delete($id);
        if($rs>0){
            $data=array(
                'status'=>1,
                'msg'=>'ok',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }else{
            $data=array(
                'status'=>0,
                'msg'=>'no',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }
    }

    //显示修改用户页面
    public  function showUserDetail(){
        $where['u_id']=I('get.id');
        $user=D('admin');
        $rs= $user->where($where)->select();
        $this->assign('userInfo',$rs);
        $this->display();
    }

    public  function userDetail(){
        $where['u_id']=I('post.id');
        $user=D('admin');
        $rs= $user->where($where)->field('u_id,name,email')->select();
        if($rs>0){
            $data=array(
                'status'=>1,
                'msg'=>'ok',
                'data'=>$rs,
            );
            $this->ajaxReturn($data);
        }else{
            $data=array(
                'status'=>0,
                'msg'=>'no',
                'data'=>$rs,
            );
            $this->ajaxReturn($data);
        }
    }

    //修改用户信息
    public function editUserInfo(){
        $where['u_id']=I('post.id');
        $set['name']=I('post.name');
        $set['password']=md5(I('post.password'));
        $set['email']=I('post.email');
        $user=D('admin');
        $rs=$user->where($where)->save($set);
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

    //显示添加用户
    public function showAddUser(){
        $this->display('addUser');
    }

    //添加用户
    public function addUser(){
        $user=D('admin');
        $user->name=trim(I('post.name'));
        $user->password=md5(I('post.password'));
        $user->email=trim(I('post.email'));
        $user->addTime=time();
        $rs=$user->add();
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