<?php
/**
 * 页员中心我的回答视图模型
 */
Class AnswerViewModel extends ViewModel {

	Protected $viewFields = array(
		'ask' => array(
			'id', 'content', 'answer', 
			'_type' => 'LEFT'
			),
		'answer' => array(
			'time', 'adopt', '_on' => 'ask.id = answer.aid',
			'_type' => 'LEFT'
			),
		'category' => array(
			'name', '_on' => 'ask.cid = category.id'
			)
		);
}
?>