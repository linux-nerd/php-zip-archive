<?php

require_once "./path.php";
require_once "./utility.php";

$fileName = $_GET["fileName"];
$pos = strpos($fileName, '.zip');
$utility = new Utility();

if($pos === false) {
    //.zip was not found
    //treat it as a simple directory

    $utility->expandDirectory("$dir\\$fileName", "$fileName/");
}else {
    //.zip was found
    //treat it as zipped directory
    
    $utility->expandZipDirectory("$dir\\$fileName", "$fileName/");
    
}
?>