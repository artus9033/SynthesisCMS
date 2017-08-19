function adminStatsGetUniqueColorsWrapper(amount){
    var ret = new Array();
    var rgbsArray = SynthesisCmsJsUtils.generateUniqueRgbColorsArray(amount);

    for(var i = 0; i <= (amount - 1); i++){
        ret.push("rgba("+rgbsArray[i][0]+","+rgbsArray[i][1]+","+rgbsArray[i][2]+",0.7)");
    }

    return ret;
}

$(window).ready(function () {
    var uniqueVisitsPerTimePeriodChartCanvas = $("#uniqueVisitsPerTimePeriodChartCanvas");
    var todaysTrafficChartCanvas = $("#todaysTrafficChartCanvas");

    var uniqueVisitsPerTimePeriodChart = new Chart(uniqueVisitsPerTimePeriodChartCanvas, {
        type: 'line',
        data: {
            labels: window.stats.diagramLabels,
            datasets: [
                {
                    label: window.trans.amount_of_views,
                    fill: true,
                    backgroundColor: "rgba(75,192,192,0.4)",
                    borderColor: "rgba(75,192,192,1)",
                    borderCapStyle: 'round',
                    borderDash: [],
                    borderDashOffset: 0.0,
                    borderJoinStyle: 'round',
                    pointBorderColor: "rgba(75,192,192,1)",
                    pointBackgroundColor: "rgba(2, 98, 82, 1)",
                    pointBorderWidth: 3,
                    pointHoverRadius: 5,
                    pointHoverBackgroundColor: "rgba(3, 139, 116, 1)",
                    pointHoverBorderColor: "rgba(0, 99, 83, 1)",
                    pointHoverBorderWidth: 2,
                    pointRadius: 3,
                    pointHitRadius: 7,
                    data: window.stats.diagramValues,
                }
            ]
        },
        options: {
            scales: {
                yAxes: [{
                    ticks: {
                        beginAtZero: true
                    }
                }]
            }
        }
    });
    var todaysTrafficChart = new Chart(todaysTrafficChartCanvas, {
        data: {
            datasets: [{
                backgroundColor: adminStatsGetUniqueColorsWrapper(window.stats.circleDiagramCount),
                pointBorderColor: "rgba(75,192,192,1)",
                pointBackgroundColor: "rgba(2, 98, 82, 1)",
                pointHoverBackgroundColor: "rgba(3, 139, 116, 1)",
                pointHoverBorderColor: "rgba(0, 99, 83, 1)",
                data: window.stats.circleDiagramValues,
            }],
            labels: window.stats.circleDiagramLabels
        },
        type: 'doughnut'
    });
});