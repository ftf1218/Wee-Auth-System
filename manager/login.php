<?php
/*
 * @FilePath: /Wee-Auth-System/manager/login.php
 * @author: Wibus
 * @Date: 2021-08-29 20:57:29
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-29 21:15:23
 * Coding With IU
 */
$mod='blank';
include_once("../config.php");
include("../api.inc.php");
if(isset($_POST['user']) && isset($_POST['pass'])){
	$user=daddslashes($_POST['user']);
	$pass=daddslashes($_POST['pass']);
	$row = $DB->get_row("SELECT * FROM auth_user WHERE user='$user' limit 1");
	if($row['user']=='') {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('此用户不存在');history.go(-1);</script>");
	}elseif ($pass != $row['pass']) {
		@header('Content-Type: text/html; charset=UTF-8');
		exit("<script language='javascript'>alert('用户名或密码不正确！');history.go(-1);</script>");
	}elseif($row['user']==$user && $row['pass']==$pass){
		$session=md5($user.$pass.$password_hash);
		$token=authcode("{$user}\t{$session}", 'ENCODE', SYS_KEY);
		setcookie("auth_token", $token, time() + 604800);
		@header('Content-Type: text/html; charset=UTF-8');
		$city=get_ip_city($clientip);
		$DB->query("insert into `auth_log` (`uid`,`type`,`date`,`city`,`data`) values ('".$user."','登陆平台','".$date."','".$city."','IP:".$clientip."')");
		exit("<script language='javascript'>alert('登陆成功');window.location.href='./';</script>");
	}
}elseif(isset($_GET['logout'])){
	setcookie("auth_token", "", time() - 604800);
	@header('Content-Type: text/html; charset=UTF-8');
	exit("<script language='javascript'>alert('注销成功');window.location.href='./login.php';</script>");
}elseif($islogin==1){
	exit("<script language='javascript'>alert('都登陆了，想干啥你！');window.location.href='./';</script>");
}
$title='用户登录';
include './header.php';
?>
<body class="bg-gradient-primary">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-9 col-lg-12 col-xl-10">
                <div class="card shadow-lg o-hidden border-0 my-5">
                    <div class="card-body p-0">
                        <div class="row">
                            <div class="col-lg-6 d-none d-lg-flex">
                                <div class="flex-grow-1 bg-login-image" style="background-image: url(&quot;assets/img/dogs/image3.jpeg&quot;);"></div>
                            </div>
                            <div class="col-lg-6">
                                <div class="p-5">
                                    <div class="text-center">
                                        <h4 class="text-dark mb-4">Welcome to STY</h4>
                                    </div>
                                    <form class="user" action="./login.php" method="post" role="form">
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="text" name="user"  id="exampleInputEmail" aria-describedby="emailHelp" placeholder="Enter User Name..."></div>
                                        <div class="mb-3">
                                            <input class="form-control form-control-user" type="password" id="exampleInputPassword" name="pass" placeholder="Password" required="required" ></div>
                                        <div class="mb-3">
                                            <div class="custom-control custom-checkbox small">
                                                <div class="form-check"><input class="form-check-input custom-control-input" type="checkbox" id="formCheck-1">
                                                <!-- <label class="form-check-label custom-control-label" for="formCheck-1"> -->
                                                <!-- <input type="checkbox" id="remember" value="1"> Remember Me -->
                                                <!-- </label> -->
                                            </div>
                                            </div>
                                        </div><button class="btn btn-primary d-block btn-user w-100" type="submit">Login</button>
                                        <!-- <hr> -->
                                        <!-- <a class="btn btn-primary d-block btn-google btn-user w-100 mb-2" role="button"><i class="fab fa-google"></i>&nbsp; Login with Google</a><a class="btn btn-primary d-block btn-facebook btn-user w-100" role="button"><i class="fab fa-facebook-f"></i>&nbsp; Login with Facebook</a> -->
                                        <hr>
                                    </form>
                                    <div class="text-center">
                                        <a class="small" href="https://blog.iucky.cn">Dev. By Wibus</a>
                                        <div class="text-center">
                                        <a class="small" href="https://github.com/wibus-wee/Wee-Auth-System">Power By Wee-Auth-System</a>
                                    </div>
                                    </div>
                                    <!-- <div class="text-center"><a class="small" href="forgot-password.html">Forgot Password?</a></div>
                                    <div class="text-center"><a class="small" href="register.html">Create an Account!</a></div> -->
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>