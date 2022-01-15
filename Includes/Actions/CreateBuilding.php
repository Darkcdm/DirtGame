<?php
session_start();
include_once 'Autoloader.php';
//import DB tools
$db = new dbTool();


//Get data from GET
$owner = $_SESSION["UserID"];
$buildingType = $_GET["Type"];
$x = $_GET["X"];
$y = $_GET["Y"];


//Get data from DB 
$sql =
    'SELECT Buildings.Building_Limit, count(ChunkMap.BuildingID = 1) AS BuildingCount
    FROM DirtGame.ChunkMap
    Inner JOIN DirtGame.Buildings
    ON Buildings.BuildingID = ChunkMap.BuildingID
    WHERE ChunkMap.OwnerID= ' . $owner . ' AND Building_Type = "' . $buildingType . '"
    GROUP BY ChunkMap.BuildingID;';

$DBpool = $db->getData($sql);

$buildingLimit = $DBpool["Building_Limit"];
$buildingCount = $DBpool["BuildingCount"];
//Check if the player reached a building limit
if ($buildingLimit > $buildingCount) {
    //build the building
    $sql =
        "UPDATE `DirtGame`.`ChunkMap` 
    SET `BuildingID` = '1', `OwnerID` = '" . $owner . "' 
    WHERE (`X` = '" . $X . "' AND `Y` = '" . $Y . "');
    ";
} else {
    //tell the user to fuck off
    echo "<script>Alert('Building Limit reached');</script>";
}



echo "buildingdone";
echo "<script>window.close();</script>";
