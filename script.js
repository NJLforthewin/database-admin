document.addEventListener("DOMContentLoaded", function () {
    const ctx = document.getElementById("occupancyChart").getContext("2d");

    new Chart(ctx, {
        type: "bar",
        data: {
            labels: ["May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec", "Jan", "Feb"],
            datasets: [{
                label: "Occupancy Rate (%)",
                data: [80, 65, 85, 40, 100, 90, 88, 85, 100, 100], // Example occupancy rates
                backgroundColor: "rgba(30, 136, 229, 0.8)", // Blue bars
                borderRadius: 5
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            scales: {
                y: {
                    beginAtZero: true,
                    max: 100,
                    ticks: {
                        callback: function(value) { return value + "%"; }
                    }
                }
            },
            plugins: {
                legend: {
                    display: false
                }
            }
        }
    });
});
