<?php


class infoPage
{
    public function CreateBuildingTable($X, $Y, $BuildingID)
    {
        if ($BuildingID == null){
            $this->PrintBuildingTable($X, $Y, $BuildingID);
        }else {
            $this->PrintRemoveBuildingButton($X, $Y, $BuildingID);
        }
        

    }
    private function PrintBuildingTable($X, $Y, $BuildingID){

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

    private function PrintRemoveBuildingButton($X, $Y, $BuildingID){
        $chunkID = ((($X+$Y+1)*($X+$Y))/2)+$Y;
        echo '
        <a href="/DirtGame/Includes/Actions/RemoveBuilding.php?GridId='.$chunkID.'&BuildingID='.$BuildingID.'">
        <button>Remove the current building on this chunk</button>
        </a>
        ';
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


        
