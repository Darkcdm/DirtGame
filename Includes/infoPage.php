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

    public function PrintResourceList($buildingID){
        $db = new dbTool();
        //get the info if the chunk has a building
        //get all mineable resources from the tile
        if ($buildingID==null){
            //mining 
            $sql = 
            "SELECT 
            Resource.ResourceName
            FROM
            Resource
            WHERE
            Resource.WorkDuration IS NOT null;
            ";
        }else{
            //crafting
            $sql =
            "SELECT 
            Resource.ResourceName
            FROM
            Resource
            LEFT JOIN 
            Buildings
            ON
            Buildings.Possible_Recipies = Resource.ResourceID
            WHERE
            Resource.WorkDuration IS null;";
        
            
        }
        
        //if it's a pure chunk then only mine basic resources
        //if it has a building, then craft assigned recipies
        $Extract = $db->getPureData($sql);
        while ($row = $Extract->fetch_assoc())
        echo "
        <option value=".$row["ResourceName"].">".$row["ResourceName"]."</option>
        ";
    }

}


        