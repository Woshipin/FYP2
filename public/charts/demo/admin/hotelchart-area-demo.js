// 设置数字格式函数
function number_format(number, decimals, dec_point, thousands_sep) {
    number = (number + "").replace(",", "").replace(" ", "");
    var n = !isFinite(+number) ? 0 : +number,
        prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
        sep = typeof thousands_sep === "undefined" ? "," : thousands_sep,
        dec = typeof dec_point === "undefined" ? "." : dec_point,
        s = "",
        toFixedFix = function (n, prec) {
            var k = Math.pow(10, prec);
            return "" + Math.round(n * k) / k;
        };
    s = (prec ? toFixedFix(n, prec) : "" + Math.round(n)).split(".");
    if (s[0].length > 3) {
        s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
    }
    if ((s[1] || "").length < prec) {
        s[1] = s[1] || "";
        s[1] += new Array(prec - s[1].length + 1).join("0");
    }
    return s.join(dec);
}

// Area Chart Example for Hotel
var ctx = document.getElementById("myHotelAreaChart");
var myLineChart = new Chart(ctx, {
    type: "line",
    data: {
        labels: _hotellabels,
        datasets: [{
            label: "Hotel Bookings",
            lineTension: 0.3,
            backgroundColor: "rgba(246, 194, 62, 0.05)",
            borderColor: "rgba(246, 194, 62, 1)",
            pointRadius: 3,
            pointBackgroundColor: "rgba(246, 194, 62, 1)",
            pointBorderColor: "rgba(246, 194, 62, 1)",
            pointHoverRadius: 3,
            pointHoverBackgroundColor: "rgba(246, 194, 62, 1)",
            pointHoverBorderColor: "rgba(246, 194, 62, 1)",
            pointHitRadius: 10,
            pointBorderWidth: 2,
            data: _hotelcounts,
        }],
    },
    options: {
        maintainAspectRatio: false,
        layout: {
            padding: {
                left: 10,
                right: 25,
                top: 25,
                bottom: 0,
            },
        },
        scales: {
            xAxes: [
                {
                    time: {
                        unit: "date",
                    },
                    gridLines: {
                        display: false,
                        drawBorder: false,
                    },
                    ticks: {
                        maxTicksLimit: 7,
                    },
                },
            ],
            yAxes: [
                {
                    ticks: {
                        maxTicksLimit: 5,
                        padding: 10,
                        callback: function (value, index, values) {
                            return +number_format(value);
                        },
                    },
                    gridLines: {
                        color: "rgb(234, 236, 244)",
                        zeroLineColor: "rgb(234, 236, 244)",
                        drawBorder: false,
                        borderDash: [2],
                        zeroLineBorderDash: [2],
                    },
                },
            ],
        },
        legend: {
            display: false,
        },
        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: "#6e707e",
            titleFontSize: 14,
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: "index",
            caretPadding: 10,
            callbacks: {
                label: function (tooltipItem, chart) {
                    var hotelName = _hoteldata[tooltipItem.index].name;
                    var popularCount = _hoteldata[tooltipItem.index].popular_count;
                    var total = _hoteldata.reduce((sum, item) => sum + item.popular_count, 0);
                    return (
                        "name: " +
                        hotelName + "\n" +
                        ", popular_booked: " +
                        number_format(popularCount) + "\n" +
                        "Total: " +
                        number_format(total)
                    );
                },
            },
        },
    },
});

// var ctx = document.getElementById('hotelChart').getContext('2d');
// var hotelChart = new Chart(ctx, {
//     type: 'line',
//     data: {
//         labels: _hotellabels,
//         datasets: [{
//             label: 'Hotel Popular Count',
//             data: _hotelcounts,
//             borderColor: 'rgba(255, 206, 86, 1)',
//             borderWidth: 2
//         }]
//     },
//     options: {
//         tooltips: {
//             callbacks: {
//                 label: function(tooltipItem, data) {
//                     var month = data.labels[tooltipItem.index];
//                     var popularCount = data.datasets[0].data[tooltipItem.index];
//                     return month + ': ' + popularCount + ' total popular count';
//                 }
//             }
//         },
//         scales: {
//             yAxes: [{
//                 ticks: {
//                     beginAtZero: true
//                 }
//             }]
//         }
//     }
// });

