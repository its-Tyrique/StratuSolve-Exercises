document.addEventListener("DOMContentLoaded", function() {
   var loginForm = document.getElementById("loginForm");
    loginForm.addEventListener("submit", function(event){
       event.preventDefault();

        let email = document.getElementById("LoginEmail").value.trim();
        let password = document.getElementById("LoginPassword").value.trim();

        let emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (!emailRegex.test(email)) {
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: 'Invalid email format.',
                showConfirmButton: true
            });
            return;
        }

        $.post("../../backend/functions/loadUser.php", {Email: email, Password: password})
        .done(function(response){

            let data = JSON.parse(response);
            if (data.success) {
                window.location.href = "home.php";
            }

            let errorMessages = '';
            if (data.error) {
                errorMessages = data.error ;

                Swal.fire({
                    icon: 'error',
                    title: 'oh no!',
                    text: errorMessages,
                    showConfirmButton: true
                });
            }
        })
        .fail(function(error){
            Swal.fire({
                icon: 'error',
                title: 'oh no!',
                text: 'Back-end error occurred.',
                showConfirmButton: true
            });
        });
    });

    function togglePasswordVisibility() {
        let passwordInput = document.getElementById("LoginPassword");
        if (passwordInput.type === "password") {
            passwordInput.type = "text";
        } else {
            passwordInput.type = "password";
        }
    }

    let passwordToggleBtn = document.querySelector(".password-toggle");
    if (passwordToggleBtn) {
        passwordToggleBtn.addEventListener("click", togglePasswordVisibility);
    }
});