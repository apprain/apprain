﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.add('panel', {beforeInit:function (a) {
    a.ui.addHandler(CKEDITOR.UI_PANEL, CKEDITOR.ui.panel.handler);
}});
CKEDITOR.UI_PANEL = 2;
CKEDITOR.ui.panel = function (a, b) {
    var c = this;
    if (b)CKEDITOR.tools.extend(c, b);
    CKEDITOR.tools.extend(c, {className:'', css:[]});
    c.id = CKEDITOR.tools.getNextNumber();
    c.document = a;
    c._ = {blocks:{}};
};
CKEDITOR.ui.panel.handler = {create:function (a) {
    return new CKEDITOR.ui.panel(a);
}};
CKEDITOR.ui.panel.prototype = {renderHtml:function (a) {
    var b = [];
    this.render(a, b);
    return b.join('');
}, render:function (a, b) {
    var d = this;
    var c = 'cke_' + d.id;
    b.push('<div class="', a.skinClass, '" lang="', a.langCode, '" style="display:none;z-index:' + (a.config.baseFloatZIndex + 1) + '">' + '<div' + ' id=', c, ' dir=', a.lang.dir, ' class="cke_panel cke_', a.lang.dir);
    if (d.className)b.push(' ', d.className);
    b.push('">');
    if (d.forceIFrame || d.css.length) {
        b.push('<iframe id="', c, '_frame" frameborder="0" src="javascript:void(');
        b.push(CKEDITOR.env.isCustomDomain() ? "(function(){document.open();document.domain='" + document.domain + "';" + 'document.close();' + '})()' : '0');
        b.push(')"></iframe>');
    }
    b.push('</div></div>');
    return c;
}, getHolderElement:function () {
    var a = this._.holder;
    if (!a) {
        if (this.forceIFrame || this.css.length) {
            var b = this.document.getById('cke_' + this.id + '_frame'), c = b.getParent(), d = c.getAttribute('dir'), e = c.getParent().getAttribute('class'), f = c.getParent().getAttribute('lang'), g = b.getFrameDocument();
            g.$.open();
            if (CKEDITOR.env.isCustomDomain())g.$.domain = document.domain;
            var h = CKEDITOR.tools.addFunction(CKEDITOR.tools.bind(function (j) {
                this.isLoaded = true;
                if (this.onLoad)this.onLoad();
            }, this));
            g.$.write('<!DOCTYPE html><html dir="' + d + '" class="' + e + '_container" lang="' + f + '">' + '<head>' + '<style>.' + e + '_container{visibility:hidden}</style>' + '</head>' + '<body class="cke_' + d + ' cke_panel_frame ' + CKEDITOR.env.cssClass + '" style="margin:0;padding:0"' + ' onload="( window.CKEDITOR || window.parent.CKEDITOR ).tools.callFunction(' + h + ');">' + '</body>' + '<link type="text/css" rel=stylesheet href="' + this.css.join('"><link type="text/css" rel="stylesheet" href="') + '">' + '</html>');
            g.$.close();
            var i = g.getWindow();
            i.$.CKEDITOR = CKEDITOR;
            g.on('keydown', function (j) {
                var l = this;
                var k = j.data.getKeystroke();
                if (l._.onKeyDown && l._.onKeyDown(k) === false) {
                    j.data.preventDefault();
                    return;
                }
                if (k == 27)l.onEscape && l.onEscape();
            }, this);
            a = g.getBody();
        } else a = this.document.getById('cke_' + this.id);
        this._.holder = a;
    }
    return a;
}, addBlock:function (a, b) {
    var c = this;
    b = c._.blocks[a] = b || new CKEDITOR.ui.panel.block(c.getHolderElement());
    if (!c._.currentBlock)c.showBlock(a);
    return b;
}, getBlock:function (a) {
    return this._.blocks[a];
}, showBlock:function (a) {
    var e = this;
    var b = e._.blocks, c = b[a], d = e._.currentBlock;
    if (d)d.hide();
    e._.currentBlock = c;
    c._.focusIndex = -1;
    e._.onKeyDown = c.onKeyDown && CKEDITOR.tools.bind(c.onKeyDown, c);
    c.show();
    return c;
}};
CKEDITOR.ui.panel.block = CKEDITOR.tools.createClass({$:function (a) {
    var b = this;
    b.element = a.append(a.getDocument().createElement('div', {attributes:{'class':'cke_panel_block'}, styles:{display:'none'}}));
    b.keys = {};
    b._.focusIndex = -1;
    b.element.disableContextMenu();
}, _:{}, proto:{show:function () {
    this.element.setStyle('display', '');
}, hide:function () {
    var a = this;
    if (!a.onHide || a.onHide.call(a) !== true)a.element.setStyle('display', 'none');
}, onKeyDown:function (a) {
    var f = this;
    var b = f.keys[a];
    switch (b) {
        case 'next':
            var c = f._.focusIndex, d = f.element.getElementsByTag('a'), e;
            while (e = d.getItem(++c))if (e.getAttribute('_cke_focus') && e.$.offsetWidth) {
                f._.focusIndex = c;
                e.focus();
                break;
            }
            return false;
        case 'prev':
            c = f._.focusIndex;
            d = f.element.getElementsByTag('a');
            while (c > 0 && (e = d.getItem(--c)))if (e.getAttribute('_cke_focus') && e.$.offsetWidth) {
                f._.focusIndex = c;
                e.focus();
                break;
            }
            return false;
        case 'click':
            c = f._.focusIndex;
            e = c >= 0 && f.element.getElementsByTag('a').getItem(c);
            if (e)e.$.click ? e.$.click() : e.$.onclick();
            return false;
    }
    return true;
}}});
