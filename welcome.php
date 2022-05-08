<?php
session_start();

class Welcome
{

    public function MainMenu()
    {

        //$username = $_COOKIE["Username"];
        $username = $_SESSION["Username"];

        if ($username == null) {
            $this->printLogin();
        } else {
            echo '<meta http-equiv = "refresh" content = "0; url = /DirtGame/UI/GameScreen.phtml" /> ';
        }
    }
    private function printLogin()
    {
        echo '
        <a href="Logon.phtml">Logon</a>/<a href="Register.phtml">Register</a>
        ';
    }
}
