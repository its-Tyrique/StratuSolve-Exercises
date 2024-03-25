$(document).ready(function() {
    // Function to validate profile form fields
    function validateProfileForm() {
        var profilePicture = document.getElementById("profilePictureInput").files[0];
        var firstName = document.getElementById("firstName").value.trim();
        var lastName = document.getElementById("lastName").value.trim();
        var email = document.getElementById("email").value.trim();
        var password = document.getElementById("password").value.trim();

        // Perform validation checks
        if (password.length < 6) {
            // Display error message for password length
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'Password must be at least 6 characters long'
            });
            return false;
        }

        // Check if any form field is empty
        if (firstName === '' || lastName === '' || email === '' || password === '') {
            return false;
        }

        // Return true if all validation checks pass
        return true;
    }

    // Add event listener for profile form submission
    $("#profile-form").submit(function(event) {
        event.preventDefault();

        // Trigger validation function before form submission
        if (!validateProfileForm()) {
            // If validation fails, prevent form submission
            return;
        }

        // Serialize form data
        var formData = new FormData(this);

        // Send AJAX request to update_profile.php
        $.ajax({
            url: "../../backend/functions/updateProfile.php",
            method: "POST",
            data: formData,
            dataType: "json",
            contentType: false,
            processData: false,
            success: function(response) {
                // Display success messages
                Swal.fire({
                    icon: 'success',
                    title: 'Profile Updated',
                    text: response.success
                });

                // Optionally, update the displayed user information on the page
                // You can retrieve the updated information from the form fields if needed
            },
            error: function(xhr, status, error) {
                // Display error message if the AJAX request fails
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Failed to update profile'
                });
            }
        });
    });

    // Add event listener for profile form button click
    $("#submitProfileBtn").click(function() {
        // Trigger form submission when button is clicked
        $("#profile-form").submit();
    });

    document.getElementById("profilePictureContainer").addEventListener("click", function() {
        // Trigger click event on the hidden file input
        document.getElementById("profilePictureInput").click();
    });

});
