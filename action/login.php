<?php
include_once "dbTool.php";
$db = new dbTool();

//get data from the request
$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$passHash = hash("sha512", $password);
//get data from database
$sql =
    "SELECT 
    PassHash, UserID
FROM
    DirtGame.Users
WHERE
    Email = '" . $email . "'
;";
$data = $db->GetData($sql);
//compare and then return the status

if ($data == null) {
    echo "wrong Email";
    exit();
}
if ($data["PassHash"] != $passHash) {
    echo "wrong Password";
    exit();
}
echo $data["UserID"];
exit();
