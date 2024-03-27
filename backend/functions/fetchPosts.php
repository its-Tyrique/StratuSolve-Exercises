<?php
    session_start();
    require_once "../includes/db_connection.php";

    if ($_SERVER["REQUEST_METHOD"] == "GET") {
        $LimitInt = isset($_GET['limit']) ? intval($_GET['limit']) : 10;
        $OffsetInt = isset($_GET['offset']) ? intval($_GET['offset']) : 0;

        $fetchPostsQuery = "
            SELECT Posts.*, Users.FirstName, Users.LastName, Users.ProfilePicture
            FROM Posts
            JOIN Users ON Posts.UserId = Users.Id
            ORDER BY Posts.Id DESC
            LIMIT ?, ?
        ";

        $FetchPostStmt = $DBConnectObj->prepare($fetchPostsQuery);
        $FetchPostStmt->bind_param("ii", $OffsetInt, $LimitInt);
        $FetchPostStmt->execute();
        $Posts = $FetchPostStmt->get_result()->fetch_all(MYSQLI_ASSOC);

        die(json_encode($Posts));
    }