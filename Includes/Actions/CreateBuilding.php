<?php
//Infrastructure setup
session_start();
include_once 'Autoloader.php';
$db = new dbTool();


//Get data from GET
$owner          = $_SESSION["UserID"];
$buildingType   = $_GET["Type"];
$x              = $_GET["X"];
$y              = $_GET["Y"];


//Get data from DB 
//Set up all queries for database
$queryTypeToID = 
"SELECT 
    BuildingID
FROM
    DirtGame.Buildings
WHERE
	Building_Type='".$buildingType."';";

echo $queryTypeToID;
$DBpool = $db->GetData($queryTypeToID);


$queryMaxAndCurrentAmount =
    'SELECT 
    Buildings.Building_Limit,
    COUNT(ChunkMap.BuildingID = '.$DBpool["BuildingID"].') AS BuildingCount
FROM
    DirtGame.Buildings
        JOIN
    DirtGame.ChunkMap
WHERE
    Buildings.BuildingID = '.$DBpool["BuildingID"].'
        OR ChunkMap.OwnerID = '.$owner.'
GROUP BY Buildings.Building_Limit;';

echo $queryMaxAndCurrentAmount;

//Assign variables from Database pull
$DBpool = $db->GetData($queryMaxAndCurrentAmount);

$buildingLimit = $DBpool["Building_Limit"];
$buildingCount = $DBpool["BuildingCount"];


//Check if the player reached a building limit
if ($buildingLimit > $buildingCount) {

    //build the building
    echo "build the building";
    echo $owner;
    $chunkID = ((($x+$y+1)*($x+$y))/2)+$y;
    echo $chunkID;
    $sql =
        "UPDATE `DirtGame`.`ChunkMap` 
    SET `BuildingID` = '1', `OwnerID` = '" . $owner . "' 
    WHERE (`ChunkID` = '" . $chunkID . "');
    ";
    $db->SetData($sql);
} else {
    //tell the user to fuck off
    echo "<script>Alert('Building Limit reached');</script>";
}



//PSEUDO AJAX FTW :D
echo "buildingdone";
echo "<script>window.close();</script>";
