<?php
/*
 * @FilePath: /STY/themes/velax/velax_carousel(cometrue).php
 * @author: Wibus
 * @Date: 2021-07-16 00:44:06
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-24 12:06:23
 * Coding With IU
 */

?>

<header id="index_header">
    <div  class="container header-contain">
        <div  class="row no-gutters">
            <div  class="swipe-group">
                <div  class="MixCarousel">
                    <div class="MixCarousel-wrapper carousel slide" data-ride="carousel">

                        <ul class="carousel-indicators">
                            <li data-target="#demo" data-slide-to="0" class="active"></li>
                        </ul>

                        <div class="MixCarousel-inner carousel-inner" >

                            <div  tabindex="-1" role="tabpanel" class="MixCarousel-slide slide carousel-item active "
                                aria-hidden="true">
                                <div  lazy="loaded" class="my-slides-hero bg-slot lazy-bg"
                                    style="background-image: url(https://api.itggg.cn/a?type=pc?<?echo rand(1,999)?>);">
                                </div>
                                <div  class="link-mask"></div>
                                <div  class="slide-link shadow-text">
                                    <h2 >Mix Pro —— 多重空间混合体</h2>
                                    <p ><span >一款超越Typecho限制的主题</span></p> <a href="https://mix.iucky.cn/index.php/archives/226/"><button
                                         class="link-btn shadow-box shadow-text"
                                        tabindex="-1">阅读文章</button></a>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
                <div  class="swiper-button-prev shadow-image">
                    <a class="carousel-control-prev" href="#demo" data-slide="prev">
                        <span class="carousel-control-prev-icon"></span>
                    </a>
                </div>
                <div  class="swiper-button-next shadow-image">
                    <a class="carousel-control-next" href="#demo" data-slide="next">
                        <span class="carousel-control-next-icon"></span>
                    </a>
                </div>
                <a class=" swiper-button-prev shadow-image carousel-control-prev" href="#demo" data-slide="prev">
                    <span class="carousel-control-prev-icon"></span>
                </a>
                <a class="swiper-button-next shadow-image carousel-control-next" href="#demo" data-slide="next">
                    <span class="carousel-control-next-icon"></span>
                </a>
            </div>
        </div>
    </div>
    <div  class="header-bg header-bg-overlay"></div>
</header>