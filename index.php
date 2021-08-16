<?php
// $uarowser=$_SERVER['HTTP_USER_AGENT'];
// if(strstr($uarowser, 'MSIE 6') || strstr($uarowser, 'MSIE 7') || strstr($uarowser, 'MSIE 8')){
//  // echo 5005;
//  exit;
// }
	//代理IP直接退出
	empty($_SERVER['HTTP_VIA']) or exit('error : xinkagou');
	//防止快速刷新
	session_start();
	$seconds = '2'; //时间段[秒]
	$refresh = '5'; //刷新次数
	//设置监控变量
	$cur_time = time();
	if(isset($_SESSION['last_time'])){
	 $_SESSION['refresh_times'] += 1;
	}else{
	 $_SESSION['refresh_times'] = 1;
	 $_SESSION['last_time'] = $cur_time;
	}
	//处理监控结果
	if($cur_time - $_SESSION['last_time'] < $seconds){
	 if($_SESSION['refresh_times'] >= $refresh){
	  //跳转至攻击者服务器地址
	  header(sprintf('Location:%s', 'http://127.0.0.1'));
	  exit('error : xinkagou');
	 }
	}else{
	 $_SESSION['refresh_times'] = 0;
	 $_SESSION['last_time'] = $cur_time;
	}
?>
<?php
$mod='blank';
include("api.inc.php");
?>
<!doctype html>
<html lang="en" class="no-js">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="static/css/reset.css">
    <link rel="stylesheet" href="static/css/style.index.css">
    <script src="static/js/modernizr.js"></script>
    <title>STY授权中心</title>
	<link rel="shortcut icon" href="/favicon.ico"/>
	<link rel="bookmark" href="/favicon.ico"/>
    <meta name="keywords" content="授权中心" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css">
	<script src="//cdn.bootcss.com/jquery/1.10.2/jquery.min.js"></script>
	<script src="static/js/jquery.min.js"></script> 
    <style>body{font-family: "microsoft yahei";}</style>
    
<link rel="stylesheet" href="https://at.alicdn.com/t/font_1117508_wxidm5ry7od.css">
    <script>
    class Message {
    /**
     * 构造函数会在实例化的时候自动执行
     */
    constructor() {
        const containerId = 'message-container';
        // 检测下html中是否已经有这个message-container元素
        this.containerEl = document.getElementById(containerId);

        if (!this.containerEl) {
            // 创建一个Element对象，也就是创建一个id为message-container的dom节点
            this.containerEl = document.createElement('div');
            this.containerEl.id = containerId;
            // 把message-container元素放在html的body末尾
            document.body.appendChild(this.containerEl);
        }
    }
    show({ type = 'info', text = '' , duration = 2000, closeable = 1}) {

                // 创建一个Element对象
                let messageEl = document.createElement('div');
                // 设置消息class，这里加上move-in可以直接看到弹出效果
                messageEl.className = 'message move-in';
                // 消息内部html字符串
                messageEl.innerHTML = `
                    <span class="icon icon-${type}"></span>
                    <div class="text">${text}</div>
                `;
        
                // 是否展示关闭按钮
                if (closeable) {
                    // 创建一个关闭按钮
                    let closeEl = document.createElement('div');
                    closeEl.className = 'close icon icon-close';
                    // 把关闭按钮追加到message元素末尾
                    messageEl.appendChild(closeEl);
        
                    // 监听关闭按钮的click事件，触发后将调用我们的close方法
                    // 我们把刚才写的移除消息封装为一个close方法
                    closeEl.addEventListener('click', () => {
                        this.close(messageEl)
                    });
                }
        
                // 追加到message-container末尾
                // this.containerEl属性是我们在构造函数中创建的message-container容器
                this.containerEl.appendChild(messageEl);
        
                // 只有当duration大于0的时候才设置定时器，这样我们的消息就会一直显示
                if (duration > 0) {
                    // 用setTimeout来做一个定时器
                    setTimeout(() => {
                        this.close(messageEl);
                    }, duration);
                }  
}
            /**
             * 关闭某个消息
             * 由于定时器里边要移除消息，然后用户手动关闭事件也要移除消息，所以我们直接把移除消息提取出来封装成一个方法
             * @param {Element} messageEl
             */
            close(messageEl) {
                // 首先把move-in这个弹出动画类给移除掉，要不然会有问题，可以自己测试下
                messageEl.className = messageEl.className.replace('move-in', '');
                // 增加一个move-out类
                messageEl.className += 'move-out';
                // 这个地方是监听动画结束事件，在动画结束后把消息从dom树中移除。
                // 如果你是在增加move-out后直接调用messageEl.remove，那么你不会看到任何动画效果
                messageEl.addEventListener('animationend', () => {
                    // Element对象内部有一个remove方法，调用之后可以将该元素从dom树种移除！
                    messageEl.remove();
                });
            }
        }
    </script>
    <style>/* message.css */

#message-container {
    position: fixed;
    left: 0;
    top: 0;
    right: 0;
    z-index: 99999;
    /* 采用flex弹性布局，让容器内部的所有消息可以水平居中，还能任意的调整宽度 */
    display: flex;
    flex-direction: column;
    align-items: center;
}
#message-container .message {
    background: #fff;
    margin: 10px 0;
    padding: 0 10px;
    height: 40px;
    box-shadow: 0 0 10px 0 #eee;
    font-size: 14px;
    border-radius: 3px;

    /* 让消息内部的三个元素（图标、文本、关闭按钮）可以垂直水平居中 */
    display: flex;
    align-items: center;
}
#message-container .message .text {
    color: #333;
    padding: 0 20px 0 5px;
}
#message-container .message .close {
    cursor: pointer;
    color: #999;
}

/* 给每个图标都加上不同的颜色，用来区分不同类型的消息 */
#message-container .message .icon-info {
    color: #0482f8;
}
#message-container .message .icon-error {
    color: #f83504;
}
#message-container .message .icon-success {
    color: #06a35a;
}
#message-container .message .icon-warning {
    color: #ceca07;
}
#message-container .message .icon-loading {
    color: #0482f8;
}
/* message.css */

/* 这个动画规则我们就叫做message-move-in吧，随后我们会用animation属性在某个元素上应用这个动画规则。 */
@keyframes message-move-in {
    0% {
        /* 前边分析过了，弹出动画是一个自上而下的淡入过程 */
        /* 所以在动画初始状态要把元素的不透明度设置为0，在动画结束的时候再把不透明度设置1，这样就会实现一个淡入动画 */
        opacity: 0;
        /* 那么“自上而下”这个动画可以用“transform”变换属性结合他的“translateY”上下平移函数来完成 */
        /* translateY(-100%)表示动画初始状态，元素在实际位置上面“自身一个高度”的位置。 */
        transform: translateY(-100%);
    }
    100% {
        opacity: 1;
        /* 平移到自身位置 */
        transform: translateY(0);
    }
}
/* message.css */

#message-container .message.move-in {
    /* animation属性是用来加载某个动画规则 请参考 https://developer.mozilla.org/zh-CN/docs/Web/CSS/animation */
    animation: message-move-in 0.3s ease-in-out;
}
/* message.css */

@keyframes message-move-out {
    0% {
        opacity: 1;
        transform: translateY(0);
    }
    100% {
        opacity: 0;
        transform: translateY(-100%);
    }
}

#message-container .message.move-out {
    animation: message-move-out 0.3s ease-in-out;
    /* 让动画结束后保持结束状态 */
    animation-fill-mode: forwards;
}</style>

    <style type="text/css">
        .form-horizontal{

            opacity:1.0;
            filter:alpha(opacity=70);
            padding-bottom: 1px;
            border-radius: 15px;
            text-align: center;
            max-width: 340px;
            margin-top:70px;
            margin-bottom:15%;
            margin-right: auto;
            margin-left: auto;
            border: 1px solid #fff;
        }

        .form-horizontal .ccwcc{
            display: block;
            color:#fff;
            font-size: 25px;
            font-weight: 700;
            padding: 15px 0;
            border-bottom: 1px solid #fff;
            margin-bottom: 1px;
        }
        .form-horizontal .ccwcc1{
            display: block;
            color:#fff;
            font-size: 20px;
            font-weight: 700;
            padding: 10px 0;
            border-bottom: 1px solid #fff;
            margin-bottom: 25px;
        }

        .form-horizontal .heading{
            display: block;
            color:#fff;
            font-size: 25px;
            font-weight: 700;
            padding: 15px 0;
            border-bottom: 1px solid #fff;
            margin-bottom: 30px;
        }
        .form-horizontal .form-group{
            padding: 0 40px;
            margin: 0 0 25px 0;
            position: relative;
        }
        .form-horizontal .form-control{
            opacity:0.8;
            background: #fff;
            border: 1px solid #f0f0f0;;
            border-radius: 20px;
            box-shadow: none;
            padding: 0 20px 0 45px;
            height: 40px;
            transition: all 0.3s ease 0s;
        }

        .form-horizontal .form-control:focus{
            opacity:0.8;
            background: #fff;
            box-shadow: none;
            outline: 0 none;
        }
        .form-horizontal .form-group i{
            position: absolute;
            top: 12px;
            left: 60px;
            font-size: 17px;
            color: #c8c8c8;
            transition : all 0.5s ease 0s;
        }
        .form-horizontal .form-control:focus + i{
            color: #00b4ef;
        }
        .form-horizontal .fa-question-circle{
            display: inline-block;
            position: absolute;
            top: 12px;
            right: 60px;
            font-size: 20px;
            color: #808080;
            transition: all 0.5s ease 0s;
        }
        .form-horizontal .fa-question-circle:hover{
            color: #000;
        }
        .form-horizontal .main-checkbox{
            float: left;
            width: 20px;
            height: 20px;
            background: #11a3fc;
            border-radius: 50%;
            position: relative;
            margin: 5px 0 0 5px;
            border: 1px solid #11a3fc;
        }
        .form-horizontal .main-checkbox label{
            width: 20px;
            height: 20px;
            position: absolute;
            top: 0;
            left: 0;
            cursor: pointer;
        }
        .form-horizontal .main-checkbox label:after{
            content: "";
            width: 10px;
            height: 5px;
            position: absolute;
            top: 5px;
            left: 4px;
            border: 3px solid #fff;
            border-top: none;
            border-right: none;
            background: transparent;
            opacity:1.0;
            -webkit-transform: rotate(-45deg);
            transform: rotate(-45deg);
        }
        .form-horizontal .main-checkbox input[type=checkbox]{
            visibility: hidden;
        }
        .form-horizontal .main-checkbox input[type=checkbox]:checked + label:after{
            opacity:1.0;
        }
        .form-horizontal .text{
            float: left;
            margin-left: 7px;
            line-height: 20px;
            padding-top: 5px;
            color:#fff;
            text-transform: capitalize;
        }
        .form-horizontal .btn{
            opacity:0.9;
            float:50%;
            font-size: 14px;
            color: #fff;
            background: #00b4ef;
            border-radius: 30px;
            padding: 10px 25px;
            border: none;
            text-transform: capitalize;
            transition: all 0.5s ease 0s;
        }
        @media only screen and (max-width: 479px){
            .form-horizontal .form-group{
                padding: 0 25px;
            }
            .form-horizontal .form-group i{
                left: 45px;
            }
            .form-horizontal .btn{
                padding: 10px 20px;
            }
        }
    </style>
</head>
<body>
<section class="cd-slider-wrapper">
    <ul class="cd-slider">
        <li class="visible">

            <div class="demo" style="padding: 0px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">

                            <form class="form-horizontal" name="myform1" method="get" action="?">
                                <input type="hidden" name="do" value="do">
                                <span class="heading">授权查询</span>


                                <div class="form-group help">
                                    <input type="text" name="url" class="form-control" id="inputPassword3" placeholder="授权网站域名(不加http://)" autocomplete="off"/>
                                    <i class="fa fa-qq"></i>

                                </div>

                                <div class="form-group help">

                                    <button class="btn">立即查询</button>

                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>

        </li>
        <li>
            <div class="demo" style="padding: 0px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">

                            <form class="form-horizontal" name="myform" method="post" action="/buy.php">
                                <input type="hidden" name="do" value="do">
                                <span class="heading">卡密授权</span>
                                <div class="form-group help">
                                    <input type="text" name="km" class="form-control" id="inputPassword3" placeholder="请输入卡密" autocomplete="off"/>
                                    <i class="fa fa-credit-card"></i>

                                </div>
                                <div class="form-group help">
                                    <input type="text" name="url" class="form-control" id="inputPassword3" placeholder="请输入域名(不加http://)" autocomplete="off"/>
                                    <i class="fa fa-qq"></i>

                                </div>
                                <div class="form-group help">
                                    <input type="text" name="qq" class="form-control" id="inputPassword3" placeholder="请输入QQ号" autocomplete="off"/>
                                    <i class="fa fa-qq"></i>

                                </div>
                                <div class="form-group help">
                                    <button class="btn">立即授权</button>

                                </div>
                            </form>
                        </div>

                    </div>
                </div>


            </div>



        </li>



        <li>
            <div class="demo" style="padding: 0px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">
                            <div class="form-horizontal">
                                <span class="ccwcc" >扫码下载源码</span>
                                <div class="ccwcc1"id="qrimg">
                                   </div>
                                <div class="form-group help" id="login" >
                                    <a href="#" class="btn" onclick="loadScript();" >点击验证</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
		
		
		<li>
            <div class="demo" style="padding: 0px 0px;">
                <div class="container">
                    <div class="row">
                        <div class="col-md-offset-3 col-md-6">

                            <div class="form-horizontal">
                                <span class="ccwcc">关于说明</span>
                                <div class="ccwcc1">
                                    Wee Auth System
                                    <br />
                                    <small>Second-Develop By Wibus</small>
                                </div>

                                <div class="form-group help">
                                    <a href="https://blog.iucky.cn/works/sty.html" class="btn">STY主题</a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </li>
		

    </ul>

    <ol class="cd-slider-navigation">
        <li class="selected"><a href="#0"><em>查询授权</em></a></li>
		<!--<li><a href="#0"><em>查询授权商</em></a></li>-->
        <li><a href="#0"><em>卡密授权</em></a></li>
		<li><a href="#0"><em>文件下载(BUG存在)</em></a></li>
		<li><a href="#0"><em>关于说明</em></a></li>
		

    </ol>
    <div class="cd-svg-cover" data-step1="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z" data-step2="M1400,800H383L770.7,0.6c0.2-0.3,0.5-0.6,0.9-0.6H1400v294V800z" data-step3="M1400,800H0V0.6C0,0.4,0,0.3,0,0h1400v294V800z" data-step4="M615,800H0V0.6C0,0.4,0,0.3,0,0h615L393,312L615,800z" data-step5="M0,800h-2V0.6C-2,0.4-2,0.3-2,0h2v312V800z" data-step6="M-2,800h2L0,0.6C0,0.3,0,0.3,0,0l-2,0v294V800z" data-step7="M0,800h1017L629.3,0.6c-0.2-0.3-0.5-0.6-0.9-0.6L0,0l0,294L0,800z" data-step8="M0,800h1400V0.6c0-0.2,0-0.3,0-0.6L0,0l0,294L0,800z" data-step9="M785,800h615V0.6c0-0.2,0-0.3,0-0.6L785,0l222,312L785,800z" data-step10="M1400,800h2V0.6c0-0.2,0-0.3,0-0.6l-2,0v312V800z">
        <svg height='100%' width="100%" preserveAspectRatio="none" viewBox="0 0 1400 800">
            <title>SVG cover layer</title>
            <desc>an animated layer to switch from one slide to the next one</desc>
            <path id="cd-changing-path" d="M1402,800h-2V0.6c0-0.3,0-0.3,0-0.6h2v294V800z"/>
        </svg>
    </div>
</section>
<script src="get/qrlogin.js?ver=1003"></script>
<script src="static/js/snap.svg-min.js"></script>
<script src="static/js/main.js"></script>
        <?
if($url=$_GET['url']) {
    if(checkauth2($url)) {
        echo "<script language=\"javascript\">alert(\"".$url."已经授权!\");document.location.href=\"/index.php\";</script>";
    }else{
        echo "<script language=\"javascript\">alert(\"".$url."未授权!\");document.location.href=\"/index.php\";</script>";
    }
	$DB->close();
}
?>
</body>
</html>