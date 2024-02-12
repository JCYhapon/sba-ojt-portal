document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("table");
    const tbody = table.querySelector("tbody");
    const headers = table.querySelectorAll("thead th");

    const rows = Array.from(tbody.querySelectorAll("tr"));

    // Object to store the number of clicks on each header
    const clickCounts = {};

    headers.forEach((header, index) => {
        header.addEventListener("click", () => {
            // Initialize click count if not set
            clickCounts[index] = clickCounts[index] || 0;

            // Increment click count
            clickCounts[index]++;

            // Apply sorting class based on click count
            if (clickCounts[index] === 1) {
                // Ascending order
                header.classList.remove("desc");
                header.classList.add("asc");
            } else if (clickCounts[index] === 2) {
                // Descending order
                header.classList.remove("asc");
                header.classList.add("desc");
            } else {
                // Remove sorting class
                header.classList.remove("asc", "desc");
                clickCounts[index] = 0;
            }

            // Sort the rows based on the selected column
            rows.sort((a, b) => {
                const aValue = a.children[index].textContent.trim();
                const bValue = b.children[index].textContent.trim();

                if (!isNaN(aValue) && !isNaN(bValue)) {
                    // If the values are numbers, compare them numerically
                    return clickCounts[index] === 1
                        ? aValue - bValue
                        : bValue - aValue;
                } else {
                    // If the values are strings, compare them alphabetically
                    return clickCounts[index] === 1
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                }
            });

            // Append the sorted rows to the tbody
            rows.forEach((row) => tbody.appendChild(row));
        });
    });

    // Function to apply search filter
    function applySearchFilter(searchTerm) {
        rows.forEach((row) => {
            const rowText = Array.from(row.children)
                .map((td) => td.textContent.trim().toLowerCase())
                .join(" ");

            if (rowText.includes(searchTerm)) {
                row.style.display = "";
            } else {
                row.style.display = "none";
            }
        });
    }

    // Initial search functionality
    const searchInput = document.getElementById("simple-search");
    searchInput.addEventListener("input", () => {
        const searchTerm = searchInput.value.toLowerCase();
        applySearchFilter(searchTerm);
    });
});
