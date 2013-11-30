﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    var a = /^[\t\r\n ]*(?:&nbsp;|\xa0)$/, b = '{cke_protected}';

    function c(B) {
        var C = B.children.length, D = B.children[C - 1];
        while (D && D.type == CKEDITOR.NODE_TEXT && !CKEDITOR.tools.trim(D.value))D = B.children[--C];
        return D;
    }

    ;
    function d(B, C) {
        var D = B.children, E = c(B);
        if (E) {
            if ((C || !CKEDITOR.env.ie) && (E.type == CKEDITOR.NODE_ELEMENT && E.name == 'br'))D.pop();
            if (E.type == CKEDITOR.NODE_TEXT && a.test(E.value))D.pop();
        }
    }

    ;
    function e(B) {
        var C = c(B);
        return!C || C.type == CKEDITOR.NODE_ELEMENT && C.name == 'br';
    }

    ;
    function f(B) {
        d(B, true);
        if (e(B))if (CKEDITOR.env.ie)B.add(new CKEDITOR.htmlParser.text('\xa0')); else B.add(new CKEDITOR.htmlParser.element('br', {}));
    }

    ;
    function g(B) {
        d(B);
        if (e(B))B.add(new CKEDITOR.htmlParser.text('\xa0'));
    }

    ;
    var h = CKEDITOR.dtd, i = CKEDITOR.tools.extend({}, h.$block, h.$listItem, h.$tableContent);
    for (var j in i)if (!('br' in h[j]))delete i[j];
    delete i.pre;
    var k = {attributeNames:[
        [/^on/, '_cke_pa_on']
    ]}, l = {elements:{}};
    for (j in i)l.elements[j] = f;
    var m = {elementNames:[
        [/^cke:/, ''],
        [/^\?xml:namespace$/, '']
    ], attributeNames:[
        [/^_cke_(saved|pa)_/, ''],
        [/^_cke.*/, '']
    ], elements:{$:function (B) {
        var C = B.attributes;
        if (C) {
            var D = ['name', 'href', 'src'], E;
            for (var F = 0; F < D.length; F++) {
                E = '_cke_saved_' + D[F];
                E in C && delete C[D[F]];
            }
        }
    }, embed:function (B) {
        var C = B.parent;
        if (C && C.name == 'object') {
            var D = C.attributes.width, E = C.attributes.height;
            D && (B.attributes.width = D);
            E && (B.attributes.height = E);
        }
    }, param:function (B) {
        B.children = [];
        B.isEmpty = true;
        return B;
    }, a:function (B) {
        if (!(B.children.length || B.attributes.name || B.attributes._cke_saved_name))return false;
    }}, attributes:{'class':function (B, C) {
        return CKEDITOR.tools.ltrim(B.replace(/(?:^|\s+)cke_[^\s]*/g, '')) || false;
    }}, comment:function (B) {
        if (B.substr(0, b.length) == b)return new CKEDITOR.htmlParser.cdata(decodeURIComponent(B.substr(b.length)));
        return B;
    }}, n = {elements:{}};
    for (j in i)n.elements[j] = g;
    if (CKEDITOR.env.ie)m.attributes.style = function (B, C) {
        return B.toLowerCase();
    };
    var o = /<(?:a|area|img|input).*?\s((?:href|src|name)\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|(?:[^ "'>]+)))/gi;

    function p(B) {
        return B.replace(o, '$& _cke_saved_$1');
    }

    ;
    var q = /<(style)(?=[ >])[^>]*>[^<]*<\/\1>/gi, r = /<cke:encoded>([^<]*)<\/cke:encoded>/gi, s = /(<\/?)((?:object|embed|param).*?>)/gi, t = /<cke:param(.*?)\/>/gi;

    function u(B) {
        return '<cke:encoded>' + encodeURIComponent(B) + '</cke:encoded>';
    }

    ;
    function v(B) {
        return B.replace(q, u);
    }

    ;
    function w(B) {
        return B.replace(s, '$1cke:$2');
    }

    ;
    function x(B) {
        return B.replace(t, '<cke:param$1></cke:param>');
    }

    ;
    function y(B, C) {
        return decodeURIComponent(C);
    }

    ;
    function z(B) {
        return B.replace(r, y);
    }

    ;
    function A(B, C) {
        var D = [], E = /<\!--\{cke_temp\}(\d*?)-->/g, F = [/<!--[\s\S]*?-->/g, /<script[\s\S]*?<\/script>/gi, /<noscript[\s\S]*?<\/noscript>/gi].concat(C);
        for (var G = 0; G < F.length; G++)B = B.replace(F[G], function (H) {
            H = H.replace(E, function (I, J) {
                return D[J];
            });
            return '<!--{cke_temp}' + (D.push(H) - 1) + '-->';
        });
        B = B.replace(E, function (H, I) {
            return '<!--' + b + encodeURIComponent(D[I]).replace(/--/g, '%2D%2D') + '-->';
        });
        return B;
    }

    ;
    CKEDITOR.plugins.add('htmldataprocessor', {requires:['htmlwriter'], init:function (B) {
        var C = B.dataProcessor = new CKEDITOR.htmlDataProcessor(B);
        C.writer.forceSimpleAmpersand = B.config.forceSimpleAmpersand;
        C.dataFilter.addRules(k);
        C.dataFilter.addRules(l);
        C.htmlFilter.addRules(m);
        C.htmlFilter.addRules(n);
    }});
    CKEDITOR.htmlDataProcessor = function (B) {
        var C = this;
        C.editor = B;
        C.writer = new CKEDITOR.htmlWriter();
        C.dataFilter = new CKEDITOR.htmlParser.filter();
        C.htmlFilter = new CKEDITOR.htmlParser.filter();
    };
    CKEDITOR.htmlDataProcessor.prototype = {toHtml:function (B, C) {
        B = A(B, this.editor.config.protectedSource);
        B = p(B);
        if (CKEDITOR.env.ie)B = v(B);
        B = w(B);
        B = x(B);
        var D = document.createElement('div');
        D.innerHTML = 'a' + B;
        B = D.innerHTML.substr(1);
        if (CKEDITOR.env.ie)B = z(B);
        var E = CKEDITOR.htmlParser.fragment.fromHtml(B, C), F = new CKEDITOR.htmlParser.basicWriter();
        E.writeHtml(F, this.dataFilter);
        return F.getHtml(true);
    }, toDataFormat:function (B, C) {
        var D = this.writer, E = CKEDITOR.htmlParser.fragment.fromHtml(B, C);
        D.reset();
        E.writeHtml(D, this.htmlFilter);
        return D.getHtml(true);
    }};
})();
CKEDITOR.config.forceSimpleAmpersand = false;
