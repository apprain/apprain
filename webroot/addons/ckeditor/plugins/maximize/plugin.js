﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    function a(f) {
        if (!f || f.type != CKEDITOR.NODE_ELEMENT || f.getName() != 'form')return[];
        var g = [], h = ['style', 'className'];
        for (var i = 0; i < h.length; i++) {
            var j = h[i], k = f.$.elements.namedItem(j);
            if (k) {
                var l = new CKEDITOR.dom.element(k);
                g.push([l, l.nextSibling]);
                l.remove();
            }
        }
        return g;
    }

    ;
    function b(f, g) {
        if (!f || f.type != CKEDITOR.NODE_ELEMENT || f.getName() != 'form')return;
        if (g.length > 0)for (var h = g.length - 1; h >= 0; h--) {
            var i = g[h][0], j = g[h][1];
            if (j)i.insertBefore(j); else i.appendTo(f);
        }
    }

    ;
    function c(f, g) {
        var h = a(f), i = {}, j = f.$;
        if (!g) {
            i['class'] = j.className || '';
            j.className = '';
        }
        i.inline = j.style.cssText || '';
        if (!g)j.style.cssText = 'position: static; overflow: visible';
        b(h);
        return i;
    }

    ;
    function d(f, g) {
        var h = a(f), i = f.$;
        if ('class' in g)i.className = g['class'];
        if ('inline' in g)i.style.cssText = g.inline;
        b(h);
    }

    ;
    function e(f, g) {
        return function () {
            var h = f.getViewPaneSize();
            g.resize(h.width, h.height, null, true);
        };
    }

    ;
    CKEDITOR.plugins.add('maximize', {init:function (f) {
        var g = f.lang, h = CKEDITOR.document, i = h.getWindow(), j, k, l, m = e(i, f), n = CKEDITOR.TRISTATE_OFF;
        f.addCommand('maximize', {modes:{wysiwyg:1, source:1}, editorFocus:false, exec:function () {
            var B = this;
            var o = f.container.getChild([0, 0]), p = f.getThemeSpace('contents');
            if (f.mode == 'wysiwyg') {
                var q = f.getSelection();
                j = q && q.getRanges();
                k = i.getScrollPosition();
            } else {
                var r = f.textarea.$;
                j = !CKEDITOR.env.ie && [r.selectionStart, r.selectionEnd];
                k = [r.scrollLeft, r.scrollTop];
            }
            if (B.state == CKEDITOR.TRISTATE_OFF) {
                i.on('resize', m);
                l = i.getScrollPosition();
                var s = f.container;
                while (s = s.getParent()) {
                    s.setCustomData('maximize_saved_styles', c(s));
                    s.setStyle('z-index', f.config.baseFloatZIndex - 1);
                }
                p.setCustomData('maximize_saved_styles', c(p, true));
                o.setCustomData('maximize_saved_styles', c(o, true));
                if (CKEDITOR.env.ie)h.$.documentElement.style.overflow = h.getBody().$.style.overflow = 'hidden'; else h.getBody().setStyles({overflow:'hidden', width:'0px', height:'0px'});
                i.$.scrollTo(0, 0);
                var t = i.getViewPaneSize();
                o.setStyle('position', 'absolute');
                o.$.offsetLeft;
                o.setStyles({'z-index':f.config.baseFloatZIndex - 1, left:'0px', top:'0px'});
                f.resize(t.width, t.height, null, true);
                var u = o.getDocumentPosition();
                o.setStyles({left:-1 * u.x + 'px', top:-1 * u.y + 'px'});
                o.addClass('cke_maximized');
            } else if (B.state == CKEDITOR.TRISTATE_ON) {
                i.removeListener('resize', m);
                var v = [p, o];
                for (var w = 0; w < v.length; w++) {
                    d(v[w], v[w].getCustomData('maximize_saved_styles'));
                    v[w].removeCustomData('maximize_saved_styles');
                }
                s = f.container;
                while (s = s.getParent()) {
                    d(s, s.getCustomData('maximize_saved_styles'));
                    s.removeCustomData('maximize_saved_styles');
                }
                i.$.scrollTo(l.x, l.y);
                o.removeClass('cke_maximized');
                f.fire('resize');
            }
            B.toggleState();
            var x = B.uiItems[0], y = B.state == CKEDITOR.TRISTATE_OFF ? g.maximize : g.minimize, z = f.element.getDocument().getById(x._.id);
            z.getChild(1).setHtml(y);
            z.setAttribute('title', y);
            z.setAttribute('href', 'javascript:void("' + y + '");');
            if (f.mode == 'wysiwyg') {
                if (j) {
                    f.getSelection().selectRanges(j);
                    var A = f.getSelection().getStartElement();
                    A && A.scrollIntoView(true);
                } else i.$.scrollTo(k.x, k.y);
            } else {
                if (j) {
                    r.selectionStart = j[0];
                    r.selectionEnd = j[1];
                }
                r.scrollLeft = k[0];
                r.scrollTop = k[1];
            }
            j = k = null;
            n = B.state;
        }, canUndo:false});
        f.ui.addButton('Maximize', {label:g.maximize, command:'maximize'});
        f.on('mode', function () {
            f.getCommand('maximize').setState(n);
        }, null, null, 100);
    }});
})();
