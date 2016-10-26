<?php
/**
 * 问题展示控制器
 */
Class ShowAction extends CommonAction {

	Public function index () {
		$id = $this->_get('id', 'intval');

		//问题详细
		$ask = D('AskInfoView')->find($id);
		if (!$ask) {
			redirect(U('List/index'));
		}
		$ask['level'] = exp_to_level($ask['exp']);
		$this->ask = $ask;

		//满意回答
		$db = D('AnswerInfoView');
		$where = array('aid' => $id, 'answer.adopt' => 1);
		$this->bingo = $db->where($where)->find();

		//全部回答
		import('ORG.Util.Page');
		$where = array('aid' => $id, 'answer.adopt' => 0);
		$count = M('answer')->where($where)->count();
		$page = new Page($count, 10);
		$limit = $page->firstRow . ',' . $page->listRows;
		$answer = $db->where($where)->limit($limit)->select();
		$this->answer = $answer;
		$this->page = $page->show();

		//待解决的相关问题
		$where = array('cid' => $ask['cid'], 'solve' => 0, 'id' => array('NEQ', $id));
		$this->wait = M('ask')->where($where)->limit(5)->select();

		$this->display();
	}

	//回答问题表单处理
	Public function answer () {
		if (!$this->isPost()) halt('页面不存在');

		$data = array(
			'content' => $this->_post('content'),
			'time' => time(),
			'aid' => $this->_post('aid', 'intval'),
			'uid' => session('uid')
			);

		if (M('answer')->data($data)->add()) {
			M('ask')->where(array('id' => $data['aid']))->setInc('answer');

			$db = M('user');
			$where = array('id' => $data['uid']);
			$db->where($where)->setInc('answer');
			$db->where($where)->setInc('exp', C('LV_ANSWER'));
			$db->where($where)->setInc('point', C('ANSWER'));

			$this->success('回答成功', $_SERVER['HTTP_REFERER']);
		} else {
			$this->error('回答失败，请重试...');
		}
	}

	//采纳答题
	Public function adopt () {
		$id = $this->_get('id', 'intval');
		$aid = $this->_get('aid', 'intval');
		$uid = $this->_get('uid', 'intval');

		$data = array(
			'id' => $id,
			'adopt' => 1
			);

		if (M('answer')->save($data)) {
			M('ask')->save(array('id' => $aid, 'solve' => 1));

			$db = M('user');
			$db->where(array('id' => $uid))->setInc('adopt');
			$db->where(array('id' => $uid))->setInc('exp', C('LV_ADOPT'));

			$reward = M('ask')->field(array('uid', 'reward'))->find($aid);
			if ($reward) {
				$db->where(array('id' => $reward['uid']))->setDec('point', $reward['reward']);
				$db->where(array('id' => $uid))->setInc('point', $reward['reward']);
			}

			$this->success('已采纳', $_SERVER['HTTP_REFERER']);
		} else {
			$this->error('采纳失败，请重试...');
		}
	}
}
?>