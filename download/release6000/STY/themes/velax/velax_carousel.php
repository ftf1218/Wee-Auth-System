<?if($GLOBALS['options']->velax_wheel):?>
<script src="https://unpkg.com/swiper/swiper-bundle.min.js"> </script>
<!-- <script src="<? echo $GLOBALS['assetURL'] ?>js/swiper.animate1.0.3.min.js"></script> -->
<link rel="stylesheet" href="https://unpkg.com/swiper/swiper-bundle.min.css">
<!-- <link rel="stylesheet" href="<? echo $GLOBALS['assetURL'] ?>css/animate.min.css"> -->
<div class="maxer-carousel" >
    <!-- 使用container -->
    <div class="swiper-container swiper-container-initialized swiper-container-horizontal swiper-container-pointer-events animate__animated animate__fadeIn animate__slow">
        <div class="swiper-wrapper" style="">
            <? echo Index::returnWheelHtml($GLOBALS['options']->velax_wheel) ?>

        </div>

        <!-- 导航按钮 -->
        <div class="maxer-carousel-button-next f-jc-c al-c swiper-button-disabled" >
            <svg class="icon" aria-hidden="true" style="font-size: 25px;"><use xlink:href="#iconRight-"></use></svg>
        </div>
        <div class="maxer-carousel-button-prev f-jc-c al-c" >
            <svg class="icon" aria-hidden="true" style="font-size: 25px;"><use xlink:href="#iconLeft-"></use></svg>
        </div>

        <!-- pagination：分页器 -->
        <div class="swiper-pagination swiper-pagination-clickable swiper-pagination-bullets">
            <span class="maxer-pagination-bullet"></span>
            <span class="maxer-pagination-bullet"></span>
            <span class="maxer-pagination-bullet maxer-pagination-bullet-active"></span>
        </div>
        
    </div>
</div>
<script>
    // var swiper = new Swiper('.swiper-container');
  </script>
  <?endif;?>