$(document).ready(function() {
    // Add event listener for profile form submission
    $("#profile-form").submit(function(event) {
        event.preventDefault();

        // Serialize form data
        var formData = $(this).serialize();

        // Send AJAX request to update_profile.php
        $.ajax({
            url: "../../backend/functions/updateProfile.php",
            method: "POST",
            data: formData,
            dataType: "json",
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

    document.getElementById("profilePictureContainer").addEventListener("click", function() {
        // Trigger click event on the hidden file input
        document.getElementById("profilePictureInput").click();
    });

});

