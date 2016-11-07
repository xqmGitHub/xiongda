<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Upload\Driver\Upyun;

class UploadController extends Controller{
    public function createConfig(){
        $bucket_name='wojian';
        $form_api_secret='dBoop6ttQ1arw7LKnJ0VxH/NSqQ=';
        $upyun=new Upyun($bucket_name,$form_api_secret);

        $opts = array();
        // 必选参数
        $opts['save-key'] = '/{year}/{mon}/{day}/xd/upload_'.$this->createCode().'_{filemd5}{.suffix}';   // 保存路径
        // 以下参数均为可选
        $opts['allow-file-type'] = 'jpg,gif,png';   // 文件类型限制，如：jpg,gif,png
        $opts['content-length-range'] = '1024000';  // 文件大小限制，如：102400,1024000 单位：Bytes
        $opts['content-secret'] = 'xd123';   //原图访问密钥，如：abc

        $sign=$upyun->signCreate($opts);
        $policy=$upyun->policyCreate($opts);
        $action=$upyun->action();
        $data['status']=1;
        $data['sign']=$sign;
        $data['policy']=$policy;
        $data['action']=$action;
        $this->ajaxReturn($data);

    }

    public function upload(){
        $this->display('upload1');
    }

    //生成验证码
    private  function createCode(){
        $code = substr(uniqid(rand()), - 4);//uniqid() 函数基于以微秒计的当前时间，生成一个唯一的 ID。
       return $code;
    }


}