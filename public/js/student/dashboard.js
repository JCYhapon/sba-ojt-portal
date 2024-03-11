document.addEventListener("DOMContentLoaded", function () {
    // Find the canvas element using its data attributes
    const canvas = document.querySelector('[data-te-chart="doughnut"]');

    // Extract necessary data from data attributes
    const data = JSON.parse(canvas.getAttribute("data-te-dataset-data"));
    const backgroundColor = JSON.parse(
        canvas.getAttribute("data-te-dataset-background-color")
    );

    // Create the doughnut chart with labels for Hired, Non-hired, and Needed Hours
    new Chart(canvas, {
        type: "doughnut",
        data: {
            labels: ["Rendered", "Left"], // Updated labels
            datasets: [
                {
                    data: data,
                    backgroundColor: backgroundColor,
                },
            ],
        },
        options: {
            // You can add options here if needed
        },
    });
});
