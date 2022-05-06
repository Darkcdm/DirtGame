<?php
include_once "dbTool.php";
$db = new dbTool();

$userID = $_POST["UserID"];

$sql = "SELECT 
ResourceName, ItemAmount
FROM
DirtGame.Users_Inventory
    INNER JOIN
Resource ON Users_Inventory.ResourceID = Resource.ResourceID
WHERE
UserID = 1;";

$datapool = $db->GetPureData($sql)->fetch_all();

echo json_encode($datapool);
