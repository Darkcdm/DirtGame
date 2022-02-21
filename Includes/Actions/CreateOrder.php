<?php
//setting up all import tools
session_start();
include_once 'Autoloader.php';
$db = new dbTool();


//pass GET Variables to local ones
$AssignWorkers = $_GET["AssignWorkers"];
$Resource = $_GET["Resource"];
$ResourceAmount = $_GET["Amount"];


//get data about the ordered resource 
$Extract = $db->GetData('SELECT * FROM DirtGame.Resource Where ResourceName = "' . $Resource . '";');

$resouceWorkTime = $Extract["WorkDuration"];
$resourceID = $Extract["ResourceID"];

if ($resouceWorkTime == null){
    //crafting
    $this->crafting($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime);
}else{
    $this->mining($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime);
}




//Pseudo AJAX FTW
echo "<script>window.close();</script>";















//functions to clean main code
function mining($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime){
    $db = new dbTool();

    $workTime = $resouceWorkTime * $ResourceAmount;
    //put order into database
    $sql =
    "INSERT INTO `DirtGame`.`Orders` (`idUser`, `type`, `ResourceID`, `Amount`, `startingTime`, `OrderTime`, `UsedWorkers`) 
    VALUES ('" . $_SESSION["UserID"] . "', 'mine', '" . $resourceID . "', '" . $ResourceAmount . "', CURRENT_TIMESTAMP(), SEC_TO_TIME(" . $workTime . "), " . $AssignWorkers . ");";

    $db->SetData($sql);

}



function crafting($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime){
    $db = new dbTool();

    $workTime = $resouceWorkTime * $ResourceAmount;
 
    
    $sql =
    "INSERT INTO `DirtGame`.`Orders` (`idUser`, `type`, `ResourceID`, `Amount`, `startingTime`, `OrderTime`, `UsedWorkers`) 
    VALUES ('" . $_SESSION["UserID"] . "', 'craft', '" . $resourceID . "', '" . $ResourceAmount . "', CURRENT_TIMESTAMP(), SEC_TO_TIME(" . $workTime . "), " . $AssignWorkers . ");";
}