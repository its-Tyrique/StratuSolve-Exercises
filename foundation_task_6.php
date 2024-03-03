<?php
    $StartTimeFlt = microtime(true);

    $ServerNameStr = "localhost";
    $UserNameStr = "root";
    $PasswordStr ="Summer29#";
    $DBNameStr = "PersonalInfoDB";

    $DBConnectObj = new mysqli($ServerNameStr, $UserNameStr, $PasswordStr, $DBNameStr);

    if ($DBConnectObj->connect_errno) {
        die("Database Connection failed: ". $DBConnectObj->connect_error);
    }

    class Person {
        // Properties
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
                die("CreatePerson execute failed: ".$CreatePersonStmt->error);
            } echo "\nUser created with ID: ".$CreatePersonStmt->insert_id;
        }
        function loadPerson($PersonIdInt) {
            $loadPersonStmt = $this->DBConnectObj->prepare("SELECT * FROM Person WHERE Id = ?");
            $loadPersonStmt->bind_param("i", $PersonIdInt);

            if (!$loadPersonStmt->execute()) {
                die("loadPerson execute failed: ".$loadPersonStmt->error);
            } else {
                $Result = $loadPersonStmt->get_result();

                if ($Result->num_rows > 0) {
                    $PersonArr = $Result->fetch_assoc();
                    echo "\nPerson loaded: \n\t".$PersonArr['FirstName']." ".$PersonArr['Surname']." \n\tDoB: ".$PersonArr['DateOfBirth']
                        ." \n\tEmail: ". $PersonArr['EmailAddress']." \n\tAge: ".$PersonArr['Age']."\n";
                } else {
                    echo "\nPerson with PersonID: ".$PersonIdInt." not found in the database\n";
                }
            }
        }
        function savePerson($PersonIdInt, $FirstNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt) {
            $SavePersonStmt = $this->DBConnectObj->prepare("
                    INSERT INTO Person (Id, FirstName, Surname, DateOfBirth,EmailAddress, Age)
                    VALUES (?, ?, ?, ?, ?, ?) ON DUPLICATE KEY UPDATE
                    FirstName = VALUES(FirstName), 
                    Surname = VALUES(Surname),
                    DateOfBirth = VALUES(DateOfBirth), 
                    EmailAddress = VALUES(EmailAddress), 
                    Age = VALUES(Age)
                ");
            $SavePersonStmt->bind_param("issssi", $PersonIdInt, $FirstNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt);

            if (!$SavePersonStmt->execute()) {
                die("SavePerson execute failed: ".$SavePersonStmt->error);
            } else {
                echo "\nPerson saved with ID: ".$PersonIdInt."\n";
            }

        }
        function deletePerson($PersonIdInt) {
            $DeletePersonStmt = $this->DBConnectObj->prepare("DELETE FROM Person WHERE Id = ?");
            $DeletePersonStmt->bind_param("i", $PersonIdInt);

            if (!$DeletePersonStmt->execute()) {
                die("DeletePerson execute failed: ".$DeletePersonStmt->error);
            } else {
                echo "\nPerson deleted with ID: ".$PersonIdInt."\n";
            }
        }
        function loadAllPeople() {
            $LoadAllPeopleStmt = $this->DBConnectObj->prepare("SELECT * FROM Person");
            if (!$LoadAllPeopleStmt->execute()) {
                die("LoadAllPeople execute failed: ".$LoadAllPeopleStmt->error);
            } else {
                $Result = $LoadAllPeopleStmt->get_result();

                if ($Result->num_rows === 0) {
                    echo "\nNo people found in table\n";
                } else {
                    while ($PersonArr = $Result->fetch_assoc()) {
                        echo "\nPersonID: ".$PersonArr['id']."\n\tName: ".$PersonArr['FirstName']." ".$PersonArr['Surname']." \n\tDoB: ".$PersonArr['DateOfBirth']
                            ." \n\tEmail: ". $PersonArr['EmailAddress']." \n\tAge: ".$PersonArr['Age']."\n";
                    }
                }
            }
        }
        function deleteAllPeople() {
            $DeleteAllPeopleStmt = $this->DBConnectObj->prepare("DELETE FROM Person");
            if (!$DeleteAllPeopleStmt->execute()) {
                die("DeleteAllPeople execute failed: ".$DeleteAllPeopleStmt->error);
            } else {
                echo "\nAll people deleted\n";
            }
        }
    }

    $PersonObj = new Person($DBConnectObj);
//    $PersonObj->createPerson('Tyrique','de Bruin','2001-05-10','Tyrique@example.com',23);
//    $PersonObj->loadPerson(9);
//    $PersonObj->savePerson(9,'Bryon','Mogapi','1995-03-21','deven@example.com', 26);
//    $PersonObj->deletePerson(2);
//    $PersonObj->loadAllPeople();
//    $PersonObj->deleteAllPeople();

    $NamesArr = [
        'Emma', 'Liam', 'Olivia', 'Noah', 'Ava', 'Isabella', 'Sophia', 'Jackson', 'Lucas', 'Aiden',
        'Mia', 'Ethan', 'Elijah', 'Harper', 'Amelia'
    ];

    $SurnamesArr = [
        'Smith', 'Johnson', 'Williams', 'Jones', 'Brown', 'Davis', 'Miller', 'Wilson', 'Moore', 'Taylor',
        'Anderson', 'Thomas', 'Jackson', 'White', 'Harris'
    ];

    for ($i = 0; $i < 10; $i++) {

        $FirstNameStr = $NamesArr[rand(0, count($NamesArr)-1)];
        $SurnameStr = $SurnamesArr[rand(0, count($SurnamesArr)-1)];
        $DateOfBirthStr = date("Y-m-d", rand(strtotime("1960-01-01"), strtotime(date("Y-m-d"))));
        $EmailAddressStr = $FirstNameStr.uniqid()."@example.com";
        $AgeInt = date_diff(date_create($DateOfBirthStr), date_create('today'))->y;
        if($AgeInt < 0) {
            $AgeInt--;
        }
        $PersonObj->createPerson($FirstNameStr, $SurnameStr, $DateOfBirthStr, $EmailAddressStr, $AgeInt);
    } echo "\n";

    $PersonObj->loadAllPeople();

    $EndTimeFlt = microtime(true);
    $executeTimeFlt = number_format(($EndTimeFlt - $StartTimeFlt),3,'.','');
    echo "\nExecution time: ".$executeTimeFlt." seconds\n";

    $DBConnectObj->close();