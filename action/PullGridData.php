<?php
include_once "dbTool.php";

$db = new dbTool();
$sql =
    "SELECT ChunkID, X, Y, Type, Username, BuildingID
            FROM DirtGame.ChunkMap
            LEFT JOIN DirtGame.Users
            ON Users.UserID = ChunkMap.OwnerID
            WHERE ChunkID = " . $_REQUEST["gridID"] . ";";

$datapool = $db->GetPureData($sql)->fetch_all();

echo json_encode($datapool);
