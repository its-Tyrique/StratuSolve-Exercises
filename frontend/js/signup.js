document.getElementById("signUpForm").addEventListener("submit", function(event) {
    event.preventDefault(); // Prevent the default form submission

    // Retrieve form data
    var firstName = document.getElementById("FirstName").value;
    var lastName = document.getElementById("LastName").value;
    var email = document.getElementById("Email").value;
    var password = document.getElementById("Password").value;
    var confirmPassword = document.getElementById("ConfirmPassword").value;

    // Validate form fields
    if (firstName === '' || lastName === '' || email === '' || password === '' || confirmPassword === '') {
        // Display SweetAlert to show error message
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'All fields are required.',
            showConfirmButton: true
        });
        return;
    }

    // Validate email format
    var emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
    if (!emailRegex.test(email)) {
        // Display SweetAlert to show error message
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Invalid email format.',
            showConfirmButton: true
        });
        return;
    }

    // Validate password length
    if (password.length < 3) {
        // Display SweetAlert to show error message
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Password must be at least 6 characters long.',
            showConfirmButton: true
        });
        return;
    }

    // Validate password match
    if (password !== confirmPassword) {
        // Display SweetAlert to show error message
        Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Passwords do not match.',
            showConfirmButton: true
        });
        return;
    }

    // AJAX request to submit form data to the server
    $.post("../../backend/functions/createUser.php", {FirstName: firstName, LastName: lastName, Email: email, Password: password, ConfirmPassword: confirmPassword})
        .done(function(response) {
            // Display SweetAlert to confirm successful sign-up
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: 'Sign-up successful!',
                showConfirmButton: false,
                timer: 4500 // Automatically close after 2 seconds
            }).then(function() {
                // Redirect to another page or perform any additional action
                window.location.href = "index.html"; // Example redirection
            });
        })
        .fail(function(error) {
            // Display SweetAlert to show error message
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Failed to sign up.',
                showConfirmButton: true
            });
        });
});
