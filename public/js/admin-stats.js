var ctx = $("#stats");
var myChart = new Chart(ctx, {
    type: 'line',
    data: {
	    labels: ["January", "February", "March", "April", "May", "June", "July"],
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
	            pointBorderWidth: 6,
	            pointHoverRadius: 5,
	            pointHoverBackgroundColor: "rgba(3, 139, 116, 1)",
	            pointHoverBorderColor: "rgba(0, 99, 83, 1)",
	            pointHoverBorderWidth: 2,
	            pointRadius: 1,
	            pointHitRadius: 10,
	            data: [65, 59, 80, 81, 56, 55, 40],
	        }
	    ]
    },
    options: {
        scales: {
            yAxes: [{
                ticks: {
                    beginAtZero:true
                }
            }]
        }
    }
});
