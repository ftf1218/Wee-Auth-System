<?php
/**
 * 添加用户
**/
$mod='blank';
include("../api.inc.php");
$title='添加用户';
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
if($udata['per_db']==0) {
	showmsg('您的账号没有权限使用此功能',3);
	exit;
}
if(isset($_POST['user']) && isset($_POST['pass'])&& isset($_POST['dlqq'])){
$per=daddslashes($_POST['per']);
if($per=="1"){
	$per_sq=1;
	$per_db=0;
	$active=1;
}else if($per=="2"){
	$per_sq=1;
	$per_db=1;
	$active=1;
}else if($per=="3"){
	$per_sq=0;
	$per_db=0;
	$active=0;
}
if($per=="1"){
  $dlqq=daddslashes($_POST['dlqq']);
  $user=$dlqq;
  $pass=$dlqq;
}
$row=$DB->get_row("SELECT * FROM auth_user WHERE user='{$user}' limit 1");
if($row) {
	showmsg('用户名已存在',3);
	exit;
}
	$sql="insert into `auth_user` (`user`,`pass`,`dlqq`,`per_sq`,`per_db`,`active`) values ('".$user."','".$pass."','".$dlqq."','".$per_sq."','".$per_db."','".$active."')";
	$DB->query($sql);
	$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$udata['user']."','添加用户','".$date."','".$city."','新用户名".$user."|授权".$per_sq."|获取".$per_db."|状态".$active."')");

exit("<script language='javascript'>alert('添加用户成功！');window.location.href='userlist.php';</script>");
} 
				if(($udata['uid'])=="1"){$all='	<option value="1">普通用户（仅简单权限，仅需要填写QQ即可自动生成其他的了）</option>';}
?>
      <div class="panel-heading font-bold">添加用户</div>
        <div class="panel-body">
          <form action="./adduser.php" method="post" class="form-horizontal" role="form">
		  <input type="hidden" name="backurl" value="<?php echo $_SERVER['HTTP_REFERER']; ?>"/>
            <div class="input-group">
              <span class="input-group-addon">用户名:</span>
              <input type="text" name="user" value="<?=@$_POST['user']?>" class="form-control" placeholder="" autocomplete="off" required/>
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">密码:</span>
              <input type="password" name="pass" value="<?=@$_POST['pass']?>" class="form-control" autocomplete="off" required/>
            </div><br/>
            <div class="input-group">
              <span class="input-group-addon">QQ:</span>
              <input type="text" name="dlqq" value="<?=@$_POST['dlqq']?>" class="form-control" autocomplete="off" required/>
            </div><br/>
			<div class="input-group">
			  <span class="input-group-addon">权限:</span>
			  <select name="per" class="form-control">
				<?php echo $all;?>
					<option value="2">副站长（所有权限）</option>
					<option value="3">封禁该用户（无任何权限）</option>
              </select>
            </div><br/>
            <div class="form-group">
              <div class="col-sm-12"><input type="submit" value="添加" class="btn btn-primary form-control"/></div>
            </div>
          </form>
        </div>
        <div class="panel-footer">
          <span class="glyphicon glyphicon-info-sign"></span> 全部操作权限才可以管理其他用户
        </div>
      </div>
    </div>
  </div>
<?php include './foot.php';?>