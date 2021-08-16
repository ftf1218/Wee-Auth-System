<aside id="aside" class="right"> 
  <div class="inner"> 
   <div class="widget"> 
    <h3 class="widget-title"> <i class="icon louie-icface"></i>Essays</h3> 
    <div class="textwidget">
     <? $GLOBALS['options']->SBS_Essays() ?>
    </div> 
   </div> 
   <div class="widget"> 
    <h3 class="widget-title"> <i class="icon louie-trend-o"></i>List</h3> 
    <ul class="items hot-views"> 

    <?php $this->widget('Widget_Metas_Tag_Cloud', 'sort=mid&ignoreZeroCount=1&desc=0&limit=10')->to($tags); ?>
                <?php if($tags->have()): ?>
                    <?php while ($tags->next()): ?>

    <li class="item"> <h4 class="title nowrap"> <a href="<?php $tags->permalink(); ?>"># <?php $tags->name(); ?></a> </h4> </li> 

                    <?php endwhile; ?>
                    <?php endif; ?>
    </ul> 
   </div> 
  </div> 
 </aside> 


<!-- 终止符（不能除去） -->
</div>