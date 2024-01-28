document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("table");
    const tbody = table.querySelector("tbody");
    const headers = table.querySelectorAll("thead th");

    const rows = Array.from(tbody.querySelectorAll("tr"));

    headers.forEach((header, index) => {
        header.addEventListener("click", () => {
            const isAscending = header.classList.contains("asc");

            // Remove sorting classes from all headers
            headers.forEach((h) => h.classList.remove("asc", "desc"));

            // Sort the rows based on the selected column
            rows.sort((a, b) => {
                const aValue = a.children[index].textContent.trim();
                const bValue = b.children[index].textContent.trim();

                if (!isNaN(aValue) && !isNaN(bValue)) {
                    // If the values are numbers, compare them numerically
                    return isAscending ? aValue - bValue : bValue - aValue;
                } else {
                    // If the values are strings, compare them alphabetically
                    return isAscending
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                }
            });

            // Append the sorted rows to the tbody
            rows.forEach((row) => tbody.appendChild(row));

            // Toggle the sorting class for the clicked header
            header.classList.toggle(isAscending ? "desc" : "asc");
        });
    });
});

document.addEventListener("DOMContentLoaded", function () {
    const table = document.querySelector("table");
    const tbody = table.querySelector("tbody");
    const headers = table.querySelectorAll("thead th");
    const searchInput = document.getElementById("simple-search");

    const rows = Array.from(tbody.querySelectorAll("tr"));

    // Sorting Logic
    headers.forEach((header, index) => {
        header.addEventListener("click", () => {
            const isAscending = header.classList.contains("asc");

            headers.forEach((h) => h.classList.remove("asc", "desc"));

            rows.sort((a, b) => {
                const aValue = a.children[index].textContent.trim();
                const bValue = b.children[index].textContent.trim();

                if (!isNaN(aValue) && !isNaN(bValue)) {
                    return isAscending ? aValue - bValue : bValue - aValue;
                } else {
                    return isAscending
                        ? aValue.localeCompare(bValue)
                        : bValue.localeCompare(aValue);
                }
            });

            rows.forEach((row) => tbody.appendChild(row));

            header.classList.toggle(isAscending ? "desc" : "asc");
        });
    });

    // Search Logic
    searchInput.addEventListener("input", () => {
        const searchTerm = searchInput.value.toLowerCase();

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
    });
});


// FOR STATUS IF - GREEN FOR ACTIVE AND RED FOR INACTIVE

document.addEventListener('DOMContentLoaded', function () {
    var statusCell = document.getElementById('statusCell');
    var status = "{{ $student->status === 1 ? 'Active' : 'Inactive' }}";

    if (status === 'Active') {
        statusCell.style.backgroundColor = 'green';
        // You can customize other styles as well
    } else if (status === 'Inactive') {
        statusCell.style.backgroundColor = 'red';
        // You can customize other styles as well
    }
});