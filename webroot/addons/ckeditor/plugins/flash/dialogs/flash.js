﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    var a = 1, b = 2, c = 4, d = {id:[
        {type:a, name:'id'}
    ], classid:[
        {type:a, name:'classid'}
    ], codebase:[
        {type:a, name:'codebase'}
    ], pluginspage:[
        {type:c, name:'pluginspage'}
    ], src:[
        {type:b, name:'movie'},
        {type:c, name:'src'}
    ], name:[
        {type:c, name:'name'}
    ], align:[
        {type:a, name:'align'}
    ], title:[
        {type:a, name:'title'},
        {type:c, name:'title'}
    ], 'class':[
        {type:a, name:'class'},
        {type:c, name:'class'}
    ], width:[
        {type:a, name:'width'},
        {type:c, name:'width'}
    ], height:[
        {type:a, name:'height'},
        {type:c, name:'height'}
    ], hSpace:[
        {type:a, name:'hSpace'},
        {type:c, name:'hSpace'}
    ], vSpace:[
        {type:a, name:'vSpace'},
        {type:c, name:'vSpace'}
    ], style:[
        {type:a, name:'style'},
        {type:c, name:'style'}
    ], type:[
        {type:c, name:'type'}
    ]}, e = ['play', 'loop', 'menu', 'quality', 'scale', 'salign', 'wmode', 'bgcolor', 'base', 'flashvars', 'allowScriptAccess', 'allowFullScreen'];
    for (var f = 0; f < e.length; f++)d[e[f]] = [
        {type:c, name:e[f]},
        {type:b, name:e[f]}
    ];
    e = ['allowFullScreen', 'play', 'loop', 'menu'];
    for (f = 0; f < e.length; f++)d[e[f]][0]['default'] = d[e[f]][1]['default'] = true;
    function g(i, j, k) {
        var q = this;
        var l = d[q.id];
        if (!l)return;
        var m = q instanceof CKEDITOR.ui.dialog.checkbox;
        for (var n = 0; n < l.length; n++) {
            var o = l[n];
            switch (o.type) {
                case a:
                    if (!i)continue;
                    if (i.getAttribute(o.name) !== null) {
                        var p = i.getAttribute(o.name);
                        if (m)q.setValue(p.toLowerCase() == 'true'); else q.setValue(p);
                        return;
                    } else if (m)q.setValue(!!o['default']);
                    break;
                case b:
                    if (!i)continue;
                    if (o.name in k) {
                        p = k[o.name];
                        if (m)q.setValue(p.toLowerCase() == 'true'); else q.setValue(p);
                        return;
                    } else if (m)q.setValue(!!o['default']);
                    break;
                case c:
                    if (!j)continue;
                    if (j.getAttribute(o.name)) {
                        p = j.getAttribute(o.name);
                        if (m)q.setValue(p.toLowerCase() == 'true'); else q.setValue(p);
                        return;
                    } else if (m)q.setValue(!!o['default']);
            }
        }
    }

    ;
    function h(i, j, k) {
        var s = this;
        var l = d[s.id];
        if (!l)return;
        var m = s.getValue() === '', n = s instanceof CKEDITOR.ui.dialog.checkbox;
        for (var o = 0; o < l.length; o++) {
            var p = l[o];
            switch (p.type) {
                case a:
                    if (!i)continue;
                    var q = s.getValue();
                    if (m || n && q === p['default'])i.removeAttribute(p.name); else i.setAttribute(p.name, q);
                    break;
                case b:
                    if (!i)continue;
                    q = s.getValue();
                    if (m || n && q === p['default']) {
                        if (p.name in k)k[p.name].remove();
                    } else if (p.name in k)k[p.name].setAttribute('value', q); else {
                        var r = CKEDITOR.dom.element.createFromHtml('<cke:param></cke:param>', i.getDocument());
                        r.setAttributes({name:p.name, value:q});
                        if (i.getChildCount() < 1)r.appendTo(i); else r.insertBefore(i.getFirst());
                    }
                    break;
                case c:
                    if (!j)continue;
                    q = s.getValue();
                    if (m || n && q === p['default'])j.removeAttribute(p.name); else j.setAttribute(p.name, q);
            }
        }
    }

    ;
    CKEDITOR.dialog.add('flash', function (i) {
        var j = !i.config.flashEmbedTagOnly, k = i.config.flashAddEmbedTag || i.config.flashEmbedTagOnly, l = '<div>' + CKEDITOR.tools.htmlEncode(i.lang.image.preview) + '<br>' + '<div id="FlashPreviewLoader" style="display:none"><div class="loading">&nbsp;</div></div>' + '<div id="FlashPreviewBox"></div></div>';
        return{title:i.lang.flash.title, minWidth:420, minHeight:310, onShow:function () {
            var y = this;
            y.fakeImage = y.objectNode = y.embedNode = null;
            var m = y.getSelectedElement();
            if (m && m.getAttribute('_cke_real_element_type') && m.getAttribute('_cke_real_element_type') == 'flash') {
                y.fakeImage = m;
                var n = i.restoreRealElement(m), o = null, p = null, q = {};
                if (n.getName() == 'cke:object') {
                    o = n;
                    var r = o.getElementsByTag('embed', 'cke');
                    if (r.count() > 0)p = r.getItem(0);
                    var s = o.getElementsByTag('param', 'cke');
                    for (var t = 0, u = s.count(); t < u; t++) {
                        var v = s.getItem(t), w = v.getAttribute('name'), x = v.getAttribute('value');
                        q[w] = x;
                    }
                } else if (n.getName() == 'cke:embed')p = n;
                y.objectNode = o;
                y.embedNode = p;
                y.setupContent(o, p, q, m);
            }
        }, onOk:function () {
            var v = this;
            var m = null, n = null, o = null;
            if (!v.fakeImage) {
                if (j) {
                    m = CKEDITOR.dom.element.createFromHtml('<cke:object></cke:object>', i.document);
                    var p = {classid:'clsid:d27cdb6e-ae6d-11cf-96b8-444553540000', codebase:'http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,40,0'};
                    m.setAttributes(p);
                }
                if (k) {
                    n = CKEDITOR.dom.element.createFromHtml('<cke:embed></cke:embed>', i.document);
                    n.setAttributes({type:'application/x-shockwave-flash', pluginspage:'http://www.macromedia.com/go/getflashplayer'});
                    if (m)n.appendTo(m);
                }
            } else {
                m = v.objectNode;
                n = v.embedNode;
            }
            if (m) {
                o = {};
                var q = m.getElementsByTag('param', 'cke');
                for (var r = 0, s = q.count(); r < s; r++)o[q.getItem(r).getAttribute('name')] = q.getItem(r);
            }
            var t = {};
            v.commitContent(m, n, o, t);
            var u = i.createFakeElement(m || n, 'cke_flash', 'flash', true);
            u.setStyles(t);
            if (v.fakeImage)u.replace(v.fakeImage); else i.insertElement(u);
        }, onHide:function () {
            if (this.preview)this.preview.setHtml('');
        }, contents:[
            {id:'info', label:i.lang.common.generalTab, accessKey:'I', elements:[
                {type:'vbox', padding:0, children:[
                    {type:'html', html:'<span>' + CKEDITOR.tools.htmlEncode(i.lang.image.url) + '</span>'},
                    {type:'hbox', widths:['280px', '110px'], align:'right', children:[
                        {id:'src', type:'text', label:'', validate:CKEDITOR.dialog.validate.notEmpty(i.lang.flash.validateSrc), setup:g, commit:h, onLoad:function () {
                            var m = this.getDialog(), n = function (o) {
                                m.preview.setHtml('<embed height="100%" width="100%" src="' + CKEDITOR.tools.htmlEncode(o) + '" type="application/x-shockwave-flash"></embed>');
                            };
                            m.preview = m.getContentElement('info', 'preview').getElement().getChild(3);
                            this.on('change', function (o) {
                                if (o.data && o.data.value)n(o.data.value);
                            });
                            this.getInputElement().on('change', function (o) {
                                n(this.getValue());
                            }, this);
                        }},
                        {type:'button', id:'browse', filebrowser:'info:src', hidden:true, align:'center', label:i.lang.common.browseServer}
                    ]}
                ]},
                {type:'hbox', widths:['25%', '25%', '25%', '25%', '25%'], children:[
                    {type:'text', id:'width', style:'width:95px', label:i.lang.flash.width, validate:CKEDITOR.dialog.validate.integer(i.lang.flash.validateWidth), setup:function (m, n, o, p) {
                        g.apply(this, arguments);
                        if (p) {
                            var q = parseInt(p.$.style.width, 10);
                            if (!isNaN(q))this.setValue(q);
                        }
                    }, commit:function (m, n, o, p) {
                        h.apply(this, arguments);
                        if (this.getValue())p.width = this.getValue() + 'px';
                    }},
                    {type:'text', id:'height', style:'width:95px', label:i.lang.flash.height, validate:CKEDITOR.dialog.validate.integer(i.lang.flash.validateHeight), setup:function (m, n, o, p) {
                        g.apply(this, arguments);
                        if (p) {
                            var q = parseInt(p.$.style.height, 10);
                            if (!isNaN(q))this.setValue(q);
                        }
                    }, commit:function (m, n, o, p) {
                        h.apply(this, arguments);
                        if (this.getValue())p.height = this.getValue() + 'px';
                    }},
                    {type:'text', id:'hSpace', style:'width:95px', label:i.lang.flash.hSpace, validate:CKEDITOR.dialog.validate.integer(i.lang.flash.validateHSpace), setup:g, commit:h},
                    {type:'text', id:'vSpace', style:'width:95px', label:i.lang.flash.vSpace, validate:CKEDITOR.dialog.validate.integer(i.lang.flash.validateVSpace), setup:g, commit:h}
                ]},
                {type:'vbox', children:[
                    {type:'html', id:'preview', style:'width:95%;', html:l}
                ]}
            ]},
            {id:'Upload', hidden:true, filebrowser:'uploadButton', label:i.lang.common.upload, elements:[
                {type:'file', id:'upload', label:i.lang.common.upload, size:38},
                {type:'fileButton', id:'uploadButton', label:i.lang.common.uploadSubmit, filebrowser:'info:src', 'for':['Upload', 'upload']}
            ]},
            {id:'properties', label:i.lang.flash.propertiesTab, elements:[
                {type:'hbox', widths:['50%', '50%'], children:[
                    {id:'scale', type:'select', label:i.lang.flash.scale, 'default':'', style:'width : 100%;', items:[
                        [i.lang.common.notSet, ''],
                        [i.lang.flash.scaleAll, 'showall'],
                        [i.lang.flash.scaleNoBorder, 'noborder'],
                        [i.lang.flash.scaleFit, 'exactfit']
                    ], setup:g, commit:h},
                    {id:'allowScriptAccess', type:'select', label:i.lang.flash.access, 'default':'', style:'width : 100%;', items:[
                        [i.lang.common.notSet, ''],
                        [i.lang.flash.accessAlways, 'always'],
                        [i.lang.flash.accessSameDomain, 'samedomain'],
                        [i.lang.flash.accessNever, 'never']
                    ], setup:g, commit:h}
                ]},
                {type:'hbox', widths:['50%', '50%'], children:[
                    {id:'wmode', type:'select', label:i.lang.flash.windowMode, 'default':'', style:'width : 100%;', items:[
                        [i.lang.common.notSet, ''],
                        [i.lang.flash.windowModeWindow, 'window'],
                        [i.lang.flash.windowModeOpaque, 'opaque'],
                        [i.lang.flash.windowModeTransparent, 'transparent']
                    ], setup:g, commit:h},
                    {id:'quality', type:'select', label:i.lang.flash.quality, 'default':'high', style:'width : 100%;', items:[
                        [i.lang.common.notSet, ''],
                        [i.lang.flash.qualityBest, 'best'],
                        [i.lang.flash.qualityHigh, 'high'],
                        [i.lang.flash.qualityAutoHigh, 'autohigh'],
                        [i.lang.flash.qualityMedium, 'medium'],
                        [i.lang.flash.qualityAutoLow, 'autolow'],
                        [i.lang.flash.qualityLow, 'low']
                    ], setup:g, commit:h}
                ]},
                {type:'hbox', widths:['50%', '50%'], children:[
                    {id:'align', type:'select', label:i.lang.flash.align, 'default':'', style:'width : 100%;', items:[
                        [i.lang.common.notSet, ''],
                        [i.lang.image.alignLeft, 'left'],
                        [i.lang.image.alignAbsBottom, 'absBottom'],
                        [i.lang.image.alignAbsMiddle, 'absMiddle'],
                        [i.lang.image.alignBaseline, 'baseline'],
                        [i.lang.image.alignBottom, 'bottom'],
                        [i.lang.image.alignMiddle, 'middle'],
                        [i.lang.image.alignRight, 'right'],
                        [i.lang.image.alignTextTop, 'textTop'],
                        [i.lang.image.alignTop, 'top']
                    ], setup:g, commit:h},
                    {type:'html', html:'<div></div>'}
                ]},
                {type:'vbox', padding:0, children:[
                    {type:'html', html:CKEDITOR.tools.htmlEncode(i.lang.flash.flashvars)},
                    {type:'checkbox', id:'menu', label:i.lang.flash.chkMenu, 'default':true, setup:g, commit:h},
                    {type:'checkbox', id:'play', label:i.lang.flash.chkPlay, 'default':true, setup:g, commit:h},
                    {type:'checkbox', id:'loop', label:i.lang.flash.chkLoop, 'default':true, setup:g, commit:h},
                    {type:'checkbox', id:'allowFullScreen', label:i.lang.flash.chkFull, 'default':true, setup:g, commit:h}
                ]}
            ]},
            {id:'advanced', label:i.lang.common.advancedTab, elements:[
                {type:'hbox', widths:['45%', '55%'], children:[
                    {type:'text', id:'id', label:i.lang.common.id, setup:g, commit:h},
                    {type:'text', id:'title', label:i.lang.common.advisoryTitle, setup:g, commit:h}
                ]},
                {type:'hbox', widths:['45%', '55%'], children:[
                    {type:'text', id:'bgcolor', label:i.lang.flash.bgcolor, setup:g, commit:h},
                    {type:'text', id:'class', label:i.lang.common.cssClass, setup:g, commit:h}
                ]},
                {type:'text', id:'style', label:i.lang.common.cssStyle, setup:g, commit:h}
            ]}
        ]};
    });
})();
