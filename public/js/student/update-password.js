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
        const isValid =
            isLengthValid &&
            hasUpperCase &&
            hasNumber &&
            hasSpecialChar &&
            isConfirmed;

        checkboxes[0].checked = isLengthValid;
        checkboxes[1].checked = hasUpperCase;
        checkboxes[2].checked = hasNumber;
        checkboxes[3].checked = hasSpecialChar;
        checkboxes[4].checked = isConfirmed;

        submitButton.disabled = !(
            isLengthValid &&
            hasUpperCase &&
            hasNumber &&
            hasSpecialChar &&
            isConfirmed
        );

        if (isConfirmed && isValid) {
            submitButton.classList.remove("bg-gray-800");
            submitButton.classList.add("bg-[#AD974F]");
        } else {
            submitButton.classList.remove("bg-[#AD974F]");
            submitButton.classList.add("bg-gray-800");
        }
    }

    passwordInput.addEventListener("input", validatePassword);
    confirmInput.addEventListener("input", validatePassword);
});
