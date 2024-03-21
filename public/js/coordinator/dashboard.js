document.addEventListener("DOMContentLoaded", function () {
    // Find the canvas element using its data attributes
    const canvas = document.querySelector('[data-te-chart="doughnut"]');

    // Extract necessary data from data attributes
    const data = JSON.parse(canvas.getAttribute("data-te-dataset-data"));
    const backgroundColor = JSON.parse(
        canvas.getAttribute("data-te-dataset-background-color")
    );

    // Create the doughnut chart with labels for Hired and Non-hired students
    new Chart(canvas, {
        type: "doughnut",
        data: {
            labels: ["Deployed", "Undeployed"], // Updated labels
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

document.getElementById("deployedCount").addEventListener("click", function () {
    var baseUrl = "coordinator_student-list";
    var url = baseUrl + "?filter=deployed";
    window.location.href = url;
});

document
    .getElementById("undeployedCount")
    .addEventListener("click", function () {
        var baseUrl = "coordinator_student-list";
        var url = baseUrl + "?filter=undeployed";
        window.location.href = url;
    });

document.getElementById("activeCompany").addEventListener("click", function () {
    var baseUrl = "coordinator_company-list";
    var url = baseUrl + "?filter=active";
    window.location.href = url;
});

document
    .getElementById("inactiveCompany")
    .addEventListener("click", function () {
        var baseUrl = "coordinator_company-list";
        var url = baseUrl + "?filter=inactive";
        window.location.href = url;
    });
