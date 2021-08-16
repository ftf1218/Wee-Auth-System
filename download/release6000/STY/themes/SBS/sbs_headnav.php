<section id="mobilebar">
    <div class="inner width icon">
        <div class="col back">
        </div>
        <div class="col title"><a href="<?php Helper::options()->siteUrl()?>"><?php $this->options->title(); ?></a></div>
        <div class="col switch">
        </div>
    </div>
</section>


<header id="navbar" class="site-header" style="overflow: visible; height: auto;"> 
   <section class="topbar"> 
    <div class="inner width"> 
     <nav class="nav pull-left"> 
      <ul class="nav-menu top-menu icon"> 

      <?php $this->widget('Widget_Metas_Category_List')->to($category); ?>
            <?php if($category->have()): ?>
            <?php while ($category->next()): ?>
       <li class="menu-item menu-item-type-custom menu-item-object-custom"><a href="<?php $category->permalink(); ?>"><?php $category->name(); ?></a></li>
       <?php endwhile;?> 
       <?php endif; ?> 


      </ul> 
     </nav> 
     <div class="meta pull-right"> 

     <form id="search" method="post" action="/" role="search">
       <input type="text" name="s" class="textinput" size="26" placeholder="Search ..." /> 
      </form> 

      <div class="logged botton"> 
       <a href="" id="button" class="login">Sign in</a> 
      </div> 

     </div> 
    </div> 
   </section> 
   <section class="banner bg" style="background-image: url(<? $GLOBALS['options']->SBS_HeadnavLink() ?>);"> 
    <div id="banner-data" style="display:none"> 
     <img id="banner-0" src="<? $GLOBALS['options']->SBS_HeadnavLink() ?>" />
    </div> 
    <div class="sns master-info width"> 
     <a href="<?php Helper::options()->siteUrl()?>" class="sns-avatar max" style="margin-bottom: 0px;"><img src="<? $GLOBALS['options']->authorIMG() ?>" width="200" class="avatar avatar-200" /></a>
    </div> 
   </section> 
  </header> 


  <div id="container" class="site-refresh"> 

   <section id="appbar"> 
    <div id="fixedbar" class="no"> 

     <div class="inner width"> 

     <div class="master-info-small pull-left">
    <div id="smallAvatar" class="tooltip" style="margin-top: 55px;">
        <div class="middle">
            <div class="sns-avatar min">
                <a href="<?php Helper::options()->siteUrl()?>">
                    <img
                        src="<? $GLOBALS['options']->authorIMG() ?>"
                        width="36"
                        class="avatar avatar-36"></a>
                </div>
            </div>
            <div class="middle info">
                <h4 class="blogname"><? $GLOBALS['options']->author() ?></h4>
                <div class="nickname">@<? $GLOBALS['options']->authorLike() ?></div>
            </div>
        </div>
    </div>

      <nav class="nav pull-left"> 
       <ul class="nav-menu main-menu"> 

        <li class="menu-item menu-item-type-custom menu-item-object-custom current_page_item menu-item-home"> 
           <a href="<?php Helper::options()->siteUrl()?>" aria-current="page">首页</a> 
         </li> 

         <?php $this->widget('Widget_Contents_Page_List')->to($pages); ?>
                            <?php if($pages->have()): ?>
                                <?php while($pages->next()): ?>
                                <li class="menu-item menu-item-type-custom menu-item-object-custom current_page_item menu-item-home"> 
                                    <a href="<?php $pages->permalink(); ?>"><?php $pages->title(); ?></a>
                                </li>
                                <?php endwhile; ?>
                                <?php endif; ?>

       </ul> 
      </nav> 

     </div> 

    </div> 
   </section> 