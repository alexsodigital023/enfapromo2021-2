<?php

spl_autoload_register(function($className){
    $parts=explode("\\",$className);
    
    if(count($parts)>2&&$parts[0]=="Sodigital"&&$parts[1]=="Services"){
        array_shift($parts);
        array_shift($parts);

        $path=dirname(__FILE__)."/".implode("/",$parts).".php";
        if(file_exists($path)){
            include_once($path);
        }
    }
});