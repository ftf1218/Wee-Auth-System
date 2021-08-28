<?php
/**
 * 登录
**/
$mod='blank';
include_once("../config.php");
include("../api.inc.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
	$row = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
	if($row['user']=='') {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('此用户不存在');history.go(-1);</script>");
	}elseif ($pass != $row['pass']) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}elseif($row['user']==$user && $row['pass']==$pass){
		$session=md5($user.$pass.$password_hash);
		$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("auth_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','登陆平台','".$date."','".$city."','IP:".$clientip."')");
		exit("<script language='javascript'>alert('登陆成功');window.location.href='./';</script>");
	}
}elseif(isset($_GET['logout'])){
	setcookie("auth_token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('注销成功');window.location.href='./login.php';</script>");
}elseif($islogin==1){
	exit("<script language='javascript'>alert('都登陆了，想干啥你！');window.location.href='./';</script>");
}
$title='用户登录';
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title><?=$title?></title>
<meta name="keywords" content="授权平台,授权平台"/>
<meta name="description" content="授权平台授权平台"/>
<link rel="stylesheet" href="Public/Style/css/font-awesome.min.css" type="text/css" />
<link rel="stylesheet" href="Public/wap/css/wap.css" type="text/css" />
<link rel="stylesheet" href="Public/wap/css/app.css" type="text/css" />
</head>


<body class="bg-white" ontouchstart="">
<div class="container w-xxxl padder">
<div class="text-center logo">
	<h2>授权管理后台</h2>
</div>
<form action="./login.php" method="post" class="form-horizontal" role="form">
<div class="list b-t-0 m-t padder-0">
<div class="input-group">
<span class="input-group-addon padder-0">账号</span>
<input type="text" name="user" class="form-control no-border"  placeholder="用户名" required="required" >
</div>
</div>
<div class="list b-t-0 m-t padder-0">
<div class="input-group">
<span class="input-group-addon padder-0">密码</span>
<input type="password" class="form-control no-border" name="pass" placeholder="密码" required="required" >
</div>
</div>
<div class="m-t-lg">
<label class="checkbox i-checks">
<input type="checkbox" id="remember" value="1"><i></i>
记住我
</label>
</div>
<button class="btn btn-lg btn-info btn-block m-t-xl" type="submit" style="width:100%;height:100%;">登&nbsp;&nbsp;录</button>
</div>
</div>
<script src="Public/Style/js/jquery-2.1.1.min.js"></script>
<script src="Public/wap/layer_mobile/layer.js"></script>
<script src="Public/wap/js/app.js"></script><script type="text/javascript"> $(document).keyup(function(event){ if(event.keyCode ==13){ login(''); } }); </script>
</body>
</html>