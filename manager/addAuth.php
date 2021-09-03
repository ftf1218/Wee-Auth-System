<?php
/*
 * @FilePath: /Wee-Auth-System/manager/addAuth.php
 * @author: Wibus
 * @Date: 2021-08-30 13:30:40
 * @LastEditors: Wibus
 * @LastEditTime: 2021-09-04 06:49:45
 * Coding With IU
 */
$mod='blank';
include("../api.inc.php");
$title='添加站点';
include './header.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
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
if($row=='')exit("<script language='javascript'>alert('数据库出现问题，正在跳转至正确渠道');window.location.href='add.php';</script>");
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
} 
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

                    <h3 class="text-dark mb-4">添加站点</h3>
                    <div class="row mb-3">
                    <div class=">
                        <div class="">
                            <div class="row">
                                <div class="col">
                                    
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">添加站点</p>
                                        </div>
                                        <div class="card-body">

                                        <!-- 表格 -->
                                        <form action="./addAuth.php" method="post" role="form">
                                            <div class="mb-3">
                                                <label class="form-label" for="address">
                                                    <strong>QQ号</strong>
                                                </label>
                                                <input
													type="text"
													name="qq"
													value="<?=@$_POST['qq']?>"
													class="form-control"
													placeholder="购买授权的QQ"
													autocomplete="off"
													required="required"/>

                                                <div class="mb-3">
                                                    <label class="form-label" for="address">
                                                        <strong>授权站点</strong>
                                                    </label>
                                                    <input
                                                        type="text"
                                                        name="url"
                                                        value="<?=@$_POST['url']?>"
                                                        class="form-control"
                                                        placeholder="添多个域名请用英文逗号 , 隔开！"
                                                        autocomplete="off"
                                                        required="required"/>
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