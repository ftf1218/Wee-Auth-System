<?php
/**
 * 添加站点
**/
$mod='blank';
include("../api.inc.php");
$title='添加站点';
include './header.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" >
<?php
/*if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}*/
if(isset($_POST['qq']) && isset($_POST['url'])){
  if ($udata['per_db'] == 0) { //如果是用户的话
    $_POST['qq'] = $udata['dlqq'];
  }
$qq=daddslashes($_POST['qq']);
$url=daddslashes($_POST['url']);
$row=$DB->get_row("SELECT * FROM auth_site WHERE uid='{$qq}' limit 1");
if($row=='')exit("<script language='javascript'>alert('授权平台不存在该QQ！');history.go(-1);</script>");
if($row['active']==0)exit("<script language='javascript'>alert('此QQ的授权已被封禁！');history.go(-1);</script>");
$url_arr=explode(',',$url);
$re='';
foreach($url_arr as $val) {
	$row1=$DB->get_row("SELECT * FROM auth_site WHERE url='{$val}' limit 1");
	if($row1!='')continue;
	$sql="insert into `auth_site` (`uid`,`url`,`date`,`authcode`,`active`,`sign`) values ('".$qq."','".trim($val)."','".$date."','".$row['authcode']."','1','".$row['sign']."')";
	$DB->query($sql);
	$re.=$val.',';
}
if($re){
$city=get_ip_city($clientip);
$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','添加站点','".$date."','".$city."','".$qq."|".$re."')");
exit("<script language='javascript'>alert('{$re}添加成功！');window.location.href='downfile.php?qq={$qq}'</script>");
}else
exit("<script language='javascript'>alert('添加失败，可能域名已存在！');history.go(-1);</script>");
} ?>
