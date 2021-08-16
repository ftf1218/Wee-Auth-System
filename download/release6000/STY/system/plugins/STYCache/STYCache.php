<?php
/*
 * @FilePath: /STY/system/plugins/STYCache/STYCache.php
 * @author: Wibus
 * @Date: 2021-07-17 19:52:09
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-28 12:42:25
 * Coding With IU
 */
// 注册文章、页面保存时的 hook（JSON 写入数据库）
Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishPublish = array('STYCache_Plugin', 'buildSearchIndex');
Typecho_Plugin::factory('Widget_Contents_Post_Edit')->finishDelete = array('STYCache_Plugin', 'buildSearchIndex');
Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishPublish = array('STYCache_Plugin', 'buildSearchIndex');
Typecho_Plugin::factory('Widget_Contents_Page_Edit')->finishDelete = array('STYCache_Plugin', 'buildSearchIndex');

class STYCache_Plugin{
    public static function buildSearchIndex($contents = null, $edit = null)
    {
        //生成索引数据
        if ($edit != null) {
            //如果是新增文章或者修改文章无需构建整个索引，速度太慢
                $code = json_decode(file_get_contents(__DIR__ . '/STYCachesearch.json'));
                $data = @$edit->stack[0]['categories'][0]['description'];
                $data = json_decode($data, true);
                //寻找当前编辑的文章在数组中的位置
                $cid = -1;
                if ('delete' == $edit->request->do) {//文章删除
                    $cid = $contents;
                } else {
                    $cid = $edit->cid;
                }
                $flag = -1;
                for ($i = 0; $i < count($code); $i++) {
                    $item = $code[$i];
                    if ($item->cid == $cid) {
                        //匹配成功
                        $flag = $i;
                        break;
                    }
                }
                if ($flag != -1) {//找到了当前保存的文章，直接修改内容即可或者删除一篇文章
                    //不是加密文章、草稿、私密、隐藏文章
                    if ('delete' == $edit->request->do) {//文章删除
                        unset($code[$flag]);
                    } else if ((@$data["password"] == null || @$data["password"] == "") && strpos($contents['type'], "draft") === FALSE && $contents['visibility'] == "publish") {
                        //修改值
                        $code[$flag]->title = $contents["title"];
                        $code[$flag]->path = $edit->permalink;
                        $code[$flag]->date = date('c', $edit->created);
                        $code[$flag]->content = $contents["text"];

                    } else {
                        //不用管，这类文章不应该出现在搜索结果中
                        //删除这个元素
                        unset($code[$flag]);
                    }
                } else {//新增一篇文章
                    if ((@$data["password"] == null || @$data["password"] == "") && strpos($contents['type'], "draft") ===
                        FALSE && $contents['visibility'] == "publish") {

                        //新增一条记录，也有一种可能是编辑的时候把链接地址也改了，就导致错误增加了一条
                        $code[] = (object)array(
                            'title' => $contents['title'],
                            'date' => date('c', $edit->created),
                            'path' => $edit->permalink,
                            'content' => trim(strip_tags($contents['text']))
                        );
                    }
                }
                file_put_contents(__DIR__ . '/search.json', json_encode(array_values($code)));

            

        } else {//插件设置界面的构建索引，如果数据太大则速度较慢
            //判断是否有写入权限
            // 获取搜索范围配置，query 对应内容
            $cache = array();
            $cache = array_merge($cache, self::build('post'));
            $cache = array_merge($cache, self::build('page'));

            $cache = json_encode($cache);

            //写入文件
            $code = file_put_contents(__DIR__ . '/STYCachesearch.json', $cache);


            $ret = self::build('comment');
            $code_comment = file_put_contents(__DIR__ . '/STYCachecomment.json', $ret);


            //写入数据库
            if ($code === false || $code_comment === false) {
                throw new Typecho_Expention(_t('STY/plugins/STYCache 文件夹没有写入权限,查看STY/plugins/下是否有STYCache文件夹，并给777权限'));
            } else {
                throw new Typecho_Exception(_t('索引构建成功!'));
            }
        }
    }

    /**
     * 生成对象
     *
     * @access private
     * @param $type
     * @return array|string
     */
    private static function build($type)
    {
        $db = Typecho_Db::get();
        if ($type == "comment"){
            $period = time() - 25920000; // 单位: 秒, 时间范围: 10个月
            $rows = $db->fetchAll($db->select('created')->from('table.comments')
                ->where('status = ?', 'approved')
                ->where('created > ?', $period )
                ->where('type = ?', 'comment')
                ->where('authorId = ?', '1'));
        }else{
            $rows = $db->fetchAll($db->select()->from('table.contents')
                ->where('table.contents.type = ?', $type)
                ->where('table.contents.status = ?', 'publish')
                ->where('table.contents.password IS NULL'));
        }

        $cache = array();
        $result = "";
        foreach ($rows as $row) {

            if ($type == 'comment'){
                $result .= date('Y-m-d',$row['created']);
            }else{
                $widget = self::widget('Contents', $row['cid']);
//            print_r(strip_tags($widget->content));
                $data = @$widget->stack[0]['categories'][0]['description'];
                $data = json_decode($data, true);

                if (@$data["password"] == null || @$data["password"] == "") {//过滤加密分类的文章
                    $item = array(
                        'title' => $row['title'],
                        'date' => date('c', $row['created']),
                        'path' => $widget->permalink,
                        'cid' => $row['cid'],
                        'content' => trim(strip_tags($widget->content))
                    );
                    $cache[] = $item;
                }
            }

        }
        if ($type == "comment"){
            return $result;
        }else{
            return $cache;
        }
    }
        /**
     * 根据 cid 生成对象
     *
     * @access private
     * @param string $table 表名, 支持 contents, comments, metas, users
     * @param $pkId
     * @return Widget_Abstract
     */
    private static function widget($table, $pkId)
    {
        $table = ucfirst($table);
        if (!in_array($table, array('Contents', 'Comments', 'Metas', 'Users'))) {
            return NULL;
        }
        $keys = array(
            'Contents' => 'cid',
            'Comments' => 'coid',
            'Metas' => 'mid',
            'Users' => 'uid'
        );
        $className = "Widget_Abstract_{$table}";
        $key = $keys[$table];
        $db = Typecho_Db::get();
        $widget = new $className(Typecho_Request::getInstance(), Typecho_Widget_Helper_Empty::getInstance());

        $db->fetchRow(
            $widget->select()->where("{$key} = ?", $pkId)->limit(1),
            array($widget, 'push'));
        return $widget;
    }
}