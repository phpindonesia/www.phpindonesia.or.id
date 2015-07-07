/*
 *  Document   : widgetsSocial.js
 *  Author     : pixelcave
 */
var WidgetsSocial = function () {
    return {
        init: function () {
            new GMaps({
                div: "#gmap-widget",
                lat: -33.8665,
                lng: 151.2,
                zoom: 15,
                disableDefaultUI: !0,
                scrollwheel: !1
            }), new GMaps({
                div: "#gmap-widget-alt",
                lat: -33.8665,
                lng: 151.2,
                zoom: 15,
                disableDefaultUI: !0,
                scrollwheel: !1
            }).setMapTypeId(google.maps.MapTypeId.SATELLITE)
        }
    }
}();