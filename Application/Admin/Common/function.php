<?php
//取子分类
function SidType($sid){
    //把父ID传过来，查出所有子栏目
    $Data=M('column');
    $where['up_id']=$sid;
    $list=$Data->where($where)->order('paixu')->select();
    return $list;
}

function CheckSeesion(){
    if($_SESSION['uName']!='' or isset($_SESSION['uName'])){
        echo $_SESSION['uName'];
    }else{
        redirect(U('Admin/Index/login'));
    }
}


function CheckImg($img){
    //用explode进行判断PHP判断字符串的包含代码如下:
    if(empty($img)){
        echo '';
        exit();
    }
    $needle = "Public/Upload/";//判断是否包含a这个字符
    $tmparray = explode($needle,$img);
    if(count($tmparray)>1){
        $str="http://llwwxy.cn/";
        echo $str.$img;
    } else{
        echo $img;
    }

}

