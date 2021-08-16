<?php
@header('Content-Type: text/html; charset=UTF-8');
?>
<!DOCTYPE html>
  <meta name="baidu-site-verification" content="j5IVXG1E2K">
  <meta name="baidu-site-verification" content="xH38E2nXT8">
  <html lang="en"><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
  <meta charset="utf-8">
  <title><?=$title?></title>
  <meta name="keywords" content="授权平台,授权平台"/>
  <meta name="description" content="授权平台授权平台"/>
  <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
  <meta name="renderer" content="webkit">
    <!-- CSS JS文件加载 -->
  <link rel="stylesheet" href="./userui/bootstrap.css" type="text/css">
  <link rel="stylesheet" href="./userui/animate.css" type="text/css">
  <link rel="stylesheet" href="./userui/font-awesome.min.css" type="text/css">
  <link rel="stylesheet" href="./userui/simple-line-icons.css" type="text/css">
  <link rel="stylesheet" href="./userui/font.css" type="text/css">
  <link rel="stylesheet" href="./userui/app.css" type="text/css">
  <link rel="stylesheet" href="./userui/sweetalert.css" type="text/css">
  <script src="./userui/hm.js"></script><script src="./userui/jquery-2.1.1.min.js"></script>
  <script src="./userui/jquery.pjax.min.js"></script>
  <script src="./userui/layer.js"></script><link rel="stylesheet" href="./userui/layer.css" id="layui_layer_skinlayercss">
  <script src="./userui/laydate.js"></script><link type="text/css" rel="stylesheet" href="./userui/laydate.css"><link type="text/css" rel="stylesheet" href="./userui/laydate(1).css" id="LayDateSkin">
  <script src="./userui/xiaoke-app.js"></script>
  <!-- CSS JS文件结束 -->
</head>
<body>
<div class="app app-header-fixed">
<!-- 导航部分开始 -->
<div class="app-header navbar">
<div class="navbar-header bg-info dk">
<button class="pull-right visible-xs" data-toggle="class:off-screen" data-target=".app-aside" ui-scroll="app">
<i class="glyphicon glyphicon-align-justify"></i>
</button>
<button class="pull-right visible-xs" data-toggle="class:show" data-target=".navbar-collapse">
<i class="glyphicon glyphicon-cog"></i>
</button>
<a href="#" class="navbar-brand text-lt text-center">
<i class="fa fa-rocket"></i>
<span class="hidden-folded m-l-xs"><?=$title?></span>
</a>
</div>
<div class="collapse pos-rlt navbar-collapse box-shadow bg-info dk">
<div class="nav navbar-nav hidden-xs">
<a href="javascript:;" class="btn no-shadow navbar-btn" data-toggle="class:app-aside-folded" data-target=".app">
<i class="fa fa-dedent fa-fw text"></i>
<i class="fa fa-indent fa-fw text-active"></i>
</a>
<a href="" class="btn no-shadow navbar-btn" data-pjax="">
<i class="icon-user fa-fw"></i>
</a>
</div>
<ul class="nav navbar-nav navbar-right">
<li class="dropdown">
<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle clear">
<span class="hidden-sm hidden-md">商城</span> <b class="caret"></b>
</a>
<ul class="dropdown-menu animated fadeInRight w">
<li><a href="" data-pjax=""><i class="glyphicon glyphicon-shopping-cart"></i> &nbsp;&nbsp;账户充值</a></li>
</ul>
</li>
<li class="dropdown">
<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle clear">
<span class="thumb-sm avatar pull-right m-t-n-sm m-b-n-sm m-l-sm">
<img alt="image" class="img-full" src="http://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin=<?=$udata['dlqq']?>&src_uin=<?=$udata['dlqq']?>&fid=<?=$udata['dlqq']?>&spec=100&url_enc=0&referer=bu_interface&term_type=PC" style="width:70px;">
<i class="on md b-white bottom"></i>
</span>
<span class="hidden-sm hidden-md"><?=$udata['user']?></span> <b class="caret"></b>
</a>
<ul class="dropdown-menu animated fadeInRight w">
<li class="wrapper b-b m-b-sm bg-light m-t-n-xs">
<div>
<p class="text-center"><?=$udata['user']?></p>
</div>
</li>
</ul>
</div>
<div id="loading" class="app-footer" style="display:none">
<div ui-butterbar="" class="butterbar active"><span class="bar"></span></div>
</div>
</div>
<div class="app-aside hidden-xs bg-white b-r">
<div class="aside-wrap">
<div class="navi-wrap">
<div class="clearfix text-center">
<div class="dropdown wrapper">
<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
<span class="thumb-lg w-auto-folded avatar">
<img alt="image" class="img-full" src="http://q2.qlogo.cn/headimg_dl?bs=qq&dst_uin=<?=$udata['dlqq']?>&src_uin=<?=$udata['dlqq']?>&fid=<?=$udata['dlqq']?>&spec=100&url_enc=0&referer=bu_interface&term_type=PC" style="width:70px;">
</span>
</a>
<a href="javascript:;" data-toggle="dropdown" class="dropdown-toggle hidden-folded">
<span class="clear">
<span class="block m-t-sm">
<strong class="font-bold text-lt"><?=$udata['user']?></strong> 
<b class="caret"></b>
</span>
<span class="text-muted text-xs block"></span>
</span>
</a>
<ul class="dropdown-menu animated fadeInRight w hidden-folded">
<li class="wrapper b-b m-b-sm bg-info m-t-n-xs">
<span class="arrow top hidden-folded arrow-info"></span>
<div>
<p class="text-center"><?=$udata['user']?></p>
</div>
</div>
<div class="line dk hidden-folded"></div>
</div>
<nav ui-nav="" class="navi">
<ul class="nav">
<li class="hidden-folded padder text-muted text-xs">
</li>
<li class="">
<a href="./">
<em class="icon-grid" style="font-size:14px;"></em>
<span>平台首页</span>
</a>
<?php if($udata['per_sq']==1&&$udata['per_db']==1&&$udata['active']==1){ ?>
<li>
<li class="">
<a href=".fuli" data-toggle="collapse">
<em class="icon-user" style="font-size:14px;"></em>
<span>用户管理</span>
</a>
<ul class="nav sidebar-subnav collapse fuli">
<li class="">
<a href="./userlist.php" >
<span>用户列表</span>
</a>
</li>
<li class="">
<a href="./adduser.php" >
<span>添加用户</span>
</a>
</li>
<li class="">
<a href="./log.php" >
<span>操作记录</span>
</a>
</li>
</ul>
</li>
</li>
<?php } 
             if($udata['per_db']==1){ ?>
<li class="">
<a href=".kuaijie" data-toggle="collapse">
<em class="icon-layers" style="font-size:14px;"></em>
<span>授权管理</span>
</a>
<ul class="nav sidebar-subnav collapse kuaijie">
<li class="">
<a href="./list.php" >
<span>授权列表</span>
</a>
</li>
<li class="">
<a href="./add.php" >
<span>添加授权</span>
</a>
</li>
<li class="">
<a href="./addsite.php" >
<span>添加站点</span>
</a>
</li>
<li class="">
<a href="./km.php" >
<span>卡密生成</span>
</a>
</li>
<li class="">
<a href="./search.php" >
<span>搜索授权</span>
</a>
</li>
</ul>
</li>	  
<?php } ?>
<li class="">
<a href="./downfile.php">
<em class="icon-rocket icon font-bold" style="font-size:14px;"></em>
<span data-localize="sidebar.nav.WIDGETS">下载管理</span>
</a>
</li>
<?php if($udata['per_sq']==1&&$udata['active']==1){ ?>
<nav ui-nav="" class="navi">
<ul class="nav">
<li class="hidden-folded padder text-muted text-xs">
 </li>
<li class="">
<a href="./pirate.php">
<em class="icon-grid" style="font-size:14px;"></em>
<span data-localize="sidebar.nav.WIDGETS">获取信息</span>
</a>
</li>
</li>
<nav ui-nav="" class="navi">
<ul class="nav">
<li class="hidden-folded padder text-muted text-xs">
</li>
<?php } 
             if($udata['uid']==1){ ?>
<li class="">
<a href="set.php">
<em class="icon-note" style="font-size:14px;"></em>
<span data-localize="sidebar.nav.WIDGETS">设置信息</span>
</a>
</li>
<li class="">
<a href="https://jq.qq.com/?_wv=1027&k=5koeCUS">
<em class="icon-note" style="font-size:14px;"></em>
<span data-localize="sidebar.nav.WIDGETS">售后Q群</span>
</a>
</li>
<?php } ?>
<nav ui-nav="" class="navi">
<ul class="nav">
<li class="hidden-folded padder text-muted text-xs">
</li>
<li class="">
<a href="./login.php?logout">
<em class="icon-logout" style="font-size:14px;"></em>
<span>注销登陆</span>
</a>
</li>
</ul>
</nav>
</div>
</div>
</div>
<!-- 导航部分结束 -->
<script type="text/javascript">get_xiaoxi();</script>
<div class="app-content">
<section id="ajaxshow"></section>
<section id="container">
<div class="app-content-body animated fadeInUp">
<div class="hbox hbox-auto-xs hbox-auto-sm">
<div class="col">  
<div class="bg-light lter b-b wrapper-sm ng-scope">
<ul class="breadcrumb">
<li><i class="fa fa-home"></i> <a href="">平台首页</a></li>
<li><?=$title?></li>
</ul>
</div>