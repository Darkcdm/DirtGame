<?php
include_once "dbTool.php";

//get data from the request
$email = $_REQUEST["email"];
$password = $_REQUEST["password"];
$passwordCheck = $_REQUEST["passwordCheck"];

/////////echo $email.", ".$password.", ".$passwordCheck;

//check if the password is the same
if (!checkPassword($password, $passwordCheck)) {
    echo "password";
    exit();
}
//make sure that the email isn't already registered
if (!checkEmail($email)) {
    echo "email";
    exit();
}
createUser($password, $email);
////////////echo "correct";
exit();


//create new account
function checkPassword($password, $passwordCheck)
{
    if ($password == $passwordCheck) {
        return true;
    } else {
        return false;
    }
}

function checkEmail($email)
{
    $db = new dbTool();

    $sql = " SELECT * FROM Users WHERE Email = '" . $email . "';";

    $data = $db->GetData($sql);

    if ($data == null) {
        return true;
    } else {
        return false;
    }
}

function createUser($password, $email)
{
    $db = new dbTool();
    //prep password to be put into database
    $hash = hash('sha256', $password);

    $sql = "INSERT INTO `D&DCreation`.`Users` (`Email`, `PassHash`) 
    VALUES ('" . $email . "', '" . $hash . "');";

    $db->SetData($sql);
}
