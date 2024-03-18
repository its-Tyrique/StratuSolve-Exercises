<?php
    require_once "../includes/db_connection.php";
    $conn = $DBConnectObj;

    $FirstNameStr = htmlspecialchars($_POST['FirstName']);
    $LastNameStr = htmlspecialchars($_POST['LastName']);
    $EmailStr = htmlspecialchars($_POST['Email']);
    $PasswordStr = htmlspecialchars($_POST['Password']);
    $ConfirmPasswordStr = htmlspecialchars($_POST['ConfirmPassword']);

    if ($PasswordStr !== $ConfirmPasswordStr) {
        die(json_encode(array("error" => "Passwords do not match")));
    }

    if (isset($_POST['FirstName'], $_POST['LastName'], $_POST['Email'], $_POST['Password'], $_POST['ConfirmPassword'])) {
        $HashedPassword = password_hash($PasswordStr, PASSWORD_BCRYPT);

        $CreateUserStmt = $DBConnectObj->prepare("INSERT INTO Users (FirstName, LastName, 
                                            Email, Password) VALUES (?, ?, ?, ?)");
        $CreateUserStmt->bind_param("ssss", $FirstNameStr, $LastNameStr, $EmailStr, $HashedPassword);
        $CreateUserStmt->execute();
        $CreateUserStmt->close();

        header('Location: ../../frontend/pages/index.html');
    }
