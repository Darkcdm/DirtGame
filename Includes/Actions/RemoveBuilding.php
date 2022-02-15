<?php
include_once 'Autoloader.php';

$db = new dbTool();

$GridId = $_GET["GridId"];
$BuildingID = $_GET["BuildingID"];

echo $GridId;
echo "</br>";
echo $BuildingID;
echo "</br>";

$query = 
"UPDATE ChunkMap
SET ChunkMap.OwnerID = null, ChunkMap.BuildingID = null
WHERE ChunkMap.ChunkID = ".$GridId.";";

$db->SetData($query);

echo "<script>window.close();</script>";