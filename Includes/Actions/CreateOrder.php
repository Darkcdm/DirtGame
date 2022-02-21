<?php

//setting up all import tools
session_start();
include_once 'Autoloader.php';
$db = new dbTool();
$backE = new OrderBackEnd();

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
    $backE->crafting($resourceID, $ResourceAmount, $AssignWorkers);
}else{
    $backE->mining($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime);
}




//Pseudo AJAX FTW
//echo "<script>window.close();</script>";














class OrderBackEnd{

//functions to clean main code
public function mining($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime){
    $db = new dbTool();

    $workTime = $resouceWorkTime * $ResourceAmount;
    //put order into database
    $sql =
    "INSERT INTO `DirtGame`.`Orders` (`idUser`, `type`, `ResourceID`, `Amount`, `startingTime`, `OrderTime`, `UsedWorkers`) 
    VALUES ('" . $_SESSION["UserID"] . "', 'mine', '" . $resourceID . "', '" . $ResourceAmount . "', CURRENT_TIMESTAMP(), SEC_TO_TIME(" . $workTime . "), " . $AssignWorkers . ");";

    $db->SetData($sql);

}



public function crafting($resourceID, $ResourceAmount, $AssignWorkers){
    $db = new dbTool();

    //get needed ingredients and crafting time /per one resource

    $sql =
    "SELECT
    Crafting.Craft_Duration,
    Crafting.IngredientID,
    Crafting.IngredientAmount,
    Crafting.ProductAmount
    FROM
    Crafting
    WHERE
    Crafting.ProductID = ".$resourceID.";
    ";
    
    $dbData = $db->GetData($sql);
    
    //calculate working time and real resource gain
    $workTime = $dbData["Craft_Duration"] * $ResourceAmount;
    $resourceGain = $dbData["ProductAmount"] * $ResourceAmount;
    //check if there's enough of resources in players inventory
        //1) parse ingredient strings from db
        $ingType = explode(",",$dbData["IngredientID"]);
        $ingAmount = explode(",",$dbData["IngredientAmount"]);

        //2) Get data about players inventory
        $sql ;
    $sql =
    "INSERT INTO `DirtGame`.`Orders` (`idUser`, `type`, `ResourceID`, `Amount`, `startingTime`, `OrderTime`, `UsedWorkers`) 
    VALUES ('" . $_SESSION["UserID"] . "', 'craft', '" . $resourceID . "', '" . $resourceGain . "', CURRENT_TIMESTAMP(), SEC_TO_TIME(" . $workTime . "), " . $AssignWorkers . ");";
    echo $sql;
    echo "<br>";
    $db->SetData($sql);
    
}
}