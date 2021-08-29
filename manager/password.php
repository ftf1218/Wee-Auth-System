<?php
/*
 * @FilePath: /Wee-Auth-System/manager/password.php
 * @author: Wibus
 * @Date: 2021-08-29 21:19:31
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-29 22:04:41
 * Coding With IU
 */
$mod='blank';
include("../api.inc.php");
$title='修改密码';
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
                <? include './leftbar.php' ?>
            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
                <? include './headnav.php' ?>
                <div class="container-fluid">
                <?php
                if(isset($_POST['submit'])) {
                $oldpass=daddslashes($_POST['oldpass']);
                if($oldpass!=$udata['pass']) {
                    msgShow('原密码错误',4);
                    exit;
                }
                $newpass=daddslashes($_POST['newpass']);
                $sql="update `auth_user` set `pass` ='{$newpass}' where `uid`='{$udata['uid']}'";
                if($DB->query($sql)){
                    setcookie("admin_token", "", time() - 604800);
                    @header('Content-Type: text/html; charset=UTF-8');
                    exit("<script language='javascript'>alert('修改成功，请重新登陆！');window.location.href='./login.php';</script>");
                }else{
                    msgShow('修改失败！<br/>'.$DB->error(),4,$_POST['backurl']);
                    exit();
                    }
                }
                // 640
                ?>
                    <h3 class="text-dark mb-4">Profile</h3>
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <div class="card mb-3">
                                <div class="card-body text-center shadow"><img class="rounded-circle mb-3 mt-4" src="https://q1.qlogo.cn/g?b=qq&nk=<?=$udata['dlqq']?>&s=640" width="160" height="160">
                                    <div class="mb-3"><button class="btn btn-primary btn-sm" type="button">QQ Photo</button></div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-8">
                            
                            <div class="row">
                                <div class="col">
                                    
                                    <div class="card shadow">
                                        <div class="card-header py-3">
                                            <p class="text-primary m-0 fw-bold">Password Settings</p>
                                        </div>
                                        <div class="card-body">
                                            <form action="./password.php" method="post" role="form">
                                                <div class="mb-3"><label class="form-label" for="address"><strong>旧密码</strong></label>
                                                <input class="form-control" type="password" name="oldpass" value="<?php echo @$_POST['oldpass'];?>" required="required" placeholder="Old Password"></div>
                                                
                                                
                                            <div class="mb-3"><label class="form-label" for="address"><strong>新密码</strong></label>
                                            <input class="form-control" type="password" name="newpass"  placeholder="New Password" required="required">
                                        </div><div class="mb-3">
                                            <!-- <button class="btn btn-primary btn-sm" type="submit">Save&nbsp;Settings</button> -->
                                            <input type="submit" name="submit" value="修改" class="btn btn-primary btn-sm"/>
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