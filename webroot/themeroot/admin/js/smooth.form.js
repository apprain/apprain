/* this function styles inputs with the type file. It basically replaces browse or choose with a custom button */
(function (jQuery) {
    jQuery.fn.file = function (options) {
        var settings = {
            width:250
        };

        if (options) {
            jQuery.extend(settings, options);
        }

        this.each(function () {
            var self = this;

            var wrapper = jQuery("<a>").attr("class", "ui-input-file");

            var filename = jQuery('<input class="file">').addClass(jQuery(self).attr("class")).css({
                "display":"inline",
                "width":settings.width + "px"
            });

            jQuery(self).before(filename);
            jQuery(self).wrap(wrapper);

            jQuery(self).css({
                "position":"relative",
                "height":settings.image_height + "px",
                "width":settings.width + "px",
                "display":"inline",
                "cursor":"pointer",
                "opacity":"0.0"
            });

            if (jQuery.browser.mozilla) {
                if (/Win/.test(navigator.platform)) {
                    jQuery(self).css("margin-left", "-142px");
                } else {
                    jQuery(self).css("margin-left", "-168px");
                }
                ;
            } else {
                jQuery(self).css("margin-left", settings.image_width - settings.width + "px");
            }
            ;

            jQuery(self).bind("change", function () {
                filename.val(jQuery(self).val());
            });
        });

        return this;
    };
})(jQuery);

jQuery(document).ready(function () {
    jQuery("input.focus, textarea.focus").focus(function () {
        if (this.value == this.defaultValue) {
            this.value = "";
        }
        else {
            this.select();
        }
    });

    jQuery("input.focus, textarea.focus").blur(function () {
        if (jQuery.trim(this.value) == "") {
            this.value = (this.defaultValue ? this.defaultValue : "");
        }
    });

    /* date picker */
    jQuery(".date").datepicker({
        showOn:'both',
        buttonImage:siteInfo.baseUrl + '/themeroot/admin/images/ui/calendar.png',
        buttonImageOnly:true,
        dateFormat:'yy-mm-dd',
        buttonText:"Choose Date"
    });

    /* select styling */
    jQuery(".select").selectmenu({
        style:'dropdown',
        width:300,
        menuWidth:200,
        icons:[
            { find:'.locked', icon:'ui-icon-locked' },
            { find:'.unlocked', icon:'ui-icon-unlocked' },
            { find:'.folder-open', icon:'ui-icon-folder-open' }
        ]
    });

    /* file input styling */
    jQuery("input[type=file]").not('#file_upload').file({
        image_height:28,
        image_width:28,
        width:250
    });

    /* button styling */
    jQuery("input:submit, input:reset, input:button").button();
});