<?php
    $ServerNameStr = "localhost";
    $UserNameStr = "root";
    $PasswordStr = "";
    $DBNameStr = "HowzitDB";

    $DBConnectObj = new mysqli($ServerNameStr, $UserNameStr, $PasswordStr, $DBNameStr);

    if ($DBConnectObj->connect_errno) {
        die("Database Connection failed: " . $DBConnectObj->connect_error);
    }
    return $DBConnectObj;
