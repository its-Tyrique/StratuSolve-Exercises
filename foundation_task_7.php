<?php
    $ServerNameStr = "localhost";
    $UserNameStr = "root";
    $PasswordStr = "Summer29#";
    $DBNameStr = "PersonalInfoDB";

    $DBConnectObj = new mysqli($ServerNameStr, $UserNameStr, $PasswordStr, $DBNameStr);

    if ($DBConnectObj->connect_errno) {
        die("Database Connection failed: " . $DBConnectObj->connect_error);
    }

    class Person {

        public $FirtNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt;
        private $DBConnectObj;

        public function __construct($DBConnectObj) {
            $this->DBConnectObj = $DBConnectObj;
        }

        // Methods
        function createPerson($FirstNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt) {
            $CreatePersonStmt = $this->DBConnectObj->prepare("INSERT INTO Person (FirstName, Surname, DateOfBirth, 
                                        EmailAddress, Age) VALUES (?, ?, ?, ?, ?)");
            $CreatePersonStmt->bind_param("ssssi", $FirstNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt);

            if (!$CreatePersonStmt->execute()) {
                die(json_encode(array('error' => 'CreatePerson execute failed: ' . $CreatePersonStmt->error)));
            }
            die(json_encode(['success' => true, 'User created with ID: '.$CreatePersonStmt->insert_id]));
        }

        function loadPerson($PersonIdInt) {
            $loadPersonStmt = $this->DBConnectObj->prepare("SELECT * FROM Person WHERE Id = ?");
            $loadPersonStmt->bind_param("i", $PersonIdInt);

            if (!$loadPersonStmt->execute()) {
                die(json_encode(['error' =>"loadPerson execute failed: " . $loadPersonStmt->error]));
            } else {
                $Result = $loadPersonStmt->get_result();

                if (!$Result) {
                    die(json_encode(['error' => 'Failed to get result from loadPersonStmt execution']));
                }
                $PersonArr = $Result->fetch_assoc();
                die(json_encode($PersonArr));
            }
        }

        function savePerson($PersonIdInt, $FirstNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt) {
            $SavePersonStmt = $this->DBConnectObj->prepare("
                            INSERT INTO Person (Id, FirstName, Surname, DateOfBirth,EmailAddress, Age)
                            VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE
                            Id = VALUES(Id),
                            FirstName = VALUES(FirstName), 
                            Surname = VALUES(Surname),
                            DateOfBirth = VALUES(DateOfBirth), 
                            EmailAddress = VALUES(EmailAddress), 
                            Age = VALUES(Age)
                        ");
            $SavePersonStmt->bind_param("issssi", $PersonIdInt, $FirstNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt);

            if (!$SavePersonStmt->execute()) {
                die(json_encode(["SavePerson execute failed: ".$SavePersonStmt->error]));
            }
            die(json_encode(["Person saved with ID: ".$PersonIdInt]));
        }

        function deletePerson($PersonIdInt) {
            $DeletePersonStmt = $this->DBConnectObj->prepare("DELETE FROM Person WHERE Id = ?");
            $DeletePersonStmt->bind_param("i", $PersonIdInt);

            if (!$DeletePersonStmt->execute()) {
                die(json_encode(["DeletePerson execute failed: " . $DeletePersonStmt->error]));
            } else {
                die(json_encode(["Person deleted with ID: " . $PersonIdInt]));
            }
        }

        function loadAllPeople() {
            $LoadAllPeopleStmt = $this->DBConnectObj->prepare("SELECT * FROM Person");
            if (!$LoadAllPeopleStmt->execute()) {
                die(json_encode(['error' => 'LoadAllPeople execute failed: ' . $LoadAllPeopleStmt->error]));
            } else {
                $Result = $LoadAllPeopleStmt->get_result();

                if (!$Result) {
                    die(json_encode(['error' => 'Failed to get result from LoadAllPeopleStmt execution']));
                }
                $PeopleArr = [];
                while ($PersonArr = $Result->fetch_assoc()) {
                    $PeopleArr[] = $PersonArr;
                }
                die(json_encode($PeopleArr));
            }
        }

        function deleteAllPeople()
        {
            $DeleteAllPeopleStmt = $this->DBConnectObj->prepare("DELETE FROM Person");
            if (!$DeleteAllPeopleStmt->execute()) {
                die(json_encode(["DeleteAllPeople execute failed: " . $DeleteAllPeopleStmt->error]));
            } else {
                die(json_encode(["All people deleted"]));
            }
        }
    }

    $PersonObj = new Person($DBConnectObj);

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        switch (true) {
            case isset($_POST['deletePerson']) && isset($_POST['PersonId']):
                $PersonIdInt = intval($_POST['PersonId']);

                try {
                    $PersonObj->deletePerson($PersonIdInt);
                    http_response_code(200);
                    die(json_encode(['success' => true, 'message' => 'Person deleted successfully']));
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to delete person']);
                }
                break;

            case isset($_POST['deleteAllRecords']):
                try {
                    $PersonObj->deleteAllPeople();
                    http_response_code(200);
                    die(json_encode(['success' => true, 'message' => 'All records deleted successfully']));
                } catch (Exception $e) {
                    http_response_code(500);
                    echo json_encode(['error' => 'Failed to delete all records']);
                }
                break;

            case isset($_POST['updatePerson']):
//                file_put_contents("Text.txt", print_r($_POST, true));
                $AgeInt = date_diff(date_create($_POST['DateOfBirth']), date_create('now'))->y;
                $PersonObj->savePerson($_POST['PersonId'], $_POST['FirstName'], $_POST['Surname'], $_POST['DateOfBirth'], $_POST['Email'], $AgeInt);
                break;

            case isset($_POST['FirstName']) && isset($_POST['Surname']) && isset($_POST['DateOfBirth']) && isset($_POST['Email']):
                $AgeInt = date_diff(date_create($_POST['DateOfBirth']), date_create('now'))->y;
                $PersonObj->createPerson($_POST['FirstName'], $_POST['Surname'], $_POST['DateOfBirth'], $_POST['Email'], $AgeInt);
                break;

            default:
                http_response_code(400);
                echo json_encode(['error' => 'Invalid request']);
                break;
        }
    }

    if ($_SERVER['REQUEST_METHOD'] === 'GET') {
        if (isset($_GET['loadPerson'], $_GET['PersonId'])) {
            $PersonIdInt = intval($_GET['PersonId']);
            $PersonObj->loadPerson($PersonIdInt);
        } else {
            $PersonObj->loadAllPeople();
        }
    } else {
        die(json_encode(['error' => 'Invalid request method or no loadAllPeople parameter found in the request']));
    }

    $DBConnectObj->close();