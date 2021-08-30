<?php
/*
 * @FilePath: /Wee-Auth-System/manager/index.php
 * @author: Wibus
 * @Date: 2021-08-29 00:30:40
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-30 13:31:47
 * Coding With IU
 */
$mod='blank';
include("../api.inc.php");
$title='首页';
include './header.php';
if($islogin==1){}else exit("<script language='javascript'>window.location.href='./login.php';</script>");
?>
<body id="page-top">
    <div id="wrapper">
        <nav
            class="navbar navbar-dark align-items-start sidebar sidebar-dark accordion bg-gradient-primary p-0">
            <div class="container-fluid d-flex flex-column p-0">
                <a
                    class="navbar-brand d-flex justify-content-center align-items-center sidebar-brand m-0"
                    href="#">
                    <div class="sidebar-brand-icon rotate-n-15">
                        <i class="fab fa-skyatlas"></i>
                    </div>
                    <div class="sidebar-brand-text mx-3">
                        <span>STY Auth</span></div>
                </a>
                <hr class="sidebar-divider my-0">

                <? include './components/leftBar.php' ?>

            </div>
        </nav>
        <div class="d-flex flex-column" id="content-wrapper">
            <div id="content">
            <? include './headnav.php' ?>
                <div class="container-fluid">
                    <div class="d-sm-flex justify-content-between align-items-center mb-4">
                        <h3 class="text-dark mb-0">Home</h3>
                        <a
                            class="btn btn-primary btn-sm d-none d-sm-inline-block"
                            role="button"
                            href="#">
                            <i class="fas fa-cog fa-sm text-white-50"></i>&nbsp;新建授权</a>
                    </div>
                    <div class="row" style="margin-bottom: 12px;">
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-primary py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-primary fw-bold text-xs mb-1">
                                                <span>用户类型</span></div>
                                            <div class="text-dark fw-bold h5 mb-0">
                                                <span>STY Pro</span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-users fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-success py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-success fw-bold text-xs mb-1">
                                                <span>已有授权</span></div>
                                            <div class="text-dark fw-bold h5 mb-0">
                                                <span>1</span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-key fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-info py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-info fw-bold text-xs mb-1">
                                                <span>最新版本</span></div>
                                            <div class="row g-0 align-items-center">
                                                <div class="col-auto">
                                                    <div class="text-dark fw-bold h5 mb-0 me-3">
                                                        <span><? echo $Newver?></span></div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-clipboard-list fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 col-xl-3 mb-4">
                            <div class="card shadow border-start-warning py-2">
                                <div class="card-body">
                                    <div class="row align-items-center no-gutters">
                                        <div class="col me-2">
                                            <div class="text-uppercase text-warning fw-bold text-xs mb-1">
                                                <span>已发布教程</span></div>
                                            <div class="text-dark fw-bold h5 mb-0">
                                                <span>暂未开放</span></div>
                                        </div>
                                        <div class="col-auto">
                                            <i class="fas fa-comments fa-2x text-gray-300"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="w-100"></div>
                    </div>
                    <? require('components/btn_index.php') ?>
                    <div class="row">
                        <div class="col">
                            <!-- Start: Basic Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="text-primary m-0 fw-bold">关于STY</h6>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">STY 是一款 Typecho 主题，原名叫做 Mix Pro，全名叫做 Super Typecho ，是 Wibus 在离开
                                        Typecho 阵营的最后一个作品<br>这是史上第一款突破单个主题限制的Typecho主题，它不单单只有一种样式，他有有多个开发者细心打造的不同部件，让你即使是同一个主题，也有不同风格的展现“STY
                                        is made for your reading”，所以STY在设计之初，就是为了阅读。<br>因此，在默认/积极维护的风格以阅读舒适度为主<br><br>更多详细内容请前往
                                        <a href="https://blog.iucky.cn/works/sty.html">https://blog.iucky.cn/works/sty.html</a>
                                        进行查看</p>
                                </div>
                            </div>
                            <!-- End: Basic Card -->
                        </div>
                        <div class="col">
                            <!-- Start: Basic Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="text-primary m-0 fw-bold">最新版本 <? echo $Newver?></h6>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">
                                        发布日期：<? echo $date ?><br><br>
                                        更新内容：<br>
                                        <? echo $upContent ?>    
                                    </p>
                                </div>
                            </div>
                            <!-- End: Basic Card -->
                        </div>
                    </div>
                </div>
            </div>
            <footer class="bg-white sticky-footer">
                <div class="container my-auto">
                    <div class="text-center my-auto copyright">
                        <span>Copyright © STY Auth 2021</span></div>
                </div>
            </footer>
        </div>
        <a class="border rounded d-inline scroll-to-top" href="#page-top">
            <i class="fas fa-angle-up"></i>
        </a>
    </div>
    <? include './footer.php' ?>