<?php
    session_start();
    require_once "../includes/db_connection.php";

    if (isset($_POST['Email'], $_POST['Password'])) {
        $EmailStr = $_POST['Email'];
        $PasswordStr = $_POST['Password'];

        if (empty($EmailStr) || empty($PasswordStr)) {
            die(json_encode(array("error" => "Please enter email and password")));
        }

        $LoadUserStmt = $DBConnectObj->prepare("SELECT * FROM Users WHERE Email = ?");
        $LoadUserStmt->bind_param("s", $EmailStr);
        $LoadUserStmt->execute();
        $LoadUserResult = $LoadUserStmt->get_result();

        if ($LoadUserResult->num_rows > 0) {
            $UserRow = $LoadUserResult->fetch_assoc();
            if (password_verify($PasswordStr, $UserRow['Password'])) {

                // Set session variables
                $_SESSION['UserId'] = $UserRow['Id'];
                $_SESSION['FirstName'] = $UserRow['FirstName'];
                $_SESSION['LastName'] = $UserRow['LastName'];
                $_SESSION['Email'] = $UserRow['Email'];
                $_SESSION['Password'] = $UserRow['Password'];
                $_SESSION['ProfilePicture'] = $UserRow['ProfilePicture'];
//                header('Location: ../../frontend/pages/home.php');

                die(json_encode(array("success" => "User logged in")));
            } else {
                die(json_encode(array("error" => "Incorrect password")));
            }
        } else {
            die(json_encode(array("error" => "User not found")));
        }
    }