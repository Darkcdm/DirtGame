<?php
include_once 'Autoloader.php';

session_start();
echo $_GET["idOrders"] . "<br>";
echo $_GET["ResourceID"] . "<br>";
echo $_GET["Amount"] . "<br>";
echo $_SESSION["UserID"] . "<br>";
//get all the values from GET and SESSION
$orderID = $_GET["idOrders"];
$resource = $_GET["ResourceID"];
$amount = $_GET["Amount"];
$userID = $_SESSION["UserID"];
//get all the values from DB (if there are some)
$sql = "SELECT 
ItemAmount
FROM
DirtGame.Users_Inventory
WHERE
ResourceID = " . $resource . " AND UserID=" . $userID . ";";
$db = new dbTool();

//check if there's already a row with the wanted resource on the current user
$dbData = $db->GetData($sql);
if ($dbData["ItemAmount"] == null) {
    echo "resource row doesn't exist" . "<br>";
    $sql = "INSERT INTO `DirtGame`.`Users_Inventory` (`UserID`, `ResourceID`, `ItemAmount`) VALUES ('" . $userID . "', '" . $resource . "', '" . $amount . "');
    ";
    echo $sql;
} else {
    echo "resource row exist" . "<br>";
    $amountToAdd = $dbData["ItemAmount"] + $amount;
    echo $amountToAdd . "<br>";
    $sql = "UPDATE `DirtGame`.`Users_Inventory` SET `ItemAmount` = '" . $amountToAdd . "' WHERE (`UserID` = '" . $userID . "' AND `ResourceID` = '" . $resource . "');";
    echo $sql;
}

//add Resources
$db->SetData($sql);
//remote order
$sql = "DELETE FROM `DirtGame`.`Orders` WHERE (`idOrders` = '" . $orderID . "');";
$db->SetData($sql);

echo "<script>window.close();</script>";
