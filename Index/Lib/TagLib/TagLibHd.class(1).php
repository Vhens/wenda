<?php
//载入ThinkPHP核心标签基类
import('TagLib');
/**
 * 自定义标签类
 */
Class TagLibHd extends TagLib {
	//自定义标签
	Protected $tags = array(
		'topcates' => array('attr' => 'limit'),
		'userinfo' => array('attr' => 'uid'),
		'location' => array('attr' => 'cid')
		);

	//顶级分类对标签
	Public function _topcates ($attr, $content) {
		$attr = $this->parseXmlAttr($attr);
		$limit = isset($attr['limit']) ? $attr['limit'] : '';

		$str = '<?php ';
		$str .= '$where = array("pid" => 0);';
		$str .= '$_topcatesResult = M("category")->where($where)->limit(' . $limit . ')->select();';
		$str .= 'foreach ($_topcatesResult as $v) : ';
		$str .= 'extract($v);?>';
		$str .= $content;
		$str .= '<?php endforeach;?>';

		return $str;
	}

	//读取用户信息
	Public function _userinfo ($attr, $content) {
		$attr = $this->parseXmlAttr($attr);
		$uid = $attr['uid'];
		$str = <<<str
<?php
	\$field = array('id', 'username', 'face', 'answer', 'adopt', 'ask', 'point', 'exp');
	\$_userinfoResult = M('user')->field(\$field)->find({$uid});
	extract(\$_userinfoResult);
	\$face = empty(\$face) ? '/Public/Images/noface.gif' : '/Uploads/Face/' . \$face;
	\$face = __ROOT__ . \$face;
	\$adopt = round(\$adopt / \$answer * 100, 1) . '%';
	\$level = exp_to_level(\$exp);
?>
str;
		$str .= $content;
		return $str;
	}

	//当前所在分类位置
	Public function _location ($attr, $content) {
		$attr = $this->parseXmlAttr($attr);
		$cid = $attr['cid'];
		$str = <<<str
<?php
	\$cid = {$cid};
	if (S('location_' . \$cid)) {
		\$_location_result = S('location_' . \$cid);
	} else {
		\$_location_category = M('category')->select();
		\$_location_result = array_reverse(get_all_parent(\$_location_category, \$cid));
		S('location_' . \$cid);
	}
	
	foreach (\$_location_result as \$v) :
		extract(\$v);
?>
str;
		$str .= $content;
		$str .= '<?php endforeach;?>';
		return $str;
	}
}
?>