<style>
.links-container {
    padding: 30px;
    background-color: #fff;
    border-top-left-radius: 5px;
    border-top-right-radius: 5px;
}
.links-container ul {
    list-style-type: circle;
}
.links-container li {
    margin: 15px 0;
}
.links-container a {
    display: inline-block;
    text-decoration: none;
    color: #444;
}
.link-description {
    margin-left: 0.5em;
    font-weight: 300;
    color: #777;
}

</style>

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
                <div class="links-container">
                <div class="links">
                <ul>
                <?php Links_Plugin::output('
                <li>
                    <a href="{url}" target="_blank" rel="noopener">{name}</a>
                    <span class="link-description">{description}</span>
                </li>
                ')?>
        </ul>
        </div>
    </div>

            </div>
        </main>
</div>
<script>
    STY_Method.vditorRender('page');
</script>