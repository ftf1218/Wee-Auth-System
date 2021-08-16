<?
/*
 * @FilePath: /STY/system/plugins/TagsHelper/Tags_Plugin.php
 * @author: Wibus
 * @Date: 2021-07-08 12:38:28
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-28 12:44:04
 * Coding With IU
 * 由泽泽社长开发
 */

Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Tags_Plugin', 'tagslist');
Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Tags_Plugin', 'tagslist');
class Tags_Plugin{
    public static function tagslist()
    {

      
?><style>.tagshelper a{cursor: pointer; padding: 0px 6px; margin: 2px 0;display: inline-block;border-radius: 2px;text-decoration: none;}
.tagshelper a:hover{background: #ccc;color: #fff;}
</style>
<script> $(document).ready(function(){
    $('#tags').after('<div style="margin-top: 35px;" class="tagshelper"><ul style="list-style: none;border: 1px solid #D9D9D6;padding: 6px 12px; max-height: 240px;overflow: auto;background-color: #FFF;border-radius: 2px;"><?php
$stack = Typecho_Widget::widget('Widget_Metas_Tag_Cloud')->stack;
$i = 0; 
while (isset($stack[$i])) {
  echo "<a id=\"$i\" onclick=\"$(\'#tags\').tokenInput(\'add\', {id: \'".$stack[$i]['name']."\', tags: \'".$stack[$i]['name']."\'});\">",$stack[$i]['name'], "</a>";
  $i++;
  if (isset($stack[$i])) echo "  ";
}
?></ul></div>');
  });</script>
<?php

    }
}