<?php
/**
 * 友链页面
 * 
 * @package custom
 */

$this->need('header.php');
if (defined('HEADNAV')){ $headnav = HEADNAV; }
if (defined('FRIENDS')){ $friends = FRIENDS; }
echo '<main id="main">';
    $this->need($headnav);
    $this->need($friends);
    $this->need('comments.php');
echo '</main>';
$this->need('footer.php');