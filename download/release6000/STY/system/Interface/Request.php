<?php
/*
 * @FilePath: /STY/system/Interface/Request.php
 * @author: Wibus
 * @Date: 2021-07-17 18:13:26
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-17 22:10:12
 * Coding With IU
 */
class Request{
    /**
     * @name: init
     * @msg: 用于启动函数
     * @param void
     * @return void
     */
    public static function init(){
        staticInfoGet();
        searchGet();
        self::buildCache();
    }
    public static function buildCache(){
        if (isset($_GET['action']) && $_GET['action'] == 'buildSearchIndex') {
            STYCache_Plugin::buildSearchIndex();
            die('成功构建索引');
        }
    }
    /**
     * @param $type post-calendar category-radar posts-chart categories-chart tags-chart
     * @param $obj
     * @param $monthNum
     * @return array
     */
    public static function getStatisticContent($type, $obj, $monthNum = 10)
    {

        $object = array();

        if ($type == "post-calendar" || $type == "posts-chart") {
            //获取统计信息
            $filePath = __TYPECHO_ROOT_DIR__ . __TYPECHO_THEME_DIR__ . DIRECTORY_SEPARATOR . 'STY' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'plugins'  . DIRECTORY_SEPARATOR . 'STYCache' . DIRECTORY_SEPARATOR . 'search.json';
            $fileContent = file_get_contents($filePath);


            //1. 确定时间段
            //获取今天所在的月份
            $end_m = (int)date('m');
            $end_d = (int)date('d');
            $end_y = (int)date('Y');

            $start_y = $end_y;

            if ($type == "post-calendar") {
                $start_m = $end_m - $monthNum + 1;
            } else {//post-chart 只需要近5个月的数据
                $start_m = $end_m - 5;
            }
            $start_d = $end_d;
            if ($start_m < 0) {
                $start_m = $start_m + 12;
                $start_y = $start_y - 1;
            }
            //获取该时间段的每一天的日期，及其该日的文章数目。

            $start_timestamp = strtotime($start_y . "-" . $start_m . "-" . $start_d);
            $end_timestamp = strtotime($end_y . "-" . $end_m . "-" . $end_d);

            $data = array();
            $max_single = 0;// 最大每日/月的文章数目

            if ($type == "post-calendar") {

                $commentPath = __TYPECHO_ROOT_DIR__ . __TYPECHO_THEME_DIR__ . DIRECTORY_SEPARATOR . 'STY' . DIRECTORY_SEPARATOR . 'system' . DIRECTORY_SEPARATOR . 'plugins'  . DIRECTORY_SEPARATOR . 'STYCache' . DIRECTORY_SEPARATOR . 'comment.json';
                $commentContent = file_get_contents($commentPath);


                // 计算日期段内有多少天
                $date = array();// 保存每天日期
                while ($start_timestamp <= $end_timestamp) {
                    $temp = date('Y-m-d', $start_timestamp);
                    $date[] = $temp;
                    //搜索当日发表的文章数目
                    $temp_num = substr_count($fileContent, '"date":"' . $temp);
                    $temp_comment_num = substr_count($commentContent, $temp);
                    $temp_num = $temp_comment_num + $temp_num;

                    if ($temp_num > $max_single) {
                        $max_single = $temp_num;
                    }
                    if ($max_single > 3) {//max 最大值是3，再后面是4+
                        $max_single = 4;
                    }
                    if ($temp_num > 3) {
//                        $temp_num = 4;
                    }

                    $data[] = array(
                        $temp,
                        $temp_num
                    );
                    $start_timestamp = strtotime('+1 day', $start_timestamp);
                }

                $object['series'] = $data;
                $object['range'] = array(
                    $start_y . "-" . $start_m . "-" . $start_d,
                    $end_y . "-" . $end_m . "-" . $end_d
                );
                $object['categories'] = range(0, $max_single);
                $object['max'] = $max_single;
//                $object['num_range'] = range(0,$max_single);
//                if (count($object['categories']) ==5){
//                    $object['categories'][4] = 'N';
//                }

//                var_dump($object);

            } else {
                // 计算时间段内有多少个月
                $xAxis = [];
                while ($start_timestamp <= $end_timestamp) {
                    $temp = date('Y-m', $start_timestamp); // 取得递增月;
                    $temp_num = substr_count($fileContent, '"date":"' . $temp);
                    if ($temp_num > $max_single) {
                        $max_single = $temp_num;
                    }
                    $xAxis[] = $temp;
                    $data[] = $temp_num;
                    $start_timestamp = strtotime('+1 month', $start_timestamp);
                }

                $object['series'] = $data;
                $object["xAxis"] = $xAxis;
                $object['categories'] = range(0, $max_single);
            }
        }

        if ($type == "category-radar" || $type == "categories-chart" || $type == "tags-chart") {
            $object = [];
            $name = [];
            $indicator = [];
            $num = [];
            $i = -1;
            while ($obj->next()) {
//                print_r("\n\n================i:".$i."================\n\n");
                //判断是否是子分类
                if ($obj->levels == 0) {
                    $i++;
//                    print_r("\nmid".$obj->mid."|count:".$obj->count."\n");
                    $name[] = $obj->name;
                    $num [] = $obj->count;
                } else {
                    $num [$i] += $obj->count;
//                    print_r("level:".$obj->levels."|id".$obj->mid."parent:".$obj->parent."|");
                }
            }

            $max_single = max($num);

//            print_r("count:".$i);

            for ($i = 0; $i < count($num); $i++) {
                if ($type == "category-radar") {
                    $indicator[] = (object)array(
                        "name" => $name[$i],
                        "max" => $max_single
                    );
                } else if ($type == "categories-chart") {
                    $indicator[] = (object)array(
                        "name" => $name[$i],
                        "value" => $num[$i]
                    );
                } else if ($type == "tags-chart") {
                    $indicator[] = $name[$i];
                }
            }

            if ($type == "categories-chart") {
                //保证color数组的颜色不重复
                $color = ['#6772e5', '#ff9e0f', '#fa755a', '#3ecf8e', '#82d3f4', '#ab47bc', '#525f7f', '#f51c47', '#26A69A', '#6772e5', '#ff9e0f', '#fa755a', '#3ecf8e', '#82d3f4', '#ab47bc', '#525f7f', '#f51c47', '#26A69A'];
                $cColor = [];
                for ($i = 0; $i < count($num); $i++) {
                    $cColor [] = $color[$i % count($color)];
                }

                $object["color"] = $cColor;
            }

            if ($type == "tags-chart") {
                $indicator = array_slice($indicator, 0, min(8, count($indicator)));
                $num = array_slice($num, 0, min(8, count($num)));
            }

            $object["indicator"] = $indicator;
            $object["series"] = $num;

        }
        return $object;

    }
}