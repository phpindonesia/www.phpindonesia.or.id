/*
 *  Document   : readyInboxCompose.js
 *  Author     : pixelcave
 */
var ReadyInboxCompose = function () {
    return {
        init: function () {
            $("#cc-input-btn").click(function () {
                $("#cc-input").removeClass("display-none").addClass("animation-pullDown"), $(this).fadeOut()
            }), $("#bcc-input-btn").click(function () {
                $("#bcc-input").removeClass("display-none").addClass("animation-pullDown"), $(this).fadeOut()
            })
        }
    }
}();