<?php
/**
 * 公共控制器
 */
Class CommonAction extends Action {

	/**
	 * ThinkPHP里面的自动运行方法
	 */
	Public function _initialize () {
		if (!isset($_SESSION['uid']) || !isset($_SESSION['uname'])) {
			$this->redirect('Login/index');
		}
	}
}
?>