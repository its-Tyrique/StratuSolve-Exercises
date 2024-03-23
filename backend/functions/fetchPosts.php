<?php
    session_start();
    require_once "../includes/db_connection.php";

    $FetchpostStmt = $DBConnectObj->prepare("SELECT * FROM Posts ORDER BY Id DESC");
    $FetchpostStmt->execute();
    $Posts = $FetchpostStmt->get_result()->fetch_all(MYSQLI_ASSOC);

    die(json_encode($Posts));