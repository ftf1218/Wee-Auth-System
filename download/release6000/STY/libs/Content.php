<?
/*
 * @FilePath: /STY/libs/Content.php
 * @author: Wibus
 * @Date: 2021-05-29 07:47:56
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-09 11:28:05
 * Coding With IU
 */
class Content {

    public static function contentPost($obj, $status, $way = "origin"){
        $db = Typecho_Db::get();
        $sql = $db->select()->from('table.comments')
            ->where('cid = ?', $obj->cid)
            ->where('status = ?', 'approved')
            ->where('mail = ?', $obj->remember('mail', true))
            ->limit(1);
        $result = $db->fetchAll($sql);//查看评论中是否有该游客的信息
        $content = $obj->content;
        if ($way = 'vditor') {
            $content = $obj->text;
            // TODO: 如果在这里使用content的话，需要注意一件事情：他会将一些数学公式进行解析，导致让Vditor Render出现渲染错误
            // 如果要解决这个问题，只能使用text
            // 但是问题又来了，如果使用text的话，在album短代码当中这将会失效，默认的正则匹配替换使用的是img标签，如果变换为markdown的解析规则
            // 他虽然能输出matches，但是最后输出的地方不是我想要的matches
            // 需要解决这个问题，就需要重新新建一份文件来测试，到底matches输出的是什么
            // 详细的问题解决将会在CallBack中
        }
        if (in_array('lazyload', Utils::checkArray($options->Show))) {//对图片进行处理
            $placeholder = Values::LazyLoadIMG;//图片占位符
            /*$content = preg_replace('/<img (.*?)src(.*?)(\/)?>/', '<img class="lazyload" $1src="' . $placeholder . '"' . $style . ' data-src$2 />', $content);*/
            $content = preg_replace('/!\\[.*\\]\\((.+)\\)/', '<img class="lazyload" $1src="' . $placeholder . '"' . $style . ' data-src$2 />', $content);
        }
        //文章中部分内容隐藏功能（回复后可见）
        if ($status || $result) {
            $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div class="hideContent">'."\n".'$1</div>',
                $content);
        } else {
            $content = preg_replace("/\[hide\](.*?)\[\/hide\]/sm", '<div class="hideContent">' . _t("此处内容需要评论回复后（审核通过）方可阅读。") . '</div>', $content);            }
            //仅登录用户可查看的内容
        if (strpos($content, '[login') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('login'));
            $isLogin = $status;
            $content = Utils::handle_preg_replace_callback("/$pattern/", function ($matches) use ($isLogin) {
                // 不解析类似 [[player]] 双重括号的代码
                if ($matches[1] == '[' && $matches[6] == ']') {
                    return substr($matches[0], 1, -1);
                }
               if ($isLogin) {
                    return '<div class="hideContent">'."\n" . $matches[5] . '</div>';
                } else {
                    return '<div class="hideContent">' . _t("该部分仅登录用户可见") . '</div>';
                }
            }, $content);
            }
        $content = self::parseContentPublic($content);
        return $content;
    }
    /**
     * 文章解析函数
     * Date: 2020-12-27
     * @param $content
     * @return null|string|string[]
     */
    public static function parseContentPublic($content) {
        //解析短代码功能
        if (strpos($content, '[scode') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('scode'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'scodeParseCallback'),
                $content);
        }
        //[bilibili id="" style=""] 这是调用bilibili小窗的短代码 与哔哩哔哩那边引入的有小许不同，这个是一个介绍小块，点击之后会跳转
        if (strpos($content, '[bilibili') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('bilibili'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'bilibiliParseCallback'),
                $content
            );
        };
        // [tip style=""] 这是调用提示框的短代码，一般用于插入文章重点提示，并不适合用于代码提示[/tip]
        if (strpos($content, '[tip') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('tip'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'TipParseCallback'),
                $content
            );
        };
        // [load value="10"] 这是进度条的短代码
        if (strpos($content, '[load') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('load'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'loadParseCallback'),
                $content
            );
        };
        // [github repo=""] 这是GitHub仓库短代码 TODO
        if (strpos($content, '[github') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('github'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'githubParseCallback'),
                $content
            );
        };
        //文章中折叠框功能
        if (strpos($content, '[collapse') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('collapse'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'collapseParseCallback'),
                $content);
        }
        //文章中标签页的功能
        if (strpos($content, '[tabs') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('tabs'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'tabsParseCallback'),
                $content);
        }
        //解析文章中的表情短代码
        $content = preg_replace_callback('/::([^:\s]*?):([^:\s]*?)::/sm', array('CallBack', 'emojiParseCallback'),
            $content);
        //解析BBB播放器
        if (strpos($content, '[bplayer') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('bplayer'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'bPlayerParseCallback'), $content);
        }
        //调用其他文章页面的摘要
        if (strpos($content, '[post') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('post'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'quoteOtherPostCallback'), $content);
        }
        //文章中视频播放器功能
        if (strpos($content, '[vplayer') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('vplayer'));
            $content = Utils::handle_preg_replace_callback("/$pattern/", array('CallBack', 'videoParseCallback'), $content);
        }
        //解析文章内图集
        if (strpos($content, '[album') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('album'));
            $content = Utils::handle_preg_replace_callback("/$pattern/", array('CallBack', 'scodeAlbumParseCallback'),
                $content);
        }
        //解析文章内按钮（handsome）
        if (strpos($content, '[button') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('button'));
            $content = Utils::handle_preg_replace_callback("/$pattern/", array('CallBack', 'bottonParseCallback'),
                $content);
        }
        //解析文章内按钮
        if (strpos($content, '[btn') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('btn'));
            $content = Utils::handle_preg_replace_callback("/$pattern/", array('CallBack', 'btnParseCallback'),
                $content);
        }
        // handle_preg_replace_callback 会让防止解析里面的HTML内容
        return $content;
    }
    public static function returnExceptshortCodeContent($content)
    {
        //解析短代码功能
        if (strpos($content, '[scode') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('scode'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'scodeParseCallback'),
                $content);
        }
        //解析文章内图集
        if (strpos($content, '[album') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('album'));
            $content = Utils::handle_preg_replace_callback("/$pattern/", array('CallBack', 'scodeAlbumParseCallback'),
                $content);
        }
        //[bilibili id="" style=""] 这是调用bilibili小窗的短代码 与哔哩哔哩那边引入的有小许不同，这个是一个介绍小块，点击之后会跳转
        if (strpos($content, '[bilibili') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('bilibili'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'bilibiliParseCallback'),
                $content
            );
        };
        // [tip style=""] 这是调用提示框的短代码，一般用于插入文章重点提示，并不适合用于代码提示[/tip]
        if (strpos($content, '[tip') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('tip'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'TipParseCallback'),
                $content
            );
        };
        // [load value="10"] 这是进度条的短代码
        if (strpos($content, '[load') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('load'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'loadParseCallback'),
                $content
            );
        };
        // [github repo=""] 这是GitHub仓库短代码 TODO
        if (strpos($content, '[github') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('github'));
            $content = preg_replace_callback(
                "/$pattern/",
                array('CallBack', 'githubParseCallback'),
                $content
            );
        };
        //文章中折叠框功能
        if (strpos($content, '[collapse') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('collapse'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'collapseParseCallback'),
                $content);
        }
        //文章中标签页的功能
        if (strpos($content, '[tabs') !== false) {
            $pattern = shortCode::get_shortcode_regex(array('tabs'));
            $content = Utils::handle_preg_replace_callback("/$pattern/", array('CallBack', 'tabsParseCallback'),
                $content);
        }
        //解析文章中的表情短代码
        $content = preg_replace_callback('/::([^:\s]*?):([^:\s]*?)::/sm', array('CallBack', 'emojiParseCallback'),
            $content);
        //解析BBB播放器
        if (strpos($content, '[bplayer') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('bplayer'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'bPlayerParseCallback'), $content);
        }
        //调用其他文章页面的摘要
        if (strpos($content, '[post') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('post'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'quoteOtherPostCallback'), $content);
        }
        //文章中视频播放器功能
        if (strpos($content, '[vplayer') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('vplayer'));
            $content = Utils::handle_preg_replace_callback("/$pattern/", array('CallBack', 'videoParseCallback'), $content);
        }
    }

}