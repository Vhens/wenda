<?php
/**
 * 前台首页控制器
 */
Class IndexAction extends CommonAction {

	//首页视图
	Public function index () {

		if (S('category')) {
			$cate = S('category');
		} else {
			$db = M('category');
			$cate = $db->where(array('pid' => 0))->select();
			foreach ($cate as $k => $v) {
				$cate[$k]['child'] = $db->where(array('pid' => $v['id']))->select();
			}
			S('category', $cate, 3600 * 24);
		}
		$this->cate = $cate;

		//待解决问题
		$db = M('ask');
		$where = array('solve' => 0, 'reward' => 0);
		$this->wait = $db->where($where)->limit(15)->select();

		//高悬赏问题
		$where = array('solve' => 0, 'reward' => array('GT', 0));
		$this->rewardAsk = $db->where($where)->limit(15)->select();

		$this->display();
	}
}
?>