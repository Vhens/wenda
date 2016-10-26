<?php
/**
 * 格式化打印数组
 * @param  [type] $arr [description]
 * @return [type]      [description]
 */
function p ($arr) {
	echo '<pre>';
	print_r($arr);
	echo '</pre>';
}

/**
 * 递归重新排序无限级分类数组
 */
function recursive ($array, $pid=0, $level=0) {
	$arr = array();

	foreach ($array as $v) {
		if ($v['pid'] == $pid) {
			$v['level'] = $level;
			$v['html'] = str_repeat('--', $level);
			$arr[] = $v;
			$arr = array_merge($arr, recursive($array, $v['id'], $level + 1));
		}
	}

	return $arr;
}

/**
 * 获取传递ID的所有子分类ID
 * @param  [type] $array [description]
 * @param  [type] $id    [description]
 * @return [type]        [description]
 */
function get_all_child ($array, $id) {
	$arr = array();

	foreach ($array as $v) {
		if ($v['pid'] == $id) {
			$arr[] = $v['id'];
			$arr = array_merge($arr, get_all_child($array, $v['id']));
		}
	}

	return $arr;
}
?>