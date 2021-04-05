<!DOCTYPE html>
<html>
    <head>
        <title>Page Title</title>
    </head>
    <body>

        <link rel="stylesheet" type="text/css" href="<?= base_url('assets/vendor/Chart.js/samples/style.css'); ?>">
        <script src="<?= base_url('assets/vendor/Chart.js/samples/Chart.bundle.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/vendor/Chart.js/samples/utils.js'); ?>" type="text/javascript"></script>
        <script src="<?= base_url('assets/vendor/Chart.js/samples/charts/area/analyser.js'); ?>" type="text/javascript"></script>

        <style>
            .chartWrapper {
                position: relative;
            }

            .chartWrapper > canvas {
                position: absolute;
                left: 0;
                top: 0;
                pointer-events: none;
            }

            .chartAreaWrapper {
                width: 600px;
                overflow-x: scroll;
            }



        </style>

        <div class="chartWrapper">
            <div class="chartAreaWrapper">
                <div class="chartAreaWrapper2">
                    <canvas id="chart-FuelSpend" height="300" width="1200"></canvas>
                </div>
            </div>
            <canvas id="axis-FuelSpend" height="300" width="0"></canvas>
        </div>
        <script>
            function generateLabels() {
                var chartLabels = [];
                for (x = 0; x < 100; x++) {
                    chartLabels.push("Label" + x);
                }
                return chartLabels;
            }

            function generateData() {
                var chartData = [];
                for (x = 0; x < 100; x++) {
                    chartData.push(Math.floor((Math.random() * 100) + 1));
                }
                return chartData;
            }

            function addData(numData, chart) {
                for (var i = 0; i < numData; i++) {
                    chart.data.datasets[0].data.push(Math.random() * 100);
                    chart.data.labels.push("Label" + i);
                    var newwidth = $('.chartAreaWrapper2').width() + 60;
                    $('.chartAreaWrapper2').width(newwidth);
                }
            }

            var chartData = {
                labels: generateLabels(),
                datasets: [{
                        label: "Test Data Set",
                        data: generateData()
                    }]
            };

            $(function () {
                var canvasFuelSpend = $('#chart-FuelSpend');
                var chartFuelSpend = new Chart(canvasFuelSpend, {
                    type: 'bar',
                    data: chartData,
                    maintainAspectRatio: false,
                    responsive: true,
                    options: {
                        tooltips: {
                            titleFontSize: 0,
                            titleMarginBottom: 0,
                            bodyFontSize: 12
                        },
                        legend: {
                            display: false
                        },
                        scales: {
                            xAxes: [{
                                    ticks: {
                                        fontSize: 12,
                                        display: false
                                    }
                                }],
                            yAxes: [{
                                    ticks: {
                                        fontSize: 12,
                                        beginAtZero: true
                                    }
                                }]
                        },
                        animation: {
                            onComplete: function () {
                                var sourceCanvas = chartFuelSpend.chart.canvas;
                                var copyWidth = chartFuelSpend.scales['y-axis-0'].width - 10;
                                var copyHeight = chartFuelSpend.scales['y-axis-0'].height + chartFuelSpend.scales['y-axis-0'].top + 10;
                                var targetCtx = document.getElementById("axis-FuelSpend").getContext("2d");
                                targetCtx.canvas.width = copyWidth;
                                targetCtx.drawImage(sourceCanvas, 0, 0, copyWidth, copyHeight, 0, 0, copyWidth, copyHeight);
                            }
                        }
                    }
                });
                addData(5, chartFuelSpend);
            });

        </script>











<!--<canvas id="myChart" width="400" height="400"></canvas>-->
<!--<script>
var ctx = document.getElementById("myChart").getContext('2d');
var myChart = new Chart(ctx, {
type: 'bar',
data: {
labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
datasets: [{
    label: '# of Votes',
    data: [12, 19, 3, 5, 2, 3],
    backgroundColor: [
        'rgba(255, 99, 132, 0.2)',
        'rgba(54, 162, 235, 0.2)',
        'rgba(255, 206, 86, 0.2)',
        'rgba(75, 192, 192, 0.2)',
        'rgba(153, 102, 255, 0.2)',
        'rgba(255, 159, 64, 0.2)'
    ],
    borderColor: [
        'rgba(255,99,132,1)',
        'rgba(54, 162, 235, 1)',
        'rgba(255, 206, 86, 1)',
        'rgba(75, 192, 192, 1)',
        'rgba(153, 102, 255, 1)',
        'rgba(255, 159, 64, 1)'
    ],
    borderWidth: 1
}]
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
</script>-->
    </body>
</html>
<!--<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<canvas id="bar-chart" width="200" height="200"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.5.0/Chart.min.js"></script>
<script>
// Bar chart
new Chart(document.getElementById("bar-chart"), {
    type: 'bar',
    data: {
      labels: ["Africa", "Asia", "Europe", "Latin America", "North America"],
      datasets: [
        {
          label: "Population (millions)",
          backgroundColor: ["#3e95cd", "#8e5ea2","#3cba9f","#e8c3b9","#c45850"],
          data: [2478,5267,734,784,433]
        }
      ]
    },
    options: {
      legend: { display: false },
      title: {
        display: true,
        text: 'Predicted world population (millions) in 2050'
      }
    }
});
</script>

</body>
</html>-->


<!--<!DOCTYPE html>
<html>
<head>
<title>Page Title</title>
</head>
<body>

<canvas id="myChart"></canvas>
<script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.4.0/Chart.min.js"></script>
<script src="<?= base_url('assets/vendor/Chart.js/src/chart.js'); ?>" type="text/javascript"></script>
<script>
var ctx = document.getElementById('myChart').getContext('2d');
var chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ["January", "February", "March", "April", "May", "June", "July"],
        datasets: [{
            label: "My First dataset",
            backgroundColor: 'rgb(255, 99, 132)',
            borderColor: 'rgb(255, 99, 132)',
            data: [0, 10, 5, 2, 20, 30, 45],
        }]
    },

    // Configuration options go here
    options: {}
});
</script>

</body>
</html>-->
