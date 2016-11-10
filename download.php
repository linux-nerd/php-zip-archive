<?php

require_once "./path.php";

$filename = $_GET['fileName'];

$filepath = $dir . '/' . $filename;
//content type
header('Content-type: text/plain');
//open/save dialog box
header("Content-Disposition: attachment; filename=$filename");
//read from server and write to buffer

readfile($filepath);

?>