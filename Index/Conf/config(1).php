<?php
$config =  array(
	'TAGLIG_LOAD' => true,
	'APP_AUTOLOAD_PATH' => '@.TagLib',
	'TAGLIB_BUILD_IN' => 'Cx,Hd',

	//异位或加密KEY值
	'AUTO_LOGIN_KEY' => md5('www.houdunwang.com'),
	//自动登录有效时间
	'AUTO_LOGIN_LIFETIME' => time() + 3600 * 24 * 7,
);
return array_merge(include './Conf/config.php', $config);
?>