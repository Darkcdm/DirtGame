<?php
/*
setcookie("Username", null, time() - (86400 * 30), "/"); // 86400 = 1 day
echo $_COOKIE["Username"];
*/


session_start();
session_unset();
session_destroy();
echo '
<head>
<title>HTML Meta Tag</title>
      <meta http-equiv = "refresh" content = "0; url = http://ubuntutest/DirtGame/UI/WelcomePage.phtml" />
</head>';
