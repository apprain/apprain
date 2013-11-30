/* sets the class of the tr containing the checked checkbox to selected */
function set_tr_class(element, selected) {
    /*if (selected) {
        element.attr("class", "selected " + element.attr("class"))
    } else {
        var css = element.attr("class");
        var position = css.indexOf('selected');

        element.attr("class", css.substring(position + 9));
    }*/
}

jQuery(document).ready(function () {
    /* checks all the checkboxes within a table */
    jQuery("table input[class=checkall]").live("click", function (event) {
        var checked = jQuery(this).attr("checked");

        jQuery("table input[type=checkbox]").each(function () {
            this.checked = checked;

            if (checked) {
                set_tr_class(jQuery(this).parent().parent(), true);
            } else {
                set_tr_class(jQuery(this).parent().parent(), false);
            }
        });
    });

    /* sets the class of the table tr when a checkbox within the table is checked */
    jQuery("table input[type=checkbox]").live("click", function (event) {
        if (jQuery(this).attr("checked")) {
            set_tr_class(jQuery(this).parent().parent(), true);
        } else {
            set_tr_class(jQuery(this).parent().parent(), false);
        }
    });
});