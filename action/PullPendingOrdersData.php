<?php

include_once "dbTool.php";

$db = new dbTool();
$userID = $_REQUEST["UserID"];

$sql =
    "SELECT idOrders, Amount, ResourceName,Orders.ResourceID, NOW(), ADDTIME(startingTime, OrderTime) AS 'FinnishTime'
        FROM DirtGame.Orders
        INNER JOIN DirtGame.Resource
        ON Resource.ResourceID = Orders.ResourceID
        WHERE idUser = " . $userID . "
        ;";

$datapool = $db->GetPureData($sql)->fetch_all();

echo json_encode($datapool);
