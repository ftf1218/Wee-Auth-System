<section class="page-header bg-light py-4 py-lg-5">
    <div class="container">
        <div class="row justify-content-lg-center">
            <div class="col-12 col-lg-9">
                <h1 class="h3">
                    <span class="nice-m-line"><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('%s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ''); ?></span>
                </h1>
                <div class="mt-2 mt-md-3">
                    <p></p>
                </div>
            </div>
        </div>
    </div>
</section>

<?php if ($this->have()): ?>
    <div class="container py-4 py-lg-5">
        <div class="row justify-content-lg-center">
            <div class="col-12 col-lg-9">
                <section class="post-list list-grid list-bordered my-n4">

                <?php while($this->next()): ?>
                    <div class="list-item post">
                        <div class="list-content py-lg-2">
                            <div class="list-body ">
                                <div class="text-lg h-2x">
                                    <a
                                        href="<?php $this->permalink() ?>"
                                        class="list-title"><?php $this->sticky(); $this->title(); ?></a>
                                </div>
                                <div class="d-none d-md-block text-sm text-muted mt-3">
                                    <div class="h-3x"><?php $this->excerpt(30, '...'); ?></div>
                                </div>
                            </div>
                            <div class="list-footer d-flex">
                                <div class="text-xs text-muted">
                                    <span class="d-inline-block">
                                        <?php echo $this->category();?>
                                    </span>
                                    <i class="text-primary px-2">•</i>
                                    <span class="d-inline-block"><?php $this->date(); ?><</span>
                                </div>
                                <div class="ml-auto text-xs text-muted "></div>
                            </div>
                        </div>
                        <div class="list-image col-3">
                            <div class="media shadow">
                                <a
                                    href="<?php $this->permalink() ?>"
                                    class="media-content lazyload"
                                    style="background-image:url('https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210724072305.svg')" data-src="<? echo Index::imgOutPut($this, $this->cid); ?>"></a>
                            </div>
                        </div>
                    </div>

                    <?php endwhile; ?>

                </section>

                <nav class="navigation pagination" role="navigation">
                    <h2 class="screen-reader-text">文章导航</h2>

                    <div class="nav-links">
                        <!-- <span class="page-number">第 1 页 / 共 79 页</span> -->
                        <?php $this->pageLink(); ?>
                        <?php $this->pageLink('next'); ?>
                    </div>
                </nav>

            </div>
        </div>
    </div>


<?php endif; ?>