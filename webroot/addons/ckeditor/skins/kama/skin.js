﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.skins.add('kama', (function () {
    var a = [];
    if (CKEDITOR.env.ie && CKEDITOR.env.version < 7)a.push('icons.png', 'images/sprites_ie6.png', 'images/dialog_sides.gif');
    return{preload:a, editor:{css:['editor.css']}, dialog:{css:['dialog.css']}, templates:{css:['templates.css']}, margins:[0, 0, 0, 0], init:function (b) {
        if (b.config.width && !isNaN(b.config.width))b.config.width -= 12;
        var c = [], d = /\$color/g, e = '/* UI Color Support */.cke_skin_kama .cke_menuitem .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover .cke_label,.cke_skin_kama .cke_menuitem a:focus .cke_label,.cke_skin_kama .cke_menuitem a:active .cke_label{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_label,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_label{\tbackground-color: transparent !important;}.cke_skin_kama .cke_menuitem a.cke_disabled:hover .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:focus .cke_icon_wrapper,.cke_skin_kama .cke_menuitem a.cke_disabled:active .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuitem a.cke_disabled .cke_icon_wrapper{\tbackground-color: $color !important;\tborder-color: $color !important;}.cke_skin_kama .cke_menuseparator{\tbackground-color: $color !important;}.cke_skin_kama .cke_menuitem a:hover,.cke_skin_kama .cke_menuitem a:focus,.cke_skin_kama .cke_menuitem a:active{\tbackground-color: $color !important;}';
        if (CKEDITOR.env.webkit) {
            e = e.split('}').slice(0, -1);
            for (var f = 0; f < e.length; f++)e[f] = e[f].split('{');
        }
        function g(j) {
            var k = j.getHead().append('style');
            k.setAttribute('id', 'cke_ui_color');
            k.setAttribute('type', 'text/css');
            return k;
        }

        ;
        function h(j, k, l) {
            var m, n, o;
            for (var p = 0; p < j.length; p++)if (CKEDITOR.env.webkit) {
                for (n = 0; n < j[p].$.sheet.rules.length; n++)j[p].$.sheet.removeRule(n);
                for (n = 0; n < k.length; n++) {
                    o = k[n][1];
                    for (m = 0; m < l.length; m++)o = o.replace(l[m][0], l[m][1]);
                    j[p].$.sheet.addRule(k[n][0], o);
                }
            } else {
                o = k;
                for (m = 0; m < l.length; m++)o = o.replace(l[m][0], l[m][1]);
                if (CKEDITOR.env.ie)j[p].$.styleSheet.cssText = o; else j[p].setHtml(o);
            }
        }

        ;
        var i = /\$color/g;
        CKEDITOR.tools.extend(b, {uiColor:null, getUiColor:function () {
            return this.uiColor;
        }, setUiColor:function (j) {
            var k, l = g(CKEDITOR.document), m = '#cke_' + b.name.replace('.', '\\.'), n = [m + ' .cke_wrapper', m + '_dialog .cke_dialog_contents', m + '_dialog a.cke_dialog_tab', m + '_dialog .cke_dialog_footer'].join(','), o = 'background-color: $color !important;';
            if (CKEDITOR.env.webkit)k = [
                [n, o]
            ]; else k = n + '{' + o + '}';
            return(this.setUiColor = function (p) {
                var q = [
                    [i, p]
                ];
                b.uiColor = p;
                h([l], k, q);
                h(c, e, q);
            })(j);
        }});
        b.on('menuShow', function (j) {
            var k = j.data[0], l = k.element.getElementsByTag('iframe').getItem(0).getFrameDocument();
            if (!l.getById('cke_ui_color')) {
                var m = g(l);
                c.push(m);
                var n = b.getUiColor();
                if (n)h([m], e, [
                    [i, n]
                ]);
            }
        });
        if (b.config.uiColor)b.setUiColor(b.config.uiColor);
    }};
})());
if (CKEDITOR.dialog)CKEDITOR.dialog.on('resize', function (a) {
    var b = a.data, c = b.width, d = b.height, e = b.dialog, f = e.parts.contents, g = !CKEDITOR.env.quirks;
    if (b.skin != 'kama')return;
    f.setStyles(CKEDITOR.env.ie || CKEDITOR.env.gecko && CKEDITOR.env.version < 10900 ? {width:c + 'px', height:d + 'px'} : {'min-width':c + 'px', 'min-height':d + 'px'});
    if (!CKEDITOR.env.ie)return;
    setTimeout(function () {
        var h = f.getParent(), i = h.getParent(), j = i.getChild(2);
        j.setStyle('width', h.$.offsetWidth + 'px');
        j = i.getChild(7);
        j.setStyle('width', h.$.offsetWidth - 28 + 'px');
        j = i.getChild(4);
        j.setStyle('height', h.$.offsetHeight - 31 - 14 + 'px');
        j = i.getChild(5);
        j.setStyle('height', h.$.offsetHeight - 31 - 14 + 'px');
    }, 100);
});
