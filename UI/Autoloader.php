<?php

spl_autoload_register('myAutoLoader');

function myAutoLoader($className){
    $path = "/var/www/html/DirtGame/Includes/";
    $extension = ".php";

    $fullPath = $path.$className.$extension;
    
    if (!file_exists($fullPath)){
        return false;
    }
    
    include_once $fullPath;
}

