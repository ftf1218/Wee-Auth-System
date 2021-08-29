<?php
/*
 * @FilePath: /Wee-Auth-System/manager/index.php
 * @author: Wibus
 * @Date: 2021-08-29 00:30:40
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-29 21:13:13
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

                <? include './leftbar.php' ?>

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
                                                        <span>v1.0.0</span></div>
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
                                                <span>18</span></div>
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
                    <div class="col">
                        <!-- Start: Collapsible Card -->
                        <div class="shadow card" style="margin-bottom: 20px;">
                            <a
                                class="btn btn-link text-start card-header fw-bold"
                                data-bs-toggle="collapse"
                                aria-expanded="true"
                                aria-controls="collapse-4"
                                href="#collapse-4"
                                role="button">功能按钮</a>
                            <div class="collapse show" id="collapse-4">
                                <div class="card-body">
                                    <!-- Start: Split Button Success -->
                                    <a
                                        class="btn btn-success btn-icon-split"
                                        role="button"
                                        style="margin-left: 35px;margin-bottom: 15px;margin-top: 15px;">
                                        <span class="text-white-50 icon">
                                            <i class="fas fa-check"></i>
                                        </span><span class="text-white text">新建授权</span></a>
                                    <!-- End: Split Button Success -->
                                    <!-- Start: Split Button Primary -->
                                    <a
                                        class="btn btn-primary btn-icon-split"
                                        role="button"
                                        style="margin-left: 35px;margin-bottom: 15px;margin-top: 15px;">
                                        <span class="text-white-50 icon">
                                            <i class="fas fa-flag"></i>
                                        </span><span class="text-white text">新增教程</span></a>
                                    <!-- End: Split Button Primary -->
                                    <!-- Start: Split Button Secondary -->
                                    <a
                                        class="btn btn-secondary btn-icon-split"
                                        role="button"
                                        style="margin-left: 35px;margin-bottom: 15px;margin-top: 15px;">
                                        <span class="text-white-50 icon">
                                            <i class="fas fa-arrow-right"></i>
                                        </span><span class="text-white text">前往首页</span></a>
                                    <!-- End: Split Button Secondary -->
                                    <!-- Start: Split Button Info -->
                                    <a
                                        class="btn btn-info btn-icon-split"
                                        role="button"
                                        style="margin-left: 35px;margin-bottom: 15px;margin-top: 15px;">
                                        <span class="text-white-50 icon">
                                            <i class="fas fa-info-circle"></i>
                                        </span><span class="text-white text">售后服务</span></a>
                                    <!-- End: Split Button Info -->
                                    <!-- Start: Split Button Warning -->
                                    <a
                                        class="btn btn-warning btn-icon-split"
                                        role="button"
                                        style="margin-left: 35px;margin-bottom: 15px;margin-top: 15px;">
                                        <span class="text-white-50 icon">
                                            <i class="fas fa-exclamation-triangle"></i>
                                        </span><span class="text-white text">联系开发者</span></a>
                                    <!-- End: Split Button Warning -->
                                    <!-- Start: Split Button Light -->
                                    <a
                                        class="btn btn-light btn-icon-split"
                                        role="button"
                                        style="margin-left: 35px;margin-bottom: 15px;margin-top: 15px;">
                                        <span class="text-black-50 icon">
                                            <i class="fas fa-arrow-right"></i>
                                        </span><span class="text-dark text" style="background: #ebebeb;">Beta站点</span></a>
                                    <!-- End: Split Button Light -->
                                </div>
                            </div>
                        </div>
                        <!-- End: Collapsible Card -->
                    </div>
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
                                        <a href="https://sty.iucky.cn/">https://sty.iucky.cn/</a>
                                        进行查看</p>
                                </div>
                            </div>
                            <!-- End: Basic Card -->
                        </div>
                        <div class="col">
                            <!-- Start: Basic Card -->
                            <div class="card shadow mb-4">
                                <div class="card-header py-3">
                                    <h6 class="text-primary m-0 fw-bold">最新版本 v1.0.0</h6>
                                </div>
                                <div class="card-body">
                                    <p class="m-0">发布日期：2020-6-x<br><br>更新内容：<br>修复了在headitem设置了sub之后发生错位的严重问题<br>增加在线人数统计选项，防止有人通过一些托管平台的进行托管导致权限无法正常新建用于记录的文件<br></p>
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