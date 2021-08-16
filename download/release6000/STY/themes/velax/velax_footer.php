<?php
/*
 * @FilePath: /STY/themes/velax/velax_footer.php
 * @author: Wibus
 * @Date: 2021-07-19 12:18:41
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-24 21:55:34
 * Coding With IU
 */?>
 
 <div class="footer-block">
  <div class="container footer-container">
  <div class="list-group">
      <?$GLOBALS['options']->velax_Footer();?>
  </div>
  <div class="footer-copy">
    <ul><li>Power By Typecho</li></ul>
    <ul><li><a href="https://blog.iucky.cn/system/sty.html">STY Theme By Wibus</a></li></ul>
    
    <ul>
      <li>Copyright © 2021 <?php $GLOBALS['options']->author(); ?> 保留所有权利。</li>
      <li>
        <a href="<? echo $GLOBALS['RealSite'] ?>/feed" target="_blank" rel="noopener">
          <span>RSS订阅</span>
          <i class="fa fa-rss" style="font-size: 80%"></i>
        </a>
      </li>
        <!-- <a href="<? echo $GLOBALS['RealSite'] ?>/sitemap.xml" target="_blank" rel="noopener">网站地图</a></li> -->
      <li><?$GLOBALS['options']->introduction()?></li></ul>
  </div>
  </div>
</div>
</div>

<script>
  var pjax = new Pjax({
  selectors: [
    "title",
    "#main", // 这个位置直接舍弃掉<div id="main"></div>
    "header",
    "#navbar"
  ],
  cacheBust: false //关闭cacheBust，取消后缀
    })
</script>