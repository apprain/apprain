﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.add('styles', {requires:['selection']});
CKEDITOR.editor.prototype.attachStyleStateChange = function (a, b) {
    var c = this._.styleStateChangeCallbacks;
    if (!c) {
        c = this._.styleStateChangeCallbacks = [];
        this.on('selectionChange', function (d) {
            for (var e = 0; e < c.length; e++) {
                var f = c[e], g = f.style.checkActive(d.data.path) ? CKEDITOR.TRISTATE_ON : CKEDITOR.TRISTATE_OFF;
                if (f.state !== g) {
                    f.fn.call(this, g);
                    f.state !== g;
                }
            }
        });
    }
    c.push({style:a, fn:b});
};
CKEDITOR.STYLE_BLOCK = 1;
CKEDITOR.STYLE_INLINE = 2;
CKEDITOR.STYLE_OBJECT = 3;
(function () {
    var a = {address:1, div:1, h1:1, h2:1, h3:1, h4:1, h5:1, h6:1, p:1, pre:1}, b = {a:1, embed:1, hr:1, img:1, li:1, object:1, ol:1, table:1, td:1, tr:1, ul:1}, c = /\s*(?:;\s*|$)/;
    CKEDITOR.style = function (A, B) {
        if (B) {
            A = CKEDITOR.tools.clone(A);
            v(A.attributes, B);
            v(A.styles, B);
        }
        var C = this.element = (A.element || '*').toLowerCase();
        this.type = C == '#' || a[C] ? CKEDITOR.STYLE_BLOCK : b[C] ? CKEDITOR.STYLE_OBJECT : CKEDITOR.STYLE_INLINE;
        this._ = {definition:A};
    };
    CKEDITOR.style.prototype = {apply:function (A) {
        z.call(this, A, false);
    }, remove:function (A) {
        z.call(this, A, true);
    }, applyToRange:function (A) {
        var B = this;
        return(B.applyToRange = B.type == CKEDITOR.STYLE_INLINE ? d : B.type == CKEDITOR.STYLE_BLOCK ? f : null).call(B, A);
    }, removeFromRange:function (A) {
        return(this.removeFromRange = this.type == CKEDITOR.STYLE_INLINE ? e : null).call(this, A);
    }, applyToObject:function (A) {
        t(A, this);
    }, checkActive:function (A) {
        switch (this.type) {
            case CKEDITOR.STYLE_BLOCK:
                return this.checkElementRemovable(A.block || A.blockLimit, true);
            case CKEDITOR.STYLE_INLINE:
                var B = A.elements;
                for (var C = 0, D; C < B.length; C++) {
                    D = B[C];
                    if (D == A.block || D == A.blockLimit)continue;
                    if (this.checkElementRemovable(D, true))return true;
                }
        }
        return false;
    }, checkElementRemovable:function (A, B) {
        if (!A)return false;
        var C = this._.definition, D;
        if (A.getName() == this.element) {
            if (!B && !A.hasAttributes())return true;
            D = w(C);
            if (D._length) {
                for (var E in D) {
                    if (E == '_length')continue;
                    var F = A.getAttribute(E);
                    if (D[E] == (E == 'style' ? y(F, false) : F)) {
                        if (!B)return true;
                    } else if (B)return false;
                }
                if (B)return true;
            } else return true;
        }
        var G = x(this)[A.getName()];
        if (G) {
            if (!(D = G.attributes))return true;
            for (var H = 0; H < D.length; H++) {
                E = D[H][0];
                var I = A.getAttribute(E);
                if (I) {
                    var J = D[H][1];
                    if (J === null || typeof J == 'string' && I == J || J.test(I))return true;
                }
            }
        }
        return false;
    }};
    CKEDITOR.style.getStyleText = function (A) {
        var B = A._ST;
        if (B)return B;
        B = A.styles;
        var C = A.attributes && A.attributes.style || '';
        if (C.length)C = C.replace(c, ';');
        for (var D in B)C += (D + ':' + B[D]).replace(c, ';');
        if (C.length)C = y(C);
        return A._ST = C;
    };
    function d(A) {
        var aa = this;
        var B = A.document;
        if (A.collapsed) {
            var C = s(aa, B);
            A.insertNode(C);
            A.moveToPosition(C, CKEDITOR.POSITION_BEFORE_END);
            return;
        }
        var D = aa.element, E = aa._.definition, F, G = CKEDITOR.dtd[D] || (F = true, CKEDITOR.dtd.span), H = A.createBookmark();
        A.enlarge(CKEDITOR.ENLARGE_ELEMENT);
        A.trim();
        var I = A.getBoundaryNodes(), J = I.startNode, K = I.endNode.getNextSourceNode(true);
        if (!K) {
            var L;
            K = L = B.createText('');
            K.insertAfter(A.endContainer);
        }
        var M = K.getParent();
        if (M && M.getAttribute('_fck_bookmark'))K = M;
        if (K.equals(J)) {
            K = K.getNextSourceNode(true);
            if (!K) {
                K = L = B.createText('');
                K.insertAfter(J);
            }
        }
        var N = J, O, P;
        while (N) {
            var Q = false;
            if (N.equals(K)) {
                N = null;
                Q = true;
            } else {
                var R = N.type, S = R == CKEDITOR.NODE_ELEMENT ? N.getName() : null;
                if (S && N.getAttribute('_fck_bookmark')) {
                    N = N.getNextSourceNode(true);
                    continue;
                }
                if (!S || G[S] && (N.getPosition(K) | CKEDITOR.POSITION_PRECEDING | CKEDITOR.POSITION_IDENTICAL | CKEDITOR.POSITION_IS_CONTAINED) == (CKEDITOR.POSITION_PRECEDING + CKEDITOR.POSITION_IDENTICAL + CKEDITOR.POSITION_IS_CONTAINED)) {
                    var T = N.getParent();
                    if (T && ((T.getDtd() || CKEDITOR.dtd.span)[D] || F)) {
                        if (!O && (!S || !CKEDITOR.dtd.$removeEmpty[S] || (N.getPosition(K) | CKEDITOR.POSITION_PRECEDING | CKEDITOR.POSITION_IDENTICAL | CKEDITOR.POSITION_IS_CONTAINED) == (CKEDITOR.POSITION_PRECEDING + CKEDITOR.POSITION_IDENTICAL + CKEDITOR.POSITION_IS_CONTAINED))) {
                            O = new CKEDITOR.dom.range(B);
                            O.setStartBefore(N);
                        }
                        if (R == CKEDITOR.NODE_TEXT || R == CKEDITOR.NODE_ELEMENT && !N.getChildCount()) {
                            var U = N, V;
                            while (!U.$.nextSibling && (V = U.getParent(), G[V.getName()]) && ((V.getPosition(J) | CKEDITOR.POSITION_FOLLOWING | CKEDITOR.POSITION_IDENTICAL | CKEDITOR.POSITION_IS_CONTAINED) == (CKEDITOR.POSITION_FOLLOWING + CKEDITOR.POSITION_IDENTICAL + CKEDITOR.POSITION_IS_CONTAINED)))U = V;
                            O.setEndAfter(U);
                            if (!U.$.nextSibling)Q = true;
                            if (!P)P = R != CKEDITOR.NODE_TEXT || /[^\s\ufeff]/.test(N.getText());
                        }
                    } else Q = true;
                } else Q = true;
                N = N.getNextSourceNode();
            }
            if (Q && P && O && !O.collapsed) {
                var W = s(aa, B), X = O.getCommonAncestor();
                while (W && X) {
                    if (X.getName() == D) {
                        for (var Y in E.attributes)if (W.getAttribute(Y) == X.getAttribute(Y))W.removeAttribute(Y);
                        for (var Z in E.styles)if (W.getStyle(Z) == X.getStyle(Z))W.removeStyle(Z);
                        if (!W.hasAttributes()) {
                            W = null;
                            break;
                        }
                    }
                    X = X.getParent();
                }
                if (W) {
                    O.extractContents().appendTo(W);
                    n(aa, W);
                    O.insertNode(W);
                    q(W);
                    if (!CKEDITOR.env.ie)W.$.normalize();
                }
                O = null;
            }
        }
        L && L.remove();
        A.moveToBookmark(H);
    }

    ;
    function e(A) {
        A.enlarge(CKEDITOR.ENLARGE_ELEMENT);
        var B = A.createBookmark(), C = B.startNode;
        if (A.collapsed) {
            var D = new CKEDITOR.dom.elementPath(C.getParent()), E;
            for (var F = 0, G; F < D.elements.length && (G = D.elements[F]); F++) {
                if (G == D.block || G == D.blockLimit)break;
                if (this.checkElementRemovable(G)) {
                    var H = A.checkBoundaryOfElement(G, CKEDITOR.END), I = !H && A.checkBoundaryOfElement(G, CKEDITOR.START);
                    if (I || H) {
                        E = G;
                        E.match = I ? 'start' : 'end';
                    } else {
                        q(G);
                        m(this, G);
                    }
                }
            }
            if (E) {
                var J = C;
                for (F = 0; true; F++) {
                    var K = D.elements[F];
                    if (K.equals(E))break; else if (K.match)continue; else K = K.clone();
                    K.append(J);
                    J = K;
                }
                J[E.match == 'start' ? 'insertBefore' : 'insertAfter'](E);
            }
        } else {
            var L = B.endNode, M = this;

            function N() {
                var Q = new CKEDITOR.dom.elementPath(C.getParent()), R = new CKEDITOR.dom.elementPath(L.getParent()), S = null, T = null;
                for (var U = 0; U < Q.elements.length; U++) {
                    var V = Q.elements[U];
                    if (V == Q.block || V == Q.blockLimit)break;
                    if (M.checkElementRemovable(V))S = V;
                }
                for (U = 0; U < R.elements.length; U++) {
                    V = R.elements[U];
                    if (V == R.block || V == R.blockLimit)break;
                    if (M.checkElementRemovable(V))T = V;
                }
                if (T)L.breakParent(T);
                if (S)C.breakParent(S);
            }

            ;
            N();
            var O = C.getNext();
            while (!O.equals(L)) {
                var P = O.getNextSourceNode();
                if (O.type == CKEDITOR.NODE_ELEMENT && this.checkElementRemovable(O)) {
                    if (O.getName() == this.element)m(this, O); else o(O, x(this)[O.getName()]);
                    if (P.type == CKEDITOR.NODE_ELEMENT && P.contains(C)) {
                        N();
                        P = C.getNext();
                    }
                }
                O = P;
            }
        }
        A.moveToBookmark(B);
    }

    ;
    function f(A) {
        var B = A.createBookmark(true), C = A.createIterator();
        C.enforceRealBlocks = true;
        var D, E = A.document, F;
        while (D = C.getNextParagraph()) {
            var G = s(this, E);
            g(D, G);
        }
        A.moveToBookmark(B);
    }

    ;
    function g(A, B) {
        var C = B.is('pre'), D = A.is('pre'), E = C && !D, F = !C && D;
        if (E)B = l(A, B); else if (F)B = k(i(A), B); else A.moveChildren(B);
        B.replace(A);
        if (C)h(B);
    }

    ;
    function h(A) {
        var B;
        if (!((B = A.getPreviousSourceNode(true, CKEDITOR.NODE_ELEMENT)) && (B.is && B.is('pre'))))return;
        var C = j(B.getHtml(), /\n$/, '') + '\n\n' + j(A.getHtml(), /^\n/, '');
        if (CKEDITOR.env.ie)A.$.outerHTML = '<pre>' + C + '</pre>'; else A.setHtml(C);
        B.remove();
    }

    ;
    function i(A) {
        var B = /(\S\s*)\n(?:\s|(<span[^>]+_fck_bookmark.*?\/span>))*\n(?!$)/gi, C = A.getName(), D = j(A.getOuterHtml(), B, function (F, G, H) {
            return G + '</pre>' + H + '<pre>';
        }), E = [];
        D.replace(/<pre>([\s\S]*?)<\/pre>/gi, function (F, G) {
            E.push(G);
        });
        return E;
    }

    ;
    function j(A, B, C) {
        var D = '', E = '';
        A = A.replace(/(^<span[^>]+_fck_bookmark.*?\/span>)|(<span[^>]+_fck_bookmark.*?\/span>$)/gi, function (F, G, H) {
            G && (D = G);
            H && (E = H);
            return '';
        });
        return D + A.replace(B, C) + E;
    }

    ;
    function k(A, B) {
        var C = new CKEDITOR.dom.documentFragment(B.getDocument());
        for (var D = 0; D < A.length; D++) {
            var E = A[D];
            E = E.replace(/(\r\n|\r)/g, '\n');
            E = j(E, /^[ \t]*\n/, '');
            E = j(E, /\n$/, '');
            E = j(E, /^[ \t]+|[ \t]+$/g, function (G, H, I) {
                if (G.length == 1)return '&nbsp;'; else if (!H)return CKEDITOR.tools.repeat('&nbsp;', G.length - 1) + ' '; else return ' ' + CKEDITOR.tools.repeat('&nbsp;', G.length - 1);
            });
            E = E.replace(/\n/g, '<br>');
            E = E.replace(/[ \t]{2,}/g, function (G) {
                return CKEDITOR.tools.repeat('&nbsp;', G.length - 1) + ' ';
            });
            var F = B.clone();
            F.setHtml(E);
            C.append(F);
        }
        return C;
    }

    ;
    function l(A, B) {
        var C = A.getHtml();
        C = j(C, /(?:^[ \t\n\r]+)|(?:[ \t\n\r]+$)/g, '');
        C = C.replace(/[ \t\r\n]*(<br[^>]*>)[ \t\r\n]*/gi, '$1');
        C = C.replace(/([ \t\n\r]+|&nbsp;)/g, ' ');
        C = C.replace(/<br\b[^>]*>/gi, '\n');
        if (CKEDITOR.env.ie) {
            var D = A.getDocument().createElement('div');
            D.append(B);
            B.$.outerHTML = '<pre>' + C + '</pre>';
            B = D.getFirst().remove();
        } else B.setHtml(C);
        return B;
    }

    ;
    function m(A, B) {
        var C = A._.definition, D = C.attributes, E = C.styles, F = x(A);

        function G() {
            for (var I in D) {
                if (I == 'class' && B.getAttribute(I) != D[I])continue;
                B.removeAttribute(I);
            }
        }

        ;
        G();
        for (var H in E)B.removeStyle(H);
        D = F[B.getName()];
        if (D)G();
        p(B);
    }

    ;
    function n(A, B) {
        var C = A._.definition, D = C.attributes, E = C.styles, F = x(A), G = B.getElementsByTag(A.element);
        for (var H = G.count(); --H >= 0;)m(A, G.getItem(H));
        for (var I in F)if (I != A.element) {
            G = B.getElementsByTag(I);
            for (H = G.count() - 1; H >= 0; H--) {
                var J = G.getItem(H);
                o(J, F[I]);
            }
        }
    }

    ;
    function o(A, B) {
        var C = B && B.attributes;
        if (C)for (var D = 0; D < C.length; D++) {
            var E = C[D][0], F;
            if (F = A.getAttribute(E)) {
                var G = C[D][1];
                if (G === null || G.test && G.test(F) || typeof G == 'string' && F == G)A.removeAttribute(E);
            }
        }
        p(A);
    }

    ;
    function p(A) {
        if (!A.hasAttributes()) {
            var B = A.getFirst(), C = A.getLast();
            A.remove(true);
            if (B) {
                q(B);
                if (C && !B.equals(C))q(C);
            }
        }
    }

    ;
    function q(A) {
        if (!A || A.type != CKEDITOR.NODE_ELEMENT || !CKEDITOR.dtd.$removeEmpty[A.getName()])return;
        r(A, A.getNext(), true);
        r(A, A.getPrevious());
    }

    ;
    function r(A, B, C) {
        if (B && B.type == CKEDITOR.NODE_ELEMENT) {
            var D = B.getAttribute('_fck_bookmark');
            if (D)B = C ? B.getNext() : B.getPrevious();
            if (B && B.type == CKEDITOR.NODE_ELEMENT && A.isIdentical(B)) {
                var E = C ? A.getLast() : A.getFirst();
                if (D)(C ? B.getPrevious() : B.getNext()).move(A, !C);
                B.moveChildren(A, !C);
                B.remove();
                if (E)q(E);
            }
        }
    }

    ;
    function s(A, B) {
        var C, D = A._.definition, E = A.element;
        if (E == '*')E = 'span';
        C = new CKEDITOR.dom.element(E, B);
        return t(C, A);
    }

    ;
    function t(A, B) {
        var C = B._.definition, D = C.attributes, E = CKEDITOR.style.getStyleText(C);
        if (D)for (var F in D)A.setAttribute(F, D[F]);
        if (E)A.setAttribute('style', E);
        return A;
    }

    ;
    var u = /#\((.+?)\)/g;

    function v(A, B) {
        for (var C in A)A[C] = A[C].replace(u, function (D, E) {
            return B[E];
        });
    }

    ;
    function w(A) {
        var B = A._AC;
        if (B)return B;
        B = {};
        var C = 0, D = A.attributes;
        if (D)for (var E in D) {
            C++;
            B[E] = D[E];
        }
        var F = CKEDITOR.style.getStyleText(A);
        if (F) {
            if (!B.style)C++;
            B.style = F;
        }
        B._length = C;
        return A._AC = B;
    }

    ;
    function x(A) {
        if (A._.overrides)return A._.overrides;
        var B = A._.overrides = {}, C = A._.definition.overrides;
        if (C) {
            if (!CKEDITOR.tools.isArray(C))C = [C];
            for (var D = 0; D < C.length; D++) {
                var E = C[D], F, G, H;
                if (typeof E == 'string')F = E.toLowerCase(); else {
                    F = E.element ? E.element.toLowerCase() : A.element;
                    H = E.attributes;
                }
                G = B[F] || (B[F] = {});
                if (H) {
                    var I = G.attributes = G.attributes || [];
                    for (var J in H)I.push([J.toLowerCase(), H[J]]);
                }
            }
        }
        return B;
    }

    ;
    function y(A, B) {
        var C;
        if (B !== false) {
            var D = new CKEDITOR.dom.element('span');
            D.setAttribute('style', A);
            C = D.getAttribute('style');
        } else C = A;
        return C.replace(/\s*([;:])\s*/, '$1').replace(/([^\s;])$/, '$1;').replace(/,\s+/g, ',').toLowerCase();
    }

    ;
    function z(A, B) {
        var C = A.getSelection(), D = C.getRanges(), E = B ? this.removeFromRange : this.applyToRange;
        for (var F = 0; F < D.length; F++)E.call(this, D[F]);
        C.selectRanges(D);
    }

    ;
})();
CKEDITOR.styleCommand = function (a) {
    this.style = a;
};
CKEDITOR.styleCommand.prototype.exec = function (a) {
    var c = this;
    a.focus();
    var b = a.document;
    if (b)if (c.state == CKEDITOR.TRISTATE_OFF)c.style.apply(b); else if (c.state == CKEDITOR.TRISTATE_ON)c.style.remove(b);
    return!!b;
};
