document.addEventListener("DOMContentLoaded", function() {
    var loginForm = document.getElementById("loginForm");

    // Function to validate email format
    function validateEmailFormat(email) {
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        return emailRegex.test(email);
    }

    // Function to validate password length
    function validatePasswordLength(password) {
        return password.length >= 6;
    }

    // Function to update validation message for an input field
    function updateValidationMessage(inputElement, isValid, message) {
        var errorElement = document.getElementById(inputElement.id + "ValidationMessage"); // Get the error message element
        if (isValid) {
            errorElement.textContent = ''; // Clear error message
            inputElement.classList.remove("is-invalid"); // Remove "is-invalid" class for Bootstrap validation
        } else {
            errorElement.textContent = message; // Display error message
            inputElement.classList.add("is-invalid"); // Add "is-invalid" class for Bootstrap validation
        }
    }

    // Add event listeners to input fields for real-time validation
    var emailInput = document.getElementById("LoginEmail");
    emailInput.addEventListener("input", function() {
        var email = emailInput.value.trim();
        var isValid = validateEmailFormat(email);
        updateValidationMessage(emailInput, isValid, 'Invalid email format.');
    });

    var passwordInput = document.getElementById("LoginPassword");
    passwordInput.addEventListener("input", function() {
        var password = passwordInput.value.trim();
        var isValid = validatePasswordLength(password);
        updateValidationMessage(passwordInput, isValid, 'Password must be at least 6 characters long.');
    });

    loginForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        var email = emailInput.value.trim();
        var password = passwordInput.value.trim();

        // Perform final validation before submitting the form
        var isEmailValid = validateEmailFormat(email);
        var isPasswordValid = validatePasswordLength(password);

        // Check if both email and password are valid
        if (!isEmailValid || !isPasswordValid) {
            // Display SweetAlert to show error message
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Email and password is incorrect. Please try again.',
                showConfirmButton: true
            });
            return;
        }

        // AJAX request to submit form data to the server
        $.post("../../backend/functions/loadUser.php", { Email: email, Password: password })
            .done(function(response) {
                // Handle successful response from the server
                var data = JSON.parse(response);
                if (data.success) {
                    window.location.href = "home.php"; // Redirect to home page
                } else {
                    // Display error message from the server
                    Swal.fire({
                        icon: 'error',
                        title: 'Error!',
                        text: data.error || 'An error occurred while processing your request.',
                        showConfirmButton: true
                    });
                }
            })
            .fail(function(error) {
                // Display error message if AJAX request fails
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to authenticate. Please try again later.',
                    showConfirmButton: true
                });
            });
    });

    // Add event listener to the "Sign up" button
    var signUpButton = document.querySelector("#signUpBtn");
    if (signUpButton) {
        signUpButton.addEventListener("click", function(event) {
            // Redirect to sign_up.html when "Sign up" button is clicked
            window.location.href = "sign_up.html";
        });
    }

    // Function to toggle password visibility
    function togglePasswordVisibility() {
        var passwordInput = document.getElementById("LoginPassword");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }

    // Add event listener to the password toggle button
    var passwordToggleBtn = document.querySelector(".password-toggle");
    if (passwordToggleBtn) {
        passwordToggleBtn.addEventListener("click", togglePasswordVisibility);
    }
});
