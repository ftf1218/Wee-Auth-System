<?php
$mod='blank';
include("api.inc.php");
$url=daddslashes($_GET['url']);
$content="您的网站未授权，授权请联系QQ：1649393506或16440162";

if($url && checkauth2($url)) {
	echo '1';
} else {
	echo '0';
}

$DB->close();
?>