document.addEventListener("DOMContentLoaded", function() {
    let postForm = document.getElementById("post-form");

    postForm.addEventListener("submit", function(event) {
        event.preventDefault();

        let postContent = document.getElementById("post-content").value.trim();
        let postImage = document.getElementById("post-image").files[0];

        postContent = sanitizeHTML(postContent);

        $.post("../../backend/functions/createPost.php", {PostContent: postContent, PostImage: postImage})
        .done(function (response){
            let data = JSON.parse(response);
            if (data.success) {

            }
            let errorMessages = '';
            if (data.error) {
            }
        })
    });

    // Basic HTML sanitization function
    function sanitizeHTML(input) {
        return input.replace(/<[^>]*>?/gm, '');
    }
}