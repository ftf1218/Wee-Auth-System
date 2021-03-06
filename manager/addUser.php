<?php
/*
 * @FilePath: /Wee-Auth-System/manager/addUser.php
 * @author: Wibus
 * @Date: 2021-08-30 13:50:05
 * @LastEditors: Wibus
 * @LastEditTime: 2021-09-04 06:51:31
 * Coding With IU
 */
$mod='blank';
include("../api.inc.php");
$title='添加用户';
include './header.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<body id="page-top">
    <div id="wrapper">
        <nav class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0" href="#">
                    <div class="sidebar-brand-icon rotate-n-15"><i class="fab fa-skyatlas"></i></div>
                    <div class="sidebar-brand-text mx-3"><span>STY Auth</span></div>
                </a>
                <hr class="sidebar-divider my-0">
                <? require('components/leftBar.php') ?>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <? require('components/headnav.php') ?>
                <div class="container-fluid">
                <?php
if($udata['per_sq']==0) {
	msgShow('您的账号没有权限使用此功能',3);
	exit;
}
if($udata['per_db']==0) {
	msgShow('您的账号没有权限使用此功能',3);
	exit;
}
if(isset($_POST['user']) && isset($_POST['pass'])&& isset($_POST['dlqq'])){
$user=daddslashes($_POST['user']);
$dlqq=daddslashes($_POST['dlqq']);
$row=$DB->get_row("SELECT * FROM auth_user WHERE user='{$user}' limit 1");
if($row) {
	msgShow('用户名已存在',3);
	exit;
}
$pass=daddslashes($_POST['pass']);
$per=daddslashes($_POST['per']);
if($per=="1"){
	$per_sq=1;
	$per_db=1;
	$active=1;
}else if($per=="2"){
	$per_sq=1;
	$per_db=0;
	$active=1;
}else if($per=="3"){
	$per_sq=0;
	$per_db=0;
	$active=0;
	}
	$sql="insert into `auth_user` (`user`,`pass`,`dlqq`,`per_sq`,`per_db`,`active`) values ('".$user."','".$pass."','".$dlqq."','".$per_sq."','".$per_db."','".$active."')";
	$DB->query($sql);
	$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$udata['user']."','添加用户','".$date."','".$city."','新用户名".$user."|授权".$per_sq."|获取".$per_db."|状态".$active."')");

exit("<script language='javascript'>alert('添加用户成功！');window.location.href='userlist.php';</script>");
} 
				if(($udata['uid'])=="1"){$all='	<option value="1">副站长</option>';}
?>
                    <h3 class="text-dark mb-4">新增用户</h3>
                    <div class="row mb-3">
                    <div class=">
                        <div class="">
                            <div class="row">
                                <div class="col">
                                    
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">新增用户</p>
                                        </div>
                                        <div class="card-body">

                                        <!-- 表格 -->
                                        <form action="./adduser.php" method="post" role="form">
                                            <div class="mb-3">
                                                <label class="form-label" for="address">
                                                    <strong>User Name</strong>
                                                </label>
                                                <input type="text" name="user" value="<?=@$_POST['user']?>" class="form-control" placeholder="" autocomplete="off"/>

                                                <div class="mb-3">
                                                    <label class="form-label" for="address">
                                                        <strong>Password</strong>
                                                    </label>
                                                    <input type="password" name="pass" value="<?=@$_POST['pass']?>" class="form-control" autocomplete="off"/>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="form-label" for="address">
                                                        <strong>QQ</strong>
                                                    </label>
                                                    <input type="text" name="dlqq" value="<?=@$_POST['dlqq']?>" class="form-control" autocomplete="off" required/>
                                                </div>
                                                <div class="mb-3">
                                                    <!-- <button class="btn btn-primary btn-sm"
                                                    type="submit">Save&nbsp;Settings</button> -->
                                                    <input type="submit" name="submit" value="添加" class="btn btn-primary btn-sm"/>
                                                </div>
                                            </form>
                                            <!-- 结束表格 -->

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright"><span>Copyright © STY Auth 2021</span></div>
                </div>
            </footer>
        </div><a class="border rounded d-inline scroll-to-top" href="#page-top"><i class="fas fa-angle-up"></i></a>
    </div>
<? include './footer.php' ?>