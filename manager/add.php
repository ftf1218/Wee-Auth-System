<?php
/**
 * 添加站点
**/
$mod='blank';
include("../api.inc.php");
$title='添加授权';
include './header.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
// if ($udata['per_db'] == 0) { //如果是用户的话
//   showmsg('您的账号没有权限使用此功能，请前往添加站点添加新的授权！',3);
// exit;
// }
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
if($row!='')exit("<script language='javascript'>alert('授权平台已存在该QQ，正在跳转至正确位置');hwindow.location.href='addAuth.php';</script>");
$row1=$DB->get_row("SELECT * FROM auth_site WHERE 1 order by sign desc limit 1");
$sign=$row1['sign']+1;
$authcode=md5(random(32).$qq);
$row2=$DB->get_row("SELECT * FROM auth_site WHERE authcode='{$authcode}' limit 1");
if($row!='')exit("<script language='javascript'>alert('请返回重新操作！');history.go(-1);</script>");
$url_arr=explode(',',$url);
foreach($url_arr as $val) {
	$sql="insert into `auth_site` (`uid`,`url`,`date`,`authcode`,`active`,`sign`) values ('".$qq."','".trim($val)."','".$date."','".$authcode."','1','".$sign."')";
	$DB->query($sql);
}
$city=get_ip_city($clientip);
$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','新增授权','".$date."','".$city."','".$qq."|".$url."')");
exit("<script language='javascript'>alert('添加授权成功！');window.location.href='downfile.php?qq={$qq}';</script>");
}  ?>


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
                    <h3 class="text-dark mb-4">新增授权</h3>
                    <div class="row mb-3">
					<div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="https://q1.qlogo.cn/g?b=qq&nk=<?=$udata['dlqq']?>&s=640" width="160" height="160">
                                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">QQ Photo</button></div>
                                </div>
                            </div>
                        </div class="col-lg-8">
                        <div>
                            <div class="row">
                                <div class="col">
                                    
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">新增授权</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="./add.php" method="post" role="form">
                                                <div class="mb-3"><label class="form-label" for="address"><strong>QQ号</strong></label>
                                                <input type="text" name="qq" value="<?=@$_POST['qq']?>" class="form-control" placeholder="购买授权的QQ" autocomplete="off" required/>
                                                
                                                
                                            <div class="mb-3"><label class="form-label" for="address"><strong>授权站点</strong></label>
											<input type="text" name="url" value="<?=@$_POST['url']?>" class="form-control" placeholder="" autocomplete="off" required placeholder="添多个域名请用英文逗号 , 隔开！"/>
                                        </div><div class="mb-3">
                                            <!-- <button class="btn btn-primary btn-sm" type="submit">Save&nbsp;Settings</button> -->
                                            <input type="submit" name="submit" value="添加" class="btn btn-primary btn-sm"/>
                                        </div></form>
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