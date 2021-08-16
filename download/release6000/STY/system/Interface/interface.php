<?php
/*
 * @FilePath: /STY/system/Interface/interface.php
 * @author: Wibus
 * @Date: 2021-07-17 18:09:11
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-17 18:15:10
 * Coding With IU
 */
function staticInfoGet(){
    if (@$_GET['action'] == "get_statistic"){
        header('Content-type:text/json');     //这句是重点，它告诉接收数据的对象此页面输出的是json数据；

        Typecho_Widget::widget('Widget_Metas_Category_List')->to($categorys);
        Typecho_Widget::widget('Widget_Metas_Tag_Cloud','ignoreZeroCount=1&limit=30')->to($tags);

        $object = [];

        $windowSize = @$_GET['size'];
        $monthNum = 10;
        if ($windowSize !== ""){
            if ($windowSize > 1200){
                $monthNum = 10;
            }else if ($windowSize>992){
                $monthNum = 8;
            }else if ($windowSize > 600){
                $monthNum = 10;
            }
            else{
                $monthNum = 5;
            }
        }

        $post_calendar = Request::getStatisticContent("post-calendar",null,$monthNum);
        $posts_chart = Request::getStatisticContent("posts-chart",null);
        $category_radar = Request::getStatisticContent("category-radar",$categorys);
        $categories_chart = Request::getStatisticContent("categories-chart",$categorys);
        $tags_chart = Request::getStatisticContent("tags-chart",$tags);

        $object["post_calendar"] = $post_calendar;
        $object["post_chart"] = $posts_chart;
        $object["category_radar"] = $category_radar;
        $object["categories_chart"] = $categories_chart;
        $object["tags_chart"] = $tags_chart;

        echo json_encode($object);

        die();
    }
}

function searchGetResult($thisText,$summaryNam =20){
    $filePath = __TYPECHO_ROOT_DIR__ . __TYPECHO_PLUGIN_DIR__ . DIRECTORY_SEPARATOR.'Handsome'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'search.json';
    $file = file_get_contents($filePath);

    $cache = json_decode($file,true);
    $html = "";

    $resultLength = 0;
    $searchResultArray = [];//搜索结果
    if (trim($thisText) !== ""){
        $searchArray = mb_split(" ",$thisText);
        $searchArray[] = $thisText;
        foreach ($searchArray as $thisText){
            if (trim($thisText) != ""){
                foreach ($cache as $item) {
                    $content_ok = mb_stripos($item['content'], $thisText);
                    if ($content_ok!==false){//内容中有匹配的结果
                        //高亮内容
                        $contentMatch = mb_substr($item['content'],max(0,$content_ok -$summaryNam/2),min($summaryNam,mb_strlen
                            ($item['content']) -$content_ok),'utf-8');
                        $contentMatch = str_ireplace($thisText,"<mark class='text_match'>".$thisText."</mark>",
                            $contentMatch);
                        $searchResultArray [] = array(
                            "path" => $item["path"],
                            "title" => $item["title"],
                            "content" => $contentMatch
                        );
                        $resultLength ++;
                    }else{
                        //高亮标题
                        $title_ok = mb_stripos($item['title'], $thisText);;
                        if ($title_ok!== false){//标题中有匹配的结果
                            $contentMatch = mb_substr($item['content'],0,min(30,mb_strlen($item['content']) -
                                $title_ok),'utf-8');

                            $contentMatch = str_ireplace($thisText,"<mark class='text_match'>".$thisText."</mark>",
                                $contentMatch);
                            $searchResultArray [] = array(
                                "path" => $item["path"],
                                "title" => $item["title"],
                                "content" => $contentMatch
                            );
                            $resultLength ++;
                        }else{
                            //匹配不是
                            continue;
                        }
                    }
                }
            }
        }

        $searchResultArray = Utils::array_unset_tt($searchResultArray,"path");

    }

    return $searchResultArray;
}

function searchGet(){
    if (@$_GET['action'] == "ajax_search"){
        header('Content-type:text/json');     //这句是重点，它告诉接收数据的对象此页面输出的是json数据；
        $thisText = @$_GET['content'];
//        $OnlyTitle = @$_GET['onlytitle'];//只查询标题字段
        $object = [];
        $filePath = __TYPECHO_ROOT_DIR__ . __TYPECHO_PLUGIN_DIR__ . DIRECTORY_SEPARATOR.'Handsome'.DIRECTORY_SEPARATOR.'cache'.DIRECTORY_SEPARATOR.'search.json';
        $file = file_get_contents($filePath);

        $cache = json_decode($file,true);
        $html = "";

        if (trim($thisText) !== ""){
            $searchResultArray = searchGetResult($thisText);//搜索结果

            if (count($searchResultArray) ===0){
                $html = "<li><a href=\"#\">无相关搜索结果🔍</a></li>";
            }else{
                foreach ($searchResultArray as $item){
                    $html .= "<li><a href=\"".$item["path"]."\">".$item["title"]."<p class=\"text-muted\">"
                        .$item["content"]."</p></a></li>";
                }
            }
        }


        $object['results'] = $html;
        echo json_encode($object);

        die();
    }
}
