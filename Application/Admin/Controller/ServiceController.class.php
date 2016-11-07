<?php
namespace Admin\Controller;
use Think\Controller;

class ServiceController extends Controller{
    public function serviceList(){
        $service=D('Service');
        $rs=$service->select();
        $this->assign('serviceList',$rs);
        $this->display();
    }

    public function removeService(){
        $id=I('post.id');
        $service=D('Service');
        $rs=$service->delete($id);
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

    public function showServiceDetail(){
        $where['id']=I('get.id');
        $service=D('Service');
        $rs=$service->where($where)->select();

        $this->assign('serviceInfo',$rs);
        $this->display();
    }

    public function editService(){
        $service=D('Service');
        if(!empty($_POST)){
            if($_FILES['img']['error']===0){
                $cfg = array(
                    'rootPath'      =>  './Public/Upload/Service/', //保存根路径
                );
                //设置附件的存储位置
                $up=new \Think\Upload($cfg);
                $uprs=$up->uploadOne($_FILES['img']);
                $img=$up->rootPath.$uprs['savepath'].$uprs['savename'];
                $set['img']=substr($img,2);//把 ./ 去掉
            }
        }

        $where['id']=I('post.id');
        $set['title']=I('post.title');
        $set['intro']=I('post.intro');
        $set['pid']=I('post.pid');
        $rs=$service->where($where)->save($set);
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

    public function showAddService(){
        $this->display('addService');
    }

    public function addService(){
        $service=D('Service');
        if(!empty($_POST)){
            if($_FILES['img']['error']===0){
                $cfg = array(
                    'rootPath'      =>  './Public/Upload/Service/', //保存根路径
                );
                //设置附件的存储位置
                $up=new \Think\Upload($cfg);
                $uprs=$up->uploadOne($_FILES['img']);
                $img=$up->rootPath.$uprs['savepath'].$uprs['savename'];
                $_POST['img']=substr($img,2);//把 ./ 去掉
            }
        }
        //收集表单信息
        $data = $service -> create();

        /*$advertisement->ggao_biaoti=I('post.ggao_biaoti');
        $advertisement->ggao_lianjie=I('post.ggao_lianjie');
        $advertisement->ggao_tupian=I('post.ggao_tupian');*/
        $rs= $service->add($data);
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