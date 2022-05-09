<?php
include_once "dbTool.php";

//get data from the request
$username = $_REQUEST["username"];
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
createUser($username, $password, $email);
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

function createUser($username, $password, $email)
{
    $db = new dbTool();
    //prep password to be put into database
    $hash = hash('sha512', $password);

    $sql = "INSERT INTO `DirtGame`.`Users` (`Username`,`Email`, `PassHash`) 
    VALUES ('" . $username . "','" . $email . "', '" . $hash . "');";

    $db->SetData($sql);

    $sql = "SELECT UserID FROM DirtGame.Users WHERE Email = '" . $email . "';";

    echo $db->GetData($sql)["UserID"];
}
