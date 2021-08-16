<?php
/**
 * Google Sitemap 生成器
 * 
 * @package Sitemap
 * @author 吴松
 * @version 1.0.0
 * @link https://www.bayun.org
 *
 */
Helper::addRoute('sitemap', '/sitemap.xml', 'Sitemap_Action', 'action');
// TODO：变成throw
require('Action.php');
Helper::removeRoute('sitemap');