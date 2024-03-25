<?php
    session_start();
    require_once "../includes/db_connection.php";

    $fetchPostsQuery = "
            SELECT Posts.*, Users.FirstName, Users.LastName, Users.ProfilePicture
            FROM Posts
            JOIN Users ON Posts.UserId = Users.Id
            ORDER BY Posts.Id DESC
    ";

    $FetchPostStmt = $DBConnectObj->prepare($fetchPostsQuery);
    $FetchPostStmt->execute();
    $Posts = $FetchPostStmt->get_result()->fetch_all(MYSQLI_ASSOC);

    die(json_encode($Posts));