<?php
namespace Home\Controller;
use Think\Controller;

class ServiceController extends Controller{

    public function service(){
        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);

        $service=D('service');


        $lanmu_id=I('get.lid');
        //判断是否传子栏目过来，如果传过来就查出该栏目的服务项目，否则查出第一个服务项目
        if($lanmu_id){
            $where['pid']=$lanmu_id;
            //把该服务项目所属栏目名称查出来

            $sName= $service->where($where)->select();
            $this->assign('serviceName',$sName[0]['title']);
            $this->assign('serviceIntro',$sName[0]['intro']);

        }else{
//            $this->assign('serviceName','网页制作');
            $serviceInfo=$service->where(array('pid'=>8))->select();
            $this->assign('serviceName',$serviceInfo[0]['title']);
            $this->assign('serviceIntro',$serviceInfo[0]['intro']);
        }

        $this->display('index');
    }
}