<?php
/**
 * 问题列表控制器
 */
Class AskAction extends CommonAction {

	//所有问题列表视图
	Public function index () {
		import('ORG.Util.Page');
		$db = M('ask');
		$count = $db->count();
		$page = new Page($count, 20);
		$limi = $page->firstRow . ',' . $page->listRows;
		$this->ask = $db->limit($limit)->order('time DESC')->select();
		$this->page = $page->show();
		$this->display();
	}

	//待解决问题列表
	Public function wait () {
		import('ORG.Util.Page');
		$db = M('ask');
		$count = $db->count();
		$page = new Page($count, 20);
		$limi = $page->firstRow . ',' . $page->listRows;
		$this->ask = $db->where(array('solve' => 0))->limit($limit)->order('time DESC')->select();
		$this->page = $page->show();
		$this->display('index');
	}

	//已解决问题列表
	Public function solve () {
		import('ORG.Util.Page');
		$db = M('ask');
		$count = $db->count();
		$page = new Page($count, 20);
		$limi = $page->firstRow . ',' . $page->listRows;
		$this->ask = $db->where(array('solve' => 1))->limit($limit)->order('time DESC')->select();
		$this->page = $page->show();
		$this->display('index');
	}

	//零回答问题列表
	Public function zero () {
		import('ORG.Util.Page');
		$db = M('ask');
		$count = $db->count();
		$page = new Page($count, 20);
		$limi = $page->firstRow . ',' . $page->listRows;
		$this->ask = $db->where(array('answer' => 0))->limit($limit)->order('time DESC')->select();
		$this->page = $page->show();
		$this->display('index');
	}

	//删除问题
	Public function delAsk () {
		$id = $this->_get('id', 'intval');
		$askinfo = M('ask')->field(array('uid', 'solve'))->find($id);

		if (D('AskRelation')->relation(true)->delete($id)) {
			$db = M('user');
			$db->where(array('id' => $askinfo['uid']))->setDec('point', C('DEL_ASK'));

			if ($askinfo['solve']) {
				$where = array('aid' => $id, 'adopt' => 1);
				$answerUid = M('answer')->where($where)->getField('uid');
				$db->where(array('id' => $answerUid))->setDec('point', C('DEL_ADOPT_ANSWER'));
				$db->where(array('id' => $askinfo['uid']))->setDec('point', C('DEL_ADOPT_ASK'));
			}

			$this->success('删除成功', U('index'));
		} else {
			$this->error('删除失败，请重试...');
		}

		
	}
}
?>