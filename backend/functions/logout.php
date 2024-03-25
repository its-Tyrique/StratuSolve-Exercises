<?php
    session_start();
    session_destroy();
    session_abort();
    header('Location: ../../frontend/pages/index.php');