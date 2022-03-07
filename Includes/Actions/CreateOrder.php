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


$backE->CheckWorkers($AssignWorkers);
//get data about the ordered resource 
$Extract = $db->GetData('SELECT * FROM DirtGame.Resource Where ResourceName = "' . $Resource . '";');

$resouceWorkTime = $Extract["WorkDuration"];
$resourceID = $Extract["ResourceID"];

if ($resouceWorkTime == null) {
    //crafting
    $backE->crafting($resourceID, $ResourceAmount, $AssignWorkers);
} else {
    $backE->mining($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime);
}




//Pseudo AJAX FTW
echo "<script>window.close();</script>";














class OrderBackEnd
{
    //functions to clean main code
    public function CheckWorkers($AssignWorkers)
    {
        $db = new dbTool();

        //get amount of free workers
        //get amount of workers being used + get amount of workers one player has
        $sql = "SELECT PeopleAmount
        FROM Users_Population
        WHERE PeopleID = 1;";

        $data = $db->GetData($sql);
        $MaxAmountOfWorkers = $data["PeopleAmount"];

        $sql = "SELECT COUNT(UsedWorkers)
        FROM Orders
        WHERE idUser = " . $_SESSION["UserID"] . ";";

        $data = $db->GetData($sql);
        $AmountOfWorkersInUse = $data["COUNT(UsedWorkers)"];

        if ($AmountOfWorkersInUse < $MaxAmountOfWorkers) {
            //user have workers in reserve
            $workersToBeUsed = $MaxAmountOfWorkers - $AmountOfWorkersInUse - $AssignWorkers;

            if ($workersToBeUsed <= 0) {
                //user doesn't have enough workers left for his order
                $this->Alert($workersToBeUsed);
            }
        } else {
            //user has no workers left

        }
    }
    public function mining($resourceID, $ResourceAmount, $AssignWorkers, $resouceWorkTime)
    {
        $db = new dbTool();

        $workTime = $resouceWorkTime * $ResourceAmount;
        //put order into database
        $sql =
            "INSERT INTO `DirtGame`.`Orders` (`idUser`, `type`, `ResourceID`, `Amount`, `startingTime`, `OrderTime`, `UsedWorkers`) 
        VALUES ('" . $_SESSION["UserID"] . "', 'mine', '" . $resourceID . "', '" . $ResourceAmount . "', CURRENT_TIMESTAMP(), SEC_TO_TIME(" . $workTime . "), " . $AssignWorkers . ");";

        $db->SetData($sql);

        echo '<script> alert("Order Created!");</script>';
    }
    public function crafting($resourceID, $ResourceAmount, $AssignWorkers)
    {
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
            Crafting.ProductID = " . $resourceID . ";
        ";

        $dbData = $db->GetData($sql);

        //calculate working time and real resource gain
        $workTime = $dbData["Craft_Duration"] * $ResourceAmount;
        $resourceGain = $dbData["ProductAmount"] * $ResourceAmount;
        //check if there's enough of resources in players inventory
        //1) parse ingredient strings from db
        $ingType = explode(",", $dbData["IngredientID"]);
        $ingAmount = explode(",", $dbData["IngredientAmount"]);

        //2) Get data about players inventory
        $sql = "SELECT
        Users_Inventory.ItemAmount
        FROM
        Users_Inventory
        WHERE
        Users_Inventory.UserID = " . $_SESSION["UserID"] . " AND ";
        //I need to add a line to the sql script per every resource needed
        for ($i = 0; $i < count($ingType) - 1; $i++) {
            $sql = $sql . "Users_Inventory.ResourceID = " . $ingType[$i] . " OR ";
        }
        $sql = $sql . "Users_Inventory.ResourceID = " . $ingType[count($ingType) - 1] . ";";

        echo "<br>";
        echo "<br>";
        echo $sql;
        echo "<br>";
        echo "<br>";



        $Users_Inventory = $db->GetPureData($sql);

        //3) compare all Arrays to decide if the player has enough resources for the crafting
        $CanCraft = TRUE;

        for ($i = 0; $i < count($ingAmount); $i++) {
            $Users_InventoryRow = $Users_Inventory->fetch_assoc();

            if ($Users_InventoryRow["ItemAmount"] >= $ingAmount[$i]) {
                echo "Enough of: " . $ingType[$i];
                echo "<br>";
            } else {
                if ($Users_InventoryRow["ItemAmount"] == null) {
                    $this->ResourceAlert($ingType[$i], $ingAmount[$i]);


                    $CanCraft = FALSE;
                } else {
                    echo "you're missing: " . $ingType[$i];
                    echo "<br>";
                    echo "you're missing: " . $Users_InventoryRow["ItemAmount"] - $ingAmount[$i];
                    echo "<br>";
                    echo $Users_InventoryRow["ItemAmount"];
                    echo "<br>";
                    $CanCraft = FALSE;
                }
            }
        }


        if ($CanCraft) {
            $sql =
                "INSERT INTO `DirtGame`.`Orders` (`idUser`, `type`, `ResourceID`, `Amount`, `startingTime`, `OrderTime`, `UsedWorkers`) 
                VALUES ('" . $_SESSION["UserID"] . "', 'craft', '" . $resourceID . "', '" . $resourceGain . "', CURRENT_TIMESTAMP(), SEC_TO_TIME(" . $workTime . "), " . $AssignWorkers . ");";
            echo $sql;
            echo "<br>";
            $db->SetData($sql);

            echo '<script> alert("Order Created!");</script>';
        }
    }
    private function ResourceAlert($ResourceID, $ResourceAmount)
    {

        $db = new dbTool();
        $sql =
            "SELECT
        Resource.ResourceName
        FROM
        Resource
        WHERE
        Resource.ResourceID = " . $ResourceID . ";";

        $resourceName = $db->GetData($sql);
        $alertString = "you're missing " . $ResourceAmount  . " of " . $resourceName["ResourceName"];
        echo '<script> alert("' . $alertString . '");</script>';
    }
    private function Alert($msg)
    {
        echo '<script> alert("' . $msg . '");</script>';
    }
}
