<?php


class infoPage
{
    public function CreateBuildingTable($X, $Y, $BuildingID)
    {
        $db = new dbTool();
        $sql = "SELECT Building_Type, Description 
        FROM DirtGame.Buildings
        ;";
        $dpPool = $db->getPureData($sql);


        echo 'What do you want to build?<br><br>';

        echo '<table>';

        echo '<tr>';
        echo '<th>Type</th>';
        echo '<th>Description</th>';
        echo '</tr>';


        echo "<tr>";
        if ($BuildingID != null) {
            while ($row = $dpPool->fetch_assoc()) {
                echo
                '<td>
                            <button onclick="myFunction()">' . $row["Building_Type"] . '</button>
                            <script>
                                function myFunction() {
                                alert("This tile is already full");
                                }
                            </script>                                    
                        </td>';
                echo '<td>' . $row["Description"] . '</td>';
                echo "</tr>";
            }
        } else {
            echo "here";
            while ($row = $dpPool->fetch_assoc()) {
                echo "here";
                echo
                '<td>
                            <button type="button">
                                <a href="/DirtGame/Includes/Actions/CreateBuilding.php?X=' . $X . '&Y=' . $Y . '&Type=' . $row["Building_Type"] . ' " target="_blank">
                                    ' . $row["Building_Type"] . '
                                </a>
                            </button>
                        </td>';
                echo '<td>' . $row["Description"] . '</td>';
                echo "</tr>";
            }
        }




        echo '</table>';
    }
}

/*
require_once "basics.php";
$basic = new basic();
//$basic->load("");
?>
<?php
$basic->load("/Includes/SQLComs.php");

class infoPage{


    public function CreateBuildingTable($X,$Y){
        $DB = new DB();


        echo 'What do you want to build?<br><br>';

        echo '<table>';
            $this->FillBuildingTable($X,$Y);
        echo '</table>';
    }

    
    private function FillBuildingTable($X,$Y){
        $DB = new DB();
        echo '<tr>';
        echo '<th>Type</th>';
        echo '<th>Description</th>';
        echo '</tr>';
        
        $DB->GetDataBuildingTable($X,$Y);
    }
}

        
        $this->OpenCon();
        $this->conn;
        $sql = "SELECT Building_Type, Description FROM DirtGame.Buildings;";
        $result = $this->conn->query($sql);
        echo "test1";
        $this->CloseCon($this->conn);
        while($row = $result->fetch_assoc()) {
            
            echo "<tr>";
            
                
                if ($this->checkBuildingLimit($row["Building_Type"])) {   
                    echo 
                    '<td>
                        <button onclick="myFunction()">'.$row["Building_Type"].'</button>
                        <script>
                            function myFunction() {
                            alert("You have reached a building limit!");
                            }
                        </script>                                    
                    </td>';
                }else{
                    
                    echo 
                    '<td>
                        <button type="button">
                            <a href="/Includes/Action/Builda'.$row["Building_Type"].'.php?X='.$X.'&Y='.$Y.' " target="_blank">
                                '.$row["Building_Type"].'
                            </a>
                        </button>
                    </td>';
                }

                echo '<td>'.$row["Description"].'</td>';
            echo "</tr>";
        } 
        