<?php 
/*
 * @Name: functionsConfig.php
 * @author: Wibus
 * @Date: 2021-04-17 16:06:35
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-08 18:14:56
 * Coding With IU
 */
function get_theme_version()
{
 $info = Typecho_Plugin::parseInfo(__DIR__ . '/index.php');
 return $info['version'];
}

function themeConfig($form) {

    // 输出欢迎
    WelcomeOUT();
    echoBackup();

// themeConfig 代码书写规范：
// 目前拥有的类：Checkbox, FormElements, Radio, Select, Text, Textarea
// 请不要使用Typecho原生类，因为Typecho原生类没有MDUI的适配
// 具体可以前往system/functions/查看
// 请注意，自定义字段请使用原生类！！（tread)

    $form->addItem(new CustomLabel('<div class="mdui-panel" mdui-panel="">'));

    $key = new Text('key', NULL, NULL, _t('授权Key'), _t('您博客的授权Key 请正确书写 否则将视为未授权'));
    $form->addInput($key); 

    // $form->addItem(new EndSymbol(2));
    $form->addItem(new Title('SEO设置','描述符号设置，标题描述设置，公告设置'));
    $切割描述符号 = new Radio('切割描述符号',array('·' => _t('<code>&nbsp;·&nbsp;</code>'),'-' => _t('<code>&nbsp;-&nbsp;</code>')),'-', _t('首页标题后缀分割线'), _t('请谨慎选择，一旦选择，<b>非特殊情况请不要修改！</b>'));
    $form->addInput($切割描述符号);  
    $标题描述 = new Text('标题描述', NULL, _t('Super Typecho Theme'), _t('首页标题后缀'), _t('你的博客标题栏博客名称后面的副标题，如果为空，则不显示副标题</br></br>'));
    $form->addInput($标题描述);  

    // 全局设置
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Title('全局设置','维护状态设置，部件模板设置，博客头图来源设置'));  

    $author = new Text('author', NULL, 'Wibus', _t('博客作者'), _t('将会输出在不同地方，如：底部'));
    $authorDesc = new Text('authorDesc', NULL, 'Wibus', _t('作者简介'), _t('将会输出在不同地方，如：底部'));
    $authorLike = new Text('authorLike', NULL, 'wibus-wee', _t('作者小名'), _t('将会输出在不同地方，如：侧边栏'));
    $authorIMG  = new Text('authorIMG', NULL, NULL, _t('作者头像'), _t('将会输出在不同地方，如：侧边栏'));
    $form->addInput($author);
    $form->addInput($authorDesc);
    $form->addInput($authorLike);
    $form->addInput($authorIMG);

    $维护状态 = new Select('维护状态', array(
        '0' => _t('关闭'),
        '1' => _t('开启')
    ), '0', _t('主题是否启动维护状态（TODO）'), _t('启动后，前端将只会显示维护页面'));
    $form->addInput($维护状态);
    // lazyloadIMG;
    $部件模板设置 = new Select('部件模板设置', array(
        'velax' => _t('velax'),
        'weeWhite' => _t('weeWhite'),
        'SBS' => _t('SBS'),
        // 'custom' => _t('自定义（不懂请不要选择此项，选择了请在后面进行配置！）')
    ),
    'velax', _t('主题的部件模板设置'), _t('主题已经提前为您选择出了最佳的搭配，选择任意一项保存后即刻生效！'));
    $form->addInput($部件模板设置);
    $rendPic_Index = new Select('rendPic_Index', array(
        '0' => _t('使用外部资源(请在下面填写资源链接)'),
        '1' => _t('使用本地资源')),
    '0', _t('缩略图资源来源'), _t('选择从哪里接入首页/文章/页面等的头图/缩略图')
    );
    $form->addInput($rendPic_Index);
    $rendPic_Link = new Text('rendPic_Link', NULL, 'https://source.unsplash.com/1600x900/?computer', _t('缩略图外部资源链接'), _t('此处只能填入URL！不建议只填写单独一个图片链接，系统将会自动在URL后面添加随机参数实现随机的效果'));
    $form->addInput($rendPic_Link);
    $imgNum = new Text('imgNum', NULL, NULL, _t('随机图片数量'), _t('随机图片数量，根据图片目录中图片实际数量设置'));
    $form->addInput($imgNum);
    $sticky_cid = new Text('sticky_cid', NULL, NULL, _t('置顶文章设置'), _t('此处填写文章cid，使用英文逗号分割，如：1,3'));
    $form->addInput($sticky_cid);
    $introduction = new Text('introduction', NULL, 'Just Uaeua.', _t('作者自我介绍'), _t('支持HTML写法，将会输出在不同的地方中，如底部'));
    $Show = new Checkbox('Show', array(
        'Pjax' => 'Pjax 无刷新加载',
        'IMouse' => 'IMouse 鼠标（仿iPadOS鼠标）',
        'Comment' => '显示评论区',
        'Devtool' => '禁止F12工具'
    ), array('Pjax','Comment', 'Comment', 'Devtool'),_t('全局启动功能'),_t('功能启动选项'));
    $form->addInput($Show->multiMode());

    // CDN设置
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Title('CDN设置','CDN静态资源加速，CDN加速链接设置'));


    $使用CDN静态资源加速 = new Select('使用CDN静态资源加速', array(
        '0' => _t('不启动（默认选项）'),
        '1' => _t('启动（请在下面填写CDN链接！）')),
    '0', _t('是否启动CDN静态资源加速'), _t('若启动，请在下面填写CDN资源链接！')
    );
    $form->addInput($使用CDN静态资源加速); 
    $CDN加速链接 = new Text('CDN加速链接', NULL, NULL, _t('CDN加速链接'), _t('请填入CDN加速链接，不懂请清空！是将assets文件夹里面！里面！的内容上传！'));
    $form->addInput($CDN加速链接);

    // Velax部件设置
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Title('Velax主题设置','头部大字设置，头部大图设置，缩略图设置，遮罩设置，资源来源设置'));


    $velax_HeadnavText = new Textarea('velax_HeadnavText', NULL, '今天你戴口罩了吗', _t('头部大字设置'),_t("头部顶部几个大字的设置，支持HTML书写"));
    $form->addInput($velax_HeadnavText);
    $velax_HeadnavLink = new Text('velax_HeadnavLink', NULL, 'https://source.unsplash.com/1600x900/?computer',_t('头部大图设置'), _t("头部顶部的大图的设置，默认图片API速度较慢"));
    $form->addInput($velax_HeadnavLink);
    $velax_HeadnavBlack = new Select('velax_HeadnavBlack', array(
        '1' => _t('添加'),
        '0' => _t('不添加')
    ), '1', _t('头部大图遮罩'), _t('是否要给头图的图片添加一层黑色的遮罩'));
    $velax_HeadnavDrop = new Select('velax_HeadnavDrop', array(
        '1' => _t('添加'),
        '0' => _t('不添加')
    ), '1', _t('头部大图模糊'), _t('是否要让头图的图片变得模糊'));
    $form->addInput($velax_HeadnavDrop);
    $velax_wheel = new Textarea('velax_wheel',NUll,NULL,_t("首页轮播图设置"),"配置首页轮播图，<b style='color: red'>如果不需要，请清空该项</b>");
    $form->addInput($velax_wheel); //TODO!!!
    $velax_bigHalfCircle = new Select('velax_bigHalfCircle', array(
        '0' => _t("关闭"),
        '1' => _t("开启")
    ),'0',_t('头部是否添加半圆图形'), _t('是否在头部大图下面添加一个半圆的遮罩')
    );
    $form->addInput($velax_bigHalfCircle);
    $velax_HeadnavHeight = new Text('velax_HeadnavHeight', NULL, '55vh', _t('头部大图高度'), _t('设置头部大图(首页与文章)的高度，如：55vh, 200px, 200cm等'));
    $form->addInput($velax_HeadnavHeight);
    $velax_Footer = new Textarea('velax_Footer', NULL, NULL, _t('底部自定义区域'), _t('设置底部区域的HTML代码，将会显示在版权提示的上方'));
    $form->addInput($velax_Footer);


    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Title('SBS主题设置','头部设置，头部大图设置等'));
    $SBS_HeadnavLink = new Text('SBS_HeadnavLink', NULL, 'https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210728144704.jpg',_t('头部大图设置'), _t("头部顶部的大图的设置"));
    $form->addInput($SBS_HeadnavLink);
    $SBS_Essays = new Textarea('SBS_Essays', NULL, 'STY 主题开卖啦！可惜没人买呜呜呜',_t('右侧边栏Essays设置'), _t("支持HTML，请使用br标签换行"));
    $form->addInput($SBS_Essays); 
    $SBS_HeadNavDesc = new Textarea('SBS_HeadNavDesc', NULL, '<li class="item">Guangzhou China</li> 
    <li class="item"> <a href="https://iucky.cn">iucky.cn</a> </li>',_t('头像下面列表设置'), _t("请使用HTML，格式请见使用文档"));
    $form->addInput($SBS_HeadNavDesc);
    $SBS_HeadNavBtn = new Textarea('SBS_HeadNavBtn', NULL, '
    <div class="item"> 
    <a href="mailto:1596355173@qq.com" rel="nofollow" target="_blank" id="button" class="tips-top" aria-label="1596355173@qq.com"> <span class="icon"></span>发送邮件</a> 
   </div> 
   <div class="item"> 
    <a href="https://wpa.qq.com/msgrd?v=3&amp;uin=1596355173&amp;site=qq&amp;menu=yes" rel="nofollow" target="_blank" id="button" class="tips-top" aria-label="发起QQ即时聊天(1596355173)"> <span class="icon"></span>即时消息</a> 
   </div> 
    ',_t('左侧列表下部按钮设置'), _t("请使用HTML，格式请见使用文档"));
    $form->addInput($SBS_HeadNavBtn);

    // 集成设置
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Title('集成设置','Vditor Editor设置， Tags Selecter设置， Markdown渲染设置'));

    $vditor_editor = new Select('vditor_editor', array(
        '1' => _t('启动'),
        '0' => _t('关闭')
    ), '1', _t('Vditor 编辑器'), _t('是否在后台编辑处启动Vditor编辑器（推荐启动）'));
    $form->addInput($vditor_editor);

    $render = new Select('render', array(
        '1' => _t('Vditor Render'),
        '0' => _t('Typecho Render')
    ), '1', _t('markdown 渲染'), _t('选择前端文章渲染方式'));
    $form->addInput($render);

    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Title('开发者设置','自定义CSS，自定义JavaScript，自定义头部，自定义底部'));
    $css = new Textarea('css', NULL, NULL, _t('自定义CSS'), _t('CSS将会输出在/body前'));
    $js = new Textarea('js', NULL, NULL, _t('自定义JavaScript'), _t('JavaScript将会输出在/body前'));
    $head = new Textarea('head', NULL, NULL, _t('自定义头部的HTML代码'), _t('将会输出在head里面'));
    $footer = new Textarea('footer', NULL, NULL, _t('自定义底部的HTML代码'), _t('将会输出在/body前'));
    $form->addInput($css);
    $form->addInput($js);
    $form->addInput($head);
    $form->addInput($footer);


    
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Title('IMouse设置','IMouse鼠标，只有全局启动部件中启动才有效'));

    $IMouseDefaultBackgroundColor = new Text('IMouseDefaultBackgroundColor', NULL, _t('\'rgba(1, 80, 111, .1)\''), _t('非 hover 默认状态下的光标背景颜色，CSS 格式'), _t('默认值：\'rgba(1, 80, 111, .1)\''));
    $form->addInput($IMouseDefaultBackgroundColor);
    $IMouseActiveBackgroundColor = new Text('IMouseActiveBackgroundColor', NULL, _t('\'rgba(1, 80, 111, .15)\''), _t('非 hover 按下状态下的光标背景颜色，CSS 格式'), _t('默认值：\'rgba(1, 80, 111, .15)\''));
    $form->addInput($IMouseActiveBackgroundColor);
    $IMouseDefaultSize = new Text('IMouseDefaultSize', NULL, _t('20'), _t('非 hover 默认状态下的光标直径'), _t('默认值：20'));
    $form->addInput($IMouseDefaultSize);
    $IMouseActiveSize = new Text('IMouseActiveSize', NULL, _t('15'), _t('非 hover 按下状态下的光标直径'), _t('默认值：15'));
    $form->addInput($IMouseActiveSize);
    $IMouseHoverPadding = new Text('IMouseHoverPadding', NULL, _t('8'), _t('hover 状态下的光标 padding 大小'), _t('默认值：8'));
    $form->addInput($IMouseHoverPadding);
    $IMouseActivePadding = new Text('IMouseActivePadding', NULL, _t('4'), _t('hover 按下状态下的光标 padding 大小'), _t('默认值：4'));
    $form->addInput($IMouseActivePadding);
    $IMouseHoverRadius = new Text('IMouseHoverRadius', NULL, _t('8'), _t('hover 状态下的光标圆角半径'), _t('默认值：8'));
    $form->addInput($IMouseHoverRadius);
    $IMouseActiveRadius = new Text('IMouseActiveRadius', NULL, _t('4'), _t('hover 按下状态下的光标圆角半径
    '), _t('默认值：4'));
    $form->addInput($IMouseActiveRadius);
    $IMouseSelectionWidth = new Text('IMouseSelectionWidth', NULL, _t('3'), _t('文字选择状态下的光标宽度'), _t('默认值：3'));
    $form->addInput($IMouseSelectionWidth);
    $IMouseSelectionHeight = new Text('IMouseSelectionHeight', NULL, _t('40'), _t('文字选择状态下的光标高度'), _t('默认值：40'));
    $form->addInput($IMouseSelectionHeight);
    $IMouseSelectionRadius = new Text('IMouseSelectionRadius', NULL, _t('2'), _t('文字选择状态下的光标圆角半径'), _t('默认值：2'));
    $form->addInput($IMouseSelectionRadius);

    // 选择终止
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));


    // 大面板终止
    $form->addItem(new Typecho_Widget_Helper_Layout("/div"));

    $submit = new Typecho_Widget_Helper_Form_Element_Submit(NULL, NULL, _t('保存设置'));
    $submit->input->setAttribute('class', 'mdui-btn mdui-color-theme-accent mdui-ripple submit_only');
    $form->addItem($submit);
}

/*
 * 编写文章设置
 * themeFields(Typecho_Widget_Helper_Layout $layout){}控制
 */
function themeFields(Typecho_Widget_Helper_Layout $layout){
    $thumb = new Typecho_Widget_Helper_Form_Element_Text('thumb', NULL, NULL, _t('当前文章首页头图'), '<strong style="color:red;">该设置仅对该篇文章有效，优先级最高</strong></br>');
    $layout->addItem($thumb);
}