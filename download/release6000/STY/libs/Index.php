<?php
/*
 * @FilePath: /STY/libs/Index.php
 * @author: Wibus
 * @Date: 2021-07-16 13:13:11
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-13 22:36:11
 * Coding With IU
 */
class Index{
    // {"title":"第一篇文章","link":"","cover":"","desc":""},
    // {"title":"第一篇文章","link":"","cover":"","desc":""}
    // {"title":"handsome —— 一如少年般模样","link":"http://www.ihewro.com", "cover":"https://cdn.jsdelivr.net/gh/ihewro/twenty-one@main/image/things-ada17-blog.png","desc":"在复杂中，保持简洁。 一款精心打磨后的typecho主题。"},
    // {"title":"Focus——不只是RSS订阅器","link":"","cover":"https://cdn.jsdelivr.net/gh/ihewro/twenty-one@main/image/things-ada17-blog.png","desc":"拒绝信息化的算法推送"}
    // title: 文章标题
    // link: 文章的地址
    // cover: 文章图片地址，比例建议8：3，不要太小，否则显示的不清楚
    // desc: 简单描述（不要太长）
    public static function returnWheelHtml($content)
    {
        $json = "[" . $content . "]";
        $wheelItems = json_decode($json);
        $index = 0;
        $init_end = "";
        foreach ($wheelItems as $item) {
            @$itemTitle = $item->title; //可能没标题...
            // @$itemDesc = $item->desc; //可能没描述
            @$itemLink = $item->link; //可能没链接
            $itemCover = $item->cover; //可能不写图片


            $insert = "";
            if ($index === 0) {
                $insert = 'active';
            }

            // exit();
            $init = '
            <!--第'.$index.'个slide-->
            <div class="swiper-slide maxer-carousel-item" style="width: 100%;">
            <div class="item-back swiper-lazy swiper-lazy-loaded" maxer-carousel-index="0"style="background-image: url('.$itemCover.');"></div>
            <div class="item-container" >
            <div class="content f-jc-c f-col al-c" >
            <h4 class="title">'.$itemTitle.'</h4>
            <a href="'.$itemLink.'">
            <button class="link-btn shadow-box shadow-text">了解详情</button></a>
            </div>
            </div>
            </div>';
            $index++; //TODO: 条条
            $init_end = $init_end.$init;
            // throw new Typecho_Exception(_t($init_end));
            
        }
        return $init_end;
    }
    // 缩略图
    // $widget 传输入 $this 来处理
    public static function imgOutPut($widget,$cid) {
        // 匹配规则
        $pattern = '/\<img.*?src\=\"(.*?)\"[^>]*>/i';
        $patternMD = '/\!\[.*?\]\((http(s)?:\/\/.*?(jpg|png|JPEG|webp|jpeg|bmp|gif))/i';
        $patternMDfoot = '/\[.*?\]:\s*(http(s)?:\/\/.*?(jpg|png|JPEG|webp|jpeg|bmp|gif))/i';

        $siteUrl = Helper::options()->siteUrl;
        if (empty($imgurl)) {
            $rand_num = $GLOBALS['options']->imgNum; //随机图片数量，根据图片目录中图片实际数量设置
                $imgurl = $GLOBALS['assetURL']."img/"
                    .rand(1, $rand_num)
                    .".jpg";
                //随机图片，须按"1.jpg","2.jpg","3.jpg"...的顺序命名，注意是绝对地址
        }
        if ($GLOBALS['options']->rendPic_Index == 0) { // 如果使用外部资源
            $link = $GLOBALS['options']->rendPic_Link; // 获取设置选项
            // $imgurl = $link.'?'.rand(1,999); //加入随机参数 //速度会有一定的消耗
            $imgurl = $link.'?'.$cid; //cid不可能重叠，因此保证进行了不同的请求（但无法确定是否502重定向后是同一张图片）
        }
        if ($widget != null){
            //解析文章内容，这个是最慢的
            $content = $widget->content; //全篇文章
        }else{
            $content = $widget->fields->thumb; //获取字段
        }
        if (preg_match_all($pattern, $content, $thumbUrl)) {
            $thumb = $thumbUrl[1][0];
            $url = $thumb;
        } elseif (preg_match_all($patternMD, $content, $thumbUrl)) {
            $thumb = $thumbUrl[1][0];
            $url = $thumb;
        } elseif (preg_match_all($patternMDfoot, $content, $thumbUrl)) {
            $thumb = $thumbUrl[1][0];
            $url = $thumb;
        } else {//文章中没有图片
            $thumb = $imgurl;
            $url = $thumb;
        }
        if ($widget->fields->thumb) {
            $url = $widget->fields->thumb; //如果字段里有值，绝对用字段值
        }
        return $url;
        // 使用方法：echo Index::imgOutPut($this, $this->cid);
        // 必须要传一个$this进去
    }
    
    public static function parse_says($content)
    {
        // 匹配每行 放入数组

        preg_match_all('/<p>(.*?)<\/p>/', $content, $says);

        $content = array();
        foreach ($says['1'] as $key => $saying) {
            $content[] = preg_split('/((-){2,}|————|——)/', $saying);  // 匹配提取----|---|--|————|——后的内容

        }
        $author_names = array();
        $say_bodys = array();
        foreach ($content as $key => $value) {
            if (count($value) != 1) {
                $author_names[] = '来源: ' . array_pop($value);   // 分割后数量如果为1 说明作者提取失败
            } else {
                $author_names[] = '';  // 失败情况加入处理
            }

            $say_bodys[] = implode("——", $value);  // 合并多余的分割项
        }

        foreach ($say_bodys as $key => $saying) {
            yield $author_names[$key] => $saying;
        }
        foreach ($says as $say => $avatar){
            echo '<blockquote><p>' . $avatar . '</p><p class="author"> ' . $say . '</p></blockquote>';
        }

    }
    /**
     * @name: parse_album
     * @msg: 解析相册
     * @param {*} $link_string
     * @return {*} string
     * 使用：Index::parse_albums($GLOBALS['albumImg']);
     */
    public static function parse_albums($link_string) {
        $arr = explode("\n", $link_string);
        $arr = array_filter($arr);
        $parse_link = function ($array) {
            $link = $name = array();
            for ($i = 0; $i < count($array); $i += 2) {
                $link[] = $array[$i];
                $name[] = $array[$i + 1];
            }
            $total = array_map(function ($i1, $i2) {
                // i1 是链接 i2 是名字
                return '
                <li class="item block"> 
                <img alt="'.$i2.'" src="'.$i1.'" width="83" class="thumb" />
                </li> 
                ';
            }, $name, $link);
            return $total;
        };
        $s = $parse_link($arr);
        foreach($s as $item) {
            // echo $item;
        }


        // 匹配每行 放入数组
        preg_match_all('/<p>(.*?)<\/p>/', $link_string, $says);

        $link_string = array();
        foreach ($says['1'] as $key => $saying) {
            $link_string[] = preg_split('/((-){2,}|————|——)/', $saying);  // 匹配提取----|---|--|————|——后的内容

        }
        $author_names = array();
        $say_bodys = array();
        foreach ($link_string as $key => $value) {
            if (count($value) != 1) {
                $author_names[] = '来源: ' . array_pop($value);   // 分割后数量如果为1 说明————后提取失败
            } else {
                $author_names[] = '';  // 失败情况加入处理
            }

            $say_bodys[] = implode("——", $value);  // 合并多余的分割项
        }

        foreach ($say_bodys as $key => $saying) {
            yield $author_names[$key] => $saying;
        }
        foreach ($says as $say => $avatar){
            // echo '<blockquote><p>' . $avatar . '</p><p class="author"> ' . $say . '</p></blockquote>';
            echo '
            <li class="item block"> 
            <img alt="'.$avatar.'" src="'.$say.'" width="83" class="thumb" />
            </li> 
            ';
        }
    }
}