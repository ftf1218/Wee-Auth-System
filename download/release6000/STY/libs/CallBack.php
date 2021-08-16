<?php
/*
 * @FilePath: /STY/libs/CallBack.php
 * @author: Wibus
 * @Date: 2021-04-17 16:06:35
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-12 22:59:05
 * Coding With IU
 */

class CallBack{
    /**
     * @name: btnParseCallback
     * @msg: 解析简洁版btn
     * @param $matches
     * @return string
     */
    public static function btnParseCallback($matches){
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        //[scode type="share"]这是灰色的短代码框，常用来引用资料什么的[/scode]
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        $url = @$attrs['url'];
        return '<a href="'.$url.'" target="_blank" class="btn-j btn-j-primary">'.$matches[5].'</a>';
    }
    /**
     * 解析显示按钮的短代码的正则替换回调函数
     * @param $matches
     * @return bool|string
     */
    public static function bottonParseCallback($matches)
    {
        // 不解析类似 [[post]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        //对$matches[3]的url如果被解析器解析成链接，这些需要反解析回来
        /*$matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/",'$1',$matches[3]);*/
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        $type = "";
        $color = "primary";
        $icon = "";
        $addOn = " ";
        $linkUrl = "";
        if (@$attrs['type'] == "round") {
            $type = "btn-rounded";
        }
        if (@$attrs['url'] != "") {
            $linkUrl = 'window.open("' . $attrs['url'] . '","_blank")';
        }
        if (@$attrs['color'] != "") {
            $color = $attrs['color'];
        }

        if (@$attrs['icon'] != "") {//判断是否是feather 图标
            if (count(mb_split(" ", $attrs['icon'])) > 1 || strpos($attrs['icon'], "fontello") !== false || strpos
                ($attrs['icon'], "glyphicon") !== false) {
                $icon = '<i class="' . $attrs['icon'] . '"></i>';
            } else {
                $icon = '<i><i data-feather="' . $attrs['icon'] . '"></i></i>';
            }
            $addOn = 'btn-addon';
        }

        return <<<EOF
<button class="btn m-b-xs btn-{$color} {$type}{$addOn}" onclick='{$linkUrl}'>{$icon}{$matches[5]}</button>
EOF;
    }

    /**
     * 短代码解析正则替换回调函数
     * @param $matches
     * @return bool|string
     */
    public static function scodeParseCallback($matches)
    {
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        //[scode type="share"]这是灰色的短代码框，常用来引用资料什么的[/scode]
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        $type = "info";
        switch (@$attrs['type']) {
            case 'yellow':
                $type = "warning";
                break;
            case 'red':
                $type = "error";
                break;
            case 'lblue':
                $type = "info";
                break;
            case 'green':
                $type = "success";
                break;
            case 'share':
                $type = "share";
                break;
        }
        return '<div class="scode inlineBlock ' . $type . '">' . "\n\n" . $matches[5] . "\n" . '</div>';
    }
    /**
     * 文章内相册解析
     * @param $matches
     * @return bool|string
     */
    public static function scodeAlbumParseCallback($matches)
    {
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }

        //[scode type="share"]这是灰色的短代码框，常用来引用资料什么的[/scode]
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数

        $content = $matches[5];


        return self::parseContentToImage($content, @$attrs["type"]);


    }
    /**
     * 解析文章内容为图片列表（相册）
     * @param $content
     * @param $type
     * @return string
     */
    public static function parseContentToImage($content, $type)
    {
        preg_match_all('/\[(.*?)\]\((.*?)\)/', $content, $matches);
        // 如： [照片](https://images.unsplash.com/19/desktop.JPG?crop=entropy&cs=tinysrgb&fit=crop&fm=jpg&h=900&ixid=MnwxfDB8MXxyYW5kb218MHx8Y29tcHV0ZXI_MXx8fHx8fDE2MjczNTg0MDU&ixlib=rb-1.2.1&q=80&utm_campaign=api-credit&utm_medium=referral&utm_source=unsplash_source&w=1600)
        // 在之后重新新建了文件后，其实发现，需要再接数组
        // 直接新建一个文件夹写一个正则匹配匹配一下其实就能发现问题
        // 还是以实践为好啊

        if (is_array($matches) && count($matches[0]) > 0) {
            $alt = $matches[1][0];
            $src = $matches[2][0];
            $html = "";
            $type = "photos";
            if ($type === "photos") {//自适应拉伸的
                $html .= "<div class='album-photos'>";
            } else {//统一宽度排列
                $html .= "<div class='photos'>";
            }
            for ($i = 0; $i < count($matches[1]); $i++) {
                $info = trim($matches[1][$i]);
                if ($type == "photos") {
                    $html .= <<<EOF
<figure>
<img src="{$matches[2][$i]}" alt="{$matches[1][$i]}" title="{$matches[1][$i]}"/>
<figcaption>{$info}</figcaption>
</figure>
EOF;
                } else {
                    $html .= <<<EOF
<figure class="image-thumb" itemprop="associatedMedia" itemscope="" itemtype="http://schema.org/ImageObject">{$matches[1][$i]}
<figcaption itemprop="caption description">{$info}</figcaption>
</figure>
EOF;
                }
            }

            $html .= "</div>";

            return $html;
        } else {
            //解析失败，就不解析，交给前端进行解析，还原之前的短代码
            $type = ($type == "photos") ? ' type="photos"' : "";
            return "<div class='album_block'>\n\n[album" . $type . "]\n" . $content . "[/album] </div>";
        }


    }
    /**
     * 一篇文章中引用另一篇文章正则替换回调函数
     * @param $matches
     * @return bool|string
     */
    public static function quoteOtherPostCallback($matches)
    {
        
        // 不解析类似 [[post]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }

        //对$matches[3]的url如果被解析器解析成链接，这些需要反解析回来
        $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/", '$1', $matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数

        //这里需要对id做一个判断，避免空值出现错误
        $cid = @$attrs["cid"];
        $url = @$attrs['url'];
        $cover = @$attrs['cover'];//封面
        $targetTitle = "";//标题
        $targetUrl = "";//链接
        $targetSummary = "";//简介文字
        if (!empty($cid)) {
            $db = Typecho_Db::get();
            $prefix = $db->getPrefix();
            $posts = $db->fetchAll($db
                ->select()->from($prefix . 'contents')
                ->orWhere('cid = ?', $cid)
                ->where('type = ? AND status = ? AND password IS NULL', 'post', 'publish'));
            //这里需要对id正确性进行一个判断，避免查找文章失败
            if (count($posts) == 0) {
                $targetTitle = "文章不存在，或文章是加密、私密文章";
            } else {
                $result = Typecho_Widget::widget('Widget_Abstract_Contents')->push($posts[0]);
                $targetSummary = Others::excerpt(Markdown::convert($result['text']), 60);
                $targetTitle = $result['title'];
                $targetUrl = $result['permalink'];
            }
        } else if (empty($cid) && $url !== "") {
            $targetUrl = $url;
            $targetSummary = @$attrs['intro'];
            $targetTitle = @$attrs['title'];
            $targetImgSrc = $cover;
        } else {
            $targetTitle = "文章不存在，请检查文章CID";
        }
        if (empty($targetImgSrc)) {
            $targetImgSrc = 'https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210723231406.png';
        }
        $imgStyle = 'background-image:url('.$targetImgSrc.')';
        return <<<EOF
<a target="_blank" href="{$targetUrl}" class="LinkCard old LinkCard--hasImage"><span class="LinkCard-backdrop" style="{$imgStyle}"></span><span class="LinkCard-content"><span class="LinkCard-text"><span class="LinkCard-title">{$targetTitle}</span><span class="LinkCard-meta"><span style="display:inline-flex;align-items:center">​<svg class="Zi Zi--InsertLink" fill="currentColor" viewBox="0 0 24 24" width="17" height="17"> <path d="M13.414 4.222a4.5 4.5 0 1 1 6.364 6.364l-3.005 3.005a.5.5 0 0 1-.707 0l-.707-.707a.5.5 0 0 1 0-.707l3.005-3.005a2.5 2.5 0 1 0-3.536-3.536l-3.005 3.005a.5.5 0 0 1-.707 0l-.707-.707a.5.5 0 0 1 0-.707l3.005-3.005zm-6.187 6.187a.5.5 0 0 1 .638-.058l.07.058.706.707a.5.5 0 0 1 .058.638l-.058.07-3.005 3.004a2.5 2.5 0 0 0 3.405 3.658l.13-.122 3.006-3.005a.5.5 0 0 1 .638-.058l.069.058.707.707a.5.5 0 0 1 .058.638l-.058.069-3.005 3.005a4.5 4.5 0 0 1-6.524-6.196l.16-.168 3.005-3.005zm8.132-3.182a.25.25 0 0 1 .353 0l1.061 1.06a.25.25 0 0 1 0 .354l-8.132 8.132a.25.25 0 0 1-.353 0l-1.061-1.06a.25.25 0 0 1 0-.354l8.132-8.132z"></path></svg></span>了解详情</span></span> <span class="LinkCard-imageCell"> <img class="LinkCard-image LinkCard-image--horizontal" alt="图标" src="{$targetImgSrc}"></span></span></a>
EOF;
    }
    public static function TipParseCallback($matches){
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        $type = @$attrs['type'];
        $content = $matches[5];
        // tip, warning, danger
        return <<<EOF
<div class="custom-block {$type}"><p>{$content}</p></div>
EOF;
    }
    /**
     * 进度条解析
     * @param $matches
     * @return bool|string
     */

    public static function loadParseCallback($matches)
    {
       // 不解析类似 [[player]] 双重括号的代码
       if ($matches[1] == '[' && $matches[6] == ']') {
           return substr($matches[0], 1, -1);
       }

       $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
       $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数

       $value = @$attrs['value'];

       return '<progress value="'.$value.'" max="100"></progress>';
    }
    public static function bilibiliParseCallback($matches){
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        $api = API_URL."bilibili.php";
        $v = @$attrs['v'];
        $id = @$attrs['id'];
        $api = $api."?v=".$v."&id=".$id;
        $pic = $api."&m=img";
        $json = curl_get($api);
        $json = json_decode($json);
        $ok = $json->{"ok"};
        if ($ok == 1) {
            $url = $json->{'url'};
            $title = $json->{"title"};
            $desc = $json->{"desc"};
            $name = $json->{"name"};
            $url = 'window.open("' . $url . '","_blank")';
            // window.open("https://www.bilibili.com/video/BV1eM4y157vZ", "_blank")
        }
        $html = <<<EOF
<div class="bili-box white">
<a class="bili-img" onclick="{$url}">
<img src="{$pic}" alt="{$title}" referrerpolicy="no-referrer">
</a>
<div class="bili-info">
<h1>
<a onclick="{$url}" target="_blank">{$title}</a>
</h1>
<p>{$desc}</p>
<a class="goto" onclick="{$url}">观看视频</a>
</div>
<div class="bili-powered">
<a href="https://blog.iucky.cn" target="_blank" title="使用了wibus的哔哩哔哩小窗接口">哔哩小窗</a>
</div>
</div>
EOF;
        // throw new Typecho_Exception($html);
             
        return $html;
    }
    public static function githubParseCallback($matches){
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        $repo = @$attrs['repo'];
        return '<div class="github-widget" data-repo="'.$repo.'"></div>';
    }
    public static function secretContentParseCallback($matches){
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        
        if (substr($matches[5],0,4) == "<br>"){
            $matches[5] = substr($matches[5],4);
        }
        return '<div class="hideContent">'."\n" . $matches[5] .'</div>';
    }
    public static function emojiParseCallback($matches)
    {
        $emotionUrlPrefix = $GLOBALS['assetURL']."OwO/img";
        $emotionPathPrefix = $GLOBALS['assetURL']."OwO/img";
        $path = $emotionPathPrefix . '/' . @$matches[1] . '/' . @$matches[2] . '.png';
        $url = $emotionUrlPrefix . '/' . @$matches[1] . '/' . @$matches[2] . '.png';
            // return @$matches[0];
            return '<img src="' . $url . '" class="emotion-' . @$matches[1] . '">';
    }
        /**
     * 折叠框解析
     * @param $matches
     * @return bool|string
     */
    public static function collapseParseCallback($matches)
    {
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }

        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数

        $title = $attrs['title'];
        $default = @$attrs['status'];
        if ($default == null || $default == "") {
            $default = "true";
        }
        if ($default == "false") {//默认关闭
            $class = "collapse";
            $classes = "collapsed";
        } else {
            $class = "collapse show";
            $classes = "";
        }
        $content = $matches[5];
        $notice = '开合';
        $id = "collapse-" . md5(uniqid()) . rand(0, 100);

        return <<<EOF
<div class="panel panel-default collapse-panel box-shadow-wrap-lg">
<div class="panel-heading panel-collapse {$classes} " data-bs-toggle="collapse" href="#{$id}" role="button" aria-expanded="false" aria-controls="{$id}">
<div class="accordion-toggle"><span>{$title}</span>
<i class="pull-right fa fa-chevron-right"></i>
</div>
</div>
<div class="{$class}" id="{$id}">
<div class="card card-body">
{$content}
</div>
</div>
</div>
EOF;
    }
    /**
     * 标签页，标签功能
     */
    public static function tabsParseCallback($matches)
    {
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }

        $content = $matches[5];

        $pattern = shortCode::get_shortcode_regex(array('tab'));
        preg_match_all("/$pattern/", $content, $matches);
        $tabs = "";
        $tabContents = "";
        for ($i = 0; $i < count($matches[3]); $i++) {
            $item = $matches[3][$i];
            $text = $matches[5][$i];
            $id = "tabs-" . md5(uniqid()) . rand(0, 100) . $i;
            $attr = htmlspecialchars_decode($item);//还原转义前的参数列表
            $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
            $name = @$attrs['name'];
            $active = @$attrs['active'];
            $in = "";
            $style = "style=\"";
            foreach ($attrs as $key => $value) {
                if ($key !== "name" && $key !== "active") {
                    $style .= $key . ':' . $value . ';';
                }
            }
            $style .= "\"";

            if ($active == "true") {
                $active = "active";
                $in = "show";
                $true = "true";
            } else {
                $active = "";
                $true = "false";
            }
            $tabs .= "<li class=\"nav-item $active $in\" role=\"presentation\" ><a class=\"nav-link $active $in\" id='".$id."-tab' data-bs-toggle=\"tab\" data-bs-target='#".$id."' role=\"tab\" aria-controls=\"$id\">$name</a></li>";
            $tabContents .= "<div class=\"tab-pane fade $active $in\" id=\"$id\" aria-labelledby='".$id."-tab' role=\"tabpanel\">$text</div>";
        }

    return <<<EOF
<div class="tab-container post_tab">
<ul class="nav no-padder b-b scroll-hide" id="nav-tab" role="tablist">
{$tabs}
</ul>
<div class="tab-content no-border" id="nav-tabContent">
{$tabContents}
</div>
</div>
EOF;

    }
    /**
     * bilibili播放器解析
     * Date: 2021-2-15
     */

    public static function bPlayerParseCallback($matches){
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        return '<iframe src="https://v.itggg.cn/?url="'.@$attrs[url].'"" allowfullscreen="allowfullscreen" mozallowfullscreen="mozallowfullscreen" msallowfullscreen="msallowfullscreen" oallowfullscreen="oallowfullscreen" webkitallowfullscreen="webkitallowfullscreen" width="100%" height="500px" frameborder="0"></iframe>';
    }
    /**
     * 视频解析的回调函数
     * @param $matches
     * @return bool|string
     */
    public static function videoParseCallback($matches)
    {
        // 不解析类似 [[player]] 双重括号的代码
        if ($matches[1] == '[' && $matches[6] == ']') {
            return substr($matches[0], 1, -1);
        }
        //对$matches[3]的url如果被解析器解析成链接，这些需要反解析回来
        $matches[3] = preg_replace("/<a href=.*?>(.*?)<\/a>/", '$1', $matches[3]);
        $attr = htmlspecialchars_decode($matches[3]);//还原转义前的参数列表
        $attrs = shortCode::shortcode_parse_atts($attr);//获取短代码的参数
        if ($attrs['url'] !== null || $attrs['url'] !== "") {
            $url = $attrs['url'];
        } else {
            return "";
        }

        if (array_key_exists('pic', $attrs) && ($attrs['pic'] !== null || $attrs['pic'] !== "")) {
            $pic = $attrs['pic'];
        } else {
            $pic = 'https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/qsNmnC2zHB5FW41.jpg';
        }
        $playCode = '<video src="' . $url . '" style="background-image:url(' .
            $pic . ');background-size: cover;" controls></video>';

        //把背景图片作为第一帧
//        $playCode = '<video src="' . $url . '" poster="'.$pic.'"></video>';

        return $playCode;

    }
}