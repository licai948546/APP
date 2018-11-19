<?php
namespace app\index\controller;

use \think\Db;
use \think\Request;
use \think\Session;

class User extends Index
{
    function index(){
        $id=Session::get('member')['id'];
        $member=Db::name('member')->where('id',$id)->find();
        $this->assign('member',$member);
        return $this->fetch();
    }
}