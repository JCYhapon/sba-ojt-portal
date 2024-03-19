// Function to show the modal
function showModal() {
    document.getElementById("customPositionModal").classList.remove("hidden");
}

// Function to hide the modal
function hideModal() {
    document.getElementById("customPositionModal").classList.add("hidden");
}

// Event listener for closing the modal
document.querySelector(".close-modal").addEventListener("click", hideModal);

// Event listener for adding custom position
document
    .getElementById("addCustomPositionBtn")
    .addEventListener("click", function () {
        const customPosition = document
            .getElementById("customPositionInput")
            .value.trim();
        if (customPosition) {
            // Create a new position item for the custom position
            const newPositionItem = document.createElement("div");
            newPositionItem.classList.add(
                "position-item",
                "flex",
                "rounded-lg",
                "items-center",
                "mt-2",
                "mr-2",
                "bg-gray-800"
            );

            // Create span element for position text
            const newPositionText = document.createElement("span");
            newPositionText.classList.add(
                "position-text",
                "rounded-lg",
                "p-2.5",
                "dark:placeholder-gray-400",
                "bg-gray-800",
                "text-white"
            );
            newPositionText.textContent = customPosition;

            // Create remove button
            const removeButton = document.createElement("button");
            removeButton.type = "button"; // Set type to button
            removeButton.classList.add(
                "remove",
                "pr-3.5",
                "cursor-pointer",
                "bg-gray-800",
                "text-white"
            );
            removeButton.dataset.position = customPosition;
            removeButton.innerHTML = "&times;"; // Display "×" symbol

            // Append elements to position item
            newPositionItem.appendChild(newPositionText);
            newPositionItem.appendChild(removeButton);

            // Append position item to container
            document
                .querySelector(".position-container")
                .appendChild(newPositionItem);

            // Create hidden input field to store position
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "positions[]";
            hiddenInput.value = customPosition;
            document
                .querySelector(".position-container")
                .appendChild(hiddenInput);

            // Clear input field
            document.getElementById("customPositionInput").value = "";

            // Hide the modal
            hideModal();
        }
    });

// Event listener for adding predefined positions
document
    .getElementById("addPosition")
    .addEventListener("change", function (event) {
        const selectedPosition = event.target.value;

        if (selectedPosition === "custom") {
            // Show the modal for entering custom position
            showModal();
        } else if (selectedPosition) {
            // Remove the selected option from the dropdown
            event.target.remove(event.target.selectedIndex);

            // Create a new position item
            const newPositionItem = document.createElement("div");
            newPositionItem.classList.add(
                "position-item",
                "flex",
                "rounded-lg",
                "items-center",
                "mt-2",
                "mr-2",
                "bg-gray-800"
            );

            // Create span element for position text
            const newPositionText = document.createElement("span");
            newPositionText.classList.add(
                "position-text",
                "rounded-lg",
                "p-2.5",
                "dark:placeholder-gray-400",
                "text-white",
                "inline-block" // Add this class to display the position text inline
            );
            newPositionText.textContent = selectedPosition;

            // Create remove button
            const removeButton = document.createElement("button");
            removeButton.type = "button"; // Set type to button
            removeButton.classList.add(
                "remove",
                "pr-3.5",
                "cursor-pointer",
                "bg-gray-800",
                "text-white",
                "inline-block" // Add this class to display the remove button inline
            );
            removeButton.dataset.position = selectedPosition;
            removeButton.innerHTML = "&times;"; // Display "×" symbol

            // Append elements to position item
            newPositionItem.appendChild(newPositionText);
            newPositionItem.appendChild(removeButton);

            // Append position item to container
            document
                .querySelector(".position-container")
                .appendChild(newPositionItem);

            // Create hidden input field to store position
            const hiddenInput = document.createElement("input");
            hiddenInput.type = "hidden";
            hiddenInput.name = "positions[]";
            hiddenInput.value = selectedPosition;
            newPositionItem.appendChild(hiddenInput); // Append hidden input to newPositionItem

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

            const matchedPositionToRemove = event.target.dataset.position;
            const matchedPositionContainer = event.target.closest(
                ".position-container"
            );

            event.target.closest(".position-item").remove();

            const hiddenInputsToRemove =
                matchedPositionContainer.querySelectorAll(
                    'input[value="' + matchedPositionToRemove + '"]'
                );
            hiddenInputsToRemove.forEach((input) => {
                input.remove();
            });
        }
    });
