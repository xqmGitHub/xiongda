<?php
namespace Admin\Controller;
use Think\Controller;
use Think\Model;

class ColumnController extends Controller{

    public function columnList()
    {
        $column = D('column');
        $totle=$column->where(array('up_id' => 0))->count();
        $per=2;
        $page_obj=new \Tool\Page($totle,$per);
        $sql="select * from  `column` where up_id=0  ".$page_obj->limit;
        $newsList= $column->query($sql);
        $pageList=$page_obj->fpage(array(3,4,5,6,7,8));
        $this->assign('list',$newsList);
        $this->assign('pageList',$pageList);

        /*$list = $column->where(array('up_id' => 0))->select();
        $this->assign('list',$list);*/
        $this->display();
    }

    public function removeColumn(){
        $id=I('post.id');
        $column=D('column');
        $rs=$column->delete($id);
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

    public function showColumnDetail(){
        $where['lanmu_id']=I('get.id');
        $column=D('column');
        $rs=$column->where($where)->select();
        $this->assign('columnInfo',$rs);
        $this->getColunNameList();
        $this->display();
    }

    public function editColumnInfo(){
        $where['lanmu_id']=I('post.id');
        $set['name']=I('post.name');
        $set['paixu']=I('post.paixu');
        $set['lanmu_jianjie']=I('post.lanmu_jianjie');
        $set['lanmu_pic']=I('post.lanmu_pic');
        $set['up_id']=I('post.up_id');
        $column=D('column');
        $rs=$column->where($where)->save($set);
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

    //获取所以得父栏目id与栏目名称
    private function getColunNameList(){
        $column=D('column');
        $rs=$column->where(array('up_id'=>0))->field('lanmu_id,name')->select();
        $this->assign('columnName',$rs);
    }

    public function showAddColumn(){
        $this->getColunNameList();
        $this->display('addColumn');
    }

    public function addColumnInfo(){
        $column=D('column');
        $column->name=I('post.name');
        $column->name=I('post.paixu');
        $column->name=I('post.up_id');
        $column->name=I('post.lanmu_jianjie');
        $column->name=I('post.lanmu_pic');
        $rs= $column->add();
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