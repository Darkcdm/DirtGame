<?php
session_start();
include_once 'Autoloader.php';

class Logon
{
    public function Login($Email, $Pass)
    {

        $HashedPasword = hash("sha512", $Pass);
        $db = new dbTool();

        $sql = 'SELECT * FROM DirtGame.Users WHERE Email = "' . $Email . '";';

        $extract = $db->GetData($sql);

        if ($HashedPasword == $extract["PassHash"]) {

            $this->CompleteLogin($extract["UserID"], $extract["Username"], $extract["Email"]);
        } else {
            echo "Wrong Password, try again!";
        }
    }




    private function CompleteLogin($UserID, $Username, $Email)
    {

        session_start();
        $_SESSION["UserID"] = $UserID;
        $_SESSION["Username"] = $Username;
        $_SESSION["Email"] = $Email;

        echo $_SESSION["UserID"];
        echo "<br>";
        echo $_SESSION["Username"];
        echo "<br>";
        echo $_SESSION["Email"];

        echo '<meta http-equiv = "refresh" content = "0; url = /DirtGame/UI/GameScreen.phtml" />';
    }
}
