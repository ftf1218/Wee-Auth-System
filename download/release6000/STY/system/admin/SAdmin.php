<?php
/*
 * @FilePath: /STY/system/admin/SAdmin.php
 * @author: Wibus
 * @Date: 2021-07-16 08:35:55
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-08 22:48:54
 * Coding With IU
 */
class SAdmin{
    public static function getBackgroundColor()
    {
        $colors = array(
            array('#673AB7', '#512DA8'),
            array('#20af42', '#1a9c39'),
            array('#336666', '#2d4e4e'),
            array('#2e3344', '#232735')
        );
        $randomKey = array_rand($colors, 1);
        $randomColor = $colors[$randomKey];
        return $randomColor;
    }
    public static function StyleHello(){
        $randomColor = self::getBackgroundColor();
        $style = '<style>:root{--randomColor0:'.$randomColor[0].';--randomColor1:'.$randomColor[1].';}.mdui-panel-item-sub-header{color:#999;margin-left:25px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap}.typecho-option span{display:block}.description{margin:.5em 0 0;color:#999;font-size:.92857em}.description:hover{color:#333;transition:.3s}.checking{margin-top:10px}#update_notification{margin-top:10px}.mdui-btn[class*=mdui-color-]:hover,.mdui-fab[class*=mdui-color-]:hover{opacity:.87;background:#00bcd4}label.settings-subtitle{color:#999;font-size:10px;font-weight:400}.settingsbutton{margin-bottom:10px;display:block}.settingsbutton a{margin-right:10px}@media screen and (min-device-width:1024px){::-webkit-scrollbar-track{background-color:rgba(255,255,255,0)}::-webkit-scrollbar{width:6px;background-color:rgba(255,255,255,0)}::-webkit-scrollbar-thumb{border-radius:3px;background-color:rgba(193,193,193,1)}}.row{margin:0}.mono,code,pre{background:#e8e8e8}#use-intro{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px;padding:8px;padding-left:20px;margin-bottom:40px}.message{background-color:var(--randomColor0)!important;color:#fff}.success{background-color:var(--randomColor0);color:#fff}#typecho-nav-list{display:none}.typecho-head-nav{padding:0 10px;background:var(--randomColor1)}.typecho-head-nav .operate a{border:none;padding-top:0;padding-bottom:0;color:rgba(255,255,255,.6)}.typecho-head-nav .operate a:hover{background-color:rgba(0,0,0,.05);color:#fff}ul.typecho-option-tabs.fix-tabs.clearfix{background:var(--randomColor1)}.col-mb-12{padding:0!important}.typecho-page-title{margin:0;height:70px;background:var(--randomColor0);background-size:cover;padding:30px}.typecho-page-title h2{margin:0;font-size:2.28571em;color:#fff}.typecho-option-tabs{padding:0;background:#fff}.typecho-option-tabs a:hover{background-color:rgba(0,0,0,.05);color:rgba(255,255,255,.8)}.typecho-option-tabs a{border:none;height:auto;color:rgba(255,255,255,.6);padding:15px}li.current{background-color:#fff;height:4px;padding:0!important;bottom:0}.typecho-option-tabs li.active a,.typecho-option-tabs li.current a{background:0 0}.container{margin:0;padding:0}.body.container{min-width:100%!important;padding:0}.typecho-option-tabs{margin:0}.typecho-option-submit button{float:right;background:#00bcd4;box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);color:#fff}.typecho-option-tabs li{margin-left:20px}.typecho-option{border-radius:3px;background:#fff;padding:12px 16px}.col-mb-12{padding-left:0!important}.typecho-option-submit{background:0 0!important}.typecho-option{float:left}.typecho-option span{margin-right:0}.typecho-option label.typecho-label{font-weight:500;margin-bottom:10px;margin-top:10px;font-size:16px;padding-bottom:5px;border-bottom:1px solid rgba(0,0,0,.2)}.typecho-page-main .typecho-option input.text{width:100%}input[type=text],textarea{border:none;border-bottom:1px solid rgba(0,0,0,.6);outline:0;border-radius:0}.typecho-option-submit{position:fixed;right:32px;bottom:32px}.typecho-foot{padding:16px 40px;color:#9e9e9e;background-color:#424242;margin-top:80px}.typecho-option .description{font-weight:400}@media screen and (max-width:480px){.typecho-option{width:94%!important;margin-bottom:20px!important}}label.typecho-label.settings-title{font-size:30px;font-weight:700;border:none}.settings-title:hover{text-decoration:underline}.appearanceTitle{float:inherit;margin-bottom:0;box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px 1%;padding:8px 2%;width:94%;display:table;background-color:#f6f8f8}.length-94{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px 1%;padding:8px 2%;width:94%;margin-bottom:20px}.length-60{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px 1%;padding:8px 2%;width:60%}.length-44{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px 1%;padding:8px 2%;width:44%;margin-bottom:30px}.length-27{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px 1%;padding:8px 2%;width:27.333%;margin-bottom:40px}.length-29{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px 1%;padding:8px 2%;width:29%}.length-59{box-shadow:0 2px 2px 0 rgba(0,0,0,.14),0 3px 1px -2px rgba(0,0,0,.2),0 1px 5px 0 rgba(0,0,0,.12);background-color:#fff;margin:8px 1%;padding:8px 2%;width:59%;margin-bottom:30px}#typecho-option-item-BGtype-2{margin-bottom:0}#typecho-option-item-bgcolor-4{margin-bottom:20px}#typecho-option-item-BlogJob-10{margin-bottom:55px}#typecho-option-item-titleintro-8{margin-bottom:50px}.mdui-textfield-input{resize:vertical;min-height:80px}button.btn.primary {display: none;}</style>';
        $styleAssets = '
        <script src="https://cdn.jsdelivr.net/npm/mdui@0.4.3/dist/js/mdui.min.js"></script>
        <script src="https://cdn.staticfile.org/jquery/2.2.4/jquery.min.js" type="text/javascript"></script>
        <link href="https://cdn.jsdelivr.net/npm/mdui@0.4.3/dist/css/mdui.min.css" rel="stylesheet">
        ';
        $endHTML = $style.$styleAssets;
        return $endHTML;
    }
    public static function Welcome(){
        $db = Typecho_Db::get();
        $backupInfo = "";
        if ($db->fetchRow($db->select()->from('table.options')->where('name = ?', 'theme:STYbf'))) {
            $backupInfo = '<div class="mdui-chip" style="color: rgb(26, 188, 156);"><span 
        class="mdui-chip-icon mdui-color-green"><i class="mdui-icon material-icons">&#xe8ba;</i></span><span class="mdui-chip-title">数据库存在主题数据备份</span></div>';
        } else {
            $backupInfo = '<div class="mdui-chip" style="color: rgb(26, 188, 156);"><span 
        class="mdui-chip-icon mdui-color-red"><i class="mdui-icon material-icons">&#xe8ba;</i></span><span 
        class="mdui-chip-title" style="color: rgb(255, 82, 82);">没有主题数据备份</span></div>';
        }
    //     if (!isPluginAvailable("Links_Plugin", "Links")) {
    //         $pluginInfo = '<div class="mdui-chip" mdui-tooltip="{content: 
    // \'' . $pluginExInfo . '\'}" style="color: rgb(26, 188, 156);"><span 
    //     class="mdui-chip-icon mdui-color-red"><i class="mdui-icon material-icons">&#xe8ba;</i></span><span 
    //     class="mdui-chip-title" style="color: rgb(255, 82, 82);" >配套插件未启用，请及时安装</span></div>';
    //     } else {
    //         $pluginInfo = '<div class="mdui-chip" mdui-tooltip="{content: 
    // \'' . $pluginExInfo . '\'}" style="color: rgb(26, 188, 156);"><span 
    //     class="mdui-chip-icon mdui-color-green"><i class="mdui-icon material-icons">&#xe8ba;</i></span><span class="mdui-chip-title">配套插件已启用</span></div>';
    //     }
        $pluginInfo = "";
        $version = get_theme_version();
        $welcomeHTML = <<<EOF
        <div class="mdui-card">
  <!-- 卡片的媒体内容，可以包含图片、视频等媒体内容，以及标题、副标题 -->
  <div class="mdui-card-media">    
    <!-- 卡片中可以包含一个或多个菜单按钮 -->
    <div class="mdui-card-menu">
      <button class="mdui-btn mdui-btn-icon mdui-text-color-white"><i class="mdui-icon material-icons">share</i></button>
    </div>
  </div>
  
  <!-- 卡片的标题和副标题 -->
<div class="mdui-card">
  <!-- 卡片头部，包含头像、标题、副标题 -->
  <div id="STY_header" class="mdui-card-header" mdui-dialog="{target: '#mail_dialog'}">
    <!--<img class="mdui-card-header-avatar" src="$img"/>-->
    <div class="mdui-card-header-title">用户，您好！</div>
    <div class="mdui-card-header-subtitle">欢迎使用 STY 主题，这里还没有完工</div>
  </div>
  
  <!-- 卡片的标题和副标题 -->
<div class="mdui-card-primary mdui-p-t-1">
    <div class="mdui-card-primary-title">STY Pro {$version}</div>
    <div class="mdui-card-primary-subtitle mdui-row mdui-row-gapless  mdui-p-t-1 mdui-p-l-1">

        <!--<div class="mdui-p-b-1" id="STY_notice">公告信息</div>
        <div class="mdui-chip"  mdui-dialog="{target: '#history_notice_dialog'}" id="history_notice" style="color: 
        #607D8B;"><span 
        class="mdui-chip-icon mdui-color-blue-grey"><i 
        class="mdui-icon material-icons">&#xe86b;</i></span><span 
        class="mdui-chip-title" style="color: #607D8B;">查看历史公告</span></div>
        
        <div id="update_notification" class="mdui-m-r-2">
            <div class="mdui-progress">
                <div class="mdui-progress-indeterminate"></div>
            </div>
            <div class="checking">检查更新中……</div>
        </div>->
        
       
                <!--备份情况-->
                {$backupInfo}
                <!--插件情况-->
                {$pluginInfo}
     </div>
  </div>  
  <!-- 卡片的按钮 -->
  <div class="mdui-card-actions">
    <button class="mdui-btn mdui-ripple"><a href="https://wibus.gitee.io/docs/sty" mdui-tooltip="{content: 
    '主题99%的使用问题都可以通过文档解决，文档有搜索功能快试试！'}"}>使用文档</a></button>
    <button class="mdui-btn mdui-ripple"><a href="https://wibus.gitee.io/docs/sty/#/log" mdui-tooltip="{content: 
    '在这里有关于主题开发的一切，还有其他更多'}">开发日志</a></button>

    <!--<button class="mdui-btn mdui-ripple showSettings" mdui-tooltip="{content: 
    '展开所有设置后，使用ctrl+F 可以快速搜索🔍某一设置项'}">展开所有设置</button>
    <button class="mdui-btn mdui-ripple hideSettings">折叠所有设置</button>-->

    <form class="protected home col-mb-12" action="?'.$name.'bf" method="post">
    <input class="mdui-btn mdui-ripple back_up" 
    mdui-tooltip="{content: '1. 仅仅是备份STY主题的外观数据</br>2. 切换主题的时候，虽然以前的外观设置的会清空但是备份数据不会被删除。</br>3. 所以当你切换回来之后，可以恢复备份数据。</br>4. 备份数据同样是备份到数据库中。</br>5. 如果已有备份数据，再次备份会覆盖之前备份'}" type="submit" name="type" value="备份模板设置数据" />&nbsp;&nbsp;
    <input class="mdui-btn mdui-ripple recover_back_up" mdui-tooltip="{content: '从主题备份恢复数据'}" type="submit" name="type" value="还原模板设置数据" />&nbsp;&nbsp;
    <input class="mdui-btn mdui-ripple un_back_up" mdui-tooltip="{content: '删除STY备份数据'}" type="submit" name="type" value="删除现有STY备份" />
    </form>

  </div>
  
  
</div>
  
</div>
<div class="mdui-dialog" id="updateDialog">
    <div class="mdui-dialog-content">
      <div class="mdui-dialog-title">更新说明</div>
      <div class="mdui-dialog-content" id="update-dialog-content">获取更新内容失败，请稍后重试</div>
    </div>
    <div class="mdui-dialog-actions">
      <button class="mdui-btn mdui-ripple" mdui-dialog-close>取消</button>
      <button class="mdui-btn mdui-ripple" mdui-dialog-confirm>前往更新</button>
    </div>
  </div>
  
  <div class="mdui-dialog mdui-p-a-5" id="dialog" data-status="0">
  <div class="mdui-spinner mdui-center">
  <h2 >关于主题</h2>
  <p>STY 是一款 Typecho 主题，原名叫做 Mix Pro，全名叫做 Super Typecho ，是 Wibus 在离开 Typecho 阵营的最后一个作品</p>
  <p>这是史上第一款突破单个主题限制的Typecho主题，它不单单只有一种样式，他有有多个开发者细心打造的不同部件，让你即使是同一个主题，也有不同风格的展现</p>
  <blockquote><p>“STY is made for your reading”，所以STY在设计之初，就是为了阅读。因此，在默认/积极维护的风格以阅读舒适度为主</p>
  </blockquote>  
  </div>
    <div class="mdui-dialog-content mdui-hidden">
      <div class="mdui-dialog-content">
    
        </div>
</div>
    </div>  
EOF;
        return $welcomeHTML;
    }
}