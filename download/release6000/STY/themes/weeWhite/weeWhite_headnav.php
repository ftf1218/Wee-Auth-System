<script src="<?php echo $GLOBALS['assetURL']; ?>js/weeWhite.js"></script>
<style>
    .post-holder *{
        font-size: 14px!important;
    }
</style>

<header id="navbar" class="header shadow-2x">
    <div class="container">
        <div class="row justify-content-lg-center">
            <div class="col-12 col-lg-9">
                <nav class="navbar navbar-expand-lg px-0 py-2 py-lg-4">
                    <a href="<?php Helper::options()->siteUrl()?>" class="navbar-brand">
                    <?php $this->options->title(); ?>
                    </a>
                    <div class="collapse navbar-collapse order-2 order-lg-1">
                        <ul class="navbar-nav mx-auto main-menu">

                            <li class="menu-item">
                                <a href="<?php Helper::options()->siteUrl()?>">首页</a>
                            </li>
                            
                            <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                            <?php if($pages->have()): ?>
                                <?php while($pages->next()): ?>
                                <li class="menu-item">
                                    <a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                                </li>
                                <?php endwhile; ?>
                                <?php endif; ?>

                        </li>
                        </ul>
                    </div>
                    <div class="nav navbar-menu sign-menu order-1 order-lg-2">
                    <a href="javascript:FactionSidebar('on')" class="d-inline-block action-search action-sidebar" id="action-sidebar">
                        <i class="text-lg iconfont icon-search-outline"></i>
                    </a>
                    <a href="javascript:FactionMenu('on')" class="d-inline-block d-lg-none action-menu pl-4" id="action-menu">
                        <i class="text-lg iconfont icon-menu-outline"></i>
                    </a>
                </div>
                </nav>
            </div>
        </div>
    </div>
</header>
<!-- 手机侧边 -->
    <!-- active时弹出 -->
    <div class="mobile-navbar" id="mobile-navbar">
    <div class="mobile-menu p-4 p-md-5">
        <a href="javascript:FactionMenu('end')" class="action-menu btn btn-light px-2 mb-4" id="action-menu">
            <i class="fa fa-times"></i>
        </a>
        <ul class="navbar-nav">
            <li class="menu-item">
                <a href="<?php Helper::options()->siteUrl()?>">首页</a>
            </li>
            <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
            <?php if($category->have()): ?>
            <?php while ($category->next()): ?>
            <li class="menu-item">
                <a href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a> </li>
            <?php endwhile;?> <?php endif; ?> 
        </ul>
    </div>
    </div>
    <!--电脑侧边 -->
    <!-- active时弹出 -->
    <div class="sidebar-collapse" id="sidebar-collapse">
    <aside class="sidebar p-4 p-md-5">
        <a href="javascript:FactionSidebar('end')" class="action-search btn btn-light px-2 mb-4" id="action-search">
            <i class="fa fa-times"></i>
        </a>
        <div class="widget widget-search mb-5">
            <div class="widget-title h6 mb-4">
                <span class="nice-b-line">站内搜索</span>
            </div>
            <div class="widget-content">
                <div class="search-input form-group mb-4">
                    <form id="search" method="post" action="/" role="search">
                        <input type="text" placeholder="请输入搜索关键词" class="form-control" name="s">
                        </form>
                    </div>
                </div>
            </div>
            <div id="recent-posts-2" class="widget widget_recent_entries mb-5">
                <div class="widget-title h6 mb-4">
                    <span class="nice-b-line">最新文章</span>
                </div>
                <ul>
                <?php $this->widget('Widget_Contents_Post_Recent')
            ->parse('<li><a href="{permalink}">{title}</a></li>'); ?>
                </ul>
            </div>
            <div id="tag_cloud-2" class="widget widget_tag_cloud mb-5">
                <div class="widget-title h6 mb-4">
                    <span class="nice-b-line">标签列表</span>
                </div>
                <div class="tagcloud">
                <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=99999')->to($tags); ?>
                <?php if($tags->have()): ?>
                    <?php while ($tags->next()): ?>
                    <a rel="tag" href="<?php $tags->permalink(); ?>" class="tag-cloud-link"><?php $tags->name(); ?></a>
                    <?php endwhile; ?>
                    <?php else: ?>
                        <li class="tag-cloud-link"><?php _e('没有任何标签'); ?></li>
                    <?php endif; ?>

                </div>
            </div>
            <div id="categories-2" class="widget widget_categories mb-5">
                <div class="widget-title h6 mb-4">
                    <span class="nice-b-line">目录分类</span>
                </div>
                <ul>
                <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
                <?php if($category->have()): ?>
                <?php while ($category->next()): ?>
                <li class="cat-item">
                    <a href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a> </li> 
                    <?php endwhile;?> <?php endif; ?> 

                </ul>
            </div>
        </aside>
    </div>
    <div class="bg-overlay"> </div>