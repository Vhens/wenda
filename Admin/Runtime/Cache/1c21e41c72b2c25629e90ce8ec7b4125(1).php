<?php if (!defined('THINK_PATH')) exit();?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html;charset=UTF-8">
	<title>Document</title>
</head>
<body>
	<form action="<?php echo U('add');?>" method='post'>
		<textarea name="name" style='width:90%;height:300px;'></textarea><br/><br/>
		<input type="text" name='pid'/><br/><br/>
		<input type="submit" />
	</form>
</body>
</html>