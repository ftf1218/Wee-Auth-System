<link rel="stylesheet" href="<?php echo $GLOBALS['assetURL']; ?>css/OwO.min.css">
<?php
    $GLOBALS['isLogin'] = $this->user->hasLogin();
    $GLOBALS['rememberEmail'] = $this->remember('mail',true);
if (!defined('__TYPECHO_ROOT_DIR__')) exit;
function threadedComments($comments, $options)
{
  $commentClass = '';
  if ($comments->authorId) {
    if ($comments->authorId == $comments->ownerId) {
      $commentClass .= ' comment-by-author';
    } else {
      $commentClass .= ' comment-by-user';
    }
  }
  $commentLevelClass = $comments->levels > 0 ? ' comment-child' : ' comment-parent';
  if ($comments->url) {
    $author = '<a href="' . $comments->url . '"' . '" target="_blank"' . ' rel="external nofollow">' . $comments->author . '</a>';
  } else {
    $author = $comments->author;
  }
  ?>
  <li id="li-<?php $comments->theId(); ?>" class="comment-body<?php
  if ($comments->levels > 0) {
    echo ' comment-child';
    $comments->levelsAlt(' comment-level-odd', ' comment-level-even');
  } else {
    echo ' comment-parent';
  }
  $comments->alt(' comment-odd', ' comment-even');
  echo $commentClass;
  ?>">
    <div id="<?php $comments->theId(); ?>">
      <div class="comments-body">
      <?php $avatar = 'https://gravatar.loli.net/avatar/' . md5(strtolower($comments->mail)) . '?d=wavatar'; ?>
        <img class="avatar" src="<?php echo $avatar ?>" alt="<?php echo $comments->author; ?>"/>
        <div class="comment_main">
          <div class="comment_meta">
            <span class="comment_author"><?php echo $author ?></span> <span
              class="comment_time"><?php $comments->date('y-m-d'); ?></span><span
              class="comment_reply"><i class="fa fa-reply" aria-hidden="true" name="回复"><?php $comments->reply() ?></i></span>
          </div>
          <?php 
          $parentMail = get_comment_at($comments->coid);
          echo Others::CommentContent($comments->content,$GLOBALS['isLogin'],$GLOBALS['rememberEmail'],$comments->mail,$parentMail);
           ?>
        </div>
      </div>
    </div>
    <?php if ($comments->children) { ?>
      <div class="comment-children"><?php $comments->threadedComments($options); ?></div><?php } ?>
  </li>
<?php } ?>



<?php $this->comments()->to($comments); ?>
<div id="comments_selecter" class="comments-list-container container bg-white is-component">
  <h2><?php $this->commentsNum(_t('暂无评论'), _t('仅有一条评论'), _t('已有 %d 条评论')); ?></h2>
  <!-- 评论框 -->
<form method="post" action="<?php $this->commentUrl() ?>" id="comment-form" role="form">
  <section class="post-form is-comment">
    <!--<h3><i class="fa fa-comments"></i>评论</h3>-->
    <div class="note-comments">
      <div id="note-m"></div>
      <?php if ($this->allow('comment')): ?>

        <?php if ($this->user->hasLogin()): ?>
          <p><?php _e('登录身份: '); ?><a
              href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>.
            <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?> &raquo;</a>
          </p>
        <?php else: ?>
          <input class="input textarea" type="text" name="author" id="author" placeholder="你叫什么~"
                 value="<?php $this->remember('author'); ?>"
                 required/>
          <input class="input textarea" type="text" name="mail" id="mail" placeholder="邮箱~" value="<?php $this->remember('mail'); ?>"
                 required/>
          <input class="input textarea" type="text" name="url" id="url" placeholder="网站~" value="<?php $this->remember('url'); ?>"/>
        <?php endif; ?>
        <textarea class="input textarea OwO-textarea " id="text" rows="8" name="text" placeholder="谢谢评论 ☆´∀｀☆"
                  required><?php $this->remember('text'); ?></textarea>
        <div class="submit">
          <button class="submit-btn no-btn" id="submit"><i class="fa fa-paper-plane"></i> 提交</button>

          <botton class="OwO">OwO</botton>
        </div>

      <?php else: ?>
        <p>评论功能暂时关闭</p>
      <?php endif; ?>
    </div>
  </section>
</form>
  <!--    回复评论框-->

  <div class="reply" id="<?php $this->respondId(); ?>" style="display: none">
    <form method="post" action="<?php $this->commentUrl() ?>" role="form"
          class="reply_form">
      <?php if ($this->allow('comment')): ?>
        <?php if ($this->user->hasLogin()): ?>
          <p><?php _e('登录身份: '); ?><a
              href="<?php $this->options->profileUrl(); ?>"><?php $this->user->screenName(); ?></a>
            <a href="<?php $this->options->logoutUrl(); ?>" title="Logout"><?php _e('退出'); ?>
              &raquo;</a>
          </p>
        <?php else: ?>
          
            <input class="input textarea" type="text" name="author" id="author" placeholder="你叫什么~"
                   value="<?php $this->remember('author'); ?>"
                   required/>
            <input class="input textarea" type="text" name="mail" id="mail" placeholder="邮箱~"
                   value="<?php $this->remember('mail'); ?>"
                   required/>
            <input class="input textarea" type="text" name="url" id="url" placeholder="网站~"
                   value="<?php $this->remember('url'); ?>"/>
          
        <?php endif; ?>
        <textarea class="input textarea OwO-Reply-textarea" id="text" rows="8" cols="100" name="text" placeholder="回复内容 ☆´∀｀☆"
                  required><?php $this->remember('text'); ?></textarea>

        <div class="submit">
          <button class="submit-btn no-btn" id="submit"><i class="fa fa-paper-plane"></i> 提交</button>
          <span class="submit-btn no-btn cancel-comment-reply">
            <?php $comments->cancelReply(); ?>
        </span>
        
        <botton class="OwO OwO-Reply">OwO</botton>

        </div>
      <?php else: ?>
        <p>评论功能暂时关闭</p>
      <?php endif; ?>

    </form>
  </div>

  <?php if ($comments->have()): ?>
    <?
      $comments->listComments();//列举评论
      echo '<nav id="comment-navigation" role="navigation">';
      $comments->pageNav('<i class="fa fa-angle-left"></i>', '<i class="fa fa-angle-right"></i>');
      echo '</nav>';
    ?>
  <?php endif; ?>
  </div>
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
            // console.log(responseDOM)
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