<?php
session_start();
class GameScreen
{

    public function renderMap($startX, $startY, $Size)
    {

        echo "<table>";

        if ($startX != null || $startY != null) {

            $this->FillMap($startX, $startY, $Size);
        } else {
            echo 'no map to render!<br>Please submit your map settings.';
        }

        echo "</table>";
    }

    private function FillMap($startX, $startY, $Size)
    {
        $db = new dbTool();

        //Get map info from DB

        for ($Y = $startY; $Y <= $startY + $Size; $Y++) {
            echo '<tr>';
            for ($X = $startX; $X <= $startX + $Size; $X++) {

                $Extract = $db->GetData(
                "SELECT 
                    Type, OwnerID, Buildings.Building_Type
                FROM 
                    DirtGame.ChunkMap 
                LEFT JOIN 
                    Buildings
                ON 
                    ChunkMap.BuildingID = Buildings.BuildingID
                WHERE 
                    ChunkID=" . $this->CalcGridID($X, $Y) . "
                    ;");

                echo '<th>
                    <a href="/DirtGame/UI/InfoPage.phtml/?GridId=' . $this->CalcGridID($X, $Y) . '" target="_blank"">
                    <button type="button">
                    ';
                if ($Extract["OwnerID"] == null) {
                    echo '<img src="/DirtGame/UI/Img/' . $Extract["Type"] . '.png"><br>
                    [' . $X . ';' . $Y . '] <br>
                    ' . $Extract["Type"];
                } else {
                    echo '
                        <img src="/DirtGame/UI/Img/' . $Extract["Building_Type"] . '.png"><br>
                        [' . $X . ';' . $Y . '] <br>
                        ' . $Extract["Building_Type"];
                }
                echo '</button>
                    </a>
                    </th>';
            }
            echo '</tr>';
        }
    }

    private function CalcGridID($X, $Y)
    {
        return 0.5 * ($X + $Y) * ($X + $Y + 1) + $Y;
    }

    public function RenderPossibleOrders()
    {
    }

    public function RenderPendingOrders()
    {
        $db = new dbTool();
        $sql =
            "SELECT idOrders, Amount, ResourceName,Orders.ResourceID, NOW(), ADDTIME(startingTime, OrderTime) AS 'FinnishTime'
        FROM DirtGame.Orders
        INNER JOIN DirtGame.Resource
        ON Resource.ResourceID = Orders.ResourceID
        WHERE idUser = " . $_SESSION["UserID"] . "
        ;";


        $Extract = $db->GetPureData($sql);




        while ($row = $Extract->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row["ResourceName"];
            echo "</td>";
            echo "<td>";
            echo $row["Amount"];
            echo "</td>";
            echo "<td>";
            if ($row["NOW()"] >= $row["FinnishTime"]) {

                echo '
                    <a href="/DirtGame/Includes/Actions/CollectOrder.php/?
                    idOrders=' . $row["idOrders"] . '&
                    ResourceID=' . $row["ResourceID"] . '&
                    Amount=' . $row["Amount"] . '
                    " 
                    target="_blank">
                    <button>Collect Order</button>
                    </a>
                    ';
            } else {
                echo  $row["FinnishTime"];
            }
            echo "</td>";
            echo "</tr>";
        }
    }

    public function RenderInventory()
    {
        $db = new dbTool();
        $sql = "SELECT 
        ResourceName, ItemAmount
      FROM
        DirtGame.Users_Inventory
     INNER JOIN 
     DirtGame.Resource
     ON
     Resource.ResourceID = Users_Inventory.ResourceID
      WHERE
        UserID = " . $_SESSION["UserID"] . ";";

        $dbData = $db->GetPureData($sql);

        while ($row = $dbData->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row["ResourceName"];
            echo "</td>";
            echo "<td>";
            echo $row["ItemAmount"];
            echo "</td>";
            echo "</tr>";
        }
    }
    public function RenderBuildings()
    {
        $sql = "SELECT 
        X,Y,Building_Type
    FROM
        DirtGame.ChunkMap
    JOIN
        DirtGame.Buildings
    ON
        ChunkMap.BuildingID = Buildings.BuildingID
    WHERE
        OwnerID = " . $_SESSION["UserID"] . ";";

        $db = new dbTool();

        $dbData = $db->GetPureData($sql);

        while ($row = $dbData->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row["X"];
            echo "</td>";
            echo "<td>";
            echo $row["Y"];
            echo "</td>";
            echo "<td>";
            echo $row["Building_Type"];
            echo "</td>";
            echo "</tr>";
        }
    }
    public function RenderPopulation(){
        $sql = "SELECT 
        Type, Description, PeopleAmount
    FROM
        DirtGame.Users_Population
    
    INNER JOIN 
        DirtGame.People
    ON
        People.PeopleID = Users_Population.PeopleID
    WHERE
        UserID = ".$_SESSION["UserID"].";";

        $db = new dbTool();

        $dbData = $db->GetPureData($sql);

        while ($row = $dbData->fetch_assoc()) {
            echo "<tr>";
            echo "<td>";
            echo $row["Type"];
            echo "</td>";
            echo "<td>";
            echo $row["PeopleAmount"];
            echo "</td>";
            echo "<td>";
            echo $row["Description"];
            echo "</td>";
            echo "</tr>";
        }
        
    }

    public function KickNotLoggedIn()
    {
        if (!isset($_SESSION['Username'])) {
            echo '<meta http-equiv = "refresh" content = "0; url = /DirtGame/UI/WelcomePage.phtml" /> ';
        }
    }
}
