<?php
/*
 * @FilePath: /STY/libs/Others.php
 * @author: Wibus
 * @Date: 2021-07-14 14:01:43
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-10 22:50:34
 * Coding With IU
 */
class Others{
    public static function ListThumb($cate){
        switch ($cate) {
            case 'default':
                $style = '#2c2c2c';
                break;
            case 'typecho':
                $style = '#999';
                break;
            default:
                $style = 'white';
                break;
        }
        return $style;
    }
    /**
     * 输出文章摘要
     * @param $content
     * @param $limit 字数限制
     * @param string $emptyText
     * @return string
     */
    public static function excerpt($content, $limit, $emptyText = "暂时无可提供的摘要")
    {

        if ($limit == 0) {
            return "";
        } else {
            $content = Content::returnExceptShortCodeContent($content);
            if (trim($content) == "") {
                return _t($emptyText);
            } else {
                return Typecho_Common::subStr(strip_tags($content), 0, $limit, "...");
            }
        }
    }

    public static function CommentContent($content, $isLogin, $rememberEmail, $currentEmail, $parentEmail, $isTime = false)
    {
        //解析私密评论
        $flag = true;
        if (strpos($content, '[secret]') !== false) {//提高效率，避免每篇文章都要解析
            $pattern = shortCode::get_shortcode_regex(array('secret'));
            $content = preg_replace_callback("/$pattern/", array('CallBack', 'secretContentParseCallback'), $content);
            if ($isLogin || ($currentEmail == $rememberEmail && $currentEmail != "") || ($parentEmail == $rememberEmail && $rememberEmail != "")) {
                $flag = true;
            } else {
                $flag = false;
            }
        }
        if ($flag) {
            $content = Content::parseContentPublic($content);
            return $content;
        } else {
            if ($isTime) {
                return '<div class="hideContent">此条为私密说说，仅发布者可见</div>';
            } else {
                return '<div class="hideContent">该评论仅登录用户及评论双方可见</div>';
            }
        }
    }
    public static function returnCommentList($obj, $security, $comments)
    {
        echo '<div id="post-comment-list" class="skt-loading">';


        if ($comments->have()) {
            echo '<h4 class="comments-title m-t-lg m-b">';
            $obj->commentsNum(_mt('暂无评论'), _mt('1 条评论'), _mt('%d 条评论'));
            echo '</h4>';
            echo <<<EOF
<nav class="loading-nav text-center m-t-lg m-b-lg hide">
<p class="infinite-scroll-request"><i class="animate-spin fontello fontello-refresh"></i>Loading...</p>
</nav>
EOF;
            $comments->listComments();//列举评论
            echo '<nav id="comment-navigation" class="text-center m-t-lg m-b-lg" role="navigation">';
            $comments->pageNav('<i class="fontello fontello-chevron-left"></i>', '<i class="fontello fontello-chevron-right"></i>');
            echo '</nav>';
        }
        Content::outputCommentJS($obj, $security);
        echo '</div>';

    }
    /**
     * 输出系统原生评论必须的js，主要是用来绑定按钮的
     * @param Widget_Archive $archive
     * @param $security
     */
    public static function outputCommentJS($archive, $security)
    {
        return <<<EOF
        <script>
        (function () {
          // ajax 提交评论实现方法
        
          // 阻止默认事件
          const ajax_init = () => {
            const form = document.getElementById('comment-form')
            form.onsubmit = e => {
              e.preventDefault()
              post_by_ajax(e, '#comment-form')
            }
            const reply_form = document.querySelector('.reply_form')
            reply_form.onsubmit = e => {
              e.preventDefault()
              post_by_ajax(e, '.reply_form', true)
            }
          }
          STY_Method.OwOInit()
          comment_init()
          ajax_init()
        
          // ajax 提交
          function post_by_ajax(e, sel, reply = false) {
            const isComment = document.querySelector('.post-form.is-comment')
            const commentForm = document.querySelector(sel)
            const post_url = e.target.getAttribute('action')
        
            // 如果是管理员登陆
            if (!document.querySelector('#comment-form #author')) {
              const text = commentForm.querySelector('#text').value
              let data = null
        
              if (reply) {
                data = {
                  text, parent: window.parentId
                }
              } else {
                data = {
                  text
                }
              }
              wee.notice('正在提交，请稍等哈', {
                color: 'yellow',
                time: 1000
              })
              wee.ajax({
                url: post_url,
                method: 'POST',
                data,
                success(res) {
                  const responseDOM = parser(res.responseText) //如果全部输出，也就是输出评论后的整个页面
                  isComment.classList.contains('active') ? isComment.classList.remove('active') : false // 如果回复区是active状态，则把它的active删除掉
                  try {
                    const needPartten = responseDOM.querySelector('#comments_selecter').innerHTML //得到评论列表
                    const comment_selecter = responseDOM.querySelector('#comments_selecter').innerHTML //整个评论区
                    // 关于为什么needPartten === doc..为true的时候需要显示等待审核
                    // 当评论后返回的HTML中，发现评论区域和原本没评论的一样，意思就是说没有审核通过✅加入评论列表中，那么这个时候就是等待审核
                    comment_selecter === 
                    document.querySelector('#comments_selecter').innerHTML ? wee.notice('请等待审核哦 φ(>ω<*) ', {
                      color: 'green',
                      time: 1000
                    }) : (
                    document.querySelector('#comments_selecter').innerHTML = comment_selecter, //使评论列表等于返回列表
                    // 关于为什么之前评论区会出现回复之后reply-form被吞掉的问题
                    // 这个comment我设计的reply_form并不在原本的#comments_selecter里面，因此如果我使用querySelector选择了#comments_selecter的话，我是无法获得到新的form的
                    // 这就会导致我这里的innerHTML出现的是没有form的，我的form在这个comment-list的外面
                    // 所以，解决方法就是将整个comment区域给替换掉，这样子form才会回来
                    wee.notice('评论成功了 (〃\'▽\'〃)', {
                      color: 'green',
                      time: 1000
                    }), (reply ? false : true))
                    STY_Method.OwOInit()
                    comment_init()
                    ajax_init()
                  } catch (e) {
                    console.log("管理员发布文章出现错误："+e)
                    wee.notice("管理员发布文章出现错误："+ e, {
                      color: 'red',
                      // time: 1500
                    })
                    console.log(responseDOM)
                  }
        
                },
                failed(res) {
                  console.log(res)
                  wee.notice('(；´д｀)ゞ 失败了', {
                    color: 'red',
                    time: 1500
                  })
                }
              })
            } else {
              // 游客
              const author = commentForm.querySelector('#author').value
              const mail = commentForm.querySelector('#mail').value
              const url = commentForm.querySelector('#url').value
              const text = commentForm.querySelector('#text').value
        
              if (reply) {
                data = {
                  author, mail, url, text, parent: window.parentId
                }
              } else {
                data = {
                  author, mail, url, text,
                }
              }
              wee.notice('正在提交，请稍等哈', {
                color: 'yellow',
                time: 1000
              })
              wee.ajax({
                method: 'POST',
                url: post_url,
                data,
                success(res) {
                  const responseDOM = parser(res.responseText) //如果全部输出，也就是输出评论后的整个页面
                  isComment.classList.contains('active') ? isComment.classList.remove('active') : false
                  try {
                    const needPartten = responseDOM.querySelector('#comments_selecter').innerHTML
                    const comment_selecter = responseDOM.querySelector('#comments_selecter').innerHTML
                    // 关于为什么needPartten === doc..为true的时候需要显示等待审核
                    // 当评论后返回的HTML中，发现评论区域和原本没评论的一样，意思就是说没有审核通过✅加入评论列表中，那么这个时候就是等待审核
                    needPartten === 
                    document.querySelector('#comments_selecter').innerHTML ? wee.notice('请等待审核哦 φ(>ω<*) ', {
                      color: 'green',
                      time: 1000
                    }) : (
                    document.querySelector('#comments_selecter').innerHTML = comment_selecter, //使评论列表等于返回列表
                    // 关于为什么之前评论区会出现回复之后reply-form被吞掉的问题
                    // 这个comment我设计的reply_form并不在原本的#comments_selecter里面，因此如果我使用querySelector选择了#comments_selecter的话，我是无法获得到新的form的
                    // 这就会导致我这里的innerHTML出现的是没有form的，我的form在这个comment-list的外面
                    // 所以，解决方法就是将整个comment区域给替换掉，这样子form才会回来
                    wee.notice('评论成功了 (〃\'▽\'〃)', {
                      color: 'green',
                      time: 1000
                    }), (reply ? false : window.scrollSmoothTo(document.body.scrollHeight || document.documentElement.scrollHeight)))
                    STY_Method.OwOInit()
                    comment_init()
                    ajax_init()
                  } catch (e) {
                    console.log("游客发布文章出现错误："+ e)
                    wee.notice("游客发布文章出现错误："+ e, {
                      color: 'red',
                      // time: 1500
                    })
                    console.log(responseDOM)
                  }
        
                },
                failed(res) {
                  console.log(res)
                  wee.notice('(；´д｀)ゞ 失败了', {
                    color: 'red',
                    time: 1500
                  })
                }
              })
            }
          }
        })();
        
        (function () {
          const commentFunction = document.head.querySelector('script')
          const innerHTML = commentFunction.innerHTML
          if (innerHTML.match(/this.dom\('respond-.*?'\)/ig)) {
            const after = innerHTML.replace(/this.dom\('respond-.*?'\)/ig, "this.dom('respond-<?php $this->is('post') ? print_r('post') : print_r('page') ?>-<?php $this->cid() ?>')")
            setTimeout(() => {
              eval(after)
            })
          } else {
            const script = document.createElement('script')
            script.innerHTML = `
        (function () {
          window.TypechoComment = {
              dom : function (id) {
                  return document.getElementById(id);
              },
              create : function (tag, attr) {
                  var el = document.createElement(tag);
                  for (var key in attr) {
                      el.setAttribute(key, attr[key]);
                  }
                  return el;
              },
              reply : function (cid, coid) {
                  var comment = this.dom(cid), parent = comment.parentNode,
                      response = this.dom('respond-<?php $this->is('post') ? print_r('post') : print_r('page') ?>-<?php $this->cid() ?>'), input = this.dom('comment-parent'),
                      form = 'form' == response.tagName ? response : response.getElementsByTagName('form')[0],
                      textarea = response.getElementsByTagName('textarea')[0];
                  if (null == input) {
                      input = this.create('input', {
                          'type' : 'hidden',
                          'name' : 'parent',
                          'id'   : 'comment-parent'
                      });
                      form.appendChild(input);
                  }
                  input.setAttribute('value', coid);
                  if (null == this.dom('comment-form-place-holder')) {
                      var holder = this.create('div', {
                          'id' : 'comment-form-place-holder'
                      });
                      response.parentNode.insertBefore(holder, response);
                  }
                  comment.appendChild(response);
                  this.dom('cancel-comment-reply-link').style.display = '';
                  if (null != textarea && 'text' == textarea.name) {
                      textarea.focus();
                  }
                  return false;
              },
              cancelReply : function () {
                  var response = this.dom('respond-<?php $this->is('post') ? print_r('post') : print_r('page') ?>-<?php $this->cid() ?>'),
                  holder = this.dom('comment-form-place-holder'), input = this.dom('comment-parent');
                  if (null != input) {
                      input.parentNode.removeChild(input);
                  }
                  if (null == holder) {
                      return true;
                  }
                  this.dom('cancel-comment-reply-link').style.display = 'none';
                  holder.parentNode.insertBefore(response, holder);
                  return false;
              }
          };
        })();
        STY_Method.OwOInit()
        `
            document.head.insertBefore(script, commentFunction)
            setTimeout(() => {
              eval(script.innerHTML)
            })
          }
        })()
        </script>
EOF;
    }
}