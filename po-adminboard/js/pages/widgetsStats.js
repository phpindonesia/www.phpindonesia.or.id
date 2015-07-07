/*
 *  Document   : widgetsStats.js
 *  Author     : pixelcave
 */
var WidgetsStats = function () {
    return {
        init: function () {
            var o = {
                type: "bar",
                barWidth: 8,
                barSpacing: 6,
                height: "80px",
                tooltipOffsetX: -25,
                tooltipOffsetY: 20,
                barColor: "#555555",
                tooltipPrefix: "+ ",
                tooltipSuffix: " Sales",
                tooltipFormat: "{{prefix}}{{value}}{{suffix}}"
            };
            $("#mini-chart-bar1").sparkline("html", o), o.barColor = "#1bbae1", o.tooltipPrefix = "", o.tooltipSuffix = " Projects", $("#mini-chart-bar2").sparkline("html", o), o.barColor = "#e74c3c", o.tooltipPrefix = "+ ", o.tooltipSuffix = " Photos", $("#mini-chart-bar3").sparkline("html", o), o.barColor = "#9b59b6", o.tooltipPrefix = "", o.tooltipSuffix = " Tickets", $("#mini-chart-bar4").sparkline("html", o);
            var i = {
                type: "line",
                width: "270px",
                height: "150px",
                tooltipOffsetX: -25,
                tooltipOffsetY: 20,
                lineWidth: 1,
                lineColor: "#3b3f40",
                fillColor: "#399399",
                spotColor: "#ffffff",
                minSpotColor: "#ffffff",
                maxSpotColor: "#ffffff",
                highlightSpotColor: "#ffffff",
                highlightLineColor: "#ffffff",
                spotRadius: 5,
                tooltipPrefix: "$ ",
                tooltipSuffix: "",
                tooltipFormat: "{{prefix}}{{y}}{{suffix}}"
            };
            $("#mini-chart-line1").sparkline("html", i), i.lineColor = "#333333", i.fillColor = "#777777", i.tooltipPrefix = "+ ", i.tooltipSuffix = " Sales", $("#mini-chart-line2").sparkline("html", i), i.lineColor = "#4a2e2b", i.fillColor = "#b33c2e", i.tooltipPrefix = "", i.tooltipSuffix = " Downloads", $("#mini-chart-line3").sparkline("html", i);
            var t = $("#chart-widget1"),
                l = $("#chart-widget2"),
                f = [
                    [1, 1560],
                    [2, 1650],
                    [3, 1320],
                    [4, 1950],
                    [5, 1800],
                    [6, 2400],
                    [7, 2100],
                    [8, 2550],
                    [9, 3300],
                    [10, 3900],
                    [11, 4200],
                    [12, 4500]
                ],
                r = [
                    [1, 500],
                    [2, 420],
                    [3, 480],
                    [4, 350],
                    [5, 600],
                    [6, 850],
                    [7, 1100],
                    [8, 950],
                    [9, 1220],
                    [10, 1300],
                    [11, 1500],
                    [12, 1700]
                ],
                e = [
                    [1, "January"],
                    [2, "February"],
                    [3, "March"],
                    [4, "April"],
                    [5, "May"],
                    [6, "June"],
                    [7, "July"],
                    [8, "August"],
                    [9, "September"],
                    [10, "October"],
                    [11, "November"],
                    [12, "December"]
                ];
            $.plot(t, [{
                data: f,
                lines: {
                    show: !0,
                    fill: !1
                },
                points: {
                    show: !0,
                    radius: 6,
                    fillColor: "#cccccc"
                }
            }, {
                data: r,
                lines: {
                    show: !0,
                    fill: !1
                },
                points: {
                    show: !0,
                    radius: 6,
                    fillColor: "#ffffff"
                }
            }], {
                colors: ["#ffffff", "#353535"],
                legend: {
                    show: !1
                },
                grid: {
                    borderWidth: 0,
                    hoverable: !0,
                    clickable: !0
                },
                yaxis: {
                    show: !1
                },
                xaxis: {
                    show: !1,
                    ticks: e
                }
            }), $.plot(l, [{
                data: f,
                lines: {
                    show: !0,
                    fill: !1
                },
                points: {
                    show: !0,
                    radius: 6,
                    fillColor: "#000000"
                }
            }, {
                data: r,
                lines: {
                    show: !0,
                    fill: !1
                },
                points: {
                    show: !0,
                    radius: 6,
                    fillColor: "#ffffff"
                }
            }], {
                colors: ["#ffffff", "#000000"],
                legend: {
                    show: !1
                },
                grid: {
                    borderWidth: 0,
                    hoverable: !0,
                    clickable: !0
                },
                yaxis: {
                    show: !1
                },
                xaxis: {
                    show: !1,
                    ticks: e
                }
            });
            var a = null,
                s = null;
            t.add(l).bind("plothover", function (o, i, t) {
                if (t) {
                    if (a !== t.dataIndex) {
                        a = t.dataIndex, $("#chart-tooltip").remove();
                        var l = (t.datapoint[0], t.datapoint[1]),
                            f = t.series.xaxis.options.ticks[t.dataIndex][1];
                        s = 1 === t.seriesIndex ? "<strong>" + l + "</strong> sales in <strong>" + f + "</strong>" : "$ <strong>" + l + "</strong> in <strong>" + f + "</strong>", $('<div id="chart-tooltip" class="chart-tooltip">' + s + "</div>").css({
                            top: t.pageY - 50,
                            left: t.pageX - 50
                        }).appendTo("body").show()
                    }
                } else $("#chart-tooltip").remove(), a = null
            })
        }
    }
}();