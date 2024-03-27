<?php
    require_once("../../backend/functions/checkAuthentication.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Home feed</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <style>
        body {
            background-color: #B6E9EB; /* Light blue background */
        }

        .nav-pills .nav-link.active {
            background-color: #0BA5F1; /* Blue active link background */
            color: #FFFFFF; /* White active link text */
        }

        .nav-pills .nav-link {
            color: #09192B; /* Dark blue link text */
        }

        .form-control {
            background-color: #FEF9EA; /* Light yellow form background */
            color: #09192B; /* Dark blue input text */
            border-color: #1CCDFB; /* Light blue border color */
        }

        .btn-primary {
            background-color: #09192B; /* Dark blue button background */
            border-color: #09192B; /* Dark blue button border */
        }

        .btn-primary:hover {
            background-color: #1CCDFB; /* Light blue button background on hover */
            border-color: #1CCDFB; /* Light blue button border on hover */
        }

        .card {
            background-color: #FEF9EA; /* Light yellow card background */
            border-color: #1CCDFB; /* Light blue card border */
        }

        .card-header {
            background-color: #0BA5F1; /* Blue card header background */
            color: #FFFFFF; /* White card header text */
        }
    </style>
</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-4">
                <ul class="nav flex-column nav-pills">
                    <li>
                        <img src="../assets/howzit_logo.jpeg" class="img-fluid rounded-circle" alt="Howzit Logo">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="profile-button" href="profile.php">Profile</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../../backend/functions/logout.php">Log-Out</a>
                    </li>
                    <!-- Add more navigation links as needed -->
                </ul>
            </div>
            <!-- Main Content -->
            <div class="col-md-8">

                <!-- Post Form -->
                <form id="post-form" action="#" method="post" enctype="multipart/form-data" role="form">
                    <div class="mb-3">
                        <label for="post-text" class="form-label">What's on your mind?</label>
                        <textarea class="form-control" id="post-text" name="PostText" rows="3" placeholder="Tune them like a radio!"></textarea>
                    </div>

                    <!-- Image upload icon -->
                    <label for="post-image" class="form-label" id="post-image-label">
                        <img src="../assets/image_icon.png" alt="Upload Image" width="50px" height="50px">
                    </label>
                    <input type="file" class="form-label visually-hidden" id="post-image" name="PostImage">
                    <!--<div class="mb-3">
                        <label for="post-image" class="form-label">Upload Image</label>
                        <input type="file" class="form-label" id="post-image" name="PostImage">
                    </div> -->
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
                <hr>

                <!-- Loading spinner -->
                <div id="loading-spinner" class="text-center" style="display: none;">
                    <div class="spinner-border" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                </div>

                <!-- Post Cards -->
                <div class="card mb-3" id="post-container">
                    <div class="card-header">
                        <div class="d-flex justify-content-between align-items-center">
                            <div>
                                <img src="../assets/user.svg" class="rounded-circle me-2" alt="User Avatar" style="width: 30px; height: 30px;">
                                <span class="fw-bold">Username</span>
                            </div>
                            <div>
                                <small class="text-muted">2 mins ago</small>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <p class="card-text">Post content goes here...</p>
                    </div>
                    <div class="card-footer">
                        <button type="button" class="btn btn-outline-primary btn-sm me-2">Like</button>
                        <button type="button" class="btn btn-outline-secondary btn-sm me-2">Comment</button>
                    </div>
                </div>
                <div id="end-of-content-indicator" class="alert alert-secondary text-center" style="display: none;">
                    <h3 class="mb-0">End of content</h3>
                </div>
                <!-- Add more post cards dynamically based on user posts -->
            </div>
        </div>
    </div>
<script src="../js/home.js"></script>
</body>
</html>