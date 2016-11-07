<?php
namespace Home\Controller;
use Think\Controller;

class ProdutsController extends Controller{

    public function produts(){
        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);

        $produts=D('produts');
        $lanmu_id=I('get.lid');
        //判断是否传子栏目过来，如果传过来就查出该栏目，否则默认查第一个
        if($lanmu_id) {
            $where['pid'] = $lanmu_id;
            //把该栏目所属栏目名称查出来
            $produtsList = $produts->where($where)->select();
            $produtTilte=$column->where(array('lanmu_id'=>$lanmu_id))->field('name')->select();
            $this->assign('produtTilte',$produtTilte[0]['name']);
        }else{
            $produtsList = $produts->select();
            $this->assign('produtTilte','网页作品');
        }
        $this->assign('produtsList',$produtsList);

        $this->display('index');
    }

    public function produtDetail(){
        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);

        $where['id']=I('get.pid');
        $produts=D('produts');
        $produtInfo=$produts->where($where)->field('intro,pic,pid')->select();
        $lanmu_id=$produtInfo[0]['pid'];
        $pname=$column->where(array('lanmu_id'=>$lanmu_id))->select();
        $this->assign('pName',$pname[0]['name']);
        $this->assign('produtInfo',$produtInfo);
        $this->display('produtDetail');
    }
}