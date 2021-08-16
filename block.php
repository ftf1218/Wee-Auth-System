<?php
if(!$DB->get_row("SELECT * FROM  auth_site where url ='$url'")){
	if($row_sqdata = $DB->get_row("SELECT * FROM auth_site WHERE url='$url' limit 1")){//判断url是否授权
	if($row_sqdata['authcode'] != $authcode){
		$DB->query("INSERT INTO auth_site (url, authcode,sata, date) VALUES ('$url', '$authcode','信息有错', '$date')");
	}
}else{
	$DB->query("INSERT INTO auth_site (url, authcode,sata, date) VALUES ('$url', '$authcode','未授权', '$date')");
}
}else if(!$DB->get_row("SELECT * FROM  auth_site where authcode ='$authcode'")){
	if($row_sqdata = $DB->get_row("SELECT * FROM auth_site WHERE url='$url' limit 1")){//判断url是否授权
	if($row_sqdata['authcode'] != $authcode){
		$DB->query("INSERT INTO auth_site (url, authcode,sata, date) VALUES ('$url', '$authcode','信息有错', '$date')");
	}
}else{
	$DB->query("INSERT INTO auth_site (url, authcode,sata, date) VALUES ('$url', '$authcode','未授权', '$date')");
}	
}
?>