<canvas id="bar-chart"></canvas>
<script type="text/javascript">
    function getRandomColor() {
        var letters = '01A23F45F6789ABC45DE'.split('');
        var color = '#';
        for (var i = 0; i < 6; i++) {
            color += letters[Math.floor(Math.random() * 16)];
        }
        return color;
    }
    var pageTitle = '<?php echo!empty($page_title) ? $page_title : ''; ?>';
    var clientwiseSalesAnalysisObject = '<?php echo ($clientwise_sales_analysis) ?>';
    var clientNameLabels = new Array();
    var clientMarginData = new Array();
    var clientColor = new Array();
    var countClient = 0;
    if (clientwiseSalesAnalysisObject != '') {
        clientwiseSalesAnalysisObject = jQuery.parseJSON(clientwiseSalesAnalysisObject);
        countClient = clientwiseSalesAnalysisObject.length;
        $.each(clientwiseSalesAnalysisObject, function (key, value) {
            var margin = parseInt(value.margin);
            var clientName = value.client_name;
            clientMarginData.push(margin);
            clientNameLabels.push(clientName);
            clientColor.push(getRandomColor());
        });
    }

    var ctx = document.getElementById("bar-chart").getContext('2d');
    var myChart = new Chart(ctx, {
        type: 'bar',
        data: {
            labels: clientNameLabels,
//            labels: ["Red", "Blue", "Yellow", "Green", "Purple", "Orange"],
            datasets: [{
                    label: '# ' + pageTitle,
                    data: clientMarginData,
                    backgroundColor: clientColor,
//                    useRandomColors: true
//                    fillColor: randomScalingFactor(),
//                    strokeColor: randomScalingFactor(),
//                    highlightFill: randomScalingFactor(),
//                    highlightStroke: randomScalingFactor(),
//                    data: [12, 19, 3, 5, 2, 3],
//                    backgroundColor: [
//                        getRandomColor()
//
////                        randomScalingFactor(),
////                        'rgba(255, 99, 132, 0.2)',
////                        'rgba(54, 162, 235, 0.2)',
////                        'rgba(255, 206, 86, 0.2)',
////                        'rgba(75, 192, 192, 0.2)',
////                        'rgba(153, 102, 255, 0.2)',
////                        'rgba(255, 159, 64, 0.2)'
//                    ],
                    borderColor: [
//                        randomScalingFactor(),
//                        'rgba(255,99,132,1)',
//                        'rgba(54, 162, 235, 1)',
//                        'rgba(255, 206, 86, 1)',
//                        'rgba(75, 192, 192, 1)',
//                        'rgba(153, 102, 255, 1)',
//                        'rgba(255, 159, 64, 1)'
                    ],
                    borderWidth: 1
                }]
        },
        options: {
            responsive: true,
//            maintainAspectRatio: false,
            tooltips: {
                titleFontSize: 0,
                titleMarginBottom: 0,
                bodyFontSize: 12
            },
//            legend: {
//                display: true
//            },
            legend: {
                onClick: (e) => e.stopPropagation(),
                labels: {
//                    fontColor: 'black',
                    boxWidth: 0,
                }
            },
            scales: {
                yAxes: [{
                        ticks: {
                            beginAtZero: true
                        },
//                        interval: 10
                    }],
                xAxes: [{
                        ticks: {
//                            fontSize: 10,
                            autoSkip: false,
                            maxRotation: 90, // angle in degrees
                            minRotation: 0 // angle in degrees
                        }
//                        interval: 10
//                         stacked: true

//                        gridLines: {
//                            offsetGridLines: true
//                        }
                    }]
            }
        }
    });

</script>