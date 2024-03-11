document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("section").addEventListener("change", function () {
        var section = this.value;

        var rows = document.querySelectorAll("#studentTable tbody tr");

        if (section === "all") {
            rows.forEach((row) => {
                row.style.display = "";
            });
        } else {
            rows.forEach((row) => {
                row.style.display = "none";
            });

            var matchingRows = document.querySelectorAll(
                '#studentTable tbody tr[data-section="' + section + '"]'
            );
            matchingRows.forEach((row) => {
                row.style.display = "";
            });
        }
    });
});
