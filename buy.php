<?php
// $uarowser=$_SERVER['HTTP_USER_AGENT'];

// if(strstr($uarowser, 'MSIE 6') || strstr($uarowser, 'MSIE 7') || strstr($uarowser, 'MSIE 8')){
//  // echo 5005;
//  exit;
// }



?>
﻿<?php
include("./api.inc.php");
require './config.php';
if($_POST['do'] == 'do'){
	$km = $_POST['km'];
	$qq = $_POST['qq'];
	$url = $_POST['url'];
	$date = date("Y-m-d H-i-s");
	$row1=$DB->get_row("SELECT * FROM auth_site WHERE 1 order by sign desc limit 1");
	$row2=$DB->get_row("SELECT * FROM auth_site WHERE uid='{$qq}' limit 1");
	$row3=$DB->get_row("SELECT * FROM auth_site WHERE url='{$url}' limit 1");
	$sign=$row1['sign']+1;
	$authcode=md5(random(32).$qq); //授权代码
	$row = $DB->get_row("SELECT * FROM auth_kms WHERE km = '{$km}'");
	if($km == '' or $qq == '' or $url ==''){
		exit("<script language='javascript'>alert('所有项不能留空!');history.go(-1);</script>");
	}
	if(!$row){
		exit("<script language='javascript'>alert('此卡密不存在!');history.go(-1);</script>");
	}else if($row['zt'] == '0'){
		exit("<script language='javascript'>alert('此卡密已使用！');history.go(-1);</script>");
	}else if($row3 != ''){
		exit("<script language='javascript'>alert('平台已存在此域名！');history.go(-1);</script>");
	}else if($row2 != ''){
		$DB->query("update auth_kms set zt = '0' where id='{$row['id']}'");
		$DB->query("INSERT INTO auth_site (`uid`, `url`, `date`, `authcode`, `sign`,`active`) VALUES ('$qq', '$url', '$date', '".$row2['authcode']."', '".$row2['sign']."', '1')");
		exit("<script language='javascript'>alert('授权成功!');history.go(-1);</script>");
	}else{
		$DB->query("update auth_kms set zt = '0' where id='{$row['id']}'");
		$DB->query("INSERT INTO auth_site (`uid`, `url`, `date`, `authcode`, `sign`,`active`) VALUES ('$qq', '$url', '$date', '$authcode', '$sign', '1')");
		exit("<script language='javascript'>alert('授权成功! 您的授权代码为：".$authcode."！请保管妥善！');history.go(-1);</script>");
	}
}else{
    exit("<script language='javascript'>alert('未定义参数');history.go(-1);</script>");
}
?>