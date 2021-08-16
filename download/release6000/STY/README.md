# STY —— 多重空间混合体 

![](https://github.com/wibus-wee/STY/actions/workflows/STY%20Dev%20Ci.yml/badge.svg)  [![DeepScan grade](https://deepscan.io/api/teams/14175/projects/17528/branches/404979/badge/grade.svg)](https://deepscan.io/dashboard#view=project&tid=14175&pid=17528&bid=404979) ![](https://wakatime.com/badge/github/wibus-wee/Mix.svg)

## 关于主题

STY 是一款 Typecho 主题，原名叫做 Mix Pro，全名叫做 Super Typecho ，是 Wibus 在离开 Typecho 阵营的最后一个作品

这是史上第一款突破单个主题限制的Typecho主题，它不单单只有一种样式，他有有多个开发者细心打造的不同部件，让你即使是同一个主题，也有不同风格的展现

> “STY is made for your reading”，所以STY在设计之初，就是为了阅读。因此，在默认/积极维护的风格以阅读舒适度为主

## 主题特色

1. `简约却不简单`。STY风格以简约为主，但在其内部核心却有着惊天动地的强大功能

2. `Vditor.js` 写作方式，STY默认以vditor作为前台解析，不过如果不喜欢的话也可以关闭哒

3. `原生js编写`，全局不引入jquery。STY出于以速度为主的原因，宁愿开发更新辛苦点，也不会引入导致缓慢的jquery（Ps：在部分机器中确实存在此类情况）

4. `不依赖jquery的无刷新技术`。STY引入了一种加载速度更快的无刷新技术，并完美兼容了其他技术的回调函数（Ps：含jq写法的回调函数不算）

5. `多种风格随意选择`。STY希望在一个主题中实现几个主题的功能以及样式，这样既不易与其他人发生风格相似的冲突，也利于修复审美疲劳

6. `多合一短代码`，为了使用户更快的迁移至本主题，开发者Wibus（也就是我啦哈哈哈）花费了许多时间为现部分主题的短代码进行了适配，如：handsome

7. 优秀的`表情解析`。STY使用与handsome相同的解析方式 使用OwO.js 利于制作自己的表情包（Ps：并与handsome兼容）

8. `Service worker`缓存机制。STY使用SW为静态资源进行缓存，与redis缓存有少许不同

9. `集成插件`于主题中，STY自带部分有用的插件，避免了安装的时候还要再装插件的麻烦，并且自带了开关

## DOMLoaded Second

依次为：STY，Mix，以及某主题



![STY DOMLoad](https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210606213611.png)

![Mix DOMLoad](https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210606213654.png)

![Joe DOMLoad](https://gitee.com/wibus/blog-assets-goo/raw/master/asset-pic/20210606213658.png)