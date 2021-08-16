<?php if ($this->have()): ?>
<section class="section-block">
    <div class="container">
        <span class="post-list row">
            <?php while($this->next()): ?>

            <div class="post-item col-lg-4 col-md-6 col-sm-12">
                <a class="post-item-card" href="<?php $this->permalink() ?>">
                    <div class="card-container">
                        <div class="card-header">
                            <div class="card-title shadow-text">
                                <h3 class="post-title">
                                    <?php $this->sticky(); $this->title(); ?>
                                </h3>
                            </div>
                            <div class="post-cover-mask"></div>
                            <div
                                class="post-cover lazyload"
                                style="background-image:url('https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210724072305.svg')" data-src="<? echo Index::imgOutPut($this, $this->cid); ?>"></div>
                        </div>

                        <div class="card-body">
                            <p class="post-intro">

                                <span><?php $this->excerpt(30, '...'); ?></span>
                            </p>
                            <div class="post-info">
                                <ul class="info-list">
                                    <li class="category-tag" style="background-color:#006284F8;"><?php echo $this->category;?></li>
                                    <li><?php $this->date(); ?></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </a>
            </div>

            <?php endwhile; ?>
        </span>
    </div>
</section>
<div class="load-more-block">
    <?php $this->pageLink('<button class="more-link"><i aria-hidden="true" class="fa fa-caret-down"></i> 上一页
          </button>'); ?>
    <?php $this->pageLink('<button class="more-link"><i aria-hidden="true" class="fa fa-caret-down"></i> 下一页
          </button>','next'); ?>

</div>
<?php endif; ?>