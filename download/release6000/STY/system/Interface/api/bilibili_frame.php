<?php
/*
 * @FilePath: /STY/system/Interface/api/bilibili_frame.php
 * @author: Wibus
 * @Date: 2021-08-11 01:18:38
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-11 12:03:23
 * Coding With IU
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
$json = curl_get('https://beta.iucky.cn/usr/themes/STY/system/Interface/api/bilibili.php?v=b&id=BV1eM4y157vZ');
$pic = "https://beta.iucky.cn/usr/themes/STY/system/Interface/api/bilibili.php?v=b&id=BV1eM4y157vZ&m=img";
$json = json_decode($json);
$ok = $json->{"ok"};
if ($ok == 1) {
    $url = $json->{'url'};
    $title = $json->{"title"};
    $desc = $json->{"desc"};
    $name = $json->{"name"};
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="referrer" content="no-referrer">
    <title>BiliBili iFrame API</title>
</head>
<body>
<div class="bili-box white">
    <a class="bili-img" href="<? echo $url ?>" target="_blank">
        <img src="<? echo $pic ?>" alt="<? echo $title ?>" referrerpolicy="no-referrer">
    </a>
    <div class="bili-info">
        <h1>
            <a href="<? echo $url ?>" target="_blank"><? echo $title ?></a>
        </h1>
        <p><? echo $desc ?></p>
        <a class="goto" href="<? echo $url ?>">观看视频</a>
    </div>
    <div class="bili-powered">
        <a href="https://blog.iucky.cn" target="_blank" title="使用了wibus的哔哩哔哩小窗接口">哔哩小窗</a>
    </div>
</div>
<style>

*{
            margin: 0;
            box-sizing: border-box;
        }

        body{
            font-size: 16px;
            line-height: 1.5;
        }

        img{
            max-width: 100%;
            vertical-align: middle;
        }

        a{
            color: inherit;
            transition: color .3s;
            text-decoration: none;
        }

        .bili-box{
            color: #555;
            height: 10em;
            display: flex;
            position: relative;
        }

        .bili-box.white{ background: #fff }
        .bili-box.gray{ background: #f9f9f9 }
        .bili-box.black{
            color: #eee;
            background: #333;
        }
        .bili-box h1{
            overflow: hidden;
            font-size: 1.05em;
            font-weight: normal;
            white-space: nowrap;
            margin-bottom: .5em;
            text-overflow: ellipsis;
        }
        .bili-box h1 a:hover{
            color: #4cb1f3;
        }

        .bili-box .bili-img{
            flex: 0 0 30%;
            max-width: 30%;
        }
        .bili-box .bili-img img{
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .bili-box .bili-info{
            padding: 1em;
            max-width: 70%;
        }
        .bili-info p{
            opacity: .75;
            font-size: .85em;

            display: -webkit-box;
            -webkit-box-orient: vertical;
            -webkit-line-clamp: 3;

            overflow: hidden;
            text-overflow: clip;
        }
        .bili-powered{
            right: 0;
            bottom: 0;
            color: #fff;
            opacity: .8;
            padding: .5em;
            line-height: 1;
            font-size: .5em;
            position: absolute;
            background: #4cb1f3;
            transition: opacity .3s;
            border-radius: 1em 0 0 0;
        }
        .bili-powered:hover{ opacity: 1 }
        .black .bili-powered{ background: #0d5e92 }
    
    </style>
</body>
</html>
