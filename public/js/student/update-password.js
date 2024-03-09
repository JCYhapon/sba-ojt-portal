document.addEventListener("DOMContentLoaded", function () {
    const passwordInput = document.getElementById("new_password");
    const confirmInput = document.getElementById("confirm_password");
    const checkboxes = document.querySelectorAll(
        '#passwordRequirements input[type="checkbox"]'
    );
    const submitButton = document.getElementById("submitButton");

    function validatePassword() {
        const password = passwordInput.value;
        const confirm = confirmInput.value;

        const isLengthValid = password.length >= 8 && password.length <= 12;
        const hasUpperCase = /[A-Z]/.test(password);
        const hasNumber = /\d/.test(password);
        const hasSpecialChar = /[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(
            password
        );
        const isConfirmed = password === confirm;

        checkboxes[0].checked = isLengthValid;
        checkboxes[1].checked = hasUpperCase;
        checkboxes[2].checked = hasNumber;
        checkboxes[3].checked = hasSpecialChar;
        checkboxes[4].checked = isConfirmed;

        // Enable/disable submit button based on password requirements
        submitButton.disabled = !(
            isLengthValid &&
            hasUpperCase &&
            hasNumber &&
            hasSpecialChar &&
            isConfirmed
        );

        // Change button color based on password requirements and confirmation
        if (isConfirmed) {
            submitButton.classList.remove("bg-gray-800"); // Remove gray background
            submitButton.classList.add("bg-[#AD974F]"); // Add custom background color
        } else {
            submitButton.classList.remove("bg-[#AD974F]"); // Remove custom background color
            submitButton.classList.add("bg-gray-800"); // Add gray background
        }
    }

    passwordInput.addEventListener("input", validatePassword);
    confirmInput.addEventListener("input", validatePassword); // Update confirmation status when confirm input changes
});
