<?
/*
 * @Name: getAuth.php
 * @author: Wibus
 * @Date: 2021-05-15 06:59:26
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-17 00:05:55
 * Coding With IU
 */


// 获取授权key的方式
$key = ConfigSTY();
$key = $GLOBALS['options']->key;

// 获取授权详情的方式
$domain=$_SERVER['HTTP_HOST'];
$akey=$GLOBALS['options']->key;
$ckurl="http://auth.iucky.cn/api/check.php?domain=".$domain."&key=".$akey;
$how=curl_get($ckurl);

// 丢出错误提示的方式
throw new Typecho_Exception(_t('主题出现内部错误！请联系开发者解决！错误输出：'.md5($domain.'20210522V1.0STYProCheckUpNo')));
// Typecho_Widget::widget('Widget_Notice')->set(_t("索引构建成功，去博客试试搜索效果吧"), 'success');

// 以下是关于我的想法：

// 1. function设置页面当中，先获取API，根据API判断是否授权
// 2. 接着向表中加入数据：md5加密（域名）
// 3. 如果是未授权的话直接throw阻止程序继续

// 1. 前端页面当中，如果没有数据的话，throw提示，让用户进入function里面先检测授权先
// 2. 如果有的话，就和md5(域名)来比对，这个操作是为了防止有人知道了这个策略之后把这个数据发给其他人，导致程序误以为是正版

// 优点：可以防止由于我们auth站点不稳定的问题，导致curl的同时前台慢了
// 缺点：麻烦，工作量大，破解策略的话可能会容易点

// 第二种想法：

// 不使用PHP，使用JavaScript进行获取
