<div class="template-content">
        <div class="header-container disable-hover">
            <div class="header-mask mask-overlay" style="background-color: rgb(245, 245, 245);">
            </div>
            <div class="header-mask linear-mask dark"></div>
            <div class="header-mask linear-mask"></div>
            <div class="header-bg" style="background-image: url('https://source.unsplash.com/1600x900/?computer&<?echo rand(1,999)?>');">
            </div>
            <div class="container">
                <header class="container page-header shadow-text">
                    <div class="content-mask" style="opacity: 0.25;"></div>
                    <div class="my-bg bg-slot lazy-bg"
                        data-src="https://velas-1252562537.file.myqcloud.com/images/jakob-owens.jpg!header_thumbnail"
                        lazy="error"
                        style="background-position: center center; background-image: url('<?echo $GLOBALS['options']->rendPic_Link."?".rand(1,999)?>');">
                    </div>
                    <h1><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('%s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?></h1>
                    
                </header>
            </div>
        </div>
        <main class="interlaced-main">
            <div class="container page-container">
                <div class="row post-list">
                <?php while ($this->next()) : ?>
                    <div class="col-lg-4 col-md-6 col-xs-12">
                        <a 
                            href="<?php $this->permalink() ?>" class="post-item-card">
                            <div class="card-container">
                                <div class="card-header">
                                    <div class="card-title shadow-text">
                                        <h3 class="post-title">
                                        <?php $this->title() ?>
                                        </h3>
                                        <!---->
                                    </div>
                                    <div class="post-cover-mask"></div>
                                    <div class="post-cover lazyload" style="background-image:url('https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210724072305.svg')" data-src="<? echo Index::imgOutPut($this, $this->cid); ?>">
                                    </div>
                                </div>
                                
                                <div class="card-body">
                                    <p class="post-intro">
                                        <!---->
                                        <!----> <span ><?php $this->excerpt(30, '...'); ?></span>
                                    </p>
                                    <div class="post-info">
                                        <ul class="info-list">
                                            <li class="category-tag"
                                                style="background-color: rgba(177, 120, 68, 0.973);">
                                                <?php echo $this->category; ?>
                                            </li>
                                            <li ><?php $this->date(); ?></li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            </a>
                    </div>
                    <?php endwhile; ?>
                </div>
                
            </div>
            <div class="blank-space"></div>
            <div class="load-more-block">
    <?php $this->pageLink('<button class="more-link"><i aria-hidden="true" class="fa fa-caret-down"></i> 上一页
          </button>'); ?>
<?php $this->pageLink('<button class="more-link"><i aria-hidden="true" class="fa fa-caret-down"></i> 下一页
          </button>','next'); ?>

</div>
        </main>
        
    </div>