<?php
session_start();

require_once('config.php');
require_once('classTencent.php');
OAuth::init(TT_AKEY, TT_SKEY);

if (isset($_GET['code']))
{
	$apiUrl = OAuth::getAccessToken($_REQUEST['code'], TT_CALLBACK_URL);
	$response = Http::request($apiUrl);
	parse_str($response, $out);
	if ($out['access_token'])
	{
		$_SESSION['t_access_token'] = $out['access_token'];
		$_SESSION['t_refresh_token'] = $out['refresh_token'];
		$_SESSION['t_expire_in'] = $out['expires_in'];
		$_SESSION['t_deadline'] = time(0) + $out['expires_in'];
		$_SESSION['t_openid'] = $_GET['openid'];
		$_SESSION['t_nick'] = $out['nick'];
		$response = OAuth::checkOAuthValid();
		if($response)
			$_SESSION['t_status'] = true;
		else
			$_SESSION['t_status'] = false;
	}
}
else
{
	$_SESSION['t_status'] = false;
}
header('location: http://blog.tennsinn.com/TypechoSync');
?>
