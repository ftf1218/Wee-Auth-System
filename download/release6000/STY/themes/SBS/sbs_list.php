<section id="contents" class="width"> 

<? require('sbs_leftBar.php'); ?>


<div id="loop" class="right"> 
 <main id="sbs-main" class="width-half"> 





  <div id="primary" class="list preview">

  <?php if ($this->have()): ?>
    <?php while($this->next()): ?>

   <article class="post"> 
    <div class="entry-header pull-left"> 
     <a href="<?php $this->permalink() ?>" class="topic-thumb bg tips-right" style="background-image: url(<? $GLOBALS['options']->authorIMG() ?>)" aria-label="Category: <? echo $this->category?>"></a> 
    </div> 
    <div class="entry-content w-50"> 
     <div class="meta"> 
      <span class="nickname">@<? $GLOBALS['options']->authorLike() ?></span> 
      <time itemprop="datePublished" datetime="2021-02-02T20:35:41+08:00"> &middot; <?php $this->date(); ?></time> 
     </div> 
     <h2 class="title"> <a href="<?php $this->permalink() ?>" rel="bookmark"><?php $this->sticky(); $this->title(); ?></a> </h2> 
     <div class="summary" itemprop="description">
     <?php $this->excerpt(100, '...'); ?>
      <img src="https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210724072305.svg"  data-src="<? echo Index::imgOutPut($this, $this->cid); ?>" class="lazyload entry-image" itemprop="image" /> 
     </div> 
    </div> 
    <footer class="entry-footer w-50"> 
     <ul class="items state"> 
      <li class="item count-comment"> <span class="icon">评</span><?php if ($this->allowComment == 1)$this->commentsNum(_t('0'), _t('1'), _t('%d'));else _t("关") ;?></li> 
      <li class="item"> <span class="icon">作者</span><?$this->author()?></li> 
     </ul> 
    </footer> 
   </article> 

   <?php endwhile; ?>
   <?php endif; ?>
  </div> 

    <div class="nav-links">
        <!-- <span class="page-number">第 1 页 / 共 79 页</span> -->
        <?php $this->pageLink('下一页','next'); ?>
        <?php $this->pageLink('上一页'); ?>
    </div>

  <!-- <div id="pagination"> 
   <div class="posts-paging"> 
    <a href="#"> <i class="dot"></i> <i class="dot"></i> <i class="dot"></i> </a> 
   </div> 
  </div>  -->

 </main> 

 <? require('sbs_rightBar.php'); ?>

</div> 
</section> 