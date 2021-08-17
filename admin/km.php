<?php
$mod='blank';
include("../api.inc.php");
$title='卡密生成';
include './head.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
$num = $_POST['num'];
function getkmkey($len = 16)
{
    $str = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789';
    $strlen = strlen($str);
    $randstr = '';
    for ($i = 0; $i < $len; $i++) {
        $randstr .= $str[mt_rand(0, $strlen - 1)];
    }
    return $randstr;
}
if ($udata['per_db'] == 0) { //如果是用户的话
    showmsg('您的账号没有权限使用此功能',3);
	exit;
}
?>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
<div class="panel panel-info" >
<div class="panel-heading font-bold">卡密生成</div>
<div class="panel-body">
<form method="post" action="" >
<input type="hidden" name="do" value="do">
<div class="input-group">
              <span class="input-group-addon">卡密个数</span>
              <input type="text" name="num"  class="form-control" placeholder="输入需要生成的个数">
            </div><br/>
<div class="col-sm-12"><input type="submit" value="确认生成" class="btn btn-primary form-control"/></div>
</from>
</div>
  <div class="panel-footer text-center">请填写生成卡密数量</div>
	</div>
		</div>
		<div class="col-sm-2"></div>
<div class="col-lg-8 col-md-12 col-lg-offset-2 text-center">
	  <div class="panel panel-primary">
	  <div class="panel-heading">生成结果</div>
  	<div class="panel-body">
      <?php
if ($_POST['do'] == 'do') {
	if ($num != '') {
		for ($i=1;$i<=$num;$i++) {
			$key = getkmkey();
			$DB->query("INSERT INTO `auth_kms` (`km`, `zt`) VALUES ('$key', '1')");
			$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$udata['user']."','生成卡密','".$date."','".$city."','卡密".$key."|数量".$num."')");

			}
				}else{
		exit("<script language='javascript'>alert('数量不能为空！');history.go(-1);</script>");
	}}
			?>
			<div class="table-responsive">
        <table class="table table-striped">
          <thead><tr><th>ID</th><th>卡密</th><th>状态</th></tr></thead>
          <tbody>
<?php
if (!isset($_GET['page'])) {
	$page = 1;
	$pageu = $page - 1;
} else {
	$page = $_GET['page'];
	$pageu = ($page - 1) * $pagesize;
}
$pagesize=30;
$rs=$DB->query("SELECT * FROM auth_kms WHERE 1 order by id desc limit $pageu,$pagesize");
while($res = $DB->fetch($rs))
{
echo '<tr><td>'.$res['id'].'</td><td>'.$res['km'].'</td><td>'.$res['zt'].'</td></tr>';
}
?>
          </tbody>
        </table>
      </div>
<?php
echo'<ul class="pagination">';
$s = ceil($gls / $pagesize);
$first=1;
$prev=$page-1;
$next=$page+1;
$last=$s;
if ($page>1)
{
echo '<li><a href="km.php?page='.$first.$link.'">首页</a></li>';
echo '<li><a href="km.php?page='.$prev.$link.'">«</a></li>';
} else {
echo '<li class="disabled"><a>首页</a></li>';
echo '<li class="disabled"><a>«</a></li>';
}
for ($i=1;$i<$page;$i++)
echo '<li><a href="km.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '<li class="disabled"><a>'.$page.'</a></li>';
for ($i=$page+1;$i<=$s;$i++)
echo '<li><a href="km.php?page='.$i.$link.'">'.$i .'</a></li>';
echo '';
if ($page<$s)
{
echo '<li><a href="km.php?page='.$next.$link.'">»</a></li>';
echo '<li><a href="km.php?page='.$last.$link.'">尾页</a></li>';
} else {
echo '<li class="disabled"><a>»</a></li>';
echo '<li class="disabled"><a>尾页</a></li>';
}
echo'</ul>';
#分页
?>
    </div>
  </div>
<?php include './foot.php';?>