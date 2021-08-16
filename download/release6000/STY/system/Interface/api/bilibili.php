<?php
/*
 * Bilibili API
 * @FilePath: /STY/system/Interface/api/bilibili.php
 * @author: Wibus
 * @Date: 2021-08-10 17:46:42
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-11 11:54:41
 * Coding With IU
 * @Description 将会输出关于视频的信息
 * v | must | string | a/b | a-->av, b-->bv
 * id | must | string | xx/BVxx | a-->string(xxxxxx), b-->string(BVxxxxx)
 * m |  | string | img/null | img-->photo, null-->json(need decode)
 * @example: ?v=b&id=BV1eM4y157vZ 或者 ?v=b&id=BV1eM4y157vZ&m=img
 * @return string/img
 */
function curl_get($url){
	$ch=curl_init($url);
	curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
	curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Linux; U; Android 4.4.1; zh-cn; R815T Build/JOP40D) AppleWebKit/533.1 (KHTML, like Gecko)Version/4.0 MQQBrowser/4.5 Mobile Safari/533.1');
	curl_setopt($ch, CURLOPT_TIMEOUT, 10);
	$content=curl_exec($ch);
	curl_close($ch);
	return($content);
}
function showImg($img){
    $info = getimagesize($img);
    $imgExt = image_type_to_extension($info[2], false);
    $fun = "imagecreatefrom{$imgExt}";
    $imgInfo = $fun($img); //创建对象
    $mime = '.jpg'; //MINE类型
    header('Content-Type:'.$mime);
    $quality = 100;
    if($imgExt == 'png') $quality = 9; //输出质量,JPEG格式(0-100),PNG格式(0-9)
    $getImgInfo = "image{$imgExt}";
    $getImgInfo($imgInfo, null, $quality);
    imagedestroy($imgInfo);
}
$api = 'https://api.bilibili.com/x/web-interface/view';
if ($_GET['v'] == 'a') {
    $后缀 = '?aid=';
}elseif(empty($_GET['v'])){
    exit('
    {
        "ok": 0,
        "error": "Cannot GET AV/BV Type"
    }
    ');
}else{
    $后缀 = '?bvid=';
}
$id = $_GET['id'];
if (empty($id)) {
    exit('
    {
        "ok": 0,
        "error": "Cannot GET id"
    }
    ');
}
$api = $api.$后缀.$id;
$获取对象 = curl_get($api);
$json = json_decode($获取对象);
$title = $json->{'data'}->{'title'};
$des = $json->{'data'}->{'desc'};
$des = nl2br($des);
$des = mb_substr($des,1,100);
$des= str_replace(array("\r\n", "\r", "\n"), "", $des);  
$desc = $des."...";
$pic = $json->{'data'}->{'pic'}; 
$name = $json->{'data'}->{'owner'}->{'name'}; 
$url = "https://www.bilibili.com/video/".$id;
$m = $_GET['m'];
if ($m == 'img'){
    showImg($pic);
}else{
    header('Content-Type:application/json');
    $out =  <<<EOF
    {
        "ok": 1,
        "url": "{$url}",
        "title": "{$title}",
        "desc": "{$desc}",
        "pic": "{$pic}",
        "name": "{$name}",
        "api": "{$api}"
    }
EOF;
}
echo $out;

// 以下是示例用法：
// $json = curl_get('bilibili.php?v=b&id=BV1eM4y157vZ');
// $json = json_decode($json);
// $ok = $json->{"ok"};
// if ($ok == 1) {
//     $url = $json->{'url'};
//     $title = $json->{"title"};
//     $desc = $json->{"desc"};
//     $pic = $json->{"pic"};
//     $name = $json->{"name"};
// }
// echo $desc;