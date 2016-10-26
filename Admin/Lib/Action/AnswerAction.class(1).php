<?php
/**
 * 回答管理控制器
 */
Class AnswerAction extends CommonAction {

	//所有回答列表
	Public function index () {
		//默认为读取所有回答， FILTER为1时读取未采纳回答，为2时读取已采纳回答
		$filter = isset($_GET['filter']) ? $_GET['filter'] : 0;
		$where = array();
		if ($filter) {
			$where['adopt'] = $filter == 1 ? 0 : 1;
		}

		import('ORG.Util.Page');
		$db = M('answer');
		$count = $db->count();
		$page = new Page($count, 20);
		$limit = $page->firstRow . ',' . $page->listRows;
		$this->answer = $db->where($where)->limit($limit)->order('time DESC')->select();

		$this->page = $page->show();
		$this->display();
	}

	//删除回答
	Public function delAnswer () {
		$id = $this->_get('id', 'intval');
		$uid = $this->_get('uid', 'intval');

		if (M('answer')->delete($id)) {
			M('user')->where(array('id' => $uid))->setDec('point', C('DEL_ANSWER'));

			$this->success('删除成功', U('index'));
		} else {
			$this->error('删除失败');
		}
	}
}
?>