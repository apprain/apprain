﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.plugins.add('keystrokes', {beforeInit:function (a) {
    a.keystrokeHandler = new CKEDITOR.keystrokeHandler(a);
    a.specialKeys = {};
}, init:function (a) {
    var b = a.config.keystrokes, c = a.config.blockedKeystrokes, d = a.keystrokeHandler.keystrokes, e = a.keystrokeHandler.blockedKeystrokes;
    for (var f = 0; f < b.length; f++)d[b[f][0]] = b[f][1];
    for (f = 0; f < c.length; f++)e[c[f]] = 1;
}});
CKEDITOR.keystrokeHandler = function (a) {
    var b = this;
    if (a.keystrokeHandler)return a.keystrokeHandler;
    b.keystrokes = {};
    b.blockedKeystrokes = {};
    b._ = {editor:a};
    return b;
};
(function () {
    var a, b = function (d) {
        d = d.data;
        var e = d.getKeystroke(), f = this.keystrokes[e], g = this._.editor;
        a = g.fire('key', {keyCode:e}) === true;
        if (!a) {
            if (f) {
                var h = {from:'keystrokeHandler'};
                a = g.execCommand(f, h) !== false;
            }
            if (!a) {
                var i = g.specialKeys[e];
                a = i && i(g) === true;
                if (!a)a = !!this.blockedKeystrokes[e];
            }
        }
        if (a)d.preventDefault(true);
        return!a;
    }, c = function (d) {
        if (a) {
            a = false;
            d.data.preventDefault(true);
        }
    };
    CKEDITOR.keystrokeHandler.prototype = {attach:function (d) {
        d.on('keydown', b, this);
        if (CKEDITOR.env.opera || CKEDITOR.env.gecko && CKEDITOR.env.mac)d.on('keypress', c, this);
    }};
})();
CKEDITOR.config.blockedKeystrokes = [CKEDITOR.CTRL + 66, CKEDITOR.CTRL + 73, CKEDITOR.CTRL + 85];
CKEDITOR.config.keystrokes = [
    [CKEDITOR.ALT + 121, 'toolbarFocus'],
    [CKEDITOR.ALT + 122, 'elementsPathFocus'],
    [CKEDITOR.SHIFT + 121, 'contextMenu'],
    [CKEDITOR.CTRL + CKEDITOR.SHIFT + 121, 'contextMenu'],
    [CKEDITOR.CTRL + 90, 'undo'],
    [CKEDITOR.CTRL + 89, 'redo'],
    [CKEDITOR.CTRL + CKEDITOR.SHIFT + 90, 'redo'],
    [CKEDITOR.CTRL + 76, 'link'],
    [CKEDITOR.CTRL + 66, 'bold'],
    [CKEDITOR.CTRL + 73, 'italic'],
    [CKEDITOR.CTRL + 85, 'underline'],
    [CKEDITOR.ALT + 109, 'toolbarCollapse']
];