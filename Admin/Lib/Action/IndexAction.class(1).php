<?php
/**
 * 后台首页控制器
 */
Class IndexAction extends CommonAction {

	//后台首页视图
	Public function index () {
		$this->display();
	}

	//用户信息
	Public function copy () {
		$time = date('y-m-d H:i');
		$ip = get_client_ip();
		$info = <<<str
		{$_SESSION['uname']} 您好！<br/>
		您的上一次登录时间是：{$_SESSION['logintime']}<br/>
		您本次的登录时间是：{$time}<br/>
		您的上一次登录IP是：{$_SESSION['loginip']}<br/>
		您的本次登录IP是：{$ip}
str;
		echo $info;
	}

	//退出登录
	Public function loginOut () {
		session_unset();
		session_destroy();
		$this->redirect('Login/index');
	}
}
?>