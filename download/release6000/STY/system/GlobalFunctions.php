<?
/*
 * @FilePath: /STY/system/GlobalFunctions.php
 * @author: Wibus
 * @Date: 2021-06-14 16:12:55
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-12 21:57:39
 * Coding With IU
 */

function themeInit($self)
{
    Helper::options()->commentsAntiSpam = false; //关闭反垃圾
    Helper::options()->commentsCheckReferer = false; //关闭检查评论来源URL与文章链接是否一致判断(否则会无法评论)
    Helper::options()->commentsMaxNestingLevels = '999'; //最大嵌套层数
    Helper::options()->commentsPageDisplay = 'first'; //强制评论第一页
    Helper::options()->commentsOrder = 'DESC'; //将最新的评论展示在前
    Helper::options()->commentsHTMLTagAllowed = '<a href=""> <img src=""> <img src="" class=""> <code> <del>';
    Helper::options()->commentsMarkdown = true;
    if (strpos($self->request->getRequestUri(), 'sitemap.xml') !== false) {
        $self->response->setStatus(200);
        $self->setThemeFile("system/interface/sitemap.php");
    }
}


//简易GET网络请求
function curl_get($url){
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$content=curl_exec($ch);
	curl_close($ch);
	return($content);
}
//调用博主最近登录时间
function get_last_login($user){
    $user   = '1';
    $now = time();
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    $row = $db->fetchRow($db->select('activated')->from('table.users')->where('uid = ?', $user));
    echo Typecho_I18n::dateWord($row['activated'], $now);
}
// 输出随机文章
function theme_random_posts(){
    $defaults = array(
    'number' => 6,
    'before' => '<ul class="archive-posts">',
    'after' => '</ul>',
    'xformat' => '<li class="archive-post"> <a class="archive-post-title" href="{permalink}">{title}</a>
     </li>'
    );
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
    ->where('status = ?','publish')
    ->where('type = ?', 'post')
    ->limit($defaults['number'])
    ->order('RAND()');
    $result = $db->fetchAll($sql);
    echo $defaults['before'];
    foreach($result as $val){
    $val = Typecho_Widget::widget('Widget_Abstract_Contents')->filter($val);
    echo str_replace(array('{permalink}', '{title}'),array($val['permalink'], $val['title']), $defaults['xformat']);
    }
    echo $defaults['after'];
}
// 页面加载时间
function timer_start() {
  global $timestart;
  $mtime     = explode( ' ', microtime() );
  $timestart = $mtime[1] + $mtime[0];
  return true;
}
timer_start();
function timer_stop( $display = 0, $precision = 3 ) {
  global $timestart, $timeend;
  $mtime     = explode( ' ', microtime() );
  $timeend   = $mtime[1] + $mtime[0];
  $timetotal = number_format( $timeend - $timestart, $precision );
  $r         = $timetotal < 1 ? $timetotal * 1000 . " ms" : $timetotal . " s";
  if ( $display ) {
      echo $r;
  }
  return $r;
}
// 文章中文字数统计
function art_count ($cid){
    $db=Typecho_Db::get ();
    $rs=$db->fetchRow ($db->select ('table.contents.text')->from ('table.contents')->where ('table.contents.cid=?',$cid)->order ('table.contents.cid',Typecho_Db::SORT_ASC)->limit (1));
    $text = preg_replace("/[^\x{4e00}-\x{9fa5}]/u", "", $rs['text']);
    echo mb_strlen($text,'UTF-8');
}
// 阅读次数
function get_post_view($archive)
{
    $cid    = $archive->cid;
    $db     = Typecho_Db::get();
    $prefix = $db->getPrefix();
    if (!array_key_exists('views', $db->fetchRow($db->select()->from('table.contents')))) {
        $db->query('ALTER TABLE `' . $prefix . 'contents` ADD `views` INT(10) DEFAULT 0;');
        echo 0;
        return;
    }
    $row = $db->fetchRow($db->select('views')->from('table.contents')->where('cid = ?', $cid));
    if ($archive->is('single')) {
       $db->query($db->update('table.contents')->rows(array('views' => (int) $row['views'] + 1))->where('cid = ?', $cid));
    }
    echo $row['views'];
    // get_post_view($this)
}
// 实时人数显示
function online_users() {
    // $theme = constant(__TYPECHO_THEME_DIR__);
    // $filename= $theme.'/Mix/online.txt'; //数据文件
    $filename='online.txt';
    // TODO：需要解决constant无法找到的问题，但是似乎有些人魔改了Typecho导致无法获取真正的相对地址
    // 以及某些博客托管会导致根目录无法创建文件，用户也无法创建
    $cookiename='STY_OnLineCount'; //Cookie名称
    $onlinetime=30; //在线有效时间
    $online=file($filename); 
    $nowtime=$_SERVER['REQUEST_TIME']; 
    $nowonline=array(); 
    foreach($online as $line){ 
        $row=explode('|',$line); 
        $sesstime=trim($row[1]); 
        if(($nowtime - $sesstime)<=$onlinetime){
            $nowonline[$row[0]]=$sesstime;
        } 
    } 
    if(isset($_COOKIE[$cookiename])){
        $uid=$_COOKIE[$cookiename]; 
    }else{
        $vid=0;
        do{
            $vid++; 
            $uid='U'.$vid; 
        }while(array_key_exists($uid,$nowonline)); 
        setcookie($cookiename,$uid); 
    } 
    $nowonline[$uid]=$nowtime;
    $total_online=count($nowonline); 
    if($fp=@fopen($filename,'w')){ 
        if(flock($fp,LOCK_EX)){ 
            rewind($fp); 
            foreach($nowonline as $fuid=>$ftime){ 
                $fline=$fuid.'|'.$ftime."\n"; 
                @fputs($fp,$fline); 
            } 
            flock($fp,LOCK_UN); 
            fclose($fp); 
        } 
    } 
    echo "$total_online"; 
} 
// 生成随机颜色值
function randColor(){
    return rand(120,200).','.rand(120,200).','.rand(120,200);
}
//目录树
function createCatalog($obj) {    //为文章标题添加锚点
    global $catalog;
    global $catalog_count;
    $catalog = array();
    $catalog_count = 0;
    $obj = preg_replace_callback('/<h([1-6])(.*?)>(.*?)<\/h\1>/i', function($obj) {
      global $catalog;
      global $catalog_count;
      $catalog_count ++;
      $catalog[] = array('text' => trim(strip_tags($obj[3])), 'depth' => $obj[1], 'count' => $catalog_count);
      return '<h'.$obj[1].$obj[2].' id="mu-post-title-'.$catalog_count.'">'.$obj[3].'</h'.$obj[1].'>';
    }, $obj);
    return $obj;
  }
  
  //输出文章目录容器
  function getCatalog() {    
    global $catalog;
    $index = '';
    if ($catalog) {
      $index = '<nav class="catalog-nav">'."\n";
      $prev_depth = '';
      $to_depth = 0;
      foreach($catalog as $catalog_item) {
        $catalog_depth = $catalog_item['depth'];
        if ($prev_depth) {
          if ($catalog_depth == $prev_depth) {
            $index .= ''."\n";
          } elseif ($catalog_depth > $prev_depth) {
            $to_depth++;
              $index .= '<nav class="catalog-nav catalog-nav-sub">'."\n";
          } else {
            $to_depth2 = ($to_depth > ($prev_depth - $catalog_depth)) ? ($prev_depth - $catalog_depth) : $to_depth;
              if ($to_depth2) {
                for ($i=0; $i<$to_depth2; $i++) {
                  $index .= ''."\n".'</nav>'."\n";
                  $to_depth--;
                  }
              }
            $index .= '';
          }
        }
          $index .= '<a class="nav-link" href="#mu-post-title-'.$catalog_item['count'].'" data-scroll="#mu-post-title-'.$catalog_item['count'].'">'.$catalog_item['text'].'</a>';
          $prev_depth = $catalog_item['depth'];
      }
      for ($i=0; $i<=$to_depth; $i++) {
        $index .= ''."\n".'</nav>'."\n";
      }
      // $index = '<div id="toc-container">'."\n".'<div id="toc">'."\n".'<strong>文章目录</strong>'."\n".$index.'</div>'."\n".'</div>'."\n";
    }
    if(!$index) {
      echo '<nav class="navbar catalog-nav"><a href="##">暂无目录</a></nav>';
    }else {
      echo $index;
    }
  };
//   HTML 压缩（TODO：不兼容）
  function compressHtml($html_source) {
    $chunks = preg_split('/(<!--<nocompress>-->.*?<!--<\/nocompress>-->|<nocompress>.*?<\/nocompress>|<pre.*?\/pre>|<textarea.*?\/textarea>|<script.*?\/script>)/msi', $html_source, -1, PREG_SPLIT_DELIM_CAPTURE);
    $compress = '';
    foreach ($chunks as $c) {
        if (strtolower(substr($c, 0, 19)) == '<!--<nocompress>-->') {
            $c = substr($c, 19, strlen($c) - 19 - 20);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 12)) == '<nocompress>') {
            $c = substr($c, 12, strlen($c) - 12 - 13);
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 4)) == '<pre' || strtolower(substr($c, 0, 9)) == '<textarea') {
            $compress .= $c;
            continue;
        } else if (strtolower(substr($c, 0, 7)) == '<script' && strpos($c, '//') != false && (strpos($c, "\r") !== false || strpos($c, "\n") !== false)) {
            $tmps = preg_split('/(\r|\n)/ms', $c, -1, PREG_SPLIT_NO_EMPTY);
            $c = '';
            foreach ($tmps as $tmp) {
                if (strpos($tmp, '//') !== false) {
                    if (substr(trim($tmp), 0, 2) == '//') {
                        continue;
                    }
                    $chars = preg_split('//', $tmp, -1, PREG_SPLIT_NO_EMPTY);
                    $is_quot = $is_apos = false;
                    foreach ($chars as $key => $char) {
                        if ($char == '"' && $chars[$key - 1] != '\\' && !$is_apos) {
                            $is_quot = !$is_quot;
                        } else if ($char == '\'' && $chars[$key - 1] != '\\' && !$is_quot) {
                            $is_apos = !$is_apos;
                        } else if ($char == '/' && $chars[$key + 1] == '/' && !$is_quot && !$is_apos) {
                            $tmp = substr($tmp, 0, $key);
                            break;
                        }
                    }
                }
                $c .= $tmp;
            }
        }
        $c = preg_replace('/[\\n\\r\\t]+/', ' ', $c);
        $c = preg_replace('/\\s{2,}/', ' ', $c);
        $c = preg_replace('/>\\s</', '> <', $c);
        $c = preg_replace('/\\/\\*.*?\\*\\//i', '', $c);
        $c = preg_replace('/<!--[^!]*-->/', '', $c);
        $compress .= $c;
    }
    return $compress;
}
//获取评论的锚点链接
function get_comment_at($coid)
{
    $db   = Typecho_Db::get();
    $prow = $db->fetchRow($db->select('parent,status')->from('table.comments')
        ->where('coid = ?', $coid));//当前评论
    $mail = "";
    $parent = @$prow['parent'];
    if ($parent != "0") {//子评论
        $arow = $db->fetchRow($db->select('author,status,mail')->from('table.comments')
            ->where('coid = ?', $parent));//查询该条评论的父评论的信息
        @$author = @$arow['author'];//作者名称
        $mail = @$arow['mail'];
        if(@$author && $arow['status'] == "approved"){//父评论作者存在且父评论已经审核通过
            if (@$prow['status'] == "waiting"){
                echo '<p class="commentReview">'._mt("（评论审核中）").'</p>';
            }
            echo '<a href="#comment-' . $parent . '">@' . $author . '</a>';
        }else{//父评论作者不存在或者父评论没有审核通过
            if (@$prow['status'] == "waiting"){
                echo '<p class="commentReview">'._mt("（评论审核中）").'</p>';
            }else{
                echo '';
            }

        }

    } else {//母评论，无需输出锚点链接
        if (@$prow['status'] == "waiting"){
            echo '<p class="commentReview">'._mt("（评论审核中）").'</p>';
        }else{
            echo '';
        }
    }

    return $mail;


}
// 检测插件是否可用
function isPluginAvailable($className, $dirName)
{
    if (class_exists($className)) {
        $plugins = Typecho_Plugin::export();
        $plugins = $plugins['activated'];
        if (is_array($plugins) && array_key_exists($dirName, $plugins)) {
            return true;
        } else {
            return false;
        }
    } else {
        return false;
    }

}
// 维护页面
function SiteClose(){
    $op = $GLOBALS['options']->维护状态;
    if ($op == 1) {
        if (!preg_match("/admin/", $_SERVER['REQUEST_URI'])) {
        exit('
<!doctype html>
<html class="no-js">

<head>
	<meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="renderer" content="webkit">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">
</head>

<body>
	<table id="maintain-box">
        <tr>
            <td>
                <div class="title">维护中</div>
                <div class="text">为了能让您访问更快更稳定，同时为您提供更高品质的服务，我们正在维护系统。因此目前网站的部分功能不能使用，请稍后再回来。给您造成了不便，请谅解。</div>
            </td>
        </tr>
    </div>
    <footer>
        <style>
        html, body {
            height: 100%;
            width: 100%;
            overflow: hidden;
            background:#000;
        }
        #maintain-box {
            max-width: 1000px;
            height: 100%;
            margin: 0 auto;
        }
        #maintain-box, #maintain-box tr, #maintain-box td {
            border: 0 !important;
        }
        #maintain-box tr td {
            text-align: center;
            vertical-align: middle;
        }
        #maintain-box .title {
            font-size: 2em !important;
            color: #fff;
        }
        #maintain-box .text {
            font-size: 1.2em !important;
            color: #fff;
        }
        </style>
    </footer>
    <?php $this->footer();?>
</body>

</html>
        ');
    }
    }
}
/**
 * 显示上一篇
 *
 * @access public
 * @param string $default 如果没有上一篇,显示的默认文字
 * @return void
 * @throws Typecho_Db_Exception
 */
function theNext($widget, $default = NULL)
{
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created > ?', $widget->created)
        ->where('table.contents.created < ?', time())
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_ASC)
        ->limit(1);
    $content = $db->fetchRow($sql);

    if ($content) {
        $content = $widget->filter($content);
        $link = '<li class="previous"> <a class="box-shadow-wrap-normal" href="' . $content['permalink'] . '" title="' . $content['title'] . '" data-toggle="tooltip"> '._mt("上一篇").' </a></li>
';
        echo $link;
    } else {
        $link = '';
        echo $link;
    }
}

/**
 * 显示下一篇
 *
 * @access public
 * @param string $default 如果没有下一篇,显示的默认文字
 * @return void
 */
function thePrev($widget, $default = NULL)
{
    $db = Typecho_Db::get();
    $sql = $db->select()->from('table.contents')
        ->where('table.contents.created < ?', $widget->created)
        ->where('table.contents.created < ?', time())
        ->where('table.contents.status = ?', 'publish')
        ->where('table.contents.type = ?', $widget->type)
        ->where('table.contents.password IS NULL')
        ->order('table.contents.created', Typecho_Db::SORT_DESC)
        ->limit(1);
    $content = $db->fetchRow($sql);

    if ($content) {
        $content = $widget->filter($content);
        $link = '<li class="next"> <a class="box-shadow-wrap-normal" href="' . $content['permalink'] . '" title="' . $content['title'] . '" data-toggle="tooltip"> 
'._mt("下一篇").' </a></li>';
        echo $link;
    } else {
        $link = '';
        echo $link;
    }
}

// 评论显示
// 可用变量：   $su[$i], $arrMail[0], $arrAuthor1[0]
// 邮箱 -> 头像：https://gravatar.loli.net/avatar/' . md5(strtolower($arrMail[0])) . '?d=wavatar';
function Autofirst(){
    $db = Typecho_Db::get();
    $query = $db->select()->from('table.comments')->where('authorId = ?','0')->order('coid',Typecho_Db::SORT_DESC)->limit(100);
    $result = $db->fetchAll($query);
    $arrUrl = array();
    $arrAuthor = array();
    $arrMail = array();
    foreach ($result as $value) {
        if($value["url"]!==null){
            array_push($arrUrl,$value["url"]);
            array_push($arrAuthor,$value["author"]);
            // array_push($arrMail, $value["mail"]);
        }
    }
    $su=array_filter(array_merge(array_unique($arrUrl)));
    $sa=array_filter(array_merge(array_unique($arrAuthor)));
    $num=0;
    for($i=0;$i<count(array_unique($su));$i++){
        if($su[$i]!=="" && $num<16){
            $num+=1;
            $db1 = Typecho_Db::get();
            $query1 = $db1->select()->from('table.comments')->where('url = ?',$su[$i])->order('coid',Typecho_Db::SORT_DESC)->limit(100);
            $result1 = $db1->fetchAll($query1);
            $arrAuthor1 = array();
            foreach ($result1 as $value) {
                    array_push($arrAuthor1,$value["author"]);
                    array_push($arrMail, $value["mail"]);
            }
            echo '
            <li class="item tips-top" aria-label="'.$arrAuthor1[0].'"> 
            <a href="'.$su[$i].'" rel="nofollow" target="_blank"> 
            <img alt="'.$arrAuthor1[0].'" src="https://gravatar.loli.net/avatar/' . md5(strtolower($arrMail[$i])) . '?d=wavatar" class="avatar avatar-42 photo" height="42" width="42" /></a>
         </li> 
         ';
        }
    }
}
function agreeNum($cid, &$record = NULL)
{
    $db = Typecho_Db::get();
    $callback = array(
        'agree' => 0,
        'recording' => false
    );

    //  判断点赞数量字段是否存在
    if (array_key_exists('agree', $data = $db->fetchRow($db->select()->from('table.contents')->where('cid = ?', $cid)))) {
        //  查询出点赞数量
        $callback['agree'] = $data['agree'];
    } else {
        //  在文章表中创建一个字段用来存储点赞数量
        $db->query('ALTER TABLE `' . $db->getPrefix() . 'contents` ADD `agree` INT(10) NOT NULL DEFAULT 0;');
    }

    //  获取记录点赞的 Cookie
    //  判断记录点赞的 Cookie 是否存在
    if (empty($recording = Typecho_Cookie::get('__typecho_agree_record'))) {
        //  如果不存在就写入 Cookie
        Typecho_Cookie::set('__typecho_agree_record', '[]');
    } else {
        $callback['recording'] = is_array($record = json_decode($recording)) && in_array($cid, $record);
    }

    //  返回
    return $callback;
}

function agree($cid)
{
    $db = Typecho_Db::get();
    $callback = agreeNum($cid, $record);

    //  获取点赞记录的 Cookie
    //  判断 Cookie 是否存在
    if (empty($record)) {
        //  如果 cookie 不存在就创建 cookie
        Typecho_Cookie::set('__typecho_agree_record', "[$cid]");
    } else {
        //  判断文章是否点赞过
        if ($callback['recording']) {
            //  如果当前文章的 cid 在 cookie 中就返回文章的赞数，不再往下执行
            return $callback['agree'];
        }
        //  添加点赞文章的 cid
        array_push($record, $cid);
        //  保存 Cookie
        Typecho_Cookie::set('__typecho_agree_record', json_encode($record));
    }

    //  更新点赞字段，让点赞字段 +1
    $db->query('UPDATE `' . $db->getPrefix() . 'contents` SET `agree` = `agree` + 1 WHERE `cid` = ' . $cid . ';');

    //  返回点赞数量
    return ++$callback['agree'];
}