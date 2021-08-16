<?
/*
 * @Name: header.php
 * @author: Wibus
 * @Date: 2021-05-10 14:17:24
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-11 11:36:30
 * Coding With IU
 */
getPages($this);

 
?>
<!DOCTYPE html>
<html lang="zh-CH">
    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title><?php $this->archiveTitle(array(
            'category'  =>  _t('分类 %s 下的文章'),
            'search'    =>  _t('包含关键字 %s 的文章'),
            'tag'       =>  _t('标签 %s 下的文章'),
            'author'    =>  _t('%s 发布的文章')
        ), '', ' - '); ?><?php $this->options->title(); ?>
            <?php $this->options->切割描述符号(); ?>
            <?php $this->options->标题描述(); ?></title>
        <style>
            a.nav-links {
                text-decoration: none;
            }
            li.category-tag > a {
                color: #fff;
            }
            main {
                padding: 0!important;
            }
        </style>
        <?php if (!empty($this->options->Show) && in_array('Pjax', $this->options->Show)): ?>
        <script src="https://cdn.jsdelivr.net/npm/pjax/pjax.js"></script>
        <?php endif; ?>
        <link rel="stylesheet" href="<?php echo $GLOBALS['assetURL']; ?>css/layout.main.css">
        <?if (defined('CSS')) {echo '<link rel="stylesheet" href="'.$GLOBALS["assetURL"].CSS.'">';}?>
        <script src="<?php echo $GLOBALS['assetURL']; ?>js/method.min.js"></script>
        <script src="<?php echo $GLOBALS['assetURL']; ?>js/STY.js"></script>
        <script src="https://cdn.jsdelivr.net/gh/Dreamer-Paul/Kico-Style/kico.min.js"></script>
        <script src="<?php echo $GLOBALS['assetURL']; ?>js/OwO.min.js"></script>
        <script>
            window.STY = {
                VERSION: '<? echo get_theme_version(); ?>',
                THEME: '<? $GLOBALS['options']->部件模板设置(); ?>',
                CDN_FAST: '<? $GLOBALS['options']->使用CDN静态资源加速(); ?>',
                ASSET_URL: '<? echo $GLOBALS['assetURL']?>',
                THEME_URL: "<? echo THEME_URL?>",
                API_URL: "<? echo API_URL?>",
                LOAD_TIME: '<? echo timer_stop() ?>',
                LOGIN_TIME: '<? echo get_last_login($this->author) ?>',
                ONLINE_USERS: '<? online_users() ?>',
                RAND_COLOR: '<? echo randColor() ?>',
                STATISTIC: '<? echo $GLOBALS['RealSite'] ?>?action=get_statistic',
                BUILD_JSON: '<? echo $GLOBALS['RealSite'] ?>?action=buildSearchIndex',
                MODE: 'light',
                FEED_URL: '<? echo $GLOBALS['RealSite'] ?>feed',
                DEVTOOL: '<? if (!empty($this->options->Show) && in_array('Devtool', $this->options->Show)): echo 'ON'; else: echo 'OFF'; endif;?>'
            }
        </script>
        <? $GLOBALS['options']->head() ?>
    </head>