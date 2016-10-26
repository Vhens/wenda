<?php
/**
 * 问题分类控制器
 */
Class CategoryAction extends CommonAction {

	//分类列表视图
	Public function index () {
		$cate = M('category')->select();
		$this->cate = recursive($cate);
		$this->display();
	}

	//添加顶级分类视图
	Public function addTop () {
		$this->display();
	}

	//添加子分类视图
	Public function addChild () {
		$this->cate = M('category')->find($this->_get('pid', 'intval'));
		$this->display();
	}

	//添加分类表单处理
	Public function addCate () {
		if (M('category')->data($_POST)->add()) {
			$this->success('添加成功', 'index');
		} else {
			$this->error('添加失败');
		}
	}

	//修改分类视图
	Public function edit () {
		$this->cate = M('category')->find($this->_get('id', 'intval'));
		$this->display();
	}

	//修改分类操作
	Public function editCate () {
		if (M('category')->save($_POST)) {
			$this->success('修改成功', 'index');
		} else {
			$this->error('修改失败');
		}
	}

	//删除分类
	Public function del () {
		$id = $this->_get('id', 'intval');
		$db = M('category');
		$cateid = $db->field(array('id', 'pid'))->select();
		$delid = get_all_child($cateid, $id);
		$delid[] = $id;

		$where = array('id' => array('IN', $delid));

		if (!$db->where($where)->delete()) {
			$this->error('删除失败');
		}

		$this->success('删除成功', U('index'));
	}
}
?>