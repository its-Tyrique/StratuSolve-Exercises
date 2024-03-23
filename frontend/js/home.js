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

    /*function fetchAllPosts() {
        $.get("../../backend/functions/fetchPosts.php", function (data) {
            let posts =JSON.parse(data);

            // Clear existing posts
            document.getElementById("post-container").innerHTML = "";

            posts.forEach(function (post) {
                let postContainer = document.createElement("div");
                postContainer.classList.add("card", "mb-3");

                let cardHeader = document.createElement("div");
                cardHeader.classList.add("card-header");

                let card = document.createElement("div");

                let PosterProfilePic = document.createElement("img");
                PosterProfilePic.src = "../assets/user.svg";
                PosterProfilePic.classList.add("rounded-circle me-2");

                let PosterName = document.createElement("span");
                PosterName.classList.add("fw-bold");
                PosterName.textContent = post.PosterName;

                let cardBody = document.createElement("div");
                cardBody.classList.add("card-body");

                let cardText = document.createElement("p");
                cardText.classList.add("card-text");
                cardText.textContent = post.PostText;

                cardBody.appendChild(cardText);
                card.appendChild(cardBody);

                // Append the card to the post container
                document.getElementById("post-container").appendChild(card);
            });
        });
    }*/

    function shortPolling() {
        setInterval(fetchAllPosts, 5000);
    }

    fetchAllPosts();
    shortPolling();
});
