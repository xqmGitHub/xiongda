<?php
namespace Home\Controller;
use Think\Controller;
class IndexController extends Controller {
    public function index(){
        //$this->show('<style type="text/css">*{ padding: 0; margin: 0; } div{ padding: 4px 48px;} body{ background: #fff; font-family: "微软雅黑"; color: #333;font-size:24px} h1{ font-size: 100px; font-weight: normal; margin-bottom: 12px; } p{ line-height: 1.8em; font-size: 36px } a,a:hover{color:blue;}</style><div style="padding: 24px 48px;"> <h1>:)</h1><p>欢迎使用 <b>ThinkPHP</b>！</p><br/>版本 V{$Think.version}</div><script type="text/javascript" src="http://ad.topthink.com/Public/static/client.js"></script><thinkad id="ad_55e75dfae343f5a1"></thinkad><script type="text/javascript" src="http://tajs.qq.com/stats?sId=9347272" charset="UTF-8"></script>','utf-8');
        $column = D('column');
        $list = $column->field('name,english,lanmu_id,up_id')->where(array('up_id' => 0))->select();
        $this->assign('list',$list);

        $company= $column->field('name,lanmu_jianjie')->where(array('lanmu_id'=>17))->select();
        $this->assign('company',$company);

        $news=D('news');
        $where['LENGTH(title)']= array('lt',60);
        $newsList=$news->where($where)->field('news_id,title,pulish_time,lanmu_id')->limit(7)->order(array('pulish_time'=>'desc'))->select();
        $this->assign('newsList',$newsList);

        $service=D('service');
        $serviceList=$service->limit(4)->select();
        $this->assign('serviceList',$serviceList);

        $produts=D('produts');
        $produtsList=$produts->field('id,pic')->select();
        $this->assign('produtsList',$produtsList);

        $this->display();
    }

    public function testInclude(){
        $this->display('testInclude');
    }

    public function tcny(){

        echo $this->cny("12301.23");
    }

function cny($ns) {
    static $cnums=array("零","壹","贰","叁","肆","伍","陆","柒","捌","玖"),
    $cnyunits=array("圆","角","分"),
    $grees=array("拾","佰","仟","万","拾","佰","仟","亿");
    list($ns1,$ns2)=explode(".",$ns,2);
    $ns2=array_filter(array($ns2[1],$ns2[0]));
    $ret=array_merge($ns2,array(implode("",$this->_cny_map_unit(str_split($ns1),$grees)),""));
    $ret=implode("",array_reverse($this->_cny_map_unit($ret,$cnyunits)));
    return str_replace(array_keys($cnums),$cnums,$ret);
}

function _cny_map_unit($list,$units) {
    $ul=count($units);
    $xs=array();
    foreach (array_reverse($list) as $x) {
        $l=count($xs);
        if ($x!="0" || !($l%4)) $n=($x=='0'?'':$x).($units[($l-1)%$ul]);
        else $n=is_numeric($xs[0][0])?$x:'';
        array_unshift($xs,$n);
    }
    return $xs;
}

}