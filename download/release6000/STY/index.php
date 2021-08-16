<?php
/**
 * 集成多个样式部件于一体的Typecho主题！
 * 
 * @package STY
 * @author Wibus
 * @version 1.4.0
 * @link https://blog.iucky.cn
 */

$sticky = $GLOBALS['options']->sticky_cid; //置顶的文章cid，按照排序输入, 请以半角逗号或空格分隔
if($sticky && $this->is('index') || $this->is('front')){
    $sticky_cids = explode(',', strtr($sticky, ' ', ','));//分割文本 
    $sticky_html = "<span style='margin-top: 2px;margin-right: 2px;font-size: 13px;font-weight: 700;float: left!important;display: inline; padding: .2em .6em .3em; line-height: 1; text-align: center; white-space: nowrap; vertical-align: baseline; border-radius: .25em;text-shadow: 0 1px 0 rgb(0 0 0 / 20%);color: #fff;background-color: #f05050;'>置顶</span>"; //置顶标题的 html
    $db = Typecho_Db::get();
    $pageSize = $this->options->pageSize;
    $select1 = $this->select()->where('type = ?', 'post');
    $select2 = $this->select()->where('type = ? && status = ? && created < ?', 'post','publish',time());
    //清空原有文章的列队
    $this->row = [];
    $this->stack = [];
    $this->length = 0;
    $order = '';
    foreach($sticky_cids as $i => $cid) {
if($i == 0) $select1->where('cid = ?', $cid);
else $select1->orWhere('cid = ?', $cid);
$order .= " when $cid then $i";
$select2->where('table.contents.cid != ?', $cid); //避免重复
    }
    if ($order) $select1->order(null,"(case cid$order end)"); //置顶文章的顺序 按 $sticky 中 文章ID顺序
    if ($this->_currentPage == 1) foreach($db->fetchAll($select1) as $sticky_post){ //首页第一页才显示
$sticky_post['sticky'] = $sticky_html;
$this->push($sticky_post); //压入列队
    }
$uid = $this->user->uid; //登录时，显示用户各自的私密文章
    if($uid) $select2->orWhere('authorId = ? && status = ?',$uid,'private');
    $sticky_posts = $db->fetchAll($select2->order('table.contents.created', Typecho_Db::SORT_DESC)->page($this->_currentPage, $this->parameter->pageSize));
    foreach($sticky_posts as $sticky_post) $this->push($sticky_post); //压入列队
    $this->setTotal($this->getTotal()-count($sticky_cids)); //置顶文章不计算在所有文章内
}
require_once('system/global.php');
if (defined('HEADNAV')){ $headnav = HEADNAV; }
if (defined('CAROUSEL')){ $carousel = CAROUSEL; }
if (defined('SLIST')){ $list = SLIST; }
$this->need('header.php');
echo "<main id='main'>";
if ($headnav) {$this->need($headnav);}
if ($carousel) {$this->need($carousel); }
if ($list) {$this->need($list);}
echo "</main>";
$this->need('footer.php');