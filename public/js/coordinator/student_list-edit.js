document
    .getElementById("addMatchedCompany")
    .addEventListener("change", function (event) {
        const selectedCompanyId = event.target.value;

        if (selectedCompanyId) {
            // Retrieve the company name based on the selected ID
            const selectedOption =
                event.target.options[event.target.selectedIndex];
            const selectedCompanyName = selectedOption.textContent;

            // Create a new matched company item
            const newMatchedCompanyItem = document.createElement("div");
            newMatchedCompanyItem.classList.add(
                "matchedCompany-item",
                "flex",
                "items-center",
                "mt-2",
                "mr-2"
            );

            // Create span element for matched company text
            const newMatchedCompanyText = document.createElement("span");
            newMatchedCompanyText.classList.add(
                "rounded-lg",
                "p-2.5",
                "dark:placeholder-gray-400",
                "bg-gray-800",
                "text-white"
            );
            newMatchedCompanyText.textContent = selectedCompanyName; // Use the fetched company name

            // Create remove button
            const removeButton = document.createElement("input");
            removeButton.type = "button"; // Set type to button
            removeButton.value = "×"; // Set the value (content) of the button
            removeButton.classList.add(
                "remove",
                "pl-2",
                "pr-1",
                "cursor-pointer"
            );
            removeButton.dataset.company = selectedCompanyId;

            // Append elements to matched company item
            newMatchedCompanyItem.appendChild(newMatchedCompanyText);
            newMatchedCompanyText.appendChild(removeButton);

            // Append matched company item to container
            document
                .querySelector(".matchedCompany-container")
                .appendChild(newMatchedCompanyItem);

            // Create hidden input field to store matched company
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "matchedCompanies[]";
            hiddenInput.value = selectedCompanyId;
            document
                .querySelector(".matchedCompany-container")
                .appendChild(hiddenInput);

            // Clear selected option
            event.target.value = "";
        }
    });

// Delegate the event handling to the document level for remove buttons
document
    .querySelector(".matchedCompany-container")
    .addEventListener("click", function (event) {
        if (event.target.classList.contains("remove")) {
            event.preventDefault();

            const matchedCompanyToRemove = event.target.dataset.company;
            const matchedCompanyContainer = event.target.closest(
                ".matchedCompany-container"
            );

            event.target.closest(".matchedCompany-item").remove();

            const hiddenInputsToRemove =
                matchedCompanyContainer.querySelectorAll(
                    'input[value="' + matchedCompanyToRemove + '"]'
                );
            hiddenInputsToRemove.forEach((input) => {
                input.remove();
            });
        }
    });


    document
        .getElementById("addPosition")
        .addEventListener("change", function (event) {
            const selectedPosition = event.target.value;

            if (selectedPosition) {
                // Remove the selected option from the dropdown list
                event.target
                    .querySelector(`option[value="${selectedPosition}"]`)
                    .remove();

                // Create a new position item
                const newPositionItem = document.createElement("div");
                newPositionItem.classList.add(
                    "position-item",
                    "flex",
                    "items-center",
                    "mt-2",
                    "mr-2"
                );

                // Create span element for position text
                const newPositionText = document.createElement("span");
                newPositionText.classList.add(
                    "rounded-lg",
                    "p-2.5",
                    "dark:placeholder-gray-400",
                    "bg-blue-500",
                    "text-white"
                );
                newPositionText.textContent = selectedPosition;

                // Create remove button
                const removeButton = document.createElement("input");
                removeButton.type = "button"; // Set type to button
                removeButton.value = "×"; // Set the value (content) of the button
                removeButton.classList.add(
                    "remove",
                    "pl-2",
                    "pr-1",
                    "cursor-pointer"
                );
                removeButton.dataset.position = selectedPosition;

                // Append elements to position item
                newPositionItem.appendChild(newPositionText);
                newPositionText.appendChild(removeButton);

                // Append position item to container
                document
                    .querySelector(".position-container")
                    .appendChild(newPositionItem);

                // Create hidden input field to store position
                const hiddenInput = document.createElement("input");
                hiddenInput.type = "hidden";
                hiddenInput.name = "positions[]";
                hiddenInput.value = selectedPosition;
                document
                    .querySelector(".position-container")
                    .appendChild(hiddenInput);

                // Clear selected option
                event.target.value = "";
            }
        });

    // Delegate the event handling to the document level for remove buttons
    document
        .querySelector(".position-container")
        .addEventListener("click", function (event) {
            if (event.target.classList.contains("remove")) {
                event.preventDefault();

                const matchedCompanyToRemove = event.target.dataset.position;
                const matchedCompanyContainer = event.target.closest(
                    ".position-container"
                );

                event.target.closest(".position-item").remove();

                const hiddenInputsToRemove =
                    matchedCompanyContainer.querySelectorAll(
                        'input[value="' + matchedCompanyToRemove + '"]'
                    );
                hiddenInputsToRemove.forEach((input) => {
                    input.remove();
                });
            }
        });