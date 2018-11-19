<?php
 namespace app\admin\controller;
 use \think\Db;

 class Member extends Permissions
 {
 	function Index(){
		$member=Db::name('member')->select();
		$this->assign('member',$member);
 		return $this->fetch();
 	}
 }