<?php
namespace Home\Controller;
use Think\Controller;

class ContactUsController extends Controller{

    public function contactUs(){
        $column = D('column');
        $list = $column->where(array('up_id' => 0))->field('name,english,lanmu_id,up_id')->select();
        $this->assign('list',$list);

        $this->display('index');
    }
}