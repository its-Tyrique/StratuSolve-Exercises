<?php
    $ServerName = "localhost";
    $UserName = "root";
    $Password ="Summer29#";
    $DBName = "PersonalInfoDB";

    $DBConnect = new mysqli($ServerName, $UserName, $Password, $DBName);

    if ($DBConnect->connect_errno) {
        die("Connection failed: ". $DBConnect->connect_error);
    } echo "Connected successfully";

    class Person {
        // Properties
        public $FirtName, $Surname, $DateOfBirth, $EmailAddress, $Age;
        private $DBConnect;

        public function __construct($DBConnect) {
            $this->DBConnect = $DBConnect;
        }

        // Methods
        function createPerson($FirstName, $Surname, $DateOfBirth, $EmailAddress, $Age) {
            $StmtCreatePerson = $this->DBConnect->prepare("INSERT INTO Person (FirstName, Surname, DateOfBirth, 
                                EmailAddress, Age) VALUES (?, ?, ?, ?, ?)");
            $StmtCreatePerson->bind_param("ssssi", $FirstName, $Surname, $DateOfBirth, $EmailAddress, $Age);

            if (!$StmtCreatePerson->execute()) {
                die("CreatePerson execute failed: ".$StmtCreatePerson->error);
            }

            echo "User created with ID:".$StmtCreatePerson->insert_id;
        }
        function loadPerson($PersonId) {

        }
        function savePerson() {

        }
        function deletePerson() {

        }
        function loadAllPeople() {

        }
        function deleteAllPeople() {

        }
    }

    $TestUser = new Person($DBConnect);
    $TestUser->createPerson('John','Doe','2001-05-10','JohnDoe@example.com',
        21);



    $DBConnect->close();