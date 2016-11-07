<?php
namespace Admin\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function login(){
        $this->display('login');
    }

    public function showerror(){
        $ad=D('advertisement');
        $rs=$ad->field('ggao_tupian')->select();
        $this->assign('img',$rs);
        $this->display('error');

    }
    public function logout(){
        unset($_SESSION['uName']);
    }

    public function checkLogin(){
        $code='';
        if(isset($_SESSION['code']) or $_SESSION!=''){
            $code=$_SESSION['code'];
        }
        $uCode=md5(I('post.J_codetext',''));
        if($uCode===$code){
            $where['name']=trim(I('post.name'));
            $where['password']=md5(I('post.password'));
            $admin=D('admin');
            $rs=$admin->where($where)->field('u_id,name')->find();
            if($rs>0){

                $_SESSION['uName']=trim($rs['name']);
                $admin->where($where)->save(array('lastLoginTime'=>time()));
                $data=array(
                    'status'=>1,
                    'msg'=>'success',
                    'data'=>[],
                );
                $this->ajaxReturn($data);
            }else{
                $data=array(
                    'status'=>2,
                    'msg'=>'UserNameOrPasswordError',
                    'data'=>[],
                );
                $this->ajaxReturn($data);
            }

        }else{
            $data=array(
                'status'=>0,
                'msg'=>'验证码错误',
                'data'=>[],
            );
            $this->ajaxReturn($data);
        }

    }

    public function index(){
        if($_SESSION['uName']!='' or isset($_SESSION['uName'])){
            $this->assign('uName',$_SESSION['uName']);
            $this->display();
        }else{
            $this->display('login');
        }
    }


public function q(){
    $this->display();
}
    //生成验证码
    public  function getCode(){
        $code = substr(uniqid(rand()), - 4);//uniqid() 函数基于以微秒计的当前时间，生成一个唯一的 ID。
        $_SESSION['code']=md5($code);
        echo json_encode($code);
    }


}