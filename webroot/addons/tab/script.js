var appTab = {
    index:0,
    headTag:'.app-tab-head .tab',
    tabs:'.app-tab-pan li',
    headCollection:null,
    panCollection:null,
    settab:function () {
        appTab.headCollection.each(function (k, o) {
            if (k == appTab.index) {
                jQuery(appTab.panCollection[k]).css('display', 'block');
                jQuery(o).addClass('tab-selected')
            }
            else {
                jQuery(o).removeClass('tab-selected')
                jQuery(appTab.panCollection[k]).css('display', 'none');
            }
        });
    },
    chageTab:function () {
        var index = 0;

        var this_text = jQuery(this).text();
        var parent = jQuery(this).closest('ul');
        var childrent = parent.children('li');

        childrent.each(function (j, i) {
            if (jQuery(i).text() == this_text) appTab.index = j;
        });
        appTab.settab();
    },
    init:function (e) {
        appTab.headCollection = jQuery(appTab.headTag);
        appTab.panCollection = jQuery(appTab.tabs);

        jQuery(appTab.headTag).click(appTab.chageTab);

        appTab.settab();
    }
}
jQuery(document).ready(appTab.init);
