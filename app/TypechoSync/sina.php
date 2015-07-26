<?php
session_start();

require_once('config.php');
require_once('classSina.php');
$clientSina = new SaeTOAuthV2(WB_AKEY, WB_SKEY);

if (isset($_REQUEST['code']))
{
	$keys = array();
	$keys['code'] = $_REQUEST['code'];
	$keys['redirect_uri'] = WB_CALLBACK_URL;
	try
	{
		$token = $clientSina->getAccessToken( 'code', $keys ) ;
		$_SESSION['s_status'] = true;
		$_SESSION['s_uid'] = $token['uid'];
    	$_SESSION['s_access_token'] = $token['access_token'];
    	$_SESSION['s_deadline'] = time(0) + $token['expires_in'];
    	$curl = curl_init();
		curl_setopt ($curl, CURLOPT_URL, 'https://api.weibo.com/2/users/show.json?uid='.$token['uid'].'&access_token='.$token['access_token']);
		curl_setopt ($curl, CURLOPT_RETURNTRANSFER, 1); 
		$sina = curl_exec($curl); 
		curl_close($curl);
		$sina = json_decode($sina, true);
		$_SESSION['s_nick'] = $sina['screen_name'];
	}
	catch(OAuthException $e)
	{
		$_SESSION['s_status'] = false;
	}
}
else
{
	$_SESSION['s_status'] = false;
}
header('location: http://blog.tennsinn.com/TypechoSync');
?>
