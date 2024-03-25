<?php
    session_start();
    require_once "../includes/db_connection.php";
    function getDefaultFilePath($UserIDInt) {
        return '../../backend/uploads/user_'."$UserIDInt".'/profile_picture/';
    }

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Retrieve form data
        $UserIDInt = $_SESSION['UserId'];
        $FirstNameStr = htmlspecialchars($_POST['firstName']);
        $LastNameStr = htmlspecialchars($_POST['lastName']);
        $EmailStr = htmlspecialchars($_POST['email']);

        if (!isset($_POST['password'])) {
            $PasswordStr = $_SESSION['Password'];
        } else {
            $PasswordStr = password_hash($_POST['password'], PASSWORD_BCRYPT);
        }

        $ProfilePictureStr = $_SESSION['ProfilePicture'];

        if (!isset($_POST['password'])) {
            $PasswordStr = $_SESSION['Password'];
        }

        $UploadDirStr = getDefaultFilePath($UserIDInt);
        if (!is_dir($UploadDirStr)) {
            mkdir($UploadDirStr, 0777, true);
        }

        // Handle profile picture upload
        if (isset($_FILES['profilePicture']) && $_FILES['profilePicture']['error'] === UPLOAD_ERR_OK) {

            $ImageFileType = strtolower(pathinfo($UploadDirStr, PATHINFO_EXTENSION));
            $AllowedTypes = array('jpg', 'jpeg', 'png', 'gif', 'svg');
            $MaxFileSize = 5000000; // 5MB

            $FileNameStr = $_FILES['profilePicture']['name'];
            $FileTmpNameStr = $_FILES['profilePicture']['tmp_name'];
            $FileSizeInt = $_FILES['profilePicture']['size'];

            $UniqueFileNameStr = uniqid().'_'.$FileNameStr;
            $DestinationPathStr = $UploadDirStr.$UniqueFileNameStr;

            if (move_uploaded_file($_FILES['profilePicture']['tmp_name'], $DestinationPathStr)) {
                $ProfilePictureStr = $DestinationPathStr;
            } else {
                $ProfilePictureStr = "../assets/user.svg";
            }
        } else {
            $ProfilePictureStr = $_SESSION['ProfilePicture'];
        }

        // Update profile picture in database
        $UpdateUserStmt = $DBConnectObj->prepare("UPDATE Users SET FirstName=?, LastName=?, Email=?, 
                 Password=?, ProfilePicture=?  WHERE Id=?");
        $UpdateUserStmt->bind_param("sssssi", $FirstNameStr, $LastNameStr, $EmailStr, $PasswordStr, $ProfilePictureStr, $UserIDInt);
        $UpdateUserStmt->execute();

        // Update session variables
        $_SESSION['FirstName'] = $FirstNameStr;
        $_SESSION['LastName'] = $LastNameStr;
        $_SESSION['Email'] = $EmailStr;
        $_SESSION['ProfilePicture'] = $ProfilePictureStr;

        die(json_encode(array("success" => "Profile updated successfully")));
    }
    die(json_encode(array("error" => "Invalid request")));