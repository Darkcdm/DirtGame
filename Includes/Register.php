<?php
include_once 'Autoloader.php';

class Register{

    public $Password = FALSE;
    public $Email = FALSE;
    public $Username = FALSE;

    public function CheckIfTaken($collum, $content){
        $db = new dbTool();
        if ($content===null){
            $extract = null;
        }else{
            $extract = $db->GetData('SELECT '.$collum.' FROM DirtGame.Users WHERE '.$collum.' = "'.$content.'";');
        }

        
        if ($extract==null){
            return TRUE;
        }else{
            echo 'Taken!';
            return FALSE;
        }
    }
    public function CheckPassword ($Password1, $Password2){
        if ($Password1 != $Password2){
            echo "Passwords don't match!";
            return FALSE;
        }
        else{
            return TRUE;
        }
    }

    public function CreatingUser ($Username, $Email, $PlainPassword){
        $db = new dbTool();

        $HashedPasword = hash("sha512",$PlainPassword);

        $sql =
        "INSERT INTO `DirtGame`.`Users` (`Username`, `Email`, `PassHash`) 
        VALUES ('".$Username."', '".$Email."', '".$HashedPasword."');";

        $db->SetData($sql);
    }
}