<?php

require_once './path.php';
require_once './utility.php';

$filePath = $_GET['fileName'];
$utility = new Utility();

$zipPath = $utility->getZipPath($filePath, $dir);
$file = $utility->getFileNameInZipDir($filePath);
$contents = '';

// $zip = new ZipArchive();

// if($zip->open($zipPath)) {
//     echo $zipPath . '<br/>';
//     echo $file . '<br/>';

//     $string = $zip->getFromName($file);
//     echo $string;
// }else {
//     echo 'There is an error';
// }

$zip = zip_open($zipPath);

if($zip) {
    while($zip_entry = zip_read($zip)) {
        if(strpos(zip_entry_name($zip_entry), $filePath) >= 0) {
            if (zip_entry_open($zip, $zip_entry)){
                $contents = zip_entry_read($zip_entry);
            }
        }

        zip_entry_close($zip_entry);
    }

    zip_close($zip);
}

header("Content-type: text/plain");
header("Content-Disposition: attachment; filename=$file");

echo $contents;
