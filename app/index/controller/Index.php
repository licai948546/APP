<?php
namespace app\index\controller;

use \think\Controller;
use \think\Db;

class Index extends Controller
{
    public function index()
    {   
        $product=Db::name('product')->select();
        $cateid=$this->request->param('cateid');
        if($cateid){
            $product=Db::name('product')->where('cateid',$cateid)->select();
        }
        $cate=Db::name('product_cate')->select();
        $this->assign('cate',$cate);
        $this->assign('product',$product);
        return $this->fetch();
    }
}
