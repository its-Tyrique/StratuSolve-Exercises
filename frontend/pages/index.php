<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Login | Sign up</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <style>
        img {
            max-width: 100%;
            height: auto;
        }
        .login-form button {
            margin-top: 20px;
        }
        .password-toggle {
            cursor: pointer;
        }

        body {
            background-color: #B6E9EB; /* Light blue background */
        }

        img {
            max-width: 100%;
            height: auto;
        }

        .login-form {
            background-color: #FEF9EA; /* Light yellow form background */
            border-radius: 10px;
            padding: 20px;
            margin-top: 20px;
        }

        .form-group label {
            color: #09192B; /* Dark blue label text */
        }

        .form-control {
            background-color: #0BA5F1; /* Blue input background */
            color: #09192B; /* Dark blue input text */
            border-color: #1CCDFB; /* Light blue border color */
        }

        .form-control:focus {
            background-color: #0BA5F1; /* Blue input background on focus */
            border-color: #1CCDFB; /* Light blue border color on focus */
            box-shadow: none; /* Remove default focus box shadow */
        }

        .btn-primary {
            background-color: #09192B; /* Dark blue button background */
            border-color: #09192B; /* Dark blue button border */
        }

        .btn-primary:hover {
            background-color: #1CCDFB; /* Light blue button background on hover */
            border-color: #1CCDFB; /* Light blue button border on hover */
        }

        a {
            color: #09192B; /* Dark blue link text */
        }
    </style>

</head>

<body>
<div class="container-fluid">
    <div class="row">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-6">
                    <img id="Logo" alt="Howzit Logo" src="../assets/howzit_logo.jpeg" class="rounded-circle"/>
                </div>
                <div class="col-md-6">
                    <form id="loginForm" action="../../backend/functions/loadUser.php" method="post" role="form" class="login-form">
                        <div class="form-group">
                            <label for="LoginEmail">Email</label>
                            <input type="email" class="form-control" id="LoginEmail" placeholder="Enter email" aria-describedby="emailHelp" required>
                            <div class="invalid-feedback" id="emailValidationMessage"></div>
                        </div>
                        <div class="form-group">
                            <label for="LoginPassword">Password</label>
                            <div class="input-group">
                                <input type="password" class="form-control" id="LoginPassword" placeholder="Password" required>
<!--                                <button type="button" class="btn btn-outline-secondary password-toggle" onclick="togglePasswordVisibility()">-->
<!--                                    <i class="bi bi-eye"></i>-->
<!--                                </button>-->
                            </div>
                            <div class="invalid-feedback" id="passwordValidationMessage"></div>
                        </div>
                        <button type="submit" class="btn btn-primary">Login</button>
                        <button type="submit" class="btn btn-primary" id="signUpBtn">Sign up</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="../js/login.js"></script>
<script>
    <?php

    // Check if the message parameter is present in the URL
    if (isset($_GET['message'])) {
        $message = "";
        // Check the message type
        if ($_GET['message'] == "not_authenticated") {
            $message = "You are not authenticated. Please log in.";
        }
        // Display the message using SweetAlert
        echo "Swal.fire({
                icon: 'error',
                title: 'Authentication Error',
                text: '$message',
                confirmButtonText: 'OK'
            });";
    }
    ?>
</script>
</body>
</html>