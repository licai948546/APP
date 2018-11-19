<?php
 namespace app\admin\controller;
 use \think\Db;

 class Member extends Permissions
 {	
	//  会员列表首页
 	function Index(){
		$member=Db::name('member')->select();
		$this->assign('member',$member);
 		return $this->fetch();
	 }

	//  审核/通过会员
	function status(){
		 if($this->request->isPost()){
			 $post = $this->request->post();
			 if(false == Db::name('member')->where('id',$post['id'])->update(['status'=>$post['status']])) {
				 return $this->error('设置失败');
			 } else {
				 return $this->success('设置成功','admin/member/index');
			 }
		 }
	 }

	//  删除会员
	function delete(){
		 if($this->request->isAjax()) {
			 $id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
			 if(false == Db::name('member')->where('id',$id)->delete()) {
				 return $this->error('删除失败');
			 } else {
				 addlog($id);//写入日志
				 return $this->success('删除成功','admin/member/index');
			 }
		 }
	 }

 }