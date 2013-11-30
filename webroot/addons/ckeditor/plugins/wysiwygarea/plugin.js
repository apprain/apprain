﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

(function () {
    var a = {table:1, pre:1}, b = /\s*<(p|div|address|h\d|center)[^>]*>\s*(?:<br[^>]*>|&nbsp;|&#160;)\s*(:?<\/\1>)?\s*$/gi;

    function c(g) {
        var l = this;
        if (l.mode == 'wysiwyg') {
            l.focus();
            var h = l.getSelection(), i = g.data;
            if (l.dataProcessor)i = l.dataProcessor.toHtml(i);
            if (CKEDITOR.env.ie) {
                var j = h.isLocked;
                if (j)h.unlock();
                var k = h.getNative();
                if (k.type == 'Control')k.clear();
                k.createRange().pasteHTML(i);
                if (j)l.getSelection().lock();
            } else l.document.$.execCommand('inserthtml', false, i);
        }
    }

    ;
    function d(g) {
        if (this.mode == 'wysiwyg') {
            this.focus();
            this.fire('saveSnapshot');
            var h = g.data, i = h.getName(), j = CKEDITOR.dtd.$block[i], k = this.getSelection(), l = k.getRanges(), m = k.isLocked;
            if (m)k.unlock();
            var n, o, p, q;
            for (var r = l.length - 1; r >= 0; r--) {
                n = l[r];
                n.deleteContents();
                o = !r && h || h.clone(true);
                var s, t;
                if (j)while ((s = n.getCommonAncestor(false, true)) && ((t = CKEDITOR.dtd[s.getName()]) && (!(t && t[i]))))if (n.checkStartOfBlock() && n.checkEndOfBlock()) {
                    n.setStartBefore(s);
                    n.collapse(true);
                    s.remove();
                } else n.splitBlock();
                n.insertNode(o);
                if (!p)p = o;
            }
            n.moveToPosition(p, CKEDITOR.POSITION_AFTER_END);
            var u = p.getNextSourceNode(true);
            if (u && u.type == CKEDITOR.NODE_ELEMENT)n.moveToElementEditStart(u);
            k.selectRanges([n]);
            if (m)this.getSelection().lock();
            CKEDITOR.tools.setTimeout(function () {
                this.fire('saveSnapshot');
            }, 0, this);
        }
    }

    ;
    function e(g) {
        if (!g.checkDirty())setTimeout(function () {
            g.resetDirty();
        });
    }

    ;
    function f(g) {
        var h = g.editor, i = g.data.path, j = i.blockLimit, k = g.data.selection, l = k.getRanges()[0], m = h.document.getBody(), n = h.config.enterMode;
        if (n != CKEDITOR.ENTER_BR && l.collapsed && j.getName() == 'body' && !i.block) {
            e(h);
            var o = k.createBookmarks(), p = l.fixBlock(true, h.config.enterMode == CKEDITOR.ENTER_DIV ? 'div' : 'p');
            if (CKEDITOR.env.ie) {
                var q = p.getElementsByTag('br'), r;
                for (var s = 0; s < q.count(); s++)if ((r = q.getItem(s)) && (r.hasAttribute('_cke_bogus')))r.remove();
            }
            k.selectBookmarks(o);
            var t = p.getChildren(), u = t.count(), v, w = CKEDITOR.dom.walker.whitespaces(true), x = p.getPrevious(w), y = p.getNext(w), z;
            if (x && x.getName && !(x.getName() in a))z = x; else if (y && y.getName && !(y.getName() in a))z = y;
            if ((!u || (v = t.getItem(0)) && (v.is && v.is('br'))) && (z && l.moveToElementEditStart(z))) {
                p.remove();
                l.select();
            }
        }
        var A = m.getLast(CKEDITOR.dom.walker.whitespaces(true));
        if (A && A.getName && A.getName() in a) {
            e(h);
            var B = h.document.createElement(CKEDITOR.env.ie && n != CKEDITOR.ENTER_BR ? '<br _cke_bogus="true" />' : 'br');
            m.append(B);
        }
    }

    ;
    CKEDITOR.plugins.add('wysiwygarea', {requires:['editingblock'], init:function (g) {
        var h = g.config.enterMode != CKEDITOR.ENTER_BR ? g.config.enterMode == CKEDITOR.ENTER_DIV ? 'div' : 'p' : false;
        g.on('editingBlockReady', function () {
            var i, j, k, l, m, n, o, p = CKEDITOR.env.isCustomDomain(), q = function () {
                if (k)k.remove();
                if (j)j.remove();
                n = 0;
                var t = 'void( ' + (CKEDITOR.env.gecko ? 'setTimeout' : '') + '( function(){' + 'document.open();' + (CKEDITOR.env.ie && p ? 'document.domain="' + document.domain + '";' : '') + 'document.write( window.parent[ "_cke_htmlToLoad_' + g.name + '" ] );' + 'document.close();' + 'window.parent[ "_cke_htmlToLoad_' + g.name + '" ] = null;' + '}' + (CKEDITOR.env.gecko ? ', 0 )' : ')()') + ' )';
                if (CKEDITOR.env.opera)t = 'void(0);';
                k = CKEDITOR.dom.element.createFromHtml('<iframe style="width:100%;height:100%" frameBorder="0" tabIndex="-1" allowTransparency="true" src="javascript:' + encodeURIComponent(t) + '"' + '></iframe>');
                var u = g.lang.editorTitle.replace('%1', g.name);
                if (CKEDITOR.env.gecko) {
                    k.on('load', function (v) {
                        v.removeListener();
                        s(k.$.contentWindow);
                    });
                    i.setAttributes({role:'region', title:u});
                    k.setAttributes({role:'region', title:' '});
                } else if (CKEDITOR.env.webkit) {
                    k.setAttribute('title', u);
                    k.setAttribute('name', u);
                } else if (CKEDITOR.env.ie) {
                    j = CKEDITOR.dom.element.createFromHtml('<fieldset style="height:100%' + (CKEDITOR.env.ie && CKEDITOR.env.quirks ? ';position:relative' : '') + '">' + '<legend style="display:block;width:0;height:0;overflow:hidden;' + (CKEDITOR.env.ie && CKEDITOR.env.quirks ? 'position:absolute' : '') + '">' + CKEDITOR.tools.htmlEncode(u) + '</legend>' + '</fieldset>', CKEDITOR.document);
                    k.appendTo(j);
                    j.appendTo(i);
                }
                if (!CKEDITOR.env.ie)i.append(k);
            }, r = '<script id="cke_actscrpt" type="text/javascript">window.onload = function(){window.parent.CKEDITOR._["contentDomReady' + g.name + '"]( window );' + '}' + '</script>', s = function (t) {
                if (n)return;
                n = 1;
                var u = t.document, v = u.body, w = u.getElementById('cke_actscrpt');
                w.parentNode.removeChild(w);
                delete CKEDITOR._['contentDomReady' + g.name];
                v.spellcheck = !g.config.disableNativeSpellChecker;
                if (CKEDITOR.env.ie) {
                    v.hideFocus = true;
                    v.disabled = true;
                    v.contentEditable = true;
                    v.removeAttribute('disabled');
                } else u.designMode = 'on';
                try {
                    u.execCommand('enableObjectResizing', false, !g.config.disableObjectResizing);
                } catch (z) {
                }
                try {
                    u.execCommand('enableInlineTableEditing', false, !g.config.disableNativeTableHandles);
                } catch (A) {
                }
                t = g.window = new CKEDITOR.dom.window(t);
                u = g.document = new CKEDITOR.dom.document(u);
                if (!(CKEDITOR.env.ie || CKEDITOR.env.opera))u.on('mousedown', function (B) {
                    var C = B.data.getTarget();
                    if (C.is('img', 'hr', 'input', 'textarea', 'select'))g.getSelection().selectElement(C);
                });
                if (CKEDITOR.env.webkit) {
                    u.on('click', function (B) {
                        if (B.data.getTarget().is('input', 'select'))B.data.preventDefault();
                    });
                    u.on('mouseup', function (B) {
                        if (B.data.getTarget().is('input', 'textarea'))B.data.preventDefault();
                    });
                }
                var x = CKEDITOR.env.ie || CKEDITOR.env.webkit ? t : u;
                x.on('blur', function () {
                    g.focusManager.blur();
                });
                x.on('focus', function () {
                    if (CKEDITOR.env.gecko) {
                        var B = v;
                        while (B.firstChild)B = B.firstChild;
                        if (!B.nextSibling && 'BR' == B.tagName && B.hasAttribute('_moz_editor_bogus_node')) {
                            var C = u.$.createEvent('KeyEvents');
                            C.initKeyEvent('keypress', true, true, t.$, false, false, false, false, 0, 32);
                            u.$.dispatchEvent(C);
                            var D = u.getBody().getFirst();
                            if (g.config.enterMode == CKEDITOR.ENTER_BR)u.createElement('br', {attributes:{_moz_dirty:''}}).replace(D); else D.remove();
                        }
                    }
                    g.focusManager.focus();
                });
                var y = g.keystrokeHandler;
                if (y)y.attach(u);
                if (CKEDITOR.env.ie)g.on('key', function (B) {
                    var C = B.data.keyCode == 8 && g.getSelection().getSelectedElement();
                    if (C) {
                        g.fire('saveSnapshot');
                        C.remove();
                        g.fire('saveSnapshot');
                        B.cancel();
                    }
                });
                if (g.contextMenu)g.contextMenu.addTarget(u);
                setTimeout(function () {
                    g.fire('contentDom');
                    if (o) {
                        g.mode = 'wysiwyg';
                        g.fire('mode');
                        o = false;
                    }
                    l = false;
                    if (m) {
                        g.focus();
                        m = false;
                    }
                    setTimeout(function () {
                        g.fire('dataReady');
                    }, 0);
                    if (CKEDITOR.env.ie)setTimeout(function () {
                        if (g.document) {
                            var B = g.document.$.body;
                            B.runtimeStyle.marginBottom = '0px';
                            B.runtimeStyle.marginBottom = '';
                        }
                    }, 1000);
                }, 0);
            };
            g.addMode('wysiwyg', {load:function (t, u, v) {
                i = t;
                if (CKEDITOR.env.ie && CKEDITOR.env.quirks)t.setStyle('position', 'relative');
                g.mayBeDirty = true;
                o = true;
                if (v)this.loadSnapshotData(u); else this.loadData(u);
            }, loadData:function (t) {
                l = true;
                if (g.dataProcessor)t = g.dataProcessor.toHtml(t, h);
                t = g.config.docType + '<html dir="' + g.config.contentsLangDirection + '">' + '<head>' + '<link type="text/css" rel="stylesheet" href="' + [].concat(g.config.contentsCss).join('"><link type="text/css" rel="stylesheet" href="') + '">' + '<style type="text/css" _fcktemp="true">' + g._.styles.join('\n') + '</style>' + '</head>' + '<body>' + t + '</body>' + '</html>' + r;
                window['_cke_htmlToLoad_' + g.name] = t;
                CKEDITOR._['contentDomReady' + g.name] = s;
                q();
                if (CKEDITOR.env.opera) {
                    var u = k.$.contentWindow.document;
                    u.open();
                    u.write(t);
                    u.close();
                }
            }, getData:function () {
                var t = k.getFrameDocument().getBody().getHtml();
                if (g.dataProcessor)t = g.dataProcessor.toDataFormat(t, h);
                if (g.config.ignoreEmptyParagraph)t = t.replace(b, '');
                return t;
            }, getSnapshotData:function () {
                return k.getFrameDocument().getBody().getHtml();
            }, loadSnapshotData:function (t) {
                k.getFrameDocument().getBody().setHtml(t);
            }, unload:function (t) {
                g.window = g.document = k = i = m = null;
                g.fire('contentDomUnload');
            }, focus:function () {
                if (l)m = true; else if (g.window) {
                    g.window.focus();
                    g.selectionChange();
                }
            }});
            g.on('insertHtml', c, null, null, 20);
            g.on('insertElement', d, null, null, 20);
            g.on('selectionChange', f, null, null, 1);
        });
    }});
})();
CKEDITOR.config.disableObjectResizing = false;
CKEDITOR.config.disableNativeTableHandles = true;
CKEDITOR.config.disableNativeSpellChecker = true;
CKEDITOR.config.ignoreEmptyParagraph = true;
