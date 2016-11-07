<?php
namespace Admin\Controller;
use Think\Controller;


class AdvertisementController extends Controller{
    public function advertisementList(){
        $advertisement=D('advertisement');
        $rs=$advertisement->select();
        $this->assign('advertisementList',$rs);
        $this->display();
    }

    public function removeAdvertisement(){
        $id=I('post.id');
        $advertisement=D('advertisement');
        $rs=$advertisement->delete($id);
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

    public function showAdvertisementDetail(){
        $where['ggao_id']=I('get.id');
        $advertisement=D('advertisement');
        $rs=$advertisement->where($where)->select();

        $this->assign('advertisementInfo',$rs);
        $this->display();
    }

    public function editAdvertisement(){


        $advertisement=D('advertisement');
        if(!empty($_POST)){
            if($_FILES['ggao_tupian']['error']===0){
                $cfg = array(
                    'rootPath'      =>  './Public/Upload/', //保存根路径
                );
                //设置附件的存储位置
                $up=new \Think\Upload($cfg);
                $uprs=$up->uploadOne($_FILES['ggao_tupian']);
                $img=$up->rootPath.$uprs['savepath'].$uprs['savename'];
                $set['ggao_tupian']=substr($img,2);//把 ./ 去掉

                //制作缩略图
                /*$smallImg=new \Think\Image();
                $smallImg->open($img);
                $smallImg->thumb(125,125);//等比例缩放
                $smallImgName=$up->rootPath.$uprs['savepath'].'small_'.$uprs['savename'];
                $smallImg->save($smallImgName);*/

            }
        }

        $where['ggao_id']=I('post.id');
        $set['ggao_biaoti']=I('post.ggao_biaoti');
        $set['ggao_lianjie']=I('post.ggao_lianjie');
        $rs=$advertisement->where($where)->save($set);
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

    public function showAddAdvertisement(){
        $this->display('addAdvertisement');
    }

    public function addAdvertisement(){
        $advertisement=D('advertisement');
        if(!empty($_POST)){
            if($_FILES['ggao_tupian']['error']===0){
                $cfg = array(
                    'rootPath'      =>  './Public/Upload/', //保存根路径
                );
                //设置附件的存储位置
                $up=new \Think\Upload($cfg);
                $uprs=$up->uploadOne($_FILES['ggao_tupian']);
                $img=$up->rootPath.$uprs['savepath'].$uprs['savename'];
                $_POST['ggao_tupian']=substr($img,2);//把 ./ 去掉
            }
        }
        //收集表单信息
        $data = $advertisement -> create();

        /*$advertisement->ggao_biaoti=I('post.ggao_biaoti');
        $advertisement->ggao_lianjie=I('post.ggao_lianjie');
        $advertisement->ggao_tupian=I('post.ggao_tupian');*/
        $rs= $advertisement->add($data);
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