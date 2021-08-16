<script src="https://unpkg.com/smoothscroll-polyfill@0.4.4/dist/smoothscroll.min.js"></script>
<style>
        .headroom--top .nav-links > div > a > span,
        .headroom--top div.logo > a > span {
            color: #fff;
        }
        header {
            height: 680px;
            height: 55vh;
            min-height: 480px;
            background-color: #777;
            margin: 0 auto;
            position: relative;
            z-index: 1;
        }
        div.category > span > a {
            color: #fff;
        }
        div.info-section > span > a {
            color: #fff;
        }
    </style>
    <div class="template-content">
        <header class="header">
            <div
                class="bg-slot lazy-bg my-bg"
                style="background-image: url('<? echo Index::imgOutPut($this, $this->cid); ?>');"></div>
            <div class="content-mask"></div>
            <div class="my-container">
                <div class="container">
                    <div class="row text-content">
                        <div class="info-section category shadow-text">
                            <span ><?php $this->category('·'); ?></span></div>
                    </div>
                    <div class="row text-content">
                        <h1 class="post-title shadow-text">
                            <span class="title-text"><?php $this->title() ?></span>
                            <!---->
                        </h1>
                    </div>
                    <div class="row text-content">
                        <div class="info-section shadow-text"></div>
                    </div>
                </div>
            </div>
        </header>

        <div class="container">
            <div class="row no-gutters">
                <div class="col-lg-10">
                    <article id="post_body" class="post-content">
                        <section class="info-block">
                            <span ><?php $this->author(); ?>
                                文</span>
                            <span ><?php $this->category('·'); ?></span>
                            <span ><?php get_post_view($this) ?>
                                Read</span>
                            <span><? art_count($this->cid) ?> 个字</span>
                            <span >
                                <time pubdate="" datetime="<?php $this->date(); ?>"><?php $this->date(); ?></time>
                            <?php if($this->user->uid==$this->authorId):?>
                                <span class="small has-tooltip" data-original-title="null"><a href="<?echo __TYPECHO_ADMIN_DIR__?>write-post.php?cid=<?php echo $this->cid?>">编辑</a></span>
                            <?endif;?>
                            </span></section>
                        <section class="post-alert"></section>
                        <section class="post-holder markdown-body post-body">
                            <?php
                            if ($GLOBALS['options']->render == 1) {
                                $content = Content::contentPost($this,$this->user->hasLogin(), 'vditor');
                                echo '<textarea id="md_text" style="display: none;" class="hide" >' . htmlspecialchars($content) . '</textarea>';
                                echo '<div id="vditor"></div>';
                            }else{
                                echo Content::contentPost($this,$this->user->hasLogin());

                            }
                            ?>
                            
                        </section>
                        <section class="authority-section">
                            <div class="post-copyright">
                                <hr>
                                <p>© 本文文字内容著作权归本站所有。商业转载请联系站长获得授权；非商业转载请注明本文出处及文章链接，且未经站长允许不得对本文文字内容进行修改演绎。</p>
                            </div>
                        </section>

<!-- <div class="extra-section row no-gutters">
    <div id="like_section" class="like-section col-md-4">
        <h2>喜欢文章</h2>
        <div class="star-container">
            <div class="VueStar">
                <div class="VueStar__ground">
                    <div class="VueStar__icon">
                        <button aria-label="喜欢这篇文章" class="like-btn">
                            <i aria-hidden="true" class="iconfont icon-like1"></i>
                        </button>
                    </div>
                    <div class="VueStar__decoration"></div>
                </div>
            </div>
        </div>
        <span class="intro-text">10人喜欢这篇文章</span>
    </div>
    <div id="donate_section" class="donate-section col-md-4">
        <h2>请喝饮料</h2>
        <div >
            <div class="star-container">
                <div class="VueStar">
                    <div class="VueStar__ground">
                        <div class="VueStar__icon">
                            <button aria-label="请喝饮料" class="donate-btn">
                                <i aria-hidden="true" class="iconfont icon-coffee"></i>
                            </button>
                        </div>
                        <div class="VueStar__decoration"></div>
                    </div>
                </div>
            </div>
            <span class="intro-text">请站长喝杯饮料吧</span>
        </div>
    </div>
</div>
<div data-v-0cf72a55="" class="row no-gutters">
    <div data-v-0cf72a55="" class="related-section col-lg-10">
        <div data-v-0cf72a55="" class="related-list">
            <h2 data-v-0cf72a55="">
                在<a data-v-0cf72a55="" href="/game" class="no-link">「游戏」</a>分类下的其它文章
            </h2>
            <div
                data-v-0cf72a55=""
                class="row no-gutters post-list related-item-container-wrapper">
                <div data-v-0cf72a55="" class="col-md-6 related-item-container">
                    <a
                        data-v-0cf72a55=""
                        href="/am/5886"
                        class="prev-link related-item page-link"
                        title="《原神》让我印象深刻的九个瞬间">
                        <div
                            data-v-0cf72a55=""
                            class="bg-content lazy-bg"
                            data-src="https://talk-1252562537.file.myqcloud.com/images/post/2021-01-17-genshin-impact-1.jpg!post_thumbnail"
                            lazy="loaded"
                            style="background-image: url(&quot;https://talk-1252562537.file.myqcloud.com/images/post/2021-01-17-genshin-impact-1.jpg!post_thumbnail&quot;);"></div>
                        <div data-v-0cf72a55="" class="text-content shadow-text">
                            <p data-v-0cf72a55="" class="post-indicator prev shadow-box">
                                旧的一篇
                                <i data-v-0cf72a55="" class="iconfont icon-arrowright"></i>
                            </p>
                            <h3 data-v-0cf72a55="">《原神》让我印象深刻的九个瞬间</h3>
                            <p data-v-0cf72a55="">游戏·日记</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
</div> -->
                    </article>
                </div>
                <div class="col-lg-2 d-lg-block d-none nav-toc-list expanded">
                <div class="post-holder markdown-body vue-affix affix-top">
                    <div class="toc">
                        <h3 id="toc_header">
                            目录
                            </h3>
                            <div id="outline" class="toc vditor-outline" style="display: block;"></div>
                    </div>
                </div>
            </div>
            </div>
        </div>
    </div>
    <script>
    STY_Method.vditorRender();
    </script>

<?php $agree = $this->hidden?array('agree' => 0, 'recording' => true):agreeNum($this->cid); ?>
<button <?php echo $agree['recording']?'disabled':''; ?> type="button" id="agree" data-cid="<?php echo $this->cid; ?>" data-url="<?php $this->permalink(); ?>" class="btn btn-w-md btn-round btn-secondary">
   <span>点赞</span>
   <span class="agree-num"><?php echo $agree['agree']; ?></span> <<< 此处施工中
</button>

<script>
STY_Method.LikeInit();
</script>