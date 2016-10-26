<?php
/**
 * 问题关联模型
 */
Class AskRelationModel extends RelationModel {

	Protected $tableName = 'ask';

	Protected $_link = array(
		'answer' => array(
			'mapping_type' => HAS_MANY,
			'foreign_key' => 'aid'
			)
		);
}
?>