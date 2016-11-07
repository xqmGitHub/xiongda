<?php
namespace Admin\Controller;
use Think\Controller;
use Think\AjaxPage;

class ProdutsController extends Controller{
    public function produtsList(){
        /*$produts=D('produts');
        $totle=$produts->count();
        $per=6;
        $page_obj=new \Tool\Page($totle,$per);
        $sql="select * from produts  ".$page_obj->limit;
        $produtsList= $produts->query($sql);
        $pageList=$page_obj->fpage(array(3,4,5,6,7,8));
        $this->assign('produtsList',$produtsList);
        $this->assign('pageList',$pageList);*/

        $this->display();
    }

    public function ajaxProdutsList(){
        $produts=D('produts');
        $per=6;
        $totle=$produts->count();
        $page_obj=new AjaxPage($totle,$per);
        $pageList=$page_obj->show();
        $produtsList= $produts->limit($page_obj->firstRow.','.$page_obj->listRows)->select();
        $this->assign('produtsList',$produtsList);
        $this->assign('pageList',$pageList);

        $this->display();
    }

    public function removeProduts(){
        $id=I('post.id');
        $produts=D('produts');
        $rs=$produts->delete($id);
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

    public function showProdutsDetail(){
        $where['id']=I('get.id');
        $produts=D('produts');
        $rs=$produts->where($where)->select();
        $this->assign('produtsInfo',$rs);
        $this->display();
    }

    public function editProduts(){


        $produts=D('produts');
        if(!empty($_POST)){
            if($_FILES['pic']['error']===0){
                $cfg = array(
                    'rootPath'      =>  './Public/Upload/Produts/', //保存根路径
                );
//设置附件的存储位置
                $up=new \Think\Upload($cfg);
                $uprs=$up->uploadOne($_FILES['pic']);
                $img=$up->rootPath.$uprs['savepath'].$uprs['savename'];

                $set['pic']=substr($img,2);//把 ./ 去掉
            }
        }

        $where['id']=I('post.id');
        $set['title']=I('post.title');
        $set['intro']=I('post.intro');
        $set['pid']=I('post.pid');
        $rs=$produts->where($where)->save($set);
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

    public function showAddProduts(){
        $this->display('addProduts');
    }

    public function addProduts(){
        $Produts=D('Produts');
        if(!empty($_POST)){
            if($_FILES['pic']['error']===0){
                $cfg = array(
                    'rootPath'      =>  './Public/Upload/Produts/', //保存根路径
                );
//设置附件的存储位置
                $up=new \Think\Upload($cfg);
                $uprs=$up->uploadOne($_FILES['pic']);
                $img=$up->rootPath.$uprs['savepath'].$uprs['savename'];
                $_POST['pic']=substr($img,2);//把 ./ 去掉
            }
        }
//收集表单信息
        $data = $Produts -> create();

        /*$advertisement->ggao_biaoti=I('post.ggao_biaoti');
        $advertisement->ggao_lianjie=I('post.ggao_lianjie');
        $advertisement->ggao_tupian=I('post.ggao_tupian');*/
        $rs= $Produts->add($data);
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