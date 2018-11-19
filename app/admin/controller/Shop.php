<?php
namespace app\admin\controller;
use \think\Db;

class Shop extends Permissions 
{   
    // 商品列表
    function index(){
        $product=Db::name('product')->select();
        $cate=Db::name('product_cate')->select();
        $this->assign('cate',$cate);
        $this->assign('product',$product);
        return $this->fetch(); 
    }

    // 商品添加|修改
    function publish(){
        $id=$this->request->param('id');
        if($id){
            $product=Db::name('product')->where('id',$id)->find();
            $this->assign('product',$product);
        }
        $cate=Db::name('product_cate')->select();
        $this->assign('cate',$cate);
        return $this->fetch();
    }

    // 商品分类
    function productCate(){
        $id=$this->request->param('id');
        if($id){
            $cate=Db::name('product_cate')->where('id',$id)->find();
            $this->assign('cate',$cate);
        }

        return $this->fetch();
    }

    // 添加商品
    function getAdd(){
        $id=$this->request->param('id');
        if($id){
            // 限制写入字段
            $allowsfields=[
                'name',
                'price',
                'description',
                'amount',
                'thumb',
                'cateid'
            ];
            // 获取提交来的数据
            $data=$this->request->post();
            $updateData=[];
            foreach($data as $k => $v){
                if(in_array($k,$allowsfields)){ //舍弃在限制外的数据
                    $updateData[$k]=$v;
                }
            }
            if(empty($updateData)){
                $this->error('修改失败，请重试！');
            }
            if(empty($updateData['name'])){
                $this->error('商品名不能为空！');
            }
            if(empty($updateData['thumb'])){
                $this->error('请上传缩略图！');
            }

            if(Db::name('product')->where('id',$id)->update($updateData)){
                $this->success('修改成功！','admin/shop/index');
            }
        }else{
            // 限制写入字段
            $fields=[
                'name',
                'price',
                'description',
                'amount',
                'thumb',
                'cateid'
            ];
            // 获取提交来的数据
            $post=$this->request->post();
            $insertData=[];
            foreach($post as $key => $val){
                if(in_array($key,$fields)){ //舍弃在限制外的数据
                    $insertData[$key]=$val;
                }
            }
            $insertData['create_time']=time();
            if(empty($insertData)){
                $this->error('添加失败，请重试！');
            }
            if(empty($insertData['name'])){
                $this->error('商品名不能为空！');
            }
            if(empty($insertData['thumb'])){
                $this->error('请上传缩略图！');
            }

            if(Db::name('product')->insert($insertData)){
                $this->success('添加成功！','admin/shop/index');
            }
        }
        
    }


    // 分类列表
    function productCateList(){

        $cate=Db::name('product_cate')->select();
        $this->assign('cate',$cate);
        return $this->fetch();
    }


    function cateAdd(){
        $id=$this->request->param('id');
        if($id){//判断新增还是修改
            //限制写入字段 
            $allowsfields=[
                'name',
                'tag',
                'remarks'
            ];
            $updateData=[];
            $post=$this->request->post();
            foreach($post as $key => $value){
                if(in_array($key,$allowsfields)){
                    $updateData[$key]=$value;
                }
            }
            $updateData['create_time']=time();
            if(Db::name('product_cate')->where('id',$id)->update($updateData)){
                $this->success('修改成功','admin/shop/productcatelist');
            }else{
                $this->error('修改失败');
            }
        }else{
            // 限制写入字段
            $allowsfields=[
                'name',
                'tag',
                'remarks'
            ];
            $insData=[];
            $post=$this->request->post();
            foreach($post as $key => $value){
                if(in_array($key,$allowsfields)){
                    $insData[$key]=$value;
                }
            }
            $insData['create_time']=time();
            if(Db::name('product_cate')->insert($insData)>=1){
                $this->success('添加成功','admin/shop/productcatelist');
            }else{
                $this->error('添加失败，请重试！');
            }
        }

    }
    // 删除商品
    function delete(){
    	if($this->request->isAjax()) {
    		$id = $this->request->has('id') ? $this->request->param('id', 0, 'intval') : 0;
            if(false == Db::name('product')->where('id',$id)->delete()) {
                return $this->error('删除失败');
            } else {
                return $this->success('删除成功','admin/shop/index');
            }
    	}
    }
}