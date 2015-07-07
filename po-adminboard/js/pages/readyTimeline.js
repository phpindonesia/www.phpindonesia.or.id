/*
 *  Document   : readyTimeline.js
 *  Author     : pixelcave
 */
var ReadyTimeline = function () {
    return {
        init: function () {
            $(".gmap").css("height", "200px"), new GMaps({
                div: "#gmap-timeline",
                lat: -33.863,
                lng: 151.2,
                zoom: 15,
                disableDefaultUI: !0,
                scrollwheel: !1
            }).addMarkers([{
                lat: -33.863,
                lng: 151.202,
                animation: google.maps.Animation.DROP,
                infoWindow: {
                    content: "<strong>Cafe-Bar: Example Address</strong>"
                }
            }]), new GMaps({
                div: "#gmap-checkin",
                lat: -33.863,
                lng: 151.217,
                zoom: 15,
                disableDefaultUI: !0,
                scrollwheel: !1
            }).addMarkers([{
                lat: -33.865,
                lng: 151.215,
                animation: google.maps.Animation.DROP,
                infoWindow: {
                    content: "<strong>Cafe-Bar: Example Address</strong>"
                }
            }])
        }
    }
}();