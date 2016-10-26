<?php
/**
 * 会员中心
 */
Class MemberAction extends CommonAction {

	Public function _initialize () {
		$this->role = isset($_SESSION['uid']) && $_GET['id'] == session('uid') ? '我' : 'TA';
	}

	//我的首页视图
	Public function index () {
		$id = $this->_get('id', 'intval');
		$msg = M('user')->field(array('point', 'exp', 'adopt', 'answer', 'ask'))->find($id);
		if (!$msg) {
			redirect(__APP__);
			die();
		}
		$this->msg = $msg;
		

		//我的提问
		$where = array('uid' => $id);
		$this->myAsk = D('AskView')->where($where)->order('time DESC')->limit(10)->select();

		//我的回答
		$where = array('answer.uid' => $id);
		$this->myAnswer = D('AnswerView')->where($where)->limit(10)->select();

		$this->display();
	}

	//我的提问
	Public function myAsk () {
		$id = $this->_get('id', 'intval');
		//我的待解决提问
		$where = array('uid' => $id, 'solve' => 0);
		$this->myAsk = D('AskView')->where($where)->order('time DESC')->select();

		//我的已解决问题
		$where['solve'] = 1;
		$this->myAnswer = D('AskView')->where($where)->order('time DESC')->select();

		$this->display();
	}

	//我的回答
	Public function myAnswer () {
		$id = $this->_get('id', 'intval');
		//我的回答
		$where = array('answer.uid' => $id);
		$this->myAnswer = D('AnswerView')->where($where)->select();

		$this->count = D('AnswerView')->where($where)->count();
		$this->display();
	}

	//我的等级
	Public function myLevel () {
		$id = $this->_get('id', 'intval');
		$this->exp = M('user')->where(array('id' => $id))->getField('exp');
		$this->level = exp_to_level($exp);
		$this->display();
	}

	//我的金币
	Public function myPoint () {
		$id = $this->_get('id', 'intval');
		$this->point = M('user')->where(array('id' => $id))->getField('point');
		$this->display();
	}
}
?>