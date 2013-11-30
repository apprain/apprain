﻿/*
 Copyright (c) 2003-2009, CKSource - Frederico Knabben. All rights reserved.
 For licensing, see LICENSE.html or http://ckeditor.com/license
 */

CKEDITOR.dialog.add('scaytcheck', function (a) {
    var b = true, c, d = CKEDITOR.document, e = [], f, g = [], h = false, i = ['dic_create,dic_restore', 'dic_rename,dic_delete'], j = [
        {id:'options', label:a.lang.scayt.optionsTab, elements:[
            {type:'html', id:'options', html:'<div class="inner_options">\t<div class="messagebox"></div>\t<div style="display:none;">\t\t<input type="checkbox" value="0" id="allCaps" />\t\t<label for="allCaps" id="label_allCaps"></label>\t</div>\t<div style="display:none;">\t\t<input type="checkbox" value="0" id="ignoreDomainNames" />\t\t<label for="ignoreDomainNames" id="label_ignoreDomainNames"></label>\t</div>\t<div style="display:none;">\t<input type="checkbox" value="0" id="mixedCase" />\t\t<label for="mixedCase" id="label_mixedCase"></label>\t</div>\t<div style="display:none;">\t\t<input type="checkbox" value="0" id="mixedWithDigits" />\t\t<label for="mixedWithDigits" id="label_mixedWithDigits"></label>\t</div></div>'}
        ]},
        {id:'langs', label:a.lang.scayt.languagesTab, elements:[
            {type:'html', id:'langs', html:'<div class="inner_langs">\t<div class="messagebox"></div>\t   <div style="float:left;width:47%;margin-left:5px;" id="scayt_lcol" ></div>   <div style="float:left;width:47%;margin-left:15px;" id="scayt_rcol"></div></div>'}
        ]},
        {id:'dictionaries', label:a.lang.scayt.dictionariesTab, elements:[
            {type:'html', style:'', id:'dic', html:'<div class="inner_dictionary" style="text-align:left; white-space:normal;">\t<div style="margin:5px auto; width:80%;white-space:normal; overflow:hidden;" id="dic_message"> </div>\t<div style="margin:5px auto; width:80%;white-space:normal;">        <span class="cke_dialog_ui_labeled_label" >Dictionary name</span><br>\t\t<span class="cke_dialog_ui_labeled_content" >\t\t\t<div class="cke_dialog_ui_input_text">\t\t\t\t<input id="dic_name" type="text" class="cke_dialog_ui_input_text"/>\t\t</div></span></div>\t\t<div style="margin:5px auto; width:80%;white-space:normal;">\t\t\t<a style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_create">\t\t\t\t</a>\t\t\t<a  style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_delete">\t\t\t\t</a>\t\t\t<a  style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_rename">\t\t\t\t</a>\t\t\t<a  style="display:none;" class="cke_dialog_ui_button" href="javascript:void(0)" id="dic_restore">\t\t\t\t</a>\t\t</div>\t<div style="margin:5px auto; width:95%;white-space:normal;" id="dic_info"></div></div>'}
        ]},
        {id:'about', label:a.lang.scayt.aboutTab, elements:[
            {type:'html', id:'about', style:'margin: 10px 40px;', html:'<div id="scayt_about"></div>'}
        ]}
    ], k = {title:a.lang.scayt.title, minWidth:340, minHeight:200, onShow:function () {
        var u = this;
        u.data = a.fire('scaytDialog', {});
        u.options = u.data.scayt_control.option();
        u.sLang = u.data.scayt_control.sLang;
        if (!u.data || !u.data.scayt || !u.data.scayt_control) {
            alert('Error loading application service');
            u.hide();
            return;
        }
        var v = 0;
        if (b)u.data.scayt.getCaption('en', function (w) {
            if (v++ > 0)return;
            c = w;
            n.apply(u);
            o.apply(u);
            b = false;
        }); else o.apply(u);
        u.selectPage(u.data.tab);
    }, onOk:function () {
        var z = this;
        var u = z.data.scayt_control, v = u.option(), w = 0;
        for (var x in z.options)if (v[x] != z.options[x] && w === 0) {
            u.option(z.options);
            w++;
        }
        var y = z.chosed_lang;
        if (y && z.data.sLang != y) {
            u.setLang(y);
            w++;
        }
        if (w > 0)u.refresh();
    }, contents:g}, l = CKEDITOR.plugins.scayt.getScayt(a);
    if (l)e = l.uiTags;
    for (f in e)if (e[f] == 1)g[g.length] = j[f];
    if (e[2] == 1)h = true;
    function m() {
        var u = d.getById('dic_name').getValue();
        if (!u) {
            p(' Dictionary name should not be empty. ');
            return false;
        }
        window.dic[this.getId()].apply(null, [this, u, i]);
        return true;
    }

    ;
    var n = function () {
        var u = this, v = u.data.scayt.getLangList(), w = ['dic_create', 'dic_delete', 'dic_rename', 'dic_restore'], x = ['mixedCase', 'mixedWithDigits', 'allCaps', 'ignoreDomainNames'], y;
        if (h) {
            for (y in w) {
                var z = w[y];
                d.getById(z).setHtml('<span class="cke_dialog_ui_button">' + c['button_' + z] + '</span>');
            }
            d.getById('dic_info').setHtml(c.dic_info);
        }
        for (y in x) {
            var A = 'label_' + x[y], B = d.getById(A);
            if ('undefined' != typeof B && 'undefined' != typeof c[A] && 'undefined' != typeof u.options[x[y]]) {
                B.setHtml(c[A]);
                var C = B.getParent();
                C.$.style.display = 'block';
            }
        }
        var D = '<p>' + c.about_throwt_image + '</p>' + '<p>' + c.version + u.data.scayt.version.toString() + '</p>' + '<p>' + c.about_throwt_copy + '</p>';
        d.getById('scayt_about').setHtml(D);
        var E = function (N, O) {
            var P = d.createElement('label');
            P.setAttribute('for', 'cke_option' + N);
            P.setHtml(O[N]);
            if (u.sLang == N)u.chosed_lang = N;
            var Q = d.createElement('div'), R = CKEDITOR.dom.element.createFromHtml('<input id="cke_option' + N + '" type="radio" ' + (u.sLang == N ? 'checked="checked"' : '') + ' value="' + N + '" name="scayt_lang" />');
            R.on('click', function () {
                this.$.checked = true;
                u.chosed_lang = N;
            });
            Q.append(R);
            Q.append(P);
            return{lang:O[N], code:N, radio:Q};
        }, F = [];
        for (y in v.rtl)F[F.length] = E(y, v.ltr);
        for (y in v.ltr)F[F.length] = E(y, v.ltr);
        F.sort(function (N, O) {
            return O.lang > N.lang ? -1 : 1;
        });
        var G = d.getById('scayt_lcol'), H = d.getById('scayt_rcol');
        for (y = 0; y < F.length; y++) {
            var I = y < F.length / 2 ? G : H;
            I.append(F[y].radio);
        }
        var J = {};
        J.dic_create = function (N, O, P) {
            var Q = P[0] + ',' + P[1], R = c.err_dic_create, S = c.succ_dic_create;
            window.scayt.createUserDictionary(O, function (T) {
                s(Q);
                r(P[1]);
                S = S.replace('%s', T.dname);
                q(S);
            }, function (T) {
                R = R.replace('%s', T.dname);
                p(R + '( ' + (T.message || '') + ')');
            });
        };
        J.dic_rename = function (N, O) {
            var P = c.err_dic_rename || '', Q = c.succ_dic_rename || '';
            window.scayt.renameUserDictionary(O, function (R) {
                Q = Q.replace('%s', R.dname);
                t(O);
                q(Q);
            }, function (R) {
                P = P.replace('%s', R.dname);
                t(O);
                p(P + '( ' + (R.message || '') + ' )');
            });
        };
        J.dic_delete = function (N, O, P) {
            var Q = P[0] + ',' + P[1], R = c.err_dic_delete, S = c.succ_dic_delete;
            window.scayt.deleteUserDictionary(function (T) {
                S = S.replace('%s', T.dname);
                s(Q);
                r(P[0]);
                t('');
                q(S);
            }, function (T) {
                R = R.replace('%s', T.dname);
                p(R);
            });
        };
        J.dic_restore = u.dic_restore || (function (N, O, P) {
            var Q = P[0] + ',' + P[1], R = c.err_dic_restore, S = c.succ_dic_restore;
            window.scayt.restoreUserDictionary(O, function (T) {
                S = S.replace('%s', T.dname);
                s(Q);
                r(P[1]);
                q(S);
            }, function (T) {
                R = R.replace('%s', T.dname);
                p(R);
            });
        });
        var K = (i[0] + ',' + i[1]).split(','), L;
        for (y = 0, L = K.length; y < L; y += 1) {
            var M = d.getById(K[y]);
            if (M)M.on('click', m, this);
        }
    }, o = function () {
        var u = this;
        for (var v in u.options) {
            var w = d.getById(v);
            if (w) {
                w.removeAttribute('checked');
                if (u.options[v] == 1)w.setAttribute('checked', 'checked');
                if (b)w.on('click', function () {
                    u.options[this.getId()] = this.$.checked ? 1 : 0;
                });
            }
        }
        if (h) {
            window.scayt.getNameUserDictionary(function (x) {
                var y = x.dname;
                if (y) {
                    d.getById('dic_name').setValue(y);
                    r(i[1]);
                } else r(i[0]);
            }, function () {
                d.getById('dic_name').setValue('');
            });
            q('');
        }
    };

    function p(u) {
        d.getById('dic_message').setHtml('<span style="color:red;">' + u + '</span>');
    }

    ;
    function q(u) {
        d.getById('dic_message').setHtml('<span style="color:blue;">' + u + '</span>');
    }

    ;
    function r(u) {
        u = String(u);
        var v = u.split(',');
        for (var w = 0, x = v.length; w < x; w += 1)d.getById(v[w]).$.style.display = 'inline';
    }

    ;
    function s(u) {
        u = String(u);
        var v = u.split(',');
        for (var w = 0, x = v.length; w < x; w += 1)d.getById(v[w]).$.style.display = 'none';
    }

    ;
    function t(u) {
        d.getById('dic_name').$.value = u;
    }

    ;
    return k;
});
