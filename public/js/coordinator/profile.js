document.addEventListener("DOMContentLoaded", function () {
    // Add change event listener to the select element
    document.getElementById("section").addEventListener("change", function () {
        // Get the selected section value
        var section = this.value;

        // Hide all table rows
        var rows = document.querySelectorAll("#studentTable tbody tr");
        rows.forEach((row) => {
            row.style.display = "none";
        });

        // Show table rows matching the selected section
        var matchingRows = document.querySelectorAll(
            '#studentTable tbody tr[data-section="' + section + '"]'
        );
        matchingRows.forEach((row) => {
            row.style.display = "";
        });
    });
});
