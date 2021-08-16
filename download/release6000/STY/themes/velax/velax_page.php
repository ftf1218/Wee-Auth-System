<div class="template-content">
        <div class="header-container disable-hover">
            <div class="header-mask mask-overlay"
                style="background-color: rgb(245, 245, 245); display: none;"></div>
            <div class="header-mask linear-mask dark"></div>
            <div class="header-mask linear-mask"></div>
            <div class="header-bg" style="background-image: url('<? echo Index::imgOutPut($this, $this->cid); ?>');">
            </div>
            <div class="container">
                <header class="container page-header shadow-text">
                    <div class="content-mask" style="opacity: 0.55;"></div>
                    <div class="my-bg bg-slot lazy-bg" style="background-position: center center; background-image: url('<? echo Index::imgOutPut($this, $this->cid); ?>');">
                    </div>
                    <h1 ><?php $this->title() ?></h1>
                    
                </header>
            </div>
        </div>
        <main class="interlaced-main">
            <div class="container">
                <div class="post-container">
                    <article>
                    <?php
                            if ($GLOBALS['options']->render == 1) {
                                $content = Content::contentPost($this,$this->user->hasLogin(), 'vditor');
                                echo '<textarea id="md_text" style="display: none;" class="hide" >' . htmlspecialchars($content) . '</textarea>';
                                echo '<div id="vditor"></div>';
                            }else{
                                echo Content::contentPost($this,$this->user->hasLogin());

                            }
                            ?>
                    </article>
                    
                </div>
            </div>
        </main>
</div>
<script>
    STY_Method.vditorRender('page');
</script>