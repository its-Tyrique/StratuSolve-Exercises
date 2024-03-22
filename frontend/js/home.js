document.addEventListener("DOMContentLoaded", function() {
    let postForm = document.getElementById("post-form");

    postForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(postForm); // Create a FormData object to store form data

        // Send form data to the backend using AJAX
        $.ajax({
            url: "../../backend/functions/createPost.php",
            method: "POST",
            data: formData, // Use the FormData object
            contentType: false,
            processData: false,
            success: function(response) {
                console.log("Ajax request succeeded.");
                console.log(response);
                let data = JSON.parse(response);
                if (data.success) {
                    // Handle success
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Post created successfully!',
                        showConfirmButton: false
                    });
                } else {
                    // Handle errors
                    errorMessages = data.error ;

                    Swal.fire({
                        icon: 'error',
                        title: 'oh no!',
                        text: errorMessages,
                        showConfirmButton: true
                    })
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", error);
                Swal.fire({
                    icon: 'error',
                    title: 'oh no!',
                    text: 'Back-end error occurred.',
                    showConfirmButton: true
                });
            }
        });
    });
});
