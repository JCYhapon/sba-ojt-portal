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
                "bg-gray-800",
                "text-white"
            );
            newPositionText.textContent = customPosition;

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
            removeButton.dataset.position = customPosition;

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
                "bg-gray-800",
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