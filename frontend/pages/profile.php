<?php
    require_once("../../backend/functions/checkAuthentication.php");
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Profile</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/profile.js"></script>

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

        .img-thumbnail {
            border-color: #1CCDFB; /* Light blue border color for profile picture */
        }
    </style>

</head>

<body>

<div class="container-fluid">
    <div class="row">
        <div class="col-md-4">
            <ul class="nav flex-column nav-pills">
                <li>
                    <img src="../assets/howzit_logo.jpeg" class="img-fluid rounded-circle" alt="Howzit Logo">
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="home.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link active" href="profile.php">Profile</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="../../backend/functions/logout.php">Log-Out</a>
                </li>
                <!-- Add more navigation links as needed -->
            </ul>
        </div>
        <div class="col-md-8">
            <div class="row">
                <div class="col-md-12">
                    <!-- Display user information -->
                    <h2>Profile Information</h2>
                    <form id="profile-form" action="../../backend/functions/updateProfile.php" method="post" enctype="multipart/form-data">
                        <!-- Profile Picture -->
                        <div class="mb-3" id="profilePictureContainer">
                            <?php if (!empty($_SESSION['ProfilePicture'])): ?>
                                <img src="../profile_pictures/<?php echo $_SESSION['ProfilePicture']; ?>" alt="Profile Picture" class="img-thumbnail" id="profilePictureImage" style="max-width: 150px;">
                            <?php else: ?>
                                <img src="../assets/user.svg" alt="Profile Picture" class="img-thumbnail" id="profilePictureImage" style="max-width: 150px;">
                            <?php endif; ?>
                            <!-- Hidden file input -->
                            <input type="file" class="form-control visually-hidden" id="profilePictureInput" name="profilePicture">
                        </div>
                        <!-- First Name -->
                        <div class="mb-3">
                            <label for="firstName" class="form-label">First name</label>
                            <input type="text" class="form-control" id="firstName" name="firstName" placeholder="First name" value="<?php echo $_SESSION['FirstName']; ?>">
                        </div>
                        <!-- Last Name -->
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="lastName" placeholder="Last name" value="<?php echo $_SESSION['LastName']; ?>">
                        </div>
                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" class="form-control" id="email" name="email" placeholder="Email address" value="<?php echo $_SESSION['Email']; ?>" readonly>
                        </div>
                        <!-- Change Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">Change Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter new password">
                        </div>
                        <!-- Save Changes button -->
                        <button type="submit" class="btn btn-primary">Save Changes</button>
                    </form>
                </div>
            </div>
            <!-- TODO add my posts functionality here-->
            <!--
            <div class="row">
                <div class="card mb-12" id="post-container">
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
            </div>
            -->
        </div>
    </div>
</div>

</body>

</html>
