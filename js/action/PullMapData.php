<?php
//load infrastructure
include_once "dbTool.php";
$db = new dbTool();

//parse data from JS 
$startX = $_POST["X"];
$startY = $_POST["Y"];
$size = $_POST["size"];

//calculate helping variables for sql query 
$minGrid = CalcGridID($startX, $startY);
$maxGrid = CalcGridID($startX + $size, $startY + $size);

$sql =
    "SELECT 
Type, OwnerID, Buildings.Building_Type
    FROM
DirtGame.ChunkMap
    LEFT JOIN
Buildings ON ChunkMap.BuildingID = Buildings.BuildingID
    WHERE
ChunkID >= " . $minGrid . " AND ChunkID <= " . $maxGrid . "
;";


//get the data from it and form it into an array
$datapool = $db->GetPureData($sql)->fetch_all();

//then send the array to JS as JSON 
echo json_encode($datapool);

function CalcGridID($X, $Y)
{
    return 0.5 * ($X + $Y) * ($X + $Y + 1) + $Y;
}
