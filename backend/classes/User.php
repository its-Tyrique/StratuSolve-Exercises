<?php
    namespace classes;
    include_once "../includes/db_connection.php";
    class User {
        private $DBConnectObj;

        public function __construct($DBConnectObj) {
            $this->DBConnectObj = $DBConnectObj;
        }

        // CRUD methods for users
        function createUser($FirstNameStr, $LastNameStr, $EmailStr, $PasswordStr) {
            $CreateUserStmt = $this->DBConnectObj->prepare("INSERT INTO Users (FirstName, LastName, 
                                        Email, Password) VALUES (?, ?, ?, ?)");
            $CreateUserStmt->bind_param("ssss", $FirstNameStr, $LastNameStr, $EmailStr, $PasswordStr);

            if (!$CreateUserStmt->execute()) {
                die(json_encode(array("error" => "Error creating user: " . $CreateUserStmt->error)));
            } die(json_encode(array("success" => "User created successfully")));
        }

        function loadUser($userIdInt) {
        }

        function saveUser($PersonIdInt, $FirstNameStr, $LastNameStr, $EmailStr, $PasswordStr) {

        }

        function deleteUser($UserIdInt) {

        }

        function loadAllUsers() {

        }

        function deleteAllUsers() {
        }
    }
    $UserObj = new \classes\User($DBConnectObj);

    error_log('POST Data: ' . print_r($_POST, true));

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        file_put_contents("Text.txt", error_log('POST Data: ' . print_r($_POST, true)));
        switch (true) {
            case isset($_POST['FirstName'], $_POST['LastName'], $_POST['Email'], $_POST['Password'], $_POST['ConfirmPassword']):

                $UserObj->createUser($_POST['FirstName'], $_POST['LastName'], $_POST['Email'], $_POST['Password']);
                file_put_contents("Reach.txt", print_r($_POST, true));

                die(json_encode(array("error" => "We are here")));

            default:
                die(json_encode(array("error" => "Invalid request")));
        }
    }