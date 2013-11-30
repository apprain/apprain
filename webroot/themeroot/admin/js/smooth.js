/* path to the stylesheets for the color picker */
var style_path = "resources/css/colors";

jQuery(document).ready(function () {
    /* messages fade away when dismiss is clicked */
    jQuery(".message > .dismiss > a").click(function (e) {
	    
		if( jQuery(this).closest('.messages').children('.message').length > 1){
			jQuery(this).closest('.message').fadeOut('slow', function(){
				jQuery(this).remove();
			});
		}
		else{
			jQuery(this).closest('.box').fadeOut('slow', function(){});
		}
        return false;
    });


    /* color picker */
    jQuery("#colors-switcher > a").click(function () {
        var style = jQuery("#color");

        style.attr("href", "" + style_path + "/" + jQuery(this).attr("title").toLowerCase() + ".css");

        return false;
    });

    jQuery("#menu h6 a").click(function () {
        var link = jQuery(this);
        var value = link.attr("href");
        var id = value.substring(value.indexOf('#') + 1);

        var heading = jQuery("#h-menu-" + id);
        var list = jQuery("#menu-" + id);

        if (list.attr("class") == "closed") {
            heading.attr("class", "selected");
            list.attr("class", "opened");
        } else {
            heading.attr("class", "");
            list.attr("class", "closed");
        }
    });

    jQuery("#menu li a[class~=collapsible]").click(function () {
        var element = jQuery(this);

        if (element.attr("class") == "collapsible plus") {
            element.attr("class", "collapsible minus");
        } else {
            element.attr("class", "collapsible plus");
        }

        var list = element.next();

        if (list.attr("class") == "collapsed") {
            list.attr("class", "expanded");
        } else {
            list.attr("class", "collapsed");
        }
    });
});