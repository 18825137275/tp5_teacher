<?php
namespace app\index\controller;

use think\Controller;
use think\Request;    //请求
use app\common\model\Teacher;    //教师模型

class LoginController extends Controller
{
	//用户登录表单
	public function index()
	{
		//显示登录表单
		return $this->fetch();
	}

	public function login()
	{
		//接收post信息
		$postData = Request::instance()->post();

		// 直接调用M层方法，进行验证登录信息。
		if(Teacher::login($postData['username'], $postData['password'])){
			return $this->success('login success!', url('Teacher/index'));
		}else{
			return $this->error('username or password incorrect!', url('index'));
		}
	}

	// 注销
	public function logOut()
	{
		if(Teacher::logOut()){
			return $this->success('logout success!', url('index'));
		}else{
			return $this->error('logout error!', url('index'));
		}
	}
}
