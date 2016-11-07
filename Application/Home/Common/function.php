<?php

//取子分类
function SidType($sid){
    $Data=M('column');
    $where['up_id']=$sid;
    $list=$Data->where($where)->field('name,english,lanmu_id,up_id')->order('paixu')->select();
    return $list;
}

//简介
function GetIntro($sid){
    $Data=M('column');
    $where['up_id']=$sid;
    $list=$Data->where($where)->field('lanmu_jianjie')->order('paixu')->select();
    return $list;
}


function AboutUs(){
    $lanmu_id=I('get.lanmu_id');
    $up_id=I('get.up_id');
    if($lanmu_id!='' and $up_id!=''){
        $Data=M('column');
        $where['lanmu_id']=$up_id;
        $list=$Data->where($where)->order('paixu')->select();
        return $list;
    }
}

