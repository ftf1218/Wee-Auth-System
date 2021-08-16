/*
 * @FilePath: /STY/assets/js/STY.js
 * @author: Wibus
 * @Date: 2021-04-11 20:24:25
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-12 22:44:20
 * Coding With IU
 */
let STY_Method = {
    CopyRight: function(){
        console.log (
            "\n %c  Typecho-STY v" + window.STY.VERSION + " https://iucky.cn ",
            " color: #fff; padding:5px 0; border-radius: 66px; background: linear-gradient(145deg, #22d3d1, #1db1b0); box-shadow:  36px 36px 71px #158483, -36px -36px 71px #2bffff;",
        );
    },
    arrIndexOf: function (arr, v) {
        for (let i = 0; i < arr.length; i++) {
            if (arr[i] == v) {
                return i;
            }
        }
        return -1;
    },
    addClass: function (obj, className) {
        if (obj.className == '') {
            obj.className = className;
        } else {
            let arrClassName = obj
                .className
                .split(' ');
            if (STY_Method.arrIndexOf(arrClassName, className) == -1) {
                obj.className += ' ' + className;
            }
        }
    },
    removeClass: function (obj, className) {
        if (obj.className != '') {
            let arrClassName = obj
                .className
                .split(' ');
            if (STY_Method.arrIndexOf(arrClassName, className) != -1) {
                arrClassName.splice(STY_Method.arrIndexOf(arrClassName, className), 1);
                obj.className = arrClassName.join(' ');
            }
        }
    },
    ready: function (callback) {
        ///兼容FF,Google
        if (document.addEventListener) {
                    document.addEventListener('DOMContentLoaded', function () {
                        document.removeEventListener('DOMContentLoaded', arguments.callee, false);
                        callback();
                    }, false)
                }
         //兼容IE
        else if (document.attachEvent) {
            document.attachEvent('onreadystatechange', function () {
                  if (document.readyState == "complete") {
                            document.detachEvent("onreadystatechange", arguments.callee);
                            callback();
                   }
            })
        }
        else if (document.lastChild == document.body) {
            callback();
        }
    },
    headNavClick: function () {
        try{
        let navbar = document.getElementById('navbar-btn');
        navbar.onclick = function () {
            // console.log('navbar.onclick')
            if (STY_Method.arrIndexOf(document.getElementById('navbar').className.split(' '), 'expanded') != -1) {
                STY_Method.removeClass(document.getElementById('navbar'), "expanded");
                // console.log('navbar1')
            } else {
                STY_Method.addClass(document.getElementById('navbar'), "expanded");
                // console.log('navbar2')
            }
        }
        let pages_on = document.getElementById('pages_on');
        let page_list = document.getElementById('children-nav-list');
        pages_on.onclick = function () {
            // console.log('pages_on.onclick')
            if (STY_Method.arrIndexOf(page_list.className.split(' '), 'expanded') != -1) {
                STY_Method.removeClass(page_list, "expanded");
            } else {
                STY_Method.addClass(page_list, "expanded");
            }
        }
        }catch(e){
            // console.log(e)
        }
    },
    CheckUpMode: function(ui) {
        if(ui == "light"){
            document.body.classList.add("no-dark-theme");
        }else{
            document.body.classList.remove("no-dark-theme");
            console.warn("Please open your system dark mode to use dark theme in this website")
        }
    },
    vditorComplete: function(){
        console.log('Vditor Render Complete')
    },
    vditorHljs: function(){
        let pres = document.getElementsByTagName('pre');
        for (let i = 0; i < pres.length; i++) {
            let code = pres[i].getElementsByTagName('code');
            pres[i].className = "mac_light mac_pre box-shadow-wrap-lg"
            code.className = "hljs"
        }
    },
    vditorRender: function(type = 'post'){
        let md_text = document.getElementById('md_text');
        Vditor.preview(document.getElementById('vditor'), md_text.value, {
            theme: {
                current: null
            },
            speech: {
                enable: true
            },
            hljs: {
                lineNumber: false, // TODO：错位
                style: 'github',
                enable: true,
                
            },
            lazyLoadImage: STY.THEME_URL + 'assets/img/other/loading.svg',
            markdown: {
                sanitize: !1,
                // Expand function
                toc: true, // 目录
                paragraphBeginningSpace: true, // 段落缩进两格
            },
            anchor: 0,
            math: {
                engine: "MathJax",
                macros: {
                    bf: "{\\boldsymbol f}",
                    bu: "{\\boldsymbol u}",
                    bv: "{\\boldsymbol v}",
                    bw: "{\\boldsymbol w}"
                },
                inlineDigit: !0
            },
            after: function () {
                STY_Method.vditorHljs();
                STY_Method.vditorComplete();
                if (type == 'post' ) {
                    STY_Method.vditorRenderTOC();   
                }
                ks.image("#vditor img")
            }
        })
    },
    initOutline: () => {
            const headingElements = []
            Array.from(document.getElementById('vditor').children).forEach((item) => {
              if (item.tagName.length === 2 && item.tagName !== 'HR' && item.tagName.indexOf('H') === 0) {
                headingElements.push(item) //此时headingElements具有item的值
              }
            })
        
            let toc = []
            window.addEventListener('scroll', () => {
              const scrollTop = window.scrollY
              toc = []
              headingElements.forEach((item) => {
                toc.push({
                  id: item.id,
                  offsetTop: item.offsetTop,
                  behavior: 'smooth'
                })
              })
        
              const currentElement = document.querySelector('.vditor-outline__item--current')
              for (let i = 0, iMax = toc.length; i < iMax; i++) {
                if (scrollTop < toc[i].offsetTop - 10) {
                  if (currentElement) {
                    currentElement.classList.remove('vditor-outline__item--current')
                  }
                  let index = i > 0 ? i - 1 : 0
                  document.querySelector('span[data-target-id="' + toc[index].id + '"]').classList.add('vditor-outline__item--current')
                  break
                }
              }
            })
    },
    vditorRenderTOC: function(){
        //TODO：目录滑动出现height问题
        const outlineElement = document.getElementById('outline')
        Vditor.outlineRender(document.getElementById('vditor'), outlineElement)
        if (outlineElement.innerText.trim() !== '') {
          outlineElement.style.display = 'block'
          this.initOutline()
        } 
    },
    swiperInit: function(){
        try{
        let velaxCarousel = new Swiper('.swiper-container', {
            // 临时可以使用enable(), disable()进行禁用或启动
            init: true, //创建实例后立即进行初始化：velaxCarousel.init()
            // cssMode: true,
            direction: 'horizontal', // 滑动方向：水平方向；竖直方向请使用vertical
            autoplay: true, // 自动滚动播放
            speed: '300', //自动滑动时间，以ms为单位
            preloadImages: false, //关闭强制加载所有图片后才初始化
            effect: 'slide', // slide切换的效果
            grabCursor: true, //启动后，当指针放在slide上的时候，将会变为小手（提示细节）
            // 可使用 'slide' or 'fade' or 'cube' or 'coverflow' or 'flip'
            // "slide"（位移切换），可设置为'slide'（普通切换、默认）,"fade"（淡入）"cube"（方块）"coverflow"（3d流）"flip"（3d翻转）        
            // 如果需要分页器
            pagination: {
                el: '.swiper-pagination'
            },
        
            // 如果需要前进后退按钮
            navigation: {
                nextEl: '.swiper-button-next',
                prevEl: '.swiper-button-prev'
            }
        })
        velaxCarousel
        } catch(e){
            // console.warn("Swiper:" + e);
        }
    },
    statisticPane: async function(){
        try{
            let response = await fetch(STY.STATISTIC)
            a = await response.json()
            this.showTheEChart(a)
        }catch(err){
            console.warn('statisticPane Request Fail: ' + err)
        }
    },
    showTheEChart: function (a) {
        try{
        this.addClass(document.querySelector(".loading-echart"), "hide"),
        this.removeClass(document.querySelector(".top-echart"), "hide");
        const b = echarts.init(
                document.getElementById("post-calendar"),
                STY.MODE
            ),
            c = echarts.init(document.getElementById("posts-chart"), STY.MODE),
            d = echarts.init(document.getElementById("categories-chart"), STY.MODE),
            e = echarts.init(document.getElementById("tags-chart"), STY.MODE),
            f = echarts.init(document.getElementById("category-radar"), STY.MODE);
        var g,
            h,
            i,
            j;
        "light" === STY.MODE
            ? (g = [
                "#ebedf0", "#c6e48b", "#7bc96f", "#239a3b", "#196127"
            ], h = "#fff", i = "#3C4858", j = "#f9f9f9")
            : (g = [
                "#ebedf0", "#c6e48b", "#7bc96f", "#239a3b", "#196127"
            ], h = "#000", i = "#fff", j = "#212121");
        const k = {
                backgroundColor: j,
                tooltip: {
                    padding: 10,
                    backgroundColor: "#555",
                    borderColor: "#777",
                    borderWidth: 1,
                    formatter: function (a) {
                        var b = a.value;
                        return '<div style="font-size: 14px;">' + b[0] + "：" + b[1] + "</div>"
                    }
                },
                visualMap: {
                    show: !1,
                    showLabel: !0,
                    min: 0,
                    max: a.post_calendar.max,
                    calculable: !1,
                    inRange: {
                        symbol: "rect",
                        color: g
                    },
                    itemWidth: 12,
                    itemHeight: 12,
                    orient: "horizontal",
                    left: "center",
                    top: 0
                },
                calendar: [
                    {
                        top: 50,
                        left: "center",
                        range: a.post_calendar.range,
                        cellSize: [
                            13, 13
                        ],
                        splitLine: {
                            show: !1
                        },
                        name: {
                            textStyle: {
                                color: i
                            }
                        },
                        itemStyle: {
                            borderColor: h,
                            borderWidth: 2
                        },
                        yearLabel: {
                            show: !1
                        },
                        monthLabel: {
                            nameMap: "cn",
                            fontSize: 11,
                            color: i
                        },
                        dayLabel: {
                            formatter: "{start}  1st",
                            nameMap: "cn",
                            fontSize: 11,
                            color: i
                        }
                    }
                ],
                series: [
                    {
                        type: "heatmap",
                        coordinateSystem: "calendar",
                        calendarIndex: 0,
                        data: a.post_calendar.series
                    }
                ]
            },
            l = {
                backgroundColor: j,
                tooltip: {},
                radar: {
                    top: 0,
                    name: {
                        textStyle: {
                            color: i
                        }
                    },
                    indicator: a.category_radar.indicator,
                    center: [
                        "50%", "50%"
                    ],
                    radius: "66%"
                },
                series: [
                    {
                        type: "radar",
                        color: ["#3ecf8e"],
                        itemStyle: {
                            normal: {
                                areaStyle: {
                                    type: "default"
                                }
                            }
                        },
                        data: [
                            {
                                value: a.category_radar.series,
                                name: "文章分类数量"
                            }
                        ]
                    }
                ]
            },
            m = {
                backgroundColor: j,
                tooltip: {
                    trigger: "axis"
                },
                xAxis: {
                    type: "category",
                    data: a.post_chart.xAxis
                },
                yAxis: {
                    type: "value"
                },
                series: [
                    {
                        name: "文章篇数",
                        type: "line",
                        color: ["#6772e5"],
                        data: a.post_chart.series,
                        markPoint: {
                            symbolSize: 45,
                            color: [
                                "#fa755a", "#3ecf8e", "#82d3f4"
                            ],
                            data: [
                                {
                                    type: "max",
                                    itemStyle: {
                                        color: ["#3ecf8e"]
                                    },
                                    name: "最大值"
                                }, {
                                    type: "min",
                                    itemStyle: {
                                        color: ["#fa755a"]
                                    },
                                    name: "最小值"
                                }
                            ]
                        },
                        markLine: {
                            itemStyle: {
                                color: ["#ab47bc"]
                            },
                            data: [
                                {
                                    type: "average",
                                    name: "平均值"
                                }
                            ]
                        }
                    }
                ]
            },
            n = {
                backgroundColor: j,
                tooltip: {
                    trigger: "item",
                    formatter: "{a} <br/>{b} : {c} ({d}%)"
                },
                pie: {
                    top: 0
                },
                series: [
                    {
                        name: "分类",
                        type: "pie",
                        radius: "50%",
                        color: a.categories_chart.color,
                        data: a.categories_chart.indicator,
                        itemStyle: {
                            emphasis: {
                                shadowBlur: 10,
                                shadowOffsetX: 0,
                                shadowColor: "rgba(0, 0, 0, 0.5)"
                            }
                        }
                    }
                ]
            },
            o = {
                backgroundColor: j,
                tooltip: {},
                xAxis: [
                    {
                        type: "category",
                        data: a.tags_chart.indicator
                    }
                ],
                yAxis: [
                    {
                        type: "value"
                    }
                ],
                series: [
                    {
                        type: "bar",
                        color: ["#82d3f4"],
                        barWidth: 18,
                        data: a.tags_chart.series,
                        markPoint: {
                            symbolSize: 45,
                            data: [
                                {
                                    type: "max",
                                    itemStyle: {
                                        color: ["#3ecf8e"]
                                    },
                                    name: "最大值"
                                }, {
                                    type: "min",
                                    itemStyle: {
                                        color: ["#fa755a"]
                                    },
                                    name: "最小值"
                                }
                            ]
                        },
                        markLine: {
                            itemStyle: {
                                color: ["#ab47bc"]
                            },
                            data: [
                                {
                                    type: "average",
                                    name: "平均值"
                                }
                            ]
                        }
                    }
                ]
            };
        b.setOption(k),
        c.setOption(m),
        d.setOption(n),
        e.setOption(o),
        f.setOption(l)
        }catch(e){
            console.warn("EChart: " + e)
        }
    },
    OwOInit: async function(){
        var OwOPan = new OwO({
            logo: 'OωO',
            container: document.getElementsByClassName('OwO')[0],
            target: document.getElementsByClassName('OwO-textarea')[0],
            api: STY.ASSET_URL + 'OwO/OwO.json',
            position: 'down',
            width: '400px',
            maxHeight: '250px'
        });
        var OwOPanReply = new OwO({
            logo: 'OωO',
            container: document.getElementsByClassName('OwO-Reply')[0],
            target: document.getElementsByClassName('OwO-Reply-textarea')[0],
            api: STY.ASSET_URL + 'OwO/OwO.json',
            position: 'down',
            width: '400px',
            maxHeight: '250px'
        });
        OwOPan
        OwOPanReply
    },
    wavesAnimation: function(){

        var duration = 750;

        // 样式string拼凑
        var forStyle = function(position){
            var cssStr = '';
            for( var key in position){
                if(position.hasOwnProperty(key)) cssStr += key+':'+position[key]+';';
            };
            return cssStr;
        }

        // 获取鼠标点击位置
        var forRect = function(target){
            var position = {
                top:0,
                left:0
            }, ele = document.documentElement;
            'undefined' != typeof target.getBoundingClientRect && (position = target.getBoundingClientRect());
            return {
                top: position.top + window.pageYOffset - ele.clientTop,
                left: position.left + window.pageXOffset - ele.clientLeft
            }
        }

        var show = function(event){
            var pDiv = event.target,
                cDiv = document.createElement('div');
            pDiv.appendChild(cDiv);
            var rectObj = forRect(pDiv),
                _height = event.pageY - rectObj.top,
                _left = event.pageX - rectObj.left,
                _scale = 'scale(' + pDiv.clientWidth / 100 * 10 + ')';
            var position = {
                top: _height+'px',
                left: _left+'px'
            };
            cDiv.className = cDiv.className + " waves-animation",
                cDiv.setAttribute("style", forStyle(position)),
                position["-webkit-transform"] = _scale,
                position["-moz-transform"] = _scale,
                position["-ms-transform"] = _scale,
                position["-o-transform"] = _scale,
                position.transform = _scale,
                position.opacity = "1",
                position["-webkit-transition-duration"] = duration + "ms",
                position["-moz-transition-duration"] = duration + "ms",
                position["-o-transition-duration"] = duration + "ms",
                position["transition-duration"] = duration + "ms",
                position["-webkit-transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)",
                position["-moz-transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)",
                position["-o-transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)",
                position["transition-timing-function"] = "cubic-bezier(0.250, 0.460, 0.450, 0.940)",
                cDiv.setAttribute("style", forStyle(position));
            var finishStyle = {
                opacity: 0,
                "-webkit-transition-duration": duration + "ms",
                "-moz-transition-duration": duration + "ms",
                "-o-transition-duration": duration + "ms",
                "transition-duration": duration + "ms",
                "-webkit-transform" : _scale,
                "-moz-transform" : _scale,
                "-ms-transform" : _scale,
                "-o-transform" : _scale,
                top: _height + "px",
                left: _left + "px",
            };
            setTimeout(function(){
                cDiv.setAttribute("style", forStyle(finishStyle));
                setTimeout(function(){
                    pDiv.removeChild(cDiv);
                },duration);
            },100)
        }
        var length = document.querySelectorAll('.touch-ripple') //得到符合条件的元素数量
        for (let index = 0; index < length.length; index++) {
            document.querySelectorAll('.touch-ripple')[index].onclick = function(e){
                show(e);
                console.log(e)
            }
        }

    },
    LikeInit: function () {
        let btn = document.querySelector('#agree')
        let data = 'agree=' + btn.dataset.cid
        let dataUrl = btn.dataset.url
        btn.onclick = function(){
            wee.ajax({
                method: 'POST',
                url: dataUrl,
                data,
                success(res){
                    try {
                        let num = /\d/;
                        if (num.test(res)) {
                            document.querySelector('.agree-num').innerHTML = res.responseText
                        }
                        wee.notice('点赞成功 (〃\'▽\'〃)', {
                            color: 'green',
                            time: 1000
                          })   
                    } catch (e) {
                        wee.notice("点赞时出现错误："+ e, {
                            color: 'red',
                            // time: 1500
                          })
                    }
                },
                failed(res){
                    console.log(res)
                    wee.notice('(；´д｀)ゞ 失败了', {
                        color: 'red',
                        time: 1500
                    })
                }
            })
        }
    },
    headroomInit: function() {
        setTimeout(
        function(){
        var navbar = document.getElementById('navbar');
        var headroom = new Headroom(navbar);
        headroom.init();
        },1000)

    },
    Pjax_Start: function(){
        NProgress.start()
    },
    Pjax_Complete: function(){
        NProgress.done()
        lazyload();
        this.headroomInit()
        this.headNavClick() //重新初始化头部按钮
        this.wavesAnimation() //重新初始化水波
        ks.image("#vditor img")
        // this.SQP_init() 
    },
    documentLoad: function(){
        ks.image("#vditor img")
        this.CopyRight() //添加©️
        this.swiperInit() //初始化swiper
        this.headNavClick() //点按按钮的操作
        // this.showTheEChart() //初始化E Chart
        this.wavesAnimation() //初始化水波
        this.headroomInit()
        lazyload();
        // this.SQP_init() 
    }
}
// 初始化评论按钮
window.comment_init = function () {
    const commentsReply = document.querySelectorAll('.comment_reply a')
    const replyForm = document.querySelector('.reply')
    const isComment = document.querySelector('.post-form.is-comment')
    for (let el of commentsReply) {
        el.addEventListener('click', e => {
            // 给恢复按钮绑定事件 获取parent-id
            const href = e
                .target
                .getAttribute('href')
            window.parentId = href.match(/replyTo=(\d+)/)[1]
            // 弹出回复框
            replyForm.removeAttribute('style')
            if (isComment.classList.contains('active')) 
                isComment
                    .classList
                    .remove('active')
            setTimeout(() => {
                document
                    .getElementById('cancel-comment-reply-link')
                    .addEventListener('click', () => {
                        replyForm.style.display = 'none'
                    })
            })
        })
    }
}
window.domParse = new DOMParser()
window.parser = dom => {
    return window
        .domParse
        .parseFromString(dom, 'text/html')
}
window.scrollSmoothTo = function scrollSmoothTo(position) {
    if (!window.requestAnimationFrame) {
        window.requestAnimationFrame = function (callback, element) {
            return setTimeout(callback, 17)
        }
    }
    // 当前滚动高度
    let scrollTop = document.documentElement.scrollTop || document.body.scrollTop
    // 滚动step方法
    const step = function () {
        // 距离目标滚动距离
        let distance = position - scrollTop
        // 目标滚动位置
        scrollTop = scrollTop + distance / 5
        if (Math.abs(distance) < 1) {
            window.scrollTo(0, position)
        } else {
            window.scrollTo(0, scrollTop)
            requestAnimationFrame(step)
        }
    }
    step()
}