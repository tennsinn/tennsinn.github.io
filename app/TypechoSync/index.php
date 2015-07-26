<?php
session_start();
date_default_timezone_set("PRC");

require_once('config.php');
require_once('classSina.php');
$clientSina = new SaeTOAuthV2(WB_AKEY, WB_SKEY);
require_once('classTencent.php');
OAuth::init(TT_AKEY, TT_SKEY);

?>

<!DOCTYPE html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>TypechoSync</title>
</head>

<body>
	<p><a href="https://github.com/tennsinn/Typecho-Plugins/tree/master/TypechoSync">下载插件</a></p>
	<p><a href="<?=$clientSina->getAuthorizeURL(WB_CALLBACK_URL)?>"><img src="http://www.sinaimg.cn/blog/developer/wiki/32.png"></a></p>
	<?php if($_SESSION['s_status']): ?>
		<p>授权账号：<?=$_SESSION['s_nick']?></p>
		<p>授权状态：<?=$_SESSION['s_deadline']<time(0) ?  '已过期' : '已授权'?></p>
		<p>uid: <?php echo $_SESSION['s_uid']; ?></p>
		<p>access_token: <?=$_SESSION['s_access_token']?></p>
		<p>Token有效期: <?=date('Y-m-d H:i:s', $_SESSION['s_deadline'])?></p>
		<p>请保存好您的授权信息，勿提供给他人。</p>
	<?php endif; ?>
	<p><a href="<?=OAuth::getAuthorizeURL(TT_CALLBACK_URL)?>">点此进行腾讯微博授权</a></p>
	<?php if($_SESSION['t_status']): ?>
		<p>授权账号：<?=$_SESSION['t_nick']?></p>
		<p>授权状态：<?=$_SESSION['t_deadline']<time(0) ?  '已过期' : '已授权'?></p>
		<p>openid: <?=$_SESSION['t_openid']?></p>
		<p>access_token: <?=$_SESSION['t_access_token']?></p>
		<p>Token有效期: <?=date('Y-m-d H:i:s', $_SESSION['t_deadline'])?></p>
		<p>请保存好您的授权信息，勿提供给他人。</p>
	<?php endif; ?>
</body>
</html>
