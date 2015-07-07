/*
 *  Document   : readyProfile.js
 *  Author     : pixelcave
 */
var ReadyProfile = function () {
    return {
        init: function () {
            var a = $("#newsfeed-update-example");
            setTimeout(function () {
                a.removeClass("display-none").find("> a").addClass("animation-fadeIn"), a.find("> div").addClass("animation-pullDown")
            }, 1500), $(".gmap").css("height", "200px"), new GMaps({
                div: "#gmap-checkin",
                lat: -33.863,
                lng: 151.217,
                zoom: 15,
                disableDefaultUI: !0,
                scrollwheel: !1
            }).addMarkers([{
                lat: -33.865,
                lng: 151.215,
                title: "Marker #2",
                animation: google.maps.Animation.DROP,
                infoWindow: {
                    content: "<strong>Cafe-Bar: Example Address</strong>"
                }
            }])
        }
    }
}();