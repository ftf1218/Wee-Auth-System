<?php
if ($_GET['do'] == "clear_km_no") {
    $db->query("delete from {$prefix}kms where isuse<>'1'");
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
}

if ($_GET['do'] == "clear_km_all") {
    $db->query("delete from {$prefix}kms where 1");
    exit("<script language='javascript'>alert('删除成功！');window.location.href='index.php';</script>");
}

$mod='blank';
include("../api.inc.php");
$title='授权管理中心';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<?php
$sites=$DB->count("SELECT count(*) from auth_site WHERE 1");
$blocks=$DB->count("SELECT count(*) from auth_block WHERE 1");
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" >
<div class="panel-heading font-bold">后台管理首页</div>
<div class="panel-body">
<table class="table table-bordered">
<tbody>
<tr height="25">
<td align="center"><font color="#808080"><b><span class="glyphicon"></span>站点统计：</b></br>正版:<?=$sites?>，盗版:<?=$blocks?></font></td>
<td align="center"><font color="#808080"><b><i class="glyphicon"></i>现在时间：</b></br></span><?=$date?></font></td>
</tr>
<tr height="25">
<td align="center"><font color="#808080"><b><i class="glyphicon"></i>登录IP：</b></br><?=$udata['dlip']?></font></td>
<td align="center"><font color="#808080"><b><i class="glyphicon"></i>登录时间：</b></span></br><?=$udata['last']?></font></td>
</tr>
<tr height="25">
<td align="center"><font color="#808080"><b><span class="glyphicon"></span>账号权限：</b></br>获取密码权限=<?=$udata['per_db']?>  授权操作权限=<?=$udata['active']?></font></td>
<td align="center"><font color="#808080"><b><i class="glyphicon"></i>欢迎您管理员：</b></br></span><?=$udata['user']?></font></td>
<tr height="25">
<td align="center"><font color="#808080"><b><span class="glyphicon"></span>服务器软件：</b></br><?php echo $_SERVER['SERVER_SOFTWARE'] ?></font></td>
<td align="center"><font color="#808080"><b><i class="glyphicon"></i>你的:QQ</b></br></span><?=$udata['dlqq']?></font></td>
</tr>
<tr height="25">
<td align="center"><a href="../" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-home"></i>网站首页</a></td>
<td align="center"><a href="./add.php" class="btn btn-sm btn-info"><i class="glyphicon glyphicon-home"></i>添加授权</a></td>
</tr>
<tr height="25">
<td align="center"><a href="./addsite.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-folder-close"></i>添加站点</a></td>
<td align="center"><a href="./km.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-cog"></i>生成卡密</a></td>
</tr>
<tr height="25">
<td align="center"><a href="./search.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-globe"></i>搜索授权</a></td>
<td align="center"><a href="./password.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-cog"></i>修改密码</a></td>
</tr>
<tr height="25">
<td align="center"><a href="./userlist.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-globe"></i>用户列表</a></td>
<td align="center"><a href="./adduser.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-cog"></i>添加用户</a></td>
</tr>
<tr height="25">
<td align="center"><a href="./log.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-globe"></i>操作记录</a></td>
<td align="center"><a href="./downfile.php" class="btn btn-sm btn-danger"><i class="glyphicon glyphicon-cog"></i>下载管理</a></td>
</tr>
</tbody>
</table>
      </div>
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">函数检测</div>
                <div class="panel-body">
                    被禁用函数：<?= ("" == ($disFuns = get_cfg_var("disable_functions"))) ? "无" : str_replace(",", "<br />", $disFuns) ?>
                    <br><br>
                    php运行方式：<?php echo $_SERVER['SERVER_SOFTWARE']; ?><br><br>
                    服务器IP：<?php echo $_SERVER['SERVER_NAME']; ?>(<?php if ('/' == DIRECTORY_SEPARATOR) {
                        echo $_SERVER['SERVER_ADDR'];
                    } else {
                        echo @gethostbyname($_SERVER['SERVER_NAME']);
                    } ?>)<br><br>
                    操作系统：<?php $os = explode(" ", php_uname());
                    echo $os[0]; ?> &nbsp;内核版本：<?php if ('/' == DIRECTORY_SEPARATOR) {
                        echo $os[2];
                    } else {
                        echo $os[1];
                    } ?><br><br>
                    总空间：<?php echo $dt; ?>&nbsp;G，
                    已用：<font color='#333333'><span id="useSpace"><?php echo $du; ?></span></font>&nbsp;G，
                    空闲：<font color='#333333'><span id="freeSpace"><?php echo $df; ?></span></font>&nbsp;G，
                    使用率：<span id="hdPercent"><?php echo $hdPercent; ?></span>%
                    <br><br>
                    Cookies支持：<?php echo isset($_COOKIE) ? '<font color="green">√</font>' : '<font color="red">×</font>'; ?>
                    <br><br>
                    PHP 版本：</b><?php echo phpversion() ?><?php if (ini_get('safe_mode')) {
                        echo '线程安全';
                    } else {
                        echo '非线程安全';
                    } ?><br><br>
                    程序最大运行时间：<?php echo ini_get('max_execution_time') ?>s<br><br>
                    POST许可：<?php echo ini_get('post_max_size'); ?><br><br>
                    文件上传许可：<?php echo ini_get('upload_max_filesize'); ?><br>
                </div>
            </div>
            
        </div>
    </div>
  </div>
<?php include './foot.php';?>