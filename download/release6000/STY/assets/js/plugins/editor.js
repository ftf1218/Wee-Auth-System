/*
 * @FilePath: /STY/assets/js/plugins/editor.js
 * @author: Wibus
 * @Date: 2021-07-03 23:49:44
 * @LastEditors: Wibus
 * @LastEditTime: 2021-08-08 22:47:03
 * Coding With IU
 */
    class Editor {
        constructor() {
            this.init_editArea();
            this.init_other();
        }
    
        /**
         * 编辑框获取焦点
         */
        focus() {
            this.editor.focus();
        }
    
        /**
         * 获取选中内容
         * @param val
         * @returns {string|*}
         */
        getSelection(val = '') {
            let selection = this.editor.getSelection();
            if (selection === "")
                return val;
            return selection;
        }
    
        /**
         * 替换选中内容
         * @param val
         */
        replaceSelection(val) {
            if (this.getSelection() === "") {
                this.insertValue(val);
            } else {
                this.editor.updateValue(val);
            }
        }
    
        /**
         * 插入内容
         * @param val
         */
        insertValue(val) {
            this.editor.insertValue(val);
        }
    
    
        /**
         * 获取文本框内容
         * @returns {*}
         */
        getString() {
            return this.editor.getValue();
        }
    
        /**
         * 打开模态框
         * @param options
         */
        openModal(options = {}) {
            const _modalOptions = {
                title: '标题',
                innerHtml: '内容',
                hasFooter: true,
                confirm: () => {
    
                },
                handler: () => {
                }
            };
            let modalOptions = Object.assign(_modalOptions, options);
            if ($("#sty-modal").length < 1) {
                $('body').append(`<div id="sty-modal" class="wmd-prompt-dialog" role="dialog">
        <div>
        <div>
            <div class="sty-modal-header-title"></div>
    </div>
    <div class="sty-modal-body">
    
    </div>
        <form>
            <button type="button" class="sty-modal-footer-button sty-modal-footer-cancel">${EditorConf.i18n.cancel}</button><button type="button" class="sty-modal-footer-button sty-modal-footer-confirm">${EditorConf.i18n.ok}</button>
        </form>
    </div>
    </div>`);
            }
            $('.sty-modal-header-title').html(modalOptions.title);
            $('.sty-modal-body').html(modalOptions.innerHtml);
            modalOptions.hasFooter ? $(`.sty-modal-footer`).show() : $('.sty-modal-footer').hide();
            $('body').addClass('no-scroll');
            modalOptions.handler();
            $('.sty-modal-footer-confirm').on('click', () => {
                modalOptions.confirm();
                $('body').removeClass('no-scroll');
            });
            $('.sty-modal-header-close').on('click', () => {
                $('#sty-modal').remove();
                $('body').removeClass('no-scroll');
            });
            $('.sty-modal-footer-cancel').on('click', () => {
                $('.sty-modal-header-title').html('');
                $('.sty-modal-body').html('');
                $('#sty-modal').remove();
                $('body').removeClass('no-scroll');
            });
            $('#sty-modal').addClass('active');
    
    
        }
    
        owoTabPrompt(title, filename) {
            let json = this.getJSON(filename),
                _this = this,
                tabTitle = $('<div class="switch-tab-wrap">'),
                tabContent = $('<div class="switch-tab-content-wrap">'),
                i = 0;
            $.each(json, function (key, value) {
                tabTitle.append(`<div class="switch-tab-title switch-tab-title-${i}" data-switch="switch-tab-content-${i}">${key}</div>`);
                let content = $(`<div class="switch-tab-content switch-tab-content-${i}">`);
                $.each(value, function (i, item) {
                    if (item.icon.indexOf('.png') > 0 || item.icon.indexOf('.jpg') > 0 || item.icon.indexOf('.gif') > 0) {
                        let name = item.data.replace('::', '').replace('(', '').replace(')', '');
                        content.append(`<div class="click-to-insert-data" data-text="${item.data}"><img title="${name}" alt="${name}" src="${EditorConf.options.pluginUrl}/${item.icon}"/></div>`);
                    } else {
                        content.append(`<div class="click-to-insert-data text" data-text="${item.data}">${item.icon}</div>`);
                    }
                });
                tabContent.append(content);
                i++;
            });
            let html = $(`<div class="switch-tab"></div>`);
            html.append(tabTitle).append(tabContent);
            this.openModal({
                title: title,
                innerHTML: '',
                hasFooter: false,
                handler: () => {
                    $('.sty-modal-body').html('').append(html);
                    let switchTab = $('#sty-modal .switch-tab');
                    switchTab.find('.switch-tab-title:first-child').addClass('active');
                    switchTab.find('.switch-tab-content:first-child').addClass('active');
                    $('.switch-tab-title', switchTab).click(function () {
                        $('.active', switchTab).removeClass('active');
                        $(this).addClass('active');
                        $('.' + $(this).data('switch')).addClass('active')
                    });
                    $('.click-to-insert-data', switchTab).click(function () {
                        _this.insertValue($(this).data('text'));
                        $('.sty-modal-header-close').trigger('click');
                    });
                }
            });
        }
    
        /**
         * 参数弹窗
         * @param key
         */
        paramsPrompt(key) {
            if (this.toolbar.hasOwnProperty(key)) {
                let options = this.toolbar[key];
                let title = options.hasOwnProperty('title') ? options['title'] : options['tip'] ? options['tip'] : '对话框';
                let previewArea = (options.hasOwnProperty('previewArea') ? options['previewArea'] : 'n');
                if (options.hasOwnProperty('params')) {
                    let html = $('<form class="params"></form>');
                    $.each(options.params, function (key, param) {
                        let dom, label = $('<label></label>'), formItem = $('<div class="form-item"></div>');
                        if (typeof param == "string") {
                            label.attr('for', key).append(param);
                            dom = $('<input>').attr('name', key).attr('type', 'text').attr('placeholder', param);
                            formItem.append(label).append(dom);
                        } else if (typeof param == "object") {
                            if (param.hasOwnProperty('label')) {
                                label.attr('for', key).html(param.label);
                            }
                            if (!param.hasOwnProperty('tag')) {
                                dom = $('<input>').attr('type', 'text');
                            } else {
                                dom = $(`<${param.tag}>`);
                                // 选项处理
                                if (param.tag === 'select' && param.hasOwnProperty('options')) {
                                    $.each(param.options, function (key, option) {
                                        let optionDom = $(`<option value="${key}">${option}</option>`);
                                        dom.append(optionDom);
                                    });
                                }
                            }
                            if (param.hasOwnProperty('required') && param.required === true) {
                                dom.attr('required', true);
                            }
                            const autoConvertKey = ['type', 'class', 'placeholder', 'default'];
                            for (let i of autoConvertKey) {
                                if (param.hasOwnProperty(autoConvertKey[i])) {
                                    dom.attr(autoConvertKey[i], param[autoConvertKey[i]]);
                                }
                            }
                            dom.attr('name', key);
                            formItem.append(label).append(dom);
                        }
                        html.append(formItem);
                    });
    
                    this.openModal({
                        title: title,
                        innerHtml: html.prop("outerHTML"),
                        handler() {
                            if (previewArea !== 'n') {
                                if (previewArea === 'c')
                                    $(".sty-modal-body").append('<div class="preview center"></div>');
                                else
                                    $(".sty-modal-body").append('<div class="preview"></div>');
                                
                                let form = $("#sty-modal .params");
                                $("input,select,textarea", form).on('change', function () {
                                    let template = window.Editor.toolbar[key]['template'];
                                    let form = $('#sty-modal .sty-modal-body .params');
                                    let params = form.serializeArray();
                                    $.each(params, function (i, param) {
                                        let element = $(`#sty-modal .params [name=${param.name}]`);
                                        let value = param.value !== "" ? param.value : (typeof element.attr('default') !== "undefined" ? element.attr('default') : '');
                                        let regExp = new RegExp("{" + $(element).attr('name') + "}", "g");
                                        template = template.replace(regExp, value);
                                    });
                                
                                });
                            }
                        },
                        confirm() {
                            const form = $('#sty-modal .sty-modal-body .params');
                            let params = form.serializeArray(), flag = true;
                            let template = window.Editor.toolbar[key]['template'];
                            $.each(params, function (i, param) {
                                let element = $(`#sty-modal .params [name=${param.name}]`);
                                if (element.prop('required') && param.value === "") {
                                    flag = false;
                                    element.addClass('required');
                                    setTimeout(function () {
                                        element.removeClass('required');
                                    }, 800);
                                }
                                let value = param.value !== "" ? param.value : (typeof element.attr('default') !== "undefined" ? element.attr('default') : '');
                                let regExp = new RegExp("{" + $(element).attr('name') + "}", "g");
                                template = template.replace(regExp, value);
                            });
                            if (flag) {
                                window.Editor.insertValue(template);
                                $('#sty-modal').remove();
                            }
                        }
                    });
                }
            }
        }
    
        /**
         * HTML弹窗
         * @param key
         */
        htmlDialog(key) {
            if (this.toolbar.hasOwnProperty(key)) {
                let options = this.toolbar[key];
                if (options.hasOwnProperty('html')) {
                    let title = options.hasOwnProperty('title') ? options['title'] : options['tip'] ? options['tip'] : '对话框';
                    this.openModal({title: title, hasFooter: false, innerHtml: options['html']});
                }
            }
        }
    
        init_editArea() {
            const originText = $('#text');
            let isMarkdown = $('[name=markdown]').val() ? 1 : 0;
            if (!isMarkdown) {
                $('.yes', notice).click(function () {
                    notice.remove();
                    $('<input type="hidden" name="markdown" value="1" />').appendTo('.submit');
                });
    
                $('btn.no', notice).click(function () {
                    notice.remove();
                });
            }
            
            originText.after('<div id="vditor"></div>');
            this.editor = new Vditor('vditor', {
                    "height": document.documentElement.clientHeight * 0.7,
                    "cache": {
                        "enable": false,
                        "cid": $('input[name="cid"]').val()
                    },
                    "value": originText.val(),
                    mode: 'ir',
                    "toolbar": window.Toolbar,
                    "toolbarConfig": {
                        "pin": true
                    },
                    "resize": {
                        "enable": true,
                        "position": "bottom"
                    },
                    "counter": {
                        "enable": true,
                        "type": "text"
                      }
                }
            );
    
            this.cacheJSON = [];
            let _this = this;
            window.Editor = this;
            _this.toolbar = {};
            $.each(window.Toolbar, function (i, button) {
                if (typeof button === "object" && button.hasOwnProperty("name")) {
                    _this.toolbar[button.name] = button;
                }
            });
            // 保存前保存数据到 #text
            originText.parents().find('form').on('submit', function () {
                originText.val(window.Editor.getString());
                return true;
            });
            // 优化图片及文件附件插入 Thanks to Markxuxiao
            Typecho.insertFileToEditor = function (file, url, isImage) {
                if (isImage) {
                    window.Editor.replaceSelection("![" + file + "](" + url + ")");
                } else {
                    window.Editor.replaceSelection("[" + window.EditorConf.i18n.clickToDownload.replace("{url}", file) + "](" + url + " \"" + file + "\")");
                }
            };
        }
    
        init_other() {
            let scrollY = window.pageYOffset || document.documentElement.scrollTop,
                submitArea = $('p.submit'),
                prevSection = submitArea.prev();
    
            submitArea.addClass('fixed').css('width', prevSection.outerWidth(true) - 10).css('left', prevSection.offset().left);
            $('#btn-preview').on('click', function () {
                $("#edit-secondary").hide();
                submitArea.removeClass('fixed').css('width', 'unset').css('left', 'unset');
                $("#vditor").parent('p').hide();
            });
            $('#btn-cancel-preview').on('click', function () {
                $("#edit-secondary").show();
                $("#vditor").parent('p').show();
            });
            $('#btn-submit').addClass('sty-btn-success');
            $(window).scroll(function () {
                if (submitArea.length > 0) {
                    if (scrollY < (prevSection.offset().top + prevSection.height() - $(window).height())) {
                        submitArea.addClass('fixed').css('width', prevSection.outerWidth(true) - 10).css('left', prevSection.offset().left);
                    } else {
                        submitArea.removeClass('fixed').css('width', 'unset').css('left', 'unset');
                    }
                }
            });
        }
    }
    
    document.addEventListener('DOMContentLoaded', () => new Editor());

    window.Toolbar = [
        "emoji",
        "headings",
        "bold",
        "italic",
        "strike",
        "link",
        "|",
        "list",
        "ordered-list",
        "check",
        "outdent",
        "indent",
        "|",
        "quote",
        "line",
        "code",
        "inline-code",
        "insert-before",
        "insert-after",
        "|",
        "upload",
        "record",
        "table",
        "|",
        "undo",
        "redo",
        "|",
        "fullscreen",
        "edit-mode",
        {
            name: "more",
            toolbar: [
                "export",
                "outline",
                "preview",
                "info",
                "help",
            ],
        },
        "|",
        {
            "name": "bottom",
            "tip": "插入按钮",
            "tipPosition": "n",
            "icon": "<svg viewBox=\"0 0 1024 1024\" xmlns=\"http://www.w3.org/2000/svg\" width=\"22\" height=\"22\"><path d=\"M856.73 796.7h-690c-57.9 0-105-47.1-105-105v-360c0-57.9 47.1-105 105-105h690c57.9 0 105 47.1 105 105v360c0 57.89-47.1 105-105 105zm-690-500.01c-19.3 0-35 15.7-35 35v360c0 19.3 15.7 35 35 35h690c19.3 0 35-15.7 35-35v-360c0-19.3-15.7-35-35-35h-690z\"/><path d=\"M233.16 431.69H790.3v160H233.16z\"/></svg>",
            "template": "[button type='{type}' icon='{icon}' url='{href}']{content}[/button]\n",
            "previewArea": "c",
            "params":
                {
                    "type": {
                        "label": "按钮类型",
                        "tag": 'select',
                        "options": {
                            "primary": "紫色",
                            "light": "白色",
                            "info": "蓝色",
                            "dark": "深色",
                            "success": "绿色",
                            "black": "黑色",
                            "warning": "黄色",
                            "danger": "红色",
                        }
                    },
                    "icon": {
                        "label": "<a href='https://fontawesome.dashgame.com/' target='_blank' title='点此查找图标Class'>按钮图标</a>",
                    },
                    "href": {
                        "label": "按钮链接",
                    }
                    ,
                    "content": {
                        "label": "按钮文字",
                        "default": "按钮",
                    }
                },
            click() {
                window.Editor.paramsPrompt('bottom');
            }
        },
        {
            "name": "bilibili",
            "tip": "插入BiliBili小窗",
            "tipPosition": "n",
            "icon": '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" version="1.1" id="Bilibili" x="0px" y="0px" viewBox="0 0 2186.86 999.65" style="enable-background:new 0 0 2186.86 999.65;" xml:space="preserve"><g><path d="M2030.61,892.82c-9.77,0-18.55,0-26.37-0.98c-16.6-0.97-33.2-1.95-49.8-1.95c-10.74,0-10.74,0-11.72-10.74l-15.63-177.74   l-15.62-147.46l-10.74-90.82l-9.77-79.1l-17.58-123.05c-5.86-43.94-12.69-86.91-21.48-130.86c-0.98-6.83-0.98-7.81,6.84-8.79   c30.27-5.86,61.52-8.79,92.77-8.79h10.74c4.88,0.98,7.81,3.91,8.79,9.77l3.91,67.38l27.34,364.26l13.67,166.99l8.79,95.71   L2030.61,892.82L2030.61,892.82z M833.34,112.54h17.58c8.79,0,10.74,2.93,10.74,11.72l7.82,118.17l17.58,245.11l10.74,127.93   l7.81,98.64l15.63,169.92c0,7.81-0.98,8.79-8.79,8.79l-70.32-2.93c-4.88,0.98-7.81-1.95-7.81-6.84l-2.93-34.18   c-2.93-29.29-5.86-58.59-7.81-88.86l-15.63-154.3l-16.6-139.65l-11.72-98.63l-12.69-89.85c-5.86-40.04-12.7-81.05-19.53-121.09   l-4.89-27.34c-0.97-4.89,0-6.84,4.89-7.82C774.75,116.45,801.12,111.57,833.34,112.54L833.34,112.54L833.34,112.54z M1815.77,506.1   c24.41,0,27.34,0.98,31.25,24.41c4.88,29.3,8.79,58.6,11.72,87.89l10.74,94.73l20.51,201.17c0.97,4.89,0,6.84-4.89,6.84   l-76.17,8.79c-7.81,0.97-9.77,0-10.74-7.81l-43.95-224.61l-27.34-149.42l-3.91-20.51c-0.97-3.9,0.98-6.83,4.89-7.81   C1758.15,512.94,1787.45,508.05,1815.77,506.1L1815.77,506.1L1815.77,506.1z M705.41,506.1c26.37-0.98,29.3,1.95,32.23,26.37   c6.84,40.04,11.72,79.1,15.63,119.14l12.69,117.18l7.81,79.11l6.84,63.47c0,8.79-0.98,10.75-8.79,11.72l-72.26,6.84   c-7.82,0.97-9.77,0-10.75-7.81l-59.57-306.65l-15.62-86.91c-0.98-4.88,0.97-7.81,5.86-8.79   C649.75,512.94,678.07,508.05,705.41,506.1L705.41,506.1L705.41,506.1z M1078.46,808.83v121.1v3.9c0.98,5.86-1.95,8.79-7.81,7.82   h-23.44c-16.6,0-33.2,0.97-49.8,1.95c-8.79,0.98-9.77,0.98-10.75-9.77l-15.62-175.78l-7.81-86.91l-11.72-132.81   c-0.98-10.75,0.98-12.7,9.76-13.68c27.35-2.93,54.69-2.93,82.04-1.95l20.5,2.93c7.82,2.93,8.79,3.91,8.79,11.72l2.93,52.73   l0.98,58.6C1077.49,702.39,1078.46,755.12,1078.46,808.83L1078.46,808.83L1078.46,808.83z M2186.86,814.69v114.26v5.86   c0,4.88-1.95,7.81-6.84,6.84h-35.15c-13.67,0-27.35,0.97-40.04,1.95c-7.81,0.98-8.79,0-9.77-8.79l-20.5-228.52l-10.75-113.28   l-3.9-57.61c-0.98-7.82,0.97-9.77,8.79-9.77c32.22-3.91,65.43-4.88,97.65-0.98c12.7,0.98,14.65,4.89,15.63,17.58l2.93,129.88   L2186.86,814.69L2186.86,814.69z M1787.45,298.09c9.76,0,18.55,0.98,25.39,1.95c4.88,0.98,6.83,2.93,7.81,7.82l12.69,135.74   c2.93,11.72,0.98,13.67-10.74,13.67l-33.2,1.95c-6.84,0.98-9.77,1.96-9.77-8.78l-13.67-110.36l-3.9-31.25   c-0.98-5.86,0.97-8.79,6.83-9.76L1787.45,298.09L1787.45,298.09z M681,298.09c7.81,0,15.63,0.98,22.46,1.95   c3.91,0.98,5.86,2.93,6.84,7.82l3.9,34.18l9.77,106.44c0.98,7.81,0.98,8.79-6.84,8.79l-38.08,1.95c-7.81,0.98-8.79,0-9.77-7.81   l-8.79-78.12l-7.81-65.43c-0.98-4.89,0.98-7.82,5.86-7.82C665.38,299.07,673.19,298.09,681,298.09L681,298.09L681,298.09z    M1070.65,395.75v67.38c0.98,10.74-0.98,10.74-9.77,10.74c-12.69,0-24.41-0.97-36.13-1.95c-7.81-0.98-8.79-0.98-7.81-8.79   l-2.93-83.01c0-18.55,0-37.11-0.98-55.66c-0.97-8.79,0-9.77,8.79-9.77c13.67,0,27.34,0.98,41.02,2.93c7.81,0,7.81,1.96,7.81,9.77   V395.75L1070.65,395.75z M2180.02,396.72v67.39c0,8.79-0.97,9.76-9.76,9.76l-37.11-1.95c-5.86-0.98-8.79-3.91-7.81-8.79   l-2.93-139.65c0-7.81,0.97-8.79,8.79-8.79c12.69,0,24.41,0.98,36.13,1.96c14.65,0.97,12.69,3.9,12.69,14.64V396.72L2180.02,396.72z    M650.73,449.46c0.97,11.72,0,13.67-11.72,14.65l-23.44,5.86c-7.81,2.93-8.79,0.97-9.76-5.86l-24.42-137.7   c-2.93-8.79-0.98-10.74,7.81-11.72l34.18-5.86c7.82-0.97,9.77-0.97,9.77,6.84c2.93,16.6,5.86,33.2,7.81,49.8l9.77,78.13V449.46   L650.73,449.46z M1689.79,315.67c14.65-2.93,30.27-4.88,45.9-6.84c4.88-0.97,6.83,1.96,7.81,6.84l7.81,53.71   c3.91,26.37,6.84,52.73,7.82,79.1v7.81c0.97,3.91-0.98,6.84-4.89,7.82l-31.25,6.83c-4.88,0.98-6.83-0.97-7.81-5.86l-25.39-145.5   V315.67L1689.79,315.67z M996.43,421.14c0,15.62-0.98,30.27-1.95,43.94c0,4.89-1.96,6.84-6.84,7.82l-30.27,2.93   c-4.88,0.97-6.84-1.96-6.84-6.84c-1.95-14.65-2.93-28.32-3.9-42.97c-1.96-26.37-3.91-53.71-4.89-81.05l-1.95-19.53   c-0.98-3.91,0.98-5.86,4.88-5.86l40.04-2.93c6.84,0,8.79,0.97,8.79,8.79L996.43,421.14L996.43,421.14z M2103.85,405.51   c0.98,18.56,0.98,38.09,0,56.64c0.98,8.79-0.97,10.75-9.76,10.75l-27.35,2.93c-4.88,0.97-7.81-1.96-7.81-6.84   c-0.98-24.41-2.93-49.8-4.88-74.22l-3.91-68.36c-0.98-4.88,0.98-6.83,4.88-6.83l39.07-2.93c6.83,0,7.81,0.97,7.81,8.79   C2103.85,351.8,2104.83,379.15,2103.85,405.51L2103.85,405.51L2103.85,405.51z M612.64,738.52c15.63,18.56,18.56,39.06,11.72,61.52   c-5.86,21.49-16.6,40.04-32.23,55.67c-25.39,26.37-54.68,47.85-86.91,64.45c-55.66,29.3-113.28,49.81-174.81,60.55   c-43.94,8.79-87.89,14.65-131.83,17.58c-13.67,0.97-27.34,0.97-41.02,0.97h-29.29c-7.82,0-9.77-1.95-10.75-9.76l-6.83-94.73   L92.13,708.25l-20.5-177.74l-11.72-94.72l-12.7-90.82c-6.83-49.81-15.62-99.61-24.41-149.42C15.96,155.51,9.13,115.47,0.34,75.44   c-0.98-4.89,0-8.79,4.88-9.77L140.96,9.03c8.79-3.91,16.6-6.84,25.39-8.79c5.86-0.98,8.79,0.98,7.81,6.84   c0,15.62,0,31.25-0.97,47.85l-0.98,12.69c-0.97,56.64-0.97,113.28,0,170.9c0.98,49.81,3.91,100.59,6.84,150.39   c4.88,78.13,12.69,156.25,20.51,233.4c0,7.81,0.97,7.81,9.76,6.84c16.6-2.93,32.23-3.91,48.83-3.91   c51.76,0,103.51,5.86,153.32,18.55c43.94,10.75,85.94,25.4,127.93,43.95c20.51,9.77,39.06,21.48,56.64,35.16   C602.88,727.78,607.76,732.66,612.64,738.52L612.64,738.52L612.64,738.52z M1713.23,729.73c20.51,16.6,27.34,39.06,21.48,65.43   c-4.88,21.49-14.65,40.04-29.3,56.64c-23.43,26.37-50.78,46.88-81.05,63.48c-58.59,32.23-121.09,54.69-187.5,66.41   c-36.13,6.83-72.27,12.69-108.4,15.62c-20.51,1.95-42.97,2.93-65.43,1.95h-26.37c-5.85,0.98-8.78-1.95-8.78-7.81   c-1.96-27.34-3.91-54.69-6.84-82.03l-15.63-166.99l-16.6-145.51l-20.5-164.06c-2.93-28.32-6.84-57.62-11.72-85.94l-17.58-109.38   c-7.81-51.75-17.58-103.51-28.32-155.27l-0.98-6.83c-1.95-4.89,0-8.79,4.88-9.77c47.86-19.53,94.73-41.02,142.58-59.57   c12.7-4.88,28.32-10.74,27.35,0.98c-3.91,36.13-2.93,72.26-3.91,107.42c-0.98,29.29-0.98,58.59,0.98,86.91v22.46   c0,35.16,0.97,70.32,3.9,104.49c1.96,45.9,4.89,92.78,8.79,138.68l8.79,98.63c0.98,18.55,2.93,36.13,5.86,54.69   c0,10.74,1.95,9.76,10.74,8.79c17.58-2.93,35.16-3.91,52.74-3.91c61.52,0.98,121.09,10.74,179.68,27.34   c40.04,10.75,78.13,25.39,115.24,44.93C1683.93,706.29,1698.58,717.04,1713.23,729.73L1713.23,729.73L1713.23,729.73z    M301.12,901.61c14.65-8.79,40.04-26.37,75.19-53.71c35.16-28.32,56.64-46.88,65.43-56.64c-52.73-23.44-107.42-43.95-164.06-62.5   L301.12,901.61L301.12,901.61z M1548.19,796.14c2.93-2.93,1.95-4.88-0.98-6.84l-23.44-9.76c-41.01-17.58-82.03-33.21-124.02-46.88   l-5.86-1.95c-1.95-0.98-3.9,0-6.83,0.98l23.43,168.94c2.93,0,4.89-0.98,5.86-1.95c38.09-27.35,76.17-55.67,114.26-85.94   L1548.19,796.14L1548.19,796.14z"/></g></svg>',
            "template": '[bilibili id="{id}" style="{style}" /]',
            "previewArea": "c",
            "params":
                {
                    "style": {
                        "label": "小窗风格",
                        "tag": 'select',
                        "options": {
                            "white": "white",
                            "black": "black",
                            "gray": "gray",
                        }
                    },
                    "id": {
                        "label": "视频BV号"
                    }
                },
            click() {
                window.Editor.paramsPrompt('bilibili');
            }
        },
        {
            "name": "bilibiliPlayer",
            "tip": "插入仿BiliBili播放器",
            "tipPosition": "n",
            "icon": '<svg id="bili-anime" viewBox="0 0 1024 1024"><path d="M588.8 359.68l-12.032-7.424 150.272-206.592a30.976 30.976 0 0 0-51.2-36.352l-153.6 210.176L281.6 170.24a30.976 30.976 0 1 0-33.024 52.736L486.4 369.92l-22.784 31.488a30.976 30.976 0 1 0 51.2 36.352l25.6-35.072 16.128 9.728A30.976 30.976 0 1 0 588.8 359.68z" fill="#FB813A"></path><path d="M763.648 850.688m-53.248 0a53.248 53.248 0 1 0 106.496 0 53.248 53.248 0 1 0-106.496 0Z" fill="#FB813A"></path><path d="M261.12 797.44a53.248 53.248 0 1 0 53.504 53.248 53.248 53.248 0 0 0-53.504-53.248z" fill="#FB813A"></path><path d="M141.312 314.368m92.928 0l556.288 0q92.928 0 92.928 92.928l0 360.704q0 92.928-92.928 92.928l-556.288 0q-92.928 0-92.928-92.928l0-360.704q0-92.928 92.928-92.928Z" fill="#FDDE80"></path><path d="M520.448 575.232m-128.256 0a128.256 128.256 0 1 0 256.512 0 128.256 128.256 0 1 0-256.512 0Z" fill="#FFFFFF"></path><path d="M476.928 546.56c0-26.88 19.2-37.632 42.24-25.6l49.664 28.672a25.6 25.6 0 0 1 0 48.64l-49.664 28.672c-23.04 13.568-42.24 2.56-42.24-24.32z" fill="#FB813A"></path></svg>',
            "template": '[bplayer url="{url}" /]',
            "previewArea": "c",
            "params":
                {
                    "url": {
                        "label": "视频链接(请在每个/前使用\\防止markdown转义)"
                    }
                },
            click() {
                window.Editor.paramsPrompt('bilibiliPlayer');
            }
        },
        {
            "name": "load",
            "tip": "插入进度条",
            "tipPosition": "n",
            "icon": '<svg viewBox="0 0 100 100"> <path d="M 50 50 m -40 0 a 40 40 0 1 0 80 0  a 40 40 0 1 0 -80 0" fill="none" stroke="#e5e9f2" stroke-width="5"> ></path> <path d="M 50 50 m -40 0 a 40 40 0 1 0 80 0  a 40 40 0 1 0 -80 0" fill="none" stroke="#20a0ff" stroke-linecap="round" class="my-svg-path" transform="rotate(90,50,50)" stroke-width="5"> </path> </svg><style>.my-svg-path{ stroke-dasharray: 252.2px, 252.2px; stroke-dashoffset: 22px; transition: stroke-dashoffset 0.6s ease 0s, stroke 0.6s ease 0s; transform: rotateZ(90deg); transform-origin: 50% 50%; }</style>',
            "template": '[load value="{value}" /]',
            "previewArea": "c",
            "params":
                {
                    "value": {
                        "label": "进度值"
                    }
                },
            click() {
                window.Editor.paramsPrompt('load');
            }
        },
        {
            "name": "tip",
            "tip": "插入提示框",
            "tipPosition": "n",
            "icon": '<svg xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" width="25px" height="25px" viewBox="0 0 27 27" version="1.1"> <g id="Page-1" stroke="none" stroke-width="1" fill="none" fill-rule="evenodd"> <g id="bulb" transform="translate(1.862069, 1.862069)" fill-rule="nonzero"> <circle id="Oval" stroke="#FFFFFF" stroke-width="1.72413793" fill="#42B983" cx="11.637931" cy="11.637931" r="11.637931"/> <path d="M14.9782602,6.26958761 C13.5786192,5.02159022 11.5988246,4.66057986 9.84877456,5.3342393 C8.09872445,6.00789873 6.87199468,7.60321973 6.67041812,9.46758536 C6.47834892,11.1289711 7.14669021,12.7736149 8.44322124,13.8300715 C8.7659962,14.0883852 8.95708577,14.476934 8.96463387,14.8902773 L8.96463387,15.950483 C8.96463396,17.4335196 10.1668727,18.6357583 11.6499092,18.6357583 C13.1329458,18.6357583 14.3351845,17.4335196 14.3351846,15.950483 L14.3351846,14.9424186 C14.3370268,14.5440734 14.5075401,14.1651552 14.8044559,13.8995932 C15.9408165,12.9709421 16.6142105,11.5917678 16.6476313,10.1245967 C16.681052,8.65742545 16.0711565,7.24901903 14.9782602,6.26958761 Z M11.641219,17.2366343 C10.9348096,17.2272767 10.3644253,16.6568924 10.3550678,15.950483 L10.3550678,15.6723963 L12.9273703,15.6723963 L12.9273703,15.9331026 C12.9274337,16.6462901 12.3543431,17.2271252 11.641219,17.2366343 Z M13.900674,12.822007 C13.4611707,13.2051427 13.1514496,13.7152716 13.0142724,14.2819624 L10.2681656,14.2819624 C10.1269899,13.6848629 9.79803163,13.1487827 9.32962275,12.7524853 L9.31224241,12.7524853 C8.37165942,11.9953905 7.89132967,10.8044358 8.04347151,9.60662873 C8.29960607,7.74087102 9.94518146,6.38428223 11.8255389,6.48874655 C13.7058963,6.59321086 15.1910767,8.12373049 15.2389665,10.0063785 C15.2362892,11.09781 14.7453153,12.1307682 13.900674,12.822007 Z" id="Shape" fill="#FFFFFF"/> </g> </g> </svg>',
            "template": '[tip type="{type}"]{content}[/tip]',
            "previewArea": "c",
            "params":
                {
                    "type": {
                        "label": "样式风格",
                        "tag": "select",
                        "options": {
                            "tip": "tip",
                            "warning": "warning",
                            "danger": "danger",
                        },
                    },
                    "content": {
                        "label": "内容"
                    }
                },
            click() {
                window.Editor.paramsPrompt('tip');
            }
        },
        {
            "name": "video",
            "tip": "插入视频播放器",
            "tipPosition": "n",
            "icon": '<svg id="bili-douga" viewBox="0 0 1024 1024"><path d="M273.408 166.912h477.696c58.368 0 105.984 47.616 105.984 105.984v477.696c0 58.368-47.616 105.984-105.984 105.984H273.408c-58.368 0-105.984-47.616-105.984-105.984V273.408C166.912 215.04 215.04 166.912 273.408 166.912z" fill="#7B78EB"></path><path d="M512 525.312v98.816c33.28-14.848 72.704 0.512 87.552 33.792 14.848 33.28-0.512 72.704-33.792 87.552-16.896 7.68-35.84 7.68-53.248 0v111.616H273.408c-58.368 0-105.984-47.616-105.984-105.984V512h137.216c-21.504 19.456-24.064 53.248-4.608 74.752 19.456 21.504 53.248 24.064 74.752 4.608 21.504-18.944 24.064-53.248 4.608-74.752l-4.608-4.608H512v-40.96c-4.096 0.512-9.216 0.512-13.312 0-51.2 0-86.016-47.616-86.016-105.984s20.992-108.032 86.016-108.032h13.312V166.912h238.592c58.368 0 105.984 47.616 105.984 105.984v251.904h-120.832c20.992-23.552 19.456-59.392-3.584-80.896-23.552-20.992-59.392-19.456-80.896 3.584-19.968 21.504-19.968 55.296 0 76.8H512z" fill="#9796ED"></path><path d="M512 525.312v98.816l13.312-4.096c35.84-7.68 72.704 15.872 79.872 52.224 7.68 35.84-18.432 72.192-54.272 78.848-4.096 1.024-8.704 1.024-13.312 1.024-9.216 0-16.384-3.072-25.088-6.144v111.616h-14.336v-132.608l18.432 8.192c27.136 11.776 58.368-0.512 70.144-27.648 11.776-27.136-0.512-58.368-27.648-70.144-13.312-5.632-28.672-5.632-42.496 0l-18.432 8.192v-117.76H399.872c14.848 33.28-0.512 72.704-33.792 87.552-33.28 14.848-72.704-0.512-87.552-33.792-7.68-16.896-7.68-35.84 0-53.248H166.912V512h137.216c-21.504 19.456-24.064 53.248-4.608 74.752 19.456 21.504 53.248 24.064 74.752 4.608 21.504-19.456 24.064-53.248 4.608-74.752l-4.608-4.608H512v-39.936h-13.312c-51.2 0-86.016-47.104-86.016-105.984s20.992-109.568 86.016-109.568h13.312V166.912h13.312v105.984h-26.624c-49.664 0-73.216 33.28-73.216 94.208 0 53.248 30.72 92.672 73.216 92.672 3.584 0.512 7.68 0.512 11.264 0l15.36-2.048V512h102.912c-13.824-35.84 4.096-76.8 40.448-90.624 35.84-13.824 76.8 4.096 90.624 40.448 6.144 15.872 6.144 33.792 0 50.176h97.792v13.312h-120.832c20.992-23.552 19.456-59.392-3.584-80.896-23.552-20.992-59.392-19.456-80.896 3.584-19.968 21.504-19.968 55.296 0 76.8H512z" fill="#6A68C6"></path><path d="M444.928 693.248c-23.04 13.312-52.224 5.12-65.024-17.408-4.096-7.68-6.144-15.36-6.144-24.064V392.192c0-26.624 20.992-47.616 47.616-47.616 8.704 0 16.896 2.048 24.576 6.656l221.696 132.608c23.04 13.312 30.208 42.496 16.896 65.024-4.096 6.656-10.24 12.8-16.896 16.896" fill="#FDDE80"></path></svg>',
            "template": '[vplayer pic="{pic}" url="{url}" /]',
            "previewArea": "c",
            "params":
                {
                    "pic": {
                        "label": "视频封面(请在每个/前使用\\防止markdown转义)"
                    },
                    "url": {
                        "label": "视频链接(请在每个/前使用\\防止markdown转义)"
                    }
                },
            click() {
                window.Editor.paramsPrompt('video');
            }
        },
        {
            "name": "login",
            "tip": "插入登录可见",
            "tipPosition": "n",
            "icon": '<svg x="0px" y="0px" width="12px" height="13px"> <path fill="#B1B7C4" d="M8.9,7.2C9,6.9,9,6.7,9,6.5v-4C9,1.1,7.9,0,6.5,0h-1C4.1,0,3,1.1,3,2.5v4c0,0.2,0,0.4,0.1,0.7 C1.3,7.8,0,9.5,0,11.5V13h12v-1.5C12,9.5,10.7,7.8,8.9,7.2z M4,2.5C4,1.7,4.7,1,5.5,1h1C7.3,1,8,1.7,8,2.5v4c0,0.2,0,0.4-0.1,0.6 l0.1,0L7.9,7.3C7.6,7.8,7.1,8.2,6.5,8.2h-1c-0.6,0-1.1-0.4-1.4-0.9L4.1,7.1l0.1,0C4,6.9,4,6.7,4,6.5V2.5z M11,12H1v-0.5 c0-1.6,1-2.9,2.4-3.4c0.5,0.7,1.2,1.1,2.1,1.1h1c0.8,0,1.6-0.4,2.1-1.1C10,8.5,11,9.9,11,11.5V12z"></path> </svg>',
            "template": '[login]{content}[/login]',
            "previewArea": "c",
            "params":
                {
                    "content": {
                        "label": "加密内容"
                    },
                },
            click() {
                window.Editor.paramsPrompt('login');
            }
        },
        {
            "name": "hide",
            "tip": "插入回复可见",
            "tipPosition": "n",
            "icon": '回',
            "template": '[hide]{content}[/hide]',
            "previewArea": "c",
            "params":
                {
                    "content": {
                        "label": "加密内容"
                    },
                },
            click() {
                window.Editor.paramsPrompt('hide');
            }
        },
        {
            "name": "collapse",
            "tip": "插入收缩框",
            "tipPosition": "n",
            "icon": '收',
            "template": '[collapse title="{title}" status="{status}"]{content}[/collapse]',
            "previewArea": "c",
            "params":
                {
                    "status": {
                        "label": "展开情况",
                        "tag": "select",
                        "options": {
                            "false": "收缩",
                            "true": "展开",
                        }
                    },
                    "title": {
                        "label": "收缩框标题",
                    },
                    "content": {
                        "label": "内容",
                    }
                },
            click() {
                window.Editor.paramsPrompt('collapse');
            }
        },
        {
            "name": "tabs",
            "tip": "插入标签卡",
            "tipPosition": "n",
            "icon": '标',
            "template": `
[tabs]
[tab name="{name}" active="true"]{content}[/tab]
[/tabs]
`,
            "previewArea": "c",
            "params":
                {
                    "name": {
                        "label": "选项卡标题",
                    },
                    "content": {
                        "label": "内容",
                    }
                },
            click() {
                window.Editor.paramsPrompt('tabs');
            }
        },
        {
            "name": "album",
            "tip": "插入相册",
            "tipPosition": "n",
            "icon": '相',
            "template": `
[album]
[普通的图片插入，支持markdown语法和html语法，混合也可以]
[/album]
            `,
            "previewArea": "c",
            "params":
                {
                    "type": {
                        "label": "相册样式（任选一个）",
                        "tag": "select",
                        "options": {
                            "": "default",
                            "photos": "photos",
                        }
                    },
                },
            click() {
                window.Editor.paramsPrompt('album');
            }
        },
        {
            "name": "post",
            "tip": "插入文章卡片",
            "tipPosition": "n",
            "icon": '文',
            "template": '[post cid="{cid}" cover="{cover}" /]',
            "previewArea": "c",
            "params":
                {
                    "cid": {
                        "label": "文章cid"
                    },
                    "cover": {
                        "label": "右侧图片(请在/前加上\\)"
                    }
                },
            click() {
                window.Editor.paramsPrompt('post');
            }
        },
        {
            "name": "Outpost",
            "tip": "插入外链卡片",
            "tipPosition": "n",
            "icon": '外',
            "template": '[post title="{title}" url="{url}" cover="{cover}" /]',
            "previewArea": "c",
            "params":
                {
                    "title": {
                        "label": "标题"
                    },
                    "url": {
                        "label": "链接(请在/前加上\\)"
                    },
                    "cover": {
                        "label": "右侧图片(请在/前加上\\)"
                    }
                },
            click() {
                window.Editor.paramsPrompt('Outpost');
            }
        },
        {
            "name": "scode",
            "tip": "插入高亮提示文本",
            "tipPosition": "n",
            "icon": '提',
            "template": '[scode type="{type}"]这些是内容[/scode]',
            "previewArea": "c",
            "params":
                {
                    "type": {
                        "label": "提示高亮类型",
                        "tag": "select",
                        "options": {
                            "share": "灰色：引用资料",
                            "yellow": "黄色：提示注意",
                            "red": "红色：严重警告",
                            "lblue": "浅蓝色：显示信息",
                            "green": "绿色：推荐信息"
                        }
                    }
                },
            click() {
                window.Editor.paramsPrompt('scode');
            }
        },
        {
            "name": "btn",
            "tip": "插入第二版🔘按钮",
            "tipPosition": "n",
            "icon": '🔘',
            "template": '[btn url="{url}"]{content}[/btn]',
            "previewArea": "c",
            "params":
                {
                    "url": {
                        "label": "跳转地址"
                    },
                    "content": {
                        "label": "内容"
                    }
                },
            click() {
                window.Editor.paramsPrompt('btn');
            }
        },
        

        
    ]
    var owo = new OwO({
        logo: '表情',
        container: document.getElementsByClassName('OwO')[0],
        target: document.getElementsByClassName('vditor-reset')[0],
        api: STY.ASSET_URL + 'OwO/OwO.json',
        position: 'down',
        width: '100%',
        maxHeight: '220px'
    });