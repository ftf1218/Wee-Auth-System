<?/*
 * @FilePath: /STY/themes/velax/velax_headnav.php
 * @author: Wibus
 * @Date: 2021-06-13 23:43:04
 * @LastEditors: Wibus
 * @LastEditTime: 2021-06-13 23:43:04
 * Coding With IU
 */
?>
<style>
<?php if ($GLOBALS['options']->velax_HeadnavDrop):?>
    #maxer-header .header-content{
        backdrop-filter: blur(10px);
    }
<?php endif;?>
</style>
<nav id="navbar" class="navbar-full light-style"><svg class="nav-shade"
        ></svg>
     <div class="nav-container"><span>
             <div role="navigation" class="container nav-content content-item">
                 <div class="logo"><a href="<?php Helper::options()->siteUrl()?>" class="nuxt-link-exact-active nuxt-link-active"
                         aria-current="page"><span><?php $this->options->title(); ?></span></a></div>
                 <div class="nav-group">
                     <div class="nav-wrapper">
                         <div class="nav-links">
                             <div><a href="<?php Helper::options()->siteUrl()?>" class="nav-a"
                                     style="position: relative;" aria-current="page"><i
                                         aria-hidden="true" class="icon-radio-tower fa iconfont"
                                        ></i> <span>🏠首页</span>
                                     
                                     <div class="touch-ripple"></div>
                                 </a></div>
                                 <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
                                 <?php if($category->have()): ?>
                                <?php while ($category->next()): ?>
                             <div><a href="<?php $category->permalink(); ?>" class="nav-a"
                                     style="position: relative;"><i aria-hidden="true"
                                         class="fa fa-iconfont"></i> <span
                                        ><?php $category->name(); ?></span><div class="touch-ripple"></div></a></div>
                                    <?php endwhile;?>
                                    <?php endif; ?> 

                                    <div>
                                    <a class="nav-a" style="position: relative;" id="pages_on">
          <span >📃页面</span>
           <i aria-hidden="true" class="fa fa-angle-down" ></i>
           <div class="touch-ripple"></div></a>
                                </div>
                         </div> 
                         <!-- <span class="tab-indicator" style="width: 60px; left: 22.5px;"></span> -->
                     </div>
                 </div> 
                 
                 <button id="navbar-btn" aria-label="展开菜单" class="nav-btn" style="position: relative;"><i
                         aria-hidden="true" class="fa fa-lg fa-bars"></i>
                     <div class="touch-ripple"></div>
                 </button>
             </div>
         </span></div>


         <ul class="children-nav-list" id="children-nav-list">
         <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                            <?php if($pages->have()): ?>
                                <?php while($pages->next()): ?>
            <li class="child-list-item">
                <a href="<?php $pages->permalink(); ?>" tabindex="0" class="" style="position: relative;"><?php $pages->title(); ?>
                <div class="touch-ripple"></div></a>
                </li>
                <?php endwhile; ?>
            <?php endif; ?>
        </ul>
     <div class="link-list">
         <ul>
             <li class="link-item"
                 style="position: relative;"><a class="nav-links nav-a" href="<?php Helper::options()->siteUrl()?>">
                    🏠首页<div class="touch-ripple"></div></a>
                 
             </li>
             <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
            <?php if($category->have()): ?>
            <?php while ($category->next()): ?>
             <li class="link-item" style="position: relative;"><i aria-hidden="true"
                     class="icon-cake--line fa iconfont"></i><a class="nav-links nav-a" href="<?php $category->permalink(); ?>">
                     <?php $category->name(); ?><div class="touch-ripple"></div></a>
                 
             </li>
             <?php endwhile;?>
            <?php endif; ?> 

         </ul>
         <hr class="dark">

         <ul>
         <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                            <?php if($pages->have()): ?>
                                <?php while($pages->next()): ?>
             <li class="link-item sub-item" style="position: relative;"><a class="nav-a nav-links" href="<?php $pages->permalink(); ?>">
                     <?php $pages->title(); ?><div class="touch-ripple"></div></a>
                     
             </li>
             <?php endwhile; ?>
            <?php endif; ?>
         </ul>


         <div class="bottom-placeholder"></div>
     </div>


 </nav>


<?php if ($this->is('index')): ?>
<style>
    .headroom--top .nav-links>div>a>span, .headroom--top div.logo>a>span {
    color: #fff!important;
}
</style>
<header id="maxer-header" style="height:<?php $GLOBALS['options']->velax_HeadnavHeight()?>;background-image: url('<?$GLOBALS['options']->velax_HeadnavLink()?>');" >
    <div class="header-content" >
        <div class="maxer-container" style="height: 100%;">
            <div class="maxer-title-container" style="height: 100%;">
                <div class="typed-text hitokoto mt-15" >
                    <div class="maxer-title-container"><?$GLOBALS['options']->velax_HeadnavText()?></div>
                </div>
            </div>
        </div>
    </div>
<?php
if ($GLOBALS['options']->velax_bigHalfCircle == 1):
    echo '<svg id="bigHalfCircle" xmlns="http://www.w3.org/2000/svg" version="1.1" width="100%" height="130" viewBox="0 0 100 100" preserveAspectRatio="none" data-v-b3387f82=""><path d="M 0 0 L0 100 L100 100 L100 0 Q 50 200 0 0" data-v-b3387f82=""></path></svg>';
endif;
?>
</header>
<?php endif; ?>