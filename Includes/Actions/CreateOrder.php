<?php
session_start();

include_once 'Autoloader.php';

$db = new dbTool();

echo "creating order";

//pass GET Variables to local ones
$AssignWorkers = $_GET["AssignWorkers"];
$Resource = $_GET["Resource"];
$ResourceAmount = $_GET["Amount"];

//DEBUG;Passing Variables work
echo "<br>";
echo $AssignWorkers;
echo "<br>";
echo $Resource;
echo "<br>";
echo $ResourceAmount;
echo "<br>";

echo "test";
$Exctract = $db->GetData('SELECT * FROM DirtGame.Resource Where ResourceName = "' . $Resource . '";');
echo "test";
$resouceWorkTime = $Exctract["WorkDuration"];
$resourceID = $Exctract["ResourceID"];

$workTime = $resouceWorkTime * $ResourceAmount;
echo $workTime;
echo "<br>";
$sql =
    "INSERT INTO `DirtGame`.`Orders` (`idUser`, `type`, `ResourceID`, `Amount`, `startingTime`, `OrderTime`, `UsedWorkers`) 
VALUES ('" . $_SESSION["UserID"] . "', 'mine', '" . $resourceID . "', '" . $ResourceAmount . "', CURRENT_TIMESTAMP(), SEC_TO_TIME(" . $workTime . "), " . $AssignWorkers . ");";

echo $sql;
echo "<br>";
$db->SetData($sql);


echo "<script>window.close();</script>";


echo '
<head>
<title>HTML Meta Tag</title>
      <meta http-equiv = "refresh" content = "0; url = http://ubuntutest/DirtGame/UI/GameScreen.phtml" />
</head>';
