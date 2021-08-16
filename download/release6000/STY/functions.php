<?php
/*
 * @Name: functions.php
 * @author: Wibus
 * @Date: 2021-04-17 16:06:35
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-11 11:52:06
 * Coding With IU
 */
if (!defined('__TYPECHO_ROOT_DIR__')) exit;

// 必须在前面加载
require('system/global.php'); //定义全局函数变量（一定在第1个！）
// require('system/Interface/getAuth.php'); //获取目标授权详情（暂时不启动）
require('libs/shortCode.php'); //短代码解析模块
require('libs/Utils.php'); // 实用工具
require('libs/Values.php'); //一些变量
require('system/GlobalFunctions.php'); // functions
require('system/Interface/interface.php'); //interface
require('system/Interface/Request.php'); //Request function

// 插件集成
require('system/plugins/main.php'); // 插件综合集成
Request::init(); // 启动构建函数

// 文章处理类
require('libs/CallBack.php'); //短代码回调
require('libs/Content.php'); //文章&页面输出模块
require('libs/Index.php'); //外观设置函数
require('libs/Others.php'); //其他模块，如：评论
// SiteClose(); // 处理维护页面

// MDUI表单组件
require("system/functions/FormElements.php");
require('system/functions/Checkbox.php');
require('system/functions/Text.php');
require('system/functions/Radio.php');
require('system/functions/Select.php');
require('system/functions/Textarea.php');

require('system/admin/SAdmin.php'); // 为后台设置页面注入样式
require('system/admin/Backup.php'); // 备份&输出样式功能
require('functionsConfig.php'); //模板外观设置