<?php
include("api.inc.php");
$file = 'https://github.com/wibus-wee/STY-static/raw/main/.ver';
$version = file_get_contents($file);
$version= str_replace(array("\r\n", "\r", "\n"), "", $version);  
$id=$conf['id'];
$url=daddslashes($_GET['url']);
$authcode=daddslashes($_GET['authcode']);
$content=$confs['content'];//未授权显示内容
$allowupdate=$conf['update'];
$uplog=$confs['uplog'];



if($_GET['ver']) {

	$param=base64_encode(authcode($_GET['ver']."\t".$url."\t".$authcode."\t".(time()+600),'ENCODE','daigua!!'));
	$download=$siteurl.'download.php?update=true&param='.$param.'&rand='.rand(100000,999999);
}

if(checkauth3($url, $authcode)) {
	if($_GET['ver'])
		$result=array('code'=>'1','msg'=>$version,'authcode'=>$authcode);
	else
		$result=array('code'=>'1','authcode'=>$authcode);
} else {
	$result=array('code'=>'-1','msg'=>$content);
}
header('Content-Type:application/json');
echo json_encode($result);
$DB->close();
?>