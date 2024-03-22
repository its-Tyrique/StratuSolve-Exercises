<?php
    session_start();
    require_once "../includes/db_connection.php";
    function getDefaultFilePath($UserIDInt) {
        return '../uploads/user_'."$UserIDInt".'/';
    }

    if($_SERVER["REQUEST_METHOD"] == "POST"){
        $UserIDInt = $_SESSION['UserId'];
        $UploadDirStr = getDefaultFilePath($UserIDInt);

        if (!is_dir($UploadDirStr)) {
            mkdir($UploadDirStr, 0777, true);
        }

        if (!empty($_POST['PostText'])) {
            $PostContentStr = htmlspecialchars($_POST['PostText']);

            // Check if an image was uploaded
            if (isset($_FILES['PostImage']) && $_FILES['PostImage']['error'] === UPLOAD_ERR_OK) {
                $FileNameStr = $_FILES['PostImage']['name'];
                $FileTmpNameStr = $_FILES['PostImage']['tmp_name'];
                $FileSizeInt = $_FILES['PostImage']['size'];

                $UniqueFileNameStr = uniqid().'_'.$FileNameStr;
                $DestinationPathStr = $UploadDirStr.$UniqueFileNameStr;
                if (move_uploaded_file($FileTmpNameStr, $DestinationPathStr)) {
                    $PostImageStr = $DestinationPathStr;
                } else {
                    die(json_encode(array("error" => "Failed to upload image")));
                }
            } else {
                $PostImageStr = null;
            }

            // Insert post into database
            $InsertPostStmt = $DBConnectObj->prepare("INSERT INTO Posts (PostText, PostImage, UserId) VALUES (?, ?, ?)");
            $InsertPostStmt->bind_param("ssi", $PostContentStr, $PostImageStr, $UserIDInt);

            if ($InsertPostStmt->execute()) {
                die(json_encode(array("success" => "Post created successfully")));
            } else {
                die(json_encode(array("error" => "Failed to create post")));
            }

        } else {
            die(json_encode(array("error" => "Post content is required")));
        }
    }