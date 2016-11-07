<?php
namespace Home\Controller;
use Think\Controller;

class AboutUsController extends Controller{
    public function aboutUs(){

        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);

        $lanmu_id=I('get.lid');
        //判断是否传子栏目过来，如果传过来就查出该栏目，否则默认查第一个
        if($lanmu_id){
            $where['lanmu_id']=$lanmu_id;
            //把该栏目所属栏目名称查出来
            $cName= $column->where($where)->field('name,lanmu_jianjie')->select();
//            $this->assign('columnName',$cName[0]['name']);
            $this->assign('columnJianjie',$cName);

        }else{
            $this->assign('columnName','公司简介');
            $company=$column->where(array('lanmu_id'=>17))->field('name,lanmu_jianjie')->select();
            $this->assign('columnJianjie',$company);
        }


        $this->display('index');
    }
}