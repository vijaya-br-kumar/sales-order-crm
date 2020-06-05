$("#filterYear").select2({
    width: "100%",
});

let ctx = document.getElementById('myChart');
let chart = new Chart(ctx, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: ['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
            datasets: [{
                label: 'Sales Order Count',
                borderColor: 'rgb(255, 99, 132)',
                data: salesOrderCount
        }]
    },

    // Configuration options go here
    options: {
        layout: {
            padding:{
                left: 50,
                    right: 0,
                    top: 50,
                    bottom: 50
            },
        },
        scales:{
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Month'
                }
            }],
                yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Sales Count'
                },
                ticks: {
                    beginAtZero: true,
                    // steps: 5,
                    // stepValue: 5,
                    // max: 100
                }
            }]
        },
        title: {
            display: true,
                text: 'Sales Order Details'
        },
        responsive: true,
            maintainAspectRatio: false
    }
});
chart.canvas.parentNode.style.width = '100%';
chart.canvas.parentNode.style.height = '500px';

$('#yearlyData').submit(function (event) {
    let year = $('#filterYear').val();
    $.ajax({
        url: salesDataApi+'?year='+year,
        method: "GET"
    })
        .done(function( response ) {
            if(response.success)
            {
                updateChart(response, year);
            }
            else
            {
                alert("Invalid Response");
            }
        })
        .fail(function(jqXHR, textStatus, errorThrown){
            alert("Error Occurred");
        });
    return false;
});

function updateChart(response, year) {
    chart.data.datasets[0].data = response.sales;
    chart.update();
}

// Yearly Sales Chart

let yearlyChartElement = document.getElementById('yearlySales');
let yearlyChart = new Chart(yearlyChartElement, {
    // The type of chart we want to create
    type: 'line',

    // The data for our dataset
    data: {
        labels: yearlySalesYear,//['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December'],
        datasets: [{
            label: 'Sales Order Count',
            borderColor: 'rgb(19,189,206)',
            data: yearlySalesData
        }]
    },

    // Configuration options go here
    options: {
        layout: {
            padding:{
                left: 50,
                right: 0,
                top: 50,
                bottom: 50
            },
        },
        scales:{
            xAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Year'
                }
            }],
            yAxes: [{
                display: true,
                scaleLabel: {
                    display: true,
                    labelString: 'Sales Count'
                },
                ticks: {
                    beginAtZero: true,
                    // steps: 5,
                    // stepValue: 5,
                    // max: 100
                }
            }]
        },
        title: {
            display: true,
            text: 'Year wise Sales Order'
        },
        responsive: true,
        maintainAspectRatio: false
    }
});
yearlyChart.canvas.parentNode.style.width = '100%';
yearlyChart.canvas.parentNode.style.height = '500px';