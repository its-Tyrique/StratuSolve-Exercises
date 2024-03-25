<?php
    session_start();

    if (!isset($_SESSION['UserId'])) {
        header("Location: ../../frontend/pages/Index.php?message=not_authenticated");
        exit();
    }