/*
 Kriesi (http://themeforest.net/user/Kriesi)
 http://www.kriesi.at/archives/create-a-multilevel-dropdown-menu-with-css-and-improve-it-via-jquery
 */

function quick() {
    jQuery("#quick ul ").css({ display:"none" });
    jQuery("#quick li").hover(function () {
        jQuery(this).find('ul:first').css({visibility:"visible", display:"none"}).show(400);
    }, function () {
        jQuery(this).find('ul:first').css({ visibility:"hidden" });
    });
}

jQuery(document).ready(function () {
    quick();
});