<?php
/*
 * @FilePath: /Wee-Auth-System/manager/functions.php
 * @author: Wibus
 * @Date: 2021-08-29 21:23:10
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-29 22:06:46
 * Coding With IU
 */
function msgShow($content = '未知的异常',$type = 4,$back = false)
{
switch($type)
{
case 1:
	$panel="success";
break;
case 2:
	$panel="info";
break;
case 3:
	$panel="warning";
break;
case 4:
	$panel="danger";
break;
}

echo '<div class="alert alert-'.$panel.'" role="alert">';
echo $content;
echo '</div>';
}