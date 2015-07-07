/*
 *  Document   : readyInbox.js
 *  Author     : pixelcave
 */
var ReadyInbox = function () {
    return {
        init: function () {
            var t = "active";
            $("thead input:checkbox").click(function () {
                var c = $(this).prop("checked"),
                    s = $(this).closest("table");
                c ? $("tbody tr", s).addClass(t) : $("tbody tr", s).removeClass(t), $("tbody input:checkbox", s).each(function () {
                    $(this).prop("checked", c)
                })
            }), $("tbody input:checkbox").click(function () {
                var c = $(this).prop("checked"),
                    s = $(this).closest("tr");
                c ? s.addClass(t) : s.removeClass(t)
            }), $(".msg-fav-btn").click(function () {
                $(this).toggleClass("text-muted text-warning"), $("i", this).toggleClass("fa-star-o fa-star")
            }), $(".msg-read-btn").click(function () {
                $(this).toggleClass("text-muted text-success")
            })
        }
    }
}();