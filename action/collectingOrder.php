<?php
include_once "dbTool.php";


$userID = $_REQUEST["UserID"];
$orderID = $_REQUEST["orderID"];
$resourceID = $_REQUEST["resourceID"];
$resourceAmount = $_REQUEST["resourceAmount"];

if ($userID == null && $orderID == null && $resourceID == null && $resourceAmount == null) {
    echo "problem with input";
    exit();
}

//removeOrder($orderID);
addResource($userID, $resourceID, $resourceAmount);

exit();

function removeOrder($orderID)
{
    $sql = "DELETE FROM `DirtGame`.`Orders` WHERE (`idOrders` = '" . $orderID . "');";
    $db = new DbTool();
    $db->SetData($sql);

    echo "order Removed";
}

function addResource($userID, $resourceID, $resourceAmount)
{


    $sql = "SELECT ItemAmount FROM DirtGame.Users_Inventory WHERE ResourceID = " . $resourceID . " AND UserID = " . $userID . "; ";
    $db = new DbTool();
    $oldResourceAmount = $db->GetData($sql);
    $newResourceAmount = $oldResourceAmount + $resourceAmount;

    $sql =
        "    UPDATE `DirtGame`.`Users_Inventory` 
    SET 
        `ItemAmount` = '" . $newResourceAmount . "'
    WHERE
        (`ResourceID` = '" . $resourceID . "' AND `UserID` = '" . $userID . "');";

    $db->SetData($sql);

    echo "resouces added";
}
