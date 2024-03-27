<?php
    require_once "../includes/db_connection.php";

    // Function to generate a random verification token
    function generateVerificationToken() {
        return bin2hex(random_bytes(32));
    }

    $FirstNameStr = htmlspecialchars($_POST['FirstName']);
    $LastNameStr = htmlspecialchars($_POST['LastName']);
    $EmailStr = htmlspecialchars($_POST['Email']);
    $PasswordStr = htmlspecialchars($_POST['Password']);
    $ConfirmPasswordStr = htmlspecialchars($_POST['ConfirmPassword']);

    if ($PasswordStr !== $ConfirmPasswordStr) {
        die(json_encode(array("error" => "Passwords do not match")));
    }

    // Set default profile picture
    $ProfilePictureStr = "../assets/user.svg";

    // Generate a verification token
    $VerificationTokenStr = generateVerificationToken();

    if (isset($_POST['FirstName'], $_POST['LastName'], $_POST['Email'], $_POST['Password'], $_POST['ConfirmPassword'])) {
        $HashedPassword = password_hash($PasswordStr, PASSWORD_BCRYPT);

        $CreateUserStmt = $DBConnectObj->prepare("INSERT INTO Users (FirstName, LastName, 
                                            Email, Password, ProfilePicture, VerificationToken) VALUES (?, ?, ?, ?, ?, ?)");
        $CreateUserStmt->bind_param("ssssss", $FirstNameStr, $LastNameStr, $EmailStr,
            $HashedPassword, $ProfilePictureStr, $VerificationTokenStr);
        $CreateUserStmt->execute();
        $CreateUserStmt->close();

        // Send verification email
        require 'sendVerificationEmail.php';
        sendVerificationEmail($EmailStr, $VerificationTokenStr);

        header('Location: ../../frontend/pages/index.php');
    }
