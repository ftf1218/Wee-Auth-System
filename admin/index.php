<?php
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
<td align="center"><font color="#808080"><b><i class="glyphicon"></i>您的QQ</b></br></span><?=$udata['dlqq']?></font></td>
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
      <div class="panel panel-primary">
        <div class="panel-heading"><h3 class="panel-title">Wee Auth System</h3></div>
          <ul class="list-group">
            <li class="list-group-item"><span class="glyphicon glyphicon"></span> Second-Develop By Wibus</li>
            <li class="list-group-item"><span class="glyphicon glyphicon"></span> 强化了检测API的安全性，确保AuthCode与数据库中匹配</li>
            <li class="list-group-item"><span class="glyphicon glyphicon"></span> 优化前端，去除了碍眼二次元和极其容易吵到别人的音乐</li>
            <li class="list-group-item"><span class="glyphicon glyphicon"></span> 优化了检测API，去除了无用的VERSION变量，新增了远程获取的功能（使用file_get_contents保证GitHub raw正常通行）</li>
            </li>
            <li class="list-group-item"><span class="glyphicon glyphicon"></span> 修复了检测API的header解析问题，确保为json的header</li>
            <li class="list-group-item"><span class="glyphicon glyphicon"></span> 优化了后台样式，变得更加舒适，考虑重构中</li>
            </li>
          </ul>
</table>
      </div>
      
        </div>
    </div>
  </div>
<?php include './foot.php';?>
