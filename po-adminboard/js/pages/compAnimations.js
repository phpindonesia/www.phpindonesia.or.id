/*
 *  Document   : compAnimations.js
 *  Author     : pixelcave
 */
var CompAnimations = function () {
    return {
        init: function () {
            var a = $(".animation-page-buttons .btn"),
                t = $(".animation-buttons .btn"),
                i = "";
            a.click(function () {
                a.removeClass("active"), $(this).addClass("active"), i = $(this).data("animation"), $("body").removeClass().addClass(i), $("#animation-page-class").text(i)
            }), t.click(function () {
                t.removeClass("active"), $(this).addClass("active"), i = $(this).data("animation"), $("#animation-element").removeClass().addClass(i), $("#animation-class").text(i)
            })
        }
    }
}();