<?php
    require_once "../includes/db_connection.php";

    if (isset($_GET['email']) && isset($_GET['token'])) {
        $EmailStr = $_GET['email'];
        $TokenStr = $_GET['token'];

        $VerifyUserStmt = $DBConnectObj->prepare("UPDATE Users SET IsVerified=1 WHERE Email=? AND VerificationToken=?");
        $VerifyUserStmt->bind_param("ss", $EmailStr, $TokenStr);
        $VerifyUserStmt->execute();
        $VerifyUserStmt->close();

        header('Location: ../../frontend/pages/index.php');
    }