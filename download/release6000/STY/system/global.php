<?php
/*
 * @Name: global.php
 * @author: Wibus
 * @Date: 2021-04-17 16:06:35
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-12 19:25:07
 * Coding With IU
 */
$options = Helper::options();
 // error_reporting(0);
// ini_set('display_errors', 0);
$GLOBALS['options'] = Typecho_Widget::widget('Widget_Options'); //设置选项（非this）
$GLOBALS['db'] = Typecho_Db::get(); //Typecho自带db函数
if ($options->rewrite == 1) {
    $GLOBALS['RealSite'] = Helper::options()->siteUrl."index.php"; //是否开启了伪静态
}else{
    $GLOBALS['RealSite'] = Helper::options()->siteUrl;
}
//CDN 静态资源加速
// 使用方法：<?php echo $GLOBALS['assetURL']; ?\>
if (Typecho_Widget::widget('Widget_Options')->使用CDN静态资源加速 == '1') {
    $GLOBALS['assetURL'] = Typecho_Widget::widget('Widget_Options')->CDN加速链接.'/assets/';
}else{
    $GLOBALS['assetURL'] = Typecho_Widget::widget('Widget_Options')->themeUrl.'/assets/';
}
if (!defined('THEME_URL')){//主题目录的绝对地址
    define("THEME_URL", rtrim(preg_replace('/^'.preg_quote($options->siteUrl, '/').'/', $options->rootUrl.'/', $options->themeUrl, 1),'/').'/');
}
if (!defined('API_URL')) {
    define("API_URL", THEME_URL."system/Interface/api/");
}
if ($_GET['theme']) {
    $GLOBALS['options']->部件模板设置 = $_GET['theme'];
    if ($_GET['theme'] == 'custom') {
        $GLOBALS['options']->headnavs = $_GET['headnav'];
        $GLOBALS['options']->carousels = $_GET['carousel'];
        $GLOBALS['options']->lists = $_GET['list'];
        $GLOBALS['options']->archieves = $_GET['archieve'];
        $GLOBALS['options']->footers = $_GET['footer'];
        $GLOBALS['options']->comments = $_GET['comment'];
        $GLOBALS['options']->posts = $_GET['post'];
        $GLOBALS['options']->pages = $_GET['page'];
        $GLOBALS['options']->csses = $_GET['css'];
        $GLOBALS['options']->friends = $_GET['friend'];
    }
}
// 使用GLOBALS进行超变量设置，便以维护
switch($GLOBALS['options']->部件模板设置){
    case 'velax':
        $headnav = 'themes/velax/velax_headnav.php';
        $carousel = 'themes/velax/velax_carousel.php';
        $list = 'themes/velax/velax_list.php';
        $archieve = 'themes/velax/velax_archieve.php';
        $footer = 'themes/velax/velax_footer.php';
        $comment = 'themes/velax/velax_comment.php';
        $post = 'themes/velax/velax_post.php';
        $page = 'themes/velax/velax_page.php';
        // 不要设置CSS！冲突！
        $friends = 'themes/velax/velax_friends.php';
        break;
    case 'weeWhite':
        $headnav = 'themes/weeWhite/weeWhite_headnav.php';
        $carousel = 'themes/weeWhite/weeWhite_carousel.php';
        $list = 'themes/weeWhite/weeWhite_list.php';
        $archieve = 'themes/weeWhite/weeWhite_archieve.php';
        $footer = 'themes/weeWhite/weeWhite_footer.php';
        $comment = 'themes/weeWhite/weeWhite_comment.php';
        $post = 'themes/weeWhite/weeWhite_post.php';
        $page = 'themes/weeWhite/weeWhite_page.php';
        $css  = 'css/weeWhite.css';
        $friends = 'themes/weeWhite/weeWhite_friends.php';
        break;
    case 'SBS':
        $headnav = 'themes/SBS/sbs_headnav.php';
        $carousel = 'themes/SBS/sbs_carousel.php';
        $list = 'themes/SBS/sbs_list.php';
        $archieve = 'themes/SBS/sbs_archieve.php';
        $footer = 'themes/SBS/sbs_footer.php';
        // 不能设置$comment！
        $post = 'themes/SBS/sbs_post.php';
        $page = 'themes/SBS/sbs_page.php';
        $css = 'css/SBS.css';
        $friends = 'themes/SBS/sbs_friends.php';
        break;
    case 'custom':
        if ($GLOBALS['options']->headnavs){
        $headnav = 'themes/'.$GLOBALS['options']->headnavs.'/'.$GLOBALS['options']->headnavs.'_headnav.php';
        };
        if ($GLOBALS['options']->carousels){
        $carousel = 'themes/'.$GLOBALS['options']->carousels.'/'.$GLOBALS['options']->carousels.'_carousel.php';
        };
        if ($GLOBALS['options']->lists){
        $list = '/themes/'.$GLOBALS['options']->lists.'/'.$GLOBALS['options']->lists.'_list.php';
        };
        if ($GLOBALS['options']->footers){
            $footer = 'themes/'.$GLOBALS['options']->footers.'/'.$GLOBALS['options']->footers.'_footer.php';
        };
        if ($GLOBALS['options']->comments){
            $comment = 'themes/'.$GLOBALS['options']->comments.'/'.$GLOBALS['options']->comments.'_comment.php';
        };
        if ($GLOBALS['options']->posts){
            $post = 'themes/'.$GLOBALS['options']->posts.'/'.$GLOBALS['options']->posts.'_post.php';
        };
        if ($GLOBALS['options']->pages){
            $page = 'themes/'.$GLOBALS['options']->pages.'/'.$GLOBALS['options']->pages.'_page.php';
        };
        if ($GLOBALS['options']->csses){
            if ($GLOBALS['options']->csses != 'velax') {
                $css = 'css/'.$GLOBALS['options']->csses;
            }
        };
        if ($GLOBALS['options']->archieves){
            $archieve = 'themes/'.$GLOBALS['options']->archieves.'/'.$GLOBALS['options']->archieves.'_archieve.php';
        };
        if ($GLOBALS['options']->friends){
            $friend = 'themes/'.$GLOBALS['options']->friends.'/'.$GLOBALS['options']->friends.'_friend.php';
        };
        break;
}
if ($headnav) { define("HEADNAV", "$headnav"); }
if ($carousel) { define("CAROUSEL", "$carousel"); }
if ($list) { define("SLIST", "$list"); }
if ($archieve) { define("ARCHIEVE", "$archieve"); }
if ($footer) { define("FOOTER", "$footer"); }
if ($comment) { define("COMMENT", "$comment"); }
if ($post) { define("POST", "$post"); }
if ($page) { define("PAGE", "$page"); }
if ($css) { define("CSS", "$css"); }
if ($friends) { define("FRIENDS", "$friends"); }

// 得到页面的链接或内容
function getPages($widget){
    $GLOBALS['pages'] = $widget->widget('Widget_Contents_Page_List')->to($pages);
    $pages = $GLOBALS['pages'];
    while ($GLOBALS['pages']->next()):
        switch ($pages->template):
            case 'page-github.php':
                $GLOBALS['github'] = $pages->permalink;
                break;
        endswitch;
    endwhile;
}