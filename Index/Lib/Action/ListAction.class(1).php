<?php
/**
 * 问题列表页控制器
 */
Class ListAction extends Action {

	Public function index () {
		$id = $this->_get('id', 'intval');

		//分类列表
		$db = M('category');
		$cate = $db->where(array('pid' => $id))->select();
		$cid = only_array($cate, 'id');
		$cid[] = $id;
		if (!$cate) {
			$pid = $db->where(array('id' => $id))->getField('pid');
			$cate = $db->where(array('pid' => $pid))->select();

			if (!$cate) {
				$cate = $db->where(array('pid' => 0))->select();
				$cid = only_array($cate, 'id');
			}
		}
		$this->cate = $cate;

		//问题列表
		$where = array('cid' => array('IN', $cid));
		//组合筛选条件
		$filter = isset($_GET['filter']) ? $this->_get('filter', 'intval') : 0;
		switch ($filter) {
			case 1 : 
				$where['solve'] = 1;
				break;
			case 2 : 
				$where['reward'] = array('GT', 0);
				break;
			case 3 :
				$where['answer'] = 0;
				break;
			default :
				$where['solve'] = 0;
		}

		//分页处理
		$count = M('ask')->where($where)->count('id');
		import('ORG.Util.Page');
		$page = new Page($count, 15);
		$limit = $page->firstRow . ',' . $page->listRows;

		$db = D('AskView');
		$this->ask = $db->where($where)->order('time DESC')->limit($limit)->select();

		$this->page = $page->show();
		$this->cateid = $id;
		$this->filter = $filter;
		$this->display();
	}
}
?>