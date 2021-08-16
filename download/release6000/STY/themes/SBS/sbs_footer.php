<div id="footer" class="site-footer">
    <div class="inner textcenter">
        <div class="copyright">© 2021 · 
            <a href="<?php Helper::options()->siteUrl()?>" target="_blank"><? $GLOBALS['options']->author(); ?></a>
        </div>
        <div class="power">
            <span><a href="https://blog.iucky.cn/system/sty.html">STY Theme By Wibus</a></span>
            <span>
                
            </span>
        </div>
    </div>
</div>

<script>
window.addEventListener('scroll', function () {
    if (document.documentElement.scrollTop > 408) {
        document.getElementById('fixedbar').classList.add('fix');
        document.querySelector('.sns-avatar').style = 'margin-bottom: 90px;'
        document.querySelector('#smallAvatar').style = 'margin-top: 0px;'
    }else{
        document.getElementById('fixedbar').classList.remove('fix');
        document.querySelector('.sns-avatar').style = 'margin-bottom: 0px;'
        document.querySelector('#smallAvatar').style = 'margin-top: 55px;'
    }
})

var pjax = new Pjax({
  selectors: [
    "title",
    "#sbs-main"
  ],
  cacheBust: false //关闭cacheBust，取消后缀
    })


</script>