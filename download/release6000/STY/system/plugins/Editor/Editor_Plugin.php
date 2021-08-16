<?
/*
 * @FilePath: /STY/system/plugins/Editor/Editor_Plugin.php
 * @author: Wibus
 * @Date: 2021-07-03 08:49:24
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-30 20:27:37
 * Coding With IU
 */
if ($GLOBALS['options']->vditor_editor == 1) {
    // 添加文章编辑选项
    Typecho_Plugin::factory('admin/write-post.php')->bottom = array('Editor_Plugin', 'Editor_addFooter');
    Typecho_Plugin::factory('admin/write-page.php')->bottom = array('Editor_Plugin', 'Editor_addFooter');
    // 修改编辑器
    Typecho_Plugin::factory('admin/write-post.php')->richEditor = array('Editor_Plugin', 'Editor_richEditor');
    Typecho_Plugin::factory('admin/write-page.php')->richEditor = array('Editor_Plugin', 'Editor_richEditor');
}

class Editor_Plugin{

    public static function Editor_addFooter() {
        echo '<link rel="stylesheet" href="'.$GLOBALS['assetURL'].'css/plugins/editor.css">';
        echo '
        <style>
        .vditor-toolbar__item .vditor-tooltipped{
            font-size: 12px;
        }
        </style>
        ';
    }
    public static function Editor_richEditor(){
        $options = Helper::options();
        if($GLOBALS['options']->vditor_editor == 1):?>
            <script>window.STY = {ASSET_URL: '<? echo $GLOBALS['assetURL']?>'}</script>
        <?php
        echo <<<EOF
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/font-awesome@4.7.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="{$GLOBALS['assetURL']}css/plugins/editor.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/vditor@3.8.4/dist/index.css"/>
        <script src="https://cdn.jsdelivr.net/npm/vditor@3.8.4/dist/index.min.js"></script>
        <script src="{$GLOBALS['assetURL']}js/OwO.min.js"></script>
        <script src="{$GLOBALS['assetURL']}js/plugins/editor.js"></script>
        <script>
            window.EditorConf = {
                'i18n': {
                    'ok': '确定',
                    'cancel': '取消',
                    'toolbar': '工具栏',
                    'markdownDisabled': '本文Markdown解析已禁用！',
                    'insertAllImages': '插入所有图片',
                    'required': '必须填写',
                    'button': '按钮',
                }
            };
        </script>
EOF;
        endif;
    }
}
