<?php
namespace app\index\controller;

use \think\Db;
class Product extends Index
{
    function index(){
        $id=$this->request->param('id');
        $info=Db::name('product')->where('id',$id)->find();
        $this->assign('info',$info);
        return $this->fetch();
    }

}