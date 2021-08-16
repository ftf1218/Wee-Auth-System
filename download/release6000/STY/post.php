<?php 
if (isset($_POST['agree'])) {
    //  判断 POST 请求中的 cid 是否是本篇文章的 cid
    if ($_POST['agree'] == $this->cid) {
        //  调用点赞函数，传入文章的 cid，然后通过 exit 输出点赞数量
        exit( strval(agree($this->cid)) );
    }
    //  如果点赞的文章 cid 不是本篇文章的 cid 就输出 error 不再往下执行
    exit('error');
}
$this->need('header.php');
if (defined('HEADNAV')){ $headnav = HEADNAV; }
if (defined('POST')){ $post = POST; }
echo '<main id="main">';
    $this->need($headnav);
    $this->need($post);
    $this->need('comments.php');
echo '</main>';
$this->need('footer.php');