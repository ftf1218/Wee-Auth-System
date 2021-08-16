<?php 
$this->need('header.php');
if (defined('HEADNAV')){ $headnav = HEADNAV; } //获取参数
if (defined('PAGE')){ $page = PAGE; } //获取参数
echo '<main id="main">';
$this->need($headnav);
$this->need($page);
$this->need('comments.php');
echo '</main>';
$this->need('footer.php');