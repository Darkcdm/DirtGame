<?php
include_once "dbTool.php";
$db = new dbTool();

//get data from the request
$email = $_REQUEST["email"];
$password = $_REQUEST["password"];

$passHash = hash("sha256", $password);
//get data from database
$sql =
    "SELECT 
PassHash
FROM
`D&DCreation`.Users
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
echo "correct";
exit();
