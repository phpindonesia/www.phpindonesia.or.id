/*
 *  Document   : uiProgress.js
 *  Author     : pixelcave
 */
var UiProgress = function () {
    var r = function (r, t) {
        return Math.floor(Math.random() * (t - r + 1)) + r
    };
    return {
        init: function () {
            var t = 0;
            $(".toggle-bars").click(function () {
                $(".progress-bar", ".bars-container").each(function () {
                    t = r(10, 100) + "%", $(this).css("width", t).html(t)
                }), $(".progress-bar", ".bars-stacked-container").each(function () {
                    t = r(10, 25) + "%", $(this).css("width", t).html(t)
                })
            })
        }
    }
}();