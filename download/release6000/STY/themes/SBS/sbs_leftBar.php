<aside id="aside" class="left"> 
 <div class="inner"> 
  <div class="sns master-info"> 
   <div class="info-base"> 
    <h2 class="blogname">Wibus<span class="icon ca-icon"></span> </h2> 
    <div class="nickname">
     <? $GLOBALS['options']->authorLike() ?>
    </div> 
    <p class="description"><? $GLOBALS['options']->authorDesc() ?></p> 
   </div> 
   <ul class="info-extras"> 

    <li class="item">Guangzhou China</li> 
    <li class="item"> <a href="https://iucky.cn">iucky.cn</a> </li> 

    <li class="item active">主人在<? echo get_last_login($this->author) ?>来过。</li> 
   </ul> 
   <div class="info-actions"> 

   <? $GLOBALS['options']->SBS_HeadNavBtn() ?>

   </div> 
  </div> 
  <div class="alteration"> 
   
   <div class="widget"> 
    <h3 class="widget-title"> <i class="icon louie-heart"></i>Visitors</h3> 
    <ul class="items attention"> 
    <? Autofirst() ?>
    </ul> 
   </div> 

  </div> 
 </div> 
</aside> 