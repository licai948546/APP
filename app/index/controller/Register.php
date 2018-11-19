<?php
namespace app\index\controller;

use \think\Db;
use \think\Request;

class Register  extends Index
{
    function Index(){

        return $this->fetch();

    }
    // 注册接口
    function Register(){
        if(!Request::instance()->isPost()){
            $this->returnMessage['code']='error';
            $this->returnMessage['message']='请求出错！';
        }else{
            // 限制写入字段
            $allowsFields=[
                'user_name',
                'user_number',
                'user_password',
                'refree',
                'mobile'
            ];
            $insertData=[];
            $post=$this->request->post();
            // 密码加密
            $post['user_password']=md5(md5($post['user_password']));
            foreach($post as $k => $v ){
                if(in_array($k,$allowsFields)){
                    $insertData[$k]=$v;
                }
            }
            $insertData['register_time']=time();
            // 验证重复
            $member=Db::name('member')->where(['user_name'=>$post['user_name'],'mobile'=>$post['mobile']])->find();
            if($member>=1){
                $this->returnMessage['code']='error';
                $this->returnMessage['message']='用户名或手机号重复';
            }else{
                if(Db::name('member')->insert($insertData)){
                    $this->returnMessage['code']='success';
                    $this->returnMessage['message']='注册成功！';
                }else{
                    $this->returnMessage['code']='error';
                    $this->returnMessage['message']='注册失败，请重试！';
                }
            }
        }

        return json($this->returnMessage);
    }


}