document.addEventListener("DOMContentLoaded", function() {
    // Retrieve form elements
    var signUpForm = document.getElementById("signUpForm");
    var firstNameInput = document.getElementById("FirstName");
    var lastNameInput = document.getElementById("LastName");
    var emailInput = document.getElementById("Email");
    var passwordInput = document.getElementById("Password");
    var confirmPasswordInput = document.getElementById("ConfirmPassword");

    // Add event listeners to input fields for real-time validation
    firstNameInput.addEventListener("input", validateFirstName);
    lastNameInput.addEventListener("input", validateLastName);
    emailInput.addEventListener("input", validateEmail);
    passwordInput.addEventListener("input", validatePassword);
    confirmPasswordInput.addEventListener("input", validateConfirmPassword);

    // Function to validate first name
    function validateFirstName() {
        var firstName = firstNameInput.value.trim();
        if (firstName === '') {
            displayError('firstName', 'First name is required.');
        } else {
            clearError('firstName');
        }
    }

    // Function to validate last name
    function validateLastName() {
        var lastName = lastNameInput.value.trim();
        if (lastName === '') {
            displayError('lastName', 'Last name is required.');
        } else {
            clearError('lastName');
        }
    }

    // Function to validate email
    function validateEmail() {
        var email = emailInput.value.trim();
        var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            displayError('email', 'Invalid email format.');
        } else {
            clearError('email');
        }
    }

    // Function to validate password
    function validatePassword() {
        var password = passwordInput.value.trim();
        if (password.length < 6) {
            displayError('password', 'Password must be at least 6 characters long.');
        } else {
            clearError('password');
        }
    }

    // Function to validate confirm password
    function validateConfirmPassword() {
        var confirmPassword = confirmPasswordInput.value.trim();
        var password = passwordInput.value.trim();
        if (confirmPassword !== password) {
            displayError('confirmPassword', 'Passwords do not match.');
        } else {
            clearError('confirmPassword');
        }
    }

    // Function to display error message
    function displayError(fieldId, errorMessage) {
        var errorElement = document.getElementById(fieldId + '-error');
        if (errorElement) {
            errorElement.textContent = errorMessage;
            errorElement.style.display = 'block';
        }
    }

    // Function to clear error message
    function clearError(fieldId) {
        var errorElement = document.getElementById(fieldId + '-error');
        if (errorElement) {
            errorElement.textContent = '';
            errorElement.style.display = 'none';
        }
    }

    // Add submit event listener to form for final validation before submission
    signUpForm.addEventListener("submit", function(event) {
        event.preventDefault(); // Prevent the default form submission

        // Perform final validation before submission
        validateFirstName();
        validateLastName();
        validateEmail();
        validatePassword();
        validateConfirmPassword();

        // Check if there are any visible error messages
        var errorElements = signUpForm.querySelectorAll('.error-message');
        var hasError = false;
        errorElements.forEach(function(element) {
            if (element.textContent !== '') {
                hasError = true;
            }
        });

        // If there are no errors, submit the form
        if (!hasError) {
            submitForm();
        }
    });

    // Function to submit the form using AJAX
    function submitForm() {
        var formData = new FormData(signUpForm);

        // AJAX request to submit form data to the server
        $.ajax({
            url: "../../backend/functions/createUser.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                // Display SweetAlert to confirm successful sign-up
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: 'Sign-up successful!',
                    showConfirmButton: true,
                    // timer: 4500,
                }).then(function() {
                    // Redirect to another page
                    window.location.href = "index.php";
                });
            },
            error: function(xhr, status, error) {
                // Display SweetAlert to show error message
                Swal.fire({
                    icon: 'error',
                    title: 'Error!',
                    text: 'Failed to sign up.',
                    showConfirmButton: true
                });
            }
        });
    }

    document.getElementById("LoginBtn").addEventListener("click", function() {
        window.location.href = "index.php";
    });
});
