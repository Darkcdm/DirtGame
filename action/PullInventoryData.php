<?php
include_once "dbTool.php";
$db = new dbTool();

$userID = $_REQUEST["UserID"];

$sql = "SELECT 
ResourceName, ItemAmount
FROM
DirtGame.Users_Inventory
    INNER JOIN
Resource ON Users_Inventory.ResourceID = Resource.ResourceID
WHERE
UserID = " . $userID . ";";

$datapool = $db->GetPureData($sql)->fetch_all();

echo json_encode($datapool);
