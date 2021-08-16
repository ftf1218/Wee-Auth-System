<?php 
/*
 * @FilePath: /STY/archive.php
 * @author: Wibus
 * @Date: 2021-04-18 19:39:41
 * @LastEditors: Wibus
 * @LastEditTime: 2021-07-13 13:26:24
 * Coding With IU
 */
$this->need('header.php');
if (defined('HEADNAV')){ $headnav = HEADNAV; }
if (defined('ARCHIEVE')){ $archieve = ARCHIEVE; }
?>
<main id='main'>
<?
$this->need($headnav);
$this->need($archieve);
?>
</main>
<?php $this->need('footer.php'); ?>