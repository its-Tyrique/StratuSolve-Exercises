document.addEventListener("DOMContentLoaded", function() {
    // Get the form and input elements
    let postForm = document.getElementById("post-form");
    let postImageLabel = document.getElementById("post-image-label");
    let postImageInput = document.getElementById("post-image");

    // Event listener for form submission
    postForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let formData = new FormData(postForm); // Create FormData object to store form data

        // Send form data to the backend using AJAX
        $.ajax({
            url: "../../backend/functions/createPost.php",
            method: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function(response) {
                console.log("Ajax request succeeded.");
                console.log(response);
                let data = JSON.parse(response);
                if (data.success) {
                    // Handle success
                    showSuccessMessage("Post created successfully!");
                    resetForm();
                    resetImageIcon();
                    fetchAllPosts();
                } else {
                    // Handle errors
                    showErrorMessage(data.error);
                }
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", error);
                showErrorMessage("Back-end error occurred.");
            }
        });
    });

    function logout() {
        $.ajax({
            url: "../../backend/functions/logout.php",
            method: "POST",
            success: function(response) {
                window.location.href = "index.php";
            },
            error: function(xhr, status, error) {
                console.error("AJAX request failed:", error);
                showErrorMessage("Back-end error occurred.");
            }
        });
    }

    let logoutLink = document.querySelector('a[href="index.php"]');
    if (logoutLink) {
        logoutLink.addEventListener("click", function (event) {
            event.preventDefault();
            logout();
        });
    }

    // Event listener for file input change
    postImageInput.addEventListener("change", function() {
        if (postImageInput.files.length > 0) {
            updateImageIcon("../assets/uploaded_image_icon.png");
        } else {
            updateImageIcon("../assets/image_icon.png");
        }
    });

    // Function to show success message
    function showSuccessMessage(message) {
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: message,
            showConfirmButton: false
        });
    }

    // Function to show error message
    function showErrorMessage(message) {
        Swal.fire({
            icon: 'error',
            title: 'Oh no!',
            text: message,
            showConfirmButton: true
        });
    }

    // Function to reset the form
    function resetForm() {
        postForm.reset();
    }

    // Function to reset the image icon
    function resetImageIcon() {
        postImageLabel.innerHTML = '<img src="../assets/image_icon.png" alt="Upload Image" width="50px" height="50px">';
    }

    // Function to update the image icon
    function updateImageIcon(src) {
        postImageLabel.innerHTML = '<img src="../assets/uploaded_image.png" alt="Uploaded Image" width="50px" height="50px">';
    }

    // Function to show loading spinner
    function showLoadingSpinner() {
        document.getElementById("loading-spinner").style.display = "block";
    }

    function hideLoadingSpinner() {
        document.getElementById("loading-spinner").style.display = "none";
    }

    let postsLoaded = false;
    function showLoadingSpinner() {
        Swal.fire({
            title: 'Loading',
            allowOutsideClick: false,
            showConfirmButton: false,
            willOpen: () => {
                Swal.showLoading();
            }
        });
    }

    function fetchAllPosts() {
        // Clear existing posts
        document.getElementById("post-container").innerHTML = "";

        if (!postsLoaded === true) {
            showLoadingSpinner();
        }

        $.get("../../backend/functions/fetchPosts.php", function (data) {
            let posts =JSON.parse(data);

            // Clear existing posts
            document.getElementById("post-container").innerHTML = "";

            posts.forEach(function(post) {
                // Create card element
                let card = document.createElement("div");
                card.classList.add("card", "mb-3");

                // Create card header
                let cardHeader = document.createElement("div");
                cardHeader.classList.add("card-header");

                // Create header content
                let headerContent = document.createElement("div");
                headerContent.classList.add("d-flex", "justify-content-between", "align-items-center");

                // Create user avatar
                let userAvatar = document.createElement("img");
                userAvatar.src = post.ProfilePicture;
                userAvatar.classList.add("rounded-circle", "me-2");
                userAvatar.alt = "User Avatar";
                userAvatar.style.width = "30px";
                userAvatar.style.height = "30px";

                // Create username
                let username = document.createElement("span");
                username.classList.add("fw-bold");
                username.textContent = post.FirstName+" "+post.LastName;

                // Create div for timestamp container
                let timestampContainer = document.createElement("div");

                // Create timestamp
                let timestamp = document.createElement("small");
                timestamp.classList.add("text-muted");
                timestamp.textContent = post.PostTimeStamp;

                // Append elements to header content
                headerContent.appendChild(userAvatar);
                headerContent.appendChild(username);
                headerContent.appendChild(timestampContainer); // Append timestamp container

                // Append timestamp to timestamp container
                timestampContainer.appendChild(timestamp);

                // Append header content to card header
                cardHeader.appendChild(headerContent);


                // Create card body
                let cardBody = document.createElement("div");
                cardBody.classList.add("card-body");

                // Create card text
                let cardText = document.createElement("p");
                cardText.classList.add("card-text");
                cardText.textContent = post.PostText;

                // Append card text to card body
                cardBody.appendChild(cardText);

                // Check if post has an image
                if (post.PostImage) {
                    // Create image element
                    let postImage = document.createElement("img");
                    postImage.classList.add("img-fluid");
                    postImage.src = post.PostImage;
                    postImage.alt = "Post Image";
                    postImage.style.maxWidth = "300px";

                    // Append image to card body
                    cardBody.appendChild(postImage);
                }

                // Create card footer
                let cardFooter = document.createElement("div");
                cardFooter.classList.add("card-footer");

                // Create like button
                let likeButton = document.createElement("button");
                likeButton.setAttribute("type", "button");
                likeButton.classList.add("btn", "btn-outline-primary", "btn-sm", "me-2");
                likeButton.textContent = "Like";

                // Create comment button
                let commentButton = document.createElement("button");
                commentButton.setAttribute("type", "button");
                commentButton.classList.add("btn", "btn-outline-secondary", "btn-sm", "me-2");
                commentButton.textContent = "Comment";

                // Append buttons to card footer
                cardFooter.appendChild(likeButton);
                cardFooter.appendChild(commentButton);

                // Append card header, body, and footer to card
                card.appendChild(cardHeader);
                card.appendChild(cardBody);
                card.appendChild(cardFooter);

                // Append card to the container
                document.getElementById("post-container").appendChild(card);
            });
            postsLoaded = true;
            Swal.close();
        });
    }

    // Function to navigate to the profile page
    function navigateToProfile() {
        window.location.href = "profile.php";
    }

    // Event listener for navigating to profile page
    let profileButton = document.getElementById("profile-button");
    profileButton.addEventListener("click", navigateToProfile);

    function shortPolling() {
        setInterval(fetchAllPosts, 5000);
    }

    fetchAllPosts();
    // shortPolling();
});
