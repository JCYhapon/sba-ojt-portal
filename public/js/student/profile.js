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

document.querySelectorAll(".remove").forEach((anchor) => {
    anchor.addEventListener("click", function (event) {
        event.preventDefault(); // Prevent the default behavior of anchor element (i.e., navigation)

        const matchedCompanyToRemove = this.dataset.position;
        const matchedCompanyContainer = this.closest(".position-container");

        // Remove the position item from the view
        this.closest(".position-item").remove();

        // Remove the corresponding hidden input field
        const hiddenInputsToRemove = matchedCompanyContainer.querySelectorAll(
            'input[value="' + matchedCompanyToRemove + '"]'
        );
        hiddenInputsToRemove.forEach((input) => {
            input.remove();
        });

        // Show the "Save Changes" and "Cancel Changes" buttons
        document.getElementById("saveChangesBtn").style.display = "block";
        document.getElementById("cancelChangesBtn").style.display = "block";
    });
});

// Add event listener to "Cancel Changes" button
document
    .getElementById("cancelChangesBtn")
    .addEventListener("click", function () {
        // Reload the page to cancel changes and reset the form
        location.reload();
    });

// Function to show/hide Save Changes button based on supervisor input
function toggleSaveChangesButton() {
    const supervisorInput = document.getElementById("supervisor");
    const saveChangesBtn = document.getElementById("saveChangesBtn");

    // Check if supervisor input field has a value
    if (supervisorInput.value.trim() !== "") {
        saveChangesBtn.style.display = "block"; // Show the button
    } else {
        saveChangesBtn.style.display = "none"; // Hide the button
    }
}

// Initially hide the Save Changes button
toggleSaveChangesButton();
