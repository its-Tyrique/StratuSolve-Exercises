<?php
    session_start();
    require_once "../includes/db_connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $UserId = $_SESSION['UserId'];
        $FirstName = $_POST['firstName'];
        $LastName = $_POST['lastName'];
        $Email = $_POST['email'];
        $Password = password_hash($_POST['password'], PASSWORD_BCRYPT);
        $ProfilePicture = $_SESSION['ProfilePicture'];


        // Handle profile picture upload
        $ProfilePicture = '';
        if (isset($_FILES["profilePictureInput"]) && $_FILES["profilePictureInput"]["error"] == UPLOAD_ERR_OK) {
            $UploadDir = '../../backend/uploads/user_/'.$_SESSION['UserId'].'/profile_picture';
            $UploadFile = $UploadDir . basename($_FILES['profilePicture']['name']);

            $ImageFileType = strtolower(pathinfo($UploadFile, PATHINFO_EXTENSION));
            $AllowedTypes = array('jpg', 'jpeg', 'png', 'gif');
            $MaxFileSize = 5000000; // 5MB

            if (move_uploaded_file($_FILES['profilePictureInput']['tmp_name'], $UploadFile)) {
                $ProfilePicture = basename($_FILES['profilePicture']['name']);
            }
        }

        // Update profile picture in database
        $UpdateUserStmt = $DBConnectObj->prepare("UPDATE Users SET FirstName=?, LastName=?, Email=?, 
                 Password=?, ProfilePicture=?  WHERE Id=?");
        $UpdateUserStmt->bind_param("sssssi", $FirstName, $LastName, $Email, $Password, $ProfilePicture, $UserId);
        $UpdateUserStmt->execute();

        // Update session variables
        $_SESSION['FirstName'] = $FirstName;
        $_SESSION['LastName'] = $LastName;
        $_SESSION['Email'] = $Email;
        $_SESSION['ProfilePicture'] = $ProfilePicture;

        die(json_encode(array("success" => "Profile updated successfully")));
    }
    die(json_encode(array("error" => "Invalid request")));