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

</head>

<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-4">
                <ul class="nav flex-column nav-pills">
                    <li>
                        <img src="../assets/howzit_logo.jpeg" class="img-fluid" alt="Howzit Logo">
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="home.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="profile.php">Profile</a>
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
                        <textarea class="form-control" id="post-text" name="PostText" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="post-image" class="form-label">Upload Image</label>
                        <input type="file" class="form-label" id="post-image" name="PostImage">
                    </div>
                    <button type="submit" class="btn btn-primary">Post</button>
                </form>
                <hr>
                <!-- Post Cards -->
                <div class="card mb-3">
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
                <!-- Add more post cards dynamically based on user posts -->
            </div>
        </div>
    </div>
<script src="../js/home.js"></script>
</body>
</html>