Chart.defaults.global.defaultFontFamily =
    'Nunito, -apple-system, system-ui, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif';
Chart.defaults.global.defaultFontColor = "#858796";

var ctx = document.getElementById("activityPieChart");
var activityPieChart = new Chart(ctx, {
    type: "doughnut",
    data: {
        labels: window.pieLabels,
        datasets: [
            {
                data: window.pieData,
                backgroundColor: [
                    "#4e73df",
                    "#1cc88a",
                    "#36b9cc",
                    "#f6c23e",
                    "#e74a3b",
                ],
                hoverBackgroundColor: [
                    "#2e59d9",
                    "#17a673",
                    "#2c9faf",
                    "#dda20a",
                    "#be2617",
                ],
                hoverBorderColor: "rgba(234, 236, 244, 1)",
            },
        ],
    },
    options: {
        maintainAspectRatio: false,

        cutoutPercentage: 65,

        tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            borderColor: "#dddfeb",
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            caretPadding: 10,
        },

        legend: {
            display: true,
            position: "bottom",
            labels: {
                usePointStyle: true,
                padding: 12,
                boxWidth: 10,
                fontSize: 12,
            },
        },
    },
});
