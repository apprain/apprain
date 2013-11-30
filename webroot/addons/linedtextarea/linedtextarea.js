/**
 * appRain CMF
 *
 * LICENSE
 *
 * This source file is subject to the MIT license that is bundled
 * with this package in the file LICENSE.txt.
 * It is also available through the world-wide-web at this URL:
 * http://www.opensource.org/licenses/mit-license.php
 * If you did not receive a copy of the license and are unable to
 * obtain it through the world-wide-web, please send an email
 * to license@apprain.com so we can send you a copy immediately.
 *
 * @copyright  Copyright (c) 2010 appRain, Team. (http://www.apprain.com)
 * @license    http://www.opensource.org/licenses/mit-license.php MIT license
 *
 * HELP
 *
 * Official Website
 * http://www.apprain.com/
 *
 * Download Link
 * http://www.apprain.com/download
 *
 * Documents Link
 * http ://www.apprain.com/docs
 *
 * DEVELOPER
 * jQuery Lined Textarea Plugin
 *   http://alan.blog-city.com/jquerylinedtextarea.htm
 *
 * Copyright (c) 2010 Alan Williamson
 *
 * VERSION:
 *    $Id: jquery-linedtextarea.js 464 2010-01-08 10:36:33Z alan $
 *
 * USAGE:
 *   Displays a line number count column to the left of the textarea
 *
 *   Class up your textarea with a given class, or target it directly
 *   with JQuery Selectors
 *
 *   $(".lined").linedtextarea({
 *       selectedLine: 10,
 *    selectedClass: 'lineselect'
 *   });
 *
 */
(function ($) {

    $.fn.linedtextarea = function (options) {

        // Get the Options
        var opts = $.extend({}, $.fn.linedtextarea.defaults, options);


        /*
         * Helper function to make sure the line numbers are always
         * kept up to the current system
         */
        var fillOutLines = function (codeLines, h, lineNo) {
            while ((codeLines.height() - h ) <= 0) {
                if (lineNo == opts.selectedLine)
                    codeLines.append("<div class='lineno'>" + lineNo + "</div>");
                else
                    codeLines.append("<div class='lineno'>" + lineNo + "</div>");

                lineNo++;
            }
            return lineNo;
        };


        /*
         * Iterate through each of the elements are to be applied to
         */
        return this.each(function () {
            var lineNo = 1;
            var textarea = $(this);

            /* Turn off the wrapping of as we don't want to screw up the line numbers */
            textarea.attr("wrap", "off");
            textarea.css({resize:'none'});
            var originalTextAreaWidth = parseInt(jQuery('#header').css('width'))-(280);

            /* Wrap the text area in the elements we need */
            textarea.wrap("<div class='linedtextarea'></div>");
            var linedTextAreaDiv = textarea.parent().wrap("<div class='linedwrap' style='width:" + originalTextAreaWidth + "px'></div>");
            var linedWrapDiv = linedTextAreaDiv.parent();

            linedWrapDiv.prepend("<div class='lines' style='width:40px'></div>");

            var linesDiv = linedWrapDiv.find(".lines");
            linesDiv.height(textarea.height() + 6);


            /* Draw the number bar; filling it out where necessary */
            linesDiv.append("<div class='codelines'></div>");
            var codeLinesDiv = linesDiv.find(".codelines");
            lineNo = fillOutLines(codeLinesDiv, linesDiv.height(), 1);

            /* Move the textarea to the selected line */
            if (opts.selectedLine != -1 && !isNaN(opts.selectedLine)) {
                var fontSize = parseInt(textarea.height() / (lineNo - 2));
                var position = parseInt(fontSize * opts.selectedLine) - (textarea.height() / 2);
                textarea[0].scrollTop = position;
            }


            /* Set the width */
            var sidebarWidth = linesDiv.outerWidth();
            var paddingHorizontal = parseInt(linedWrapDiv.css("border-left-width")) + parseInt(linedWrapDiv.css("border-right-width")) + parseInt(linedWrapDiv.css("padding-left")) + parseInt(linedWrapDiv.css("padding-right"));
            var linedWrapDivNewWidth = originalTextAreaWidth - paddingHorizontal;
            var textareaNewWidth = originalTextAreaWidth - sidebarWidth - paddingHorizontal - 20;

            textarea.width(textareaNewWidth);
            linedWrapDiv.width(linedWrapDivNewWidth);


            /* React to the scroll event */
            textarea.scroll(function (tn) {
                var domTextArea = $(this)[0];
                var scrollTop = domTextArea.scrollTop;
                var clientHeight = domTextArea.clientHeight;
                codeLinesDiv.css({'margin-top':(-1 * scrollTop) + "px"});
                lineNo = fillOutLines(codeLinesDiv, scrollTop + clientHeight, lineNo);
            });


            /* Should the textarea get resized outside of our control */
            textarea.resize(function (tn) {
                var domTextArea = $(this)[0];
                linesDiv.height(domTextArea.clientHeight + 6);
            });

        });
    };

    // default options
    $.fn.linedtextarea.defaults = {
        selectedLine:-1,
        selectedClass:'lineselect'
    };
})(jQuery);