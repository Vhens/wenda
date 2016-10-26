<?php
/**
 * 公用控制器
 */
Class CommonAction extends Action {

	Protected function _initialize () {
		if (!C('WEB_STATE')) {
			halt('网站维护中');
		}

		//自动登录处理
		if (isset($_COOKIE['auto']) && !isset($_SESSION['uid'])) {
			$value = explode('|', encrytion($_COOKIE['auto']));
			
			if ($value[1] == get_client_ip()) {
				session('uid', $value[0]);
				session('username', $value[2]);
			}
		}
	}

	//退出登录
	Public function logout () {
		session_unset();
		session_destroy();
		redirect(__APP__);
	}

	//登录表单处理
	Public function login () {
		if (!$this->isPost()) halt('页面不存在');

		$db = M('user');
		$where = array('account' => $this->_post('account'));
		$field = array('id', 'username', 'password', 'logintime', 'lock');
		$user = $db->where($where)->field($field)->find();

		if (!$user || $user['password'] != $this->_post('pwd', 'md5')) {
			$this->error('帐号或密码错误');
		}

		if ($user['lock']) {
			$this->error('帐号被锁定');
		}

		if (isset($_POST['auto'])) {
			$value = $user['id'] . '|' . get_client_ip() . '|' . $user['username'];
			$value = encrytion($value, 1);
			@setcookie('auto', $value, C('AUTO_LOGIN_LIFETIME'), '/');
		}

		//每天登录增加经验
		$today = strtotime(date('Y-m-d'));
		$where = array('id' => $user['id']);
		if ($user['logintime'] < $today) {
			$db->where($where)->setInc('exp', C('LV_LOGIN'));
		}

		$db->where($where)->save(array('logintime' => time()));

		session('uid', $user['id']);
		session('username', $user['username']);
		redirect($_SERVER['HTTP_REFERER']);
	}

	//异步验证登录帐号与密码
	Public function checkLogin () {
		if (!$this->isAjax()) halt('页面不存在');

		$account = $this->_post('account');
		$where = array('account' => $account);

		$pwd = M('user')->where($where)->getField('password');
		if (!$pwd || $pwd != $this->_post('password', 'md5')) {
			echo 0;
		} else {
			echo 1;
		}
	}

	//注册表单处理
	Public function register () {
		if (!$this->isPost()) halt('页面不存在');

		$db = D('User');
		if (!$db->create()) {
			$this->error($db->getError());
		}
		$username = $db->username;
		if (!$uid = $db->add()) $this->error('注册失败，请重试...');

		session('uid', $uid);
		session('username', $username);
		$this->success('注册成功，正在为您跳转...', __APP__);
	}

	//异步验证帐号
	Public function checkAccount () {
		if (!$this->isAjax()) halt('页面不存在');
		$account = $this->_post('account');
		$where = array('account' => $account);
		if (M('user')->where($where)->getField('id')) {
			echo 0;
		} else {
			echo 1;
		}
	}

	//异步验证用户名
	Public function checkUsername () {
		if (!$this->isAjax()) halt('页面不存在');
		$username = $this->_post('username');
		$where = array('username' => $username);
		if (M('user')->where($where)->getField('id')) {
			echo 0;
		} else {
			echo 1;
		}
	}

	//异步验证验证码
	Public function checkVerify () {
		if (!$this->isAjax()) halt('页面不存在');

		if ($_SESSION['verify'] == $this->_post('verify', 'md5')) {
			echo 1;
		} else {
			echo 0;
		}
	}

	//验证码
	Public function verify () {
		import('ORG.Util.Image');
		Image::buildImageVerify();
	}
}
?>