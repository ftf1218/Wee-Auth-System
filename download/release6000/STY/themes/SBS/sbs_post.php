<style>
    article{
        margin: 0;
        
    }
</style>

<section id="contents" class="width"> 

<? require('sbs_leftBar.php'); ?>


<div id="loop" class="right">
 <main id="sbs-main" class="width-half"> 
  <div id="primary" class="content">


<article class="post">
    <header class="entry-header">
        <h1 class="title" itemprop="name"><?php $this->title() ?></h1>
        <div class="meta">发布于
            <time itemprop="datePublished" datetime="<?php $this->date() ?>"><?php $this->date() ?></time>
            /
            <?php $this->category('·'); ?>
        </div>
    </header>
    <div class="entry-content " itemprop="articleBody">
<?php
                            if ($GLOBALS['options']->render == 1) {
                                $content = Content::contentPost($this,$this->user->hasLogin(), 'vditor');
                                echo '<textarea id="md_text" style="display: none;" class="hide" >' . htmlspecialchars($content) . '</textarea>';
                                echo '<div id="vditor"></div>';
                            }else{
                                echo Content::contentPost($this,$this->user->hasLogin());

                            }
                            ?>
        </div>
<script>
STY_Method.vditorRender();
</script>
        <div class="tags">

        <?php $this->tags('<span style="background:rgb('.randColor().')"></span>', true, ''); ?>

        </div>
        <footer class="entry-footer">
            <div class="trends">
                <ul class="items state">
                    <li class="item views">
                        <span class="state-title">浏览</span>
                        <span class="state-count"><?get_post_view($this)?></span>
                    </li>
                        </ul>
                </div>
            </footer>
        </article>

  </div> 

<? $this->need('themes/SBS/sbs_comment.php') ?>

<div class="toc" style="display: none;">
                        <h3 id="toc_header">
                            目录
                            </h3>
                            <div id="outline" class="toc vditor-outline" style="display: none;"></div>
                    </div>

 </main> 
 <? require('sbs_rightBar.php'); ?>

</div> 
</section> 

