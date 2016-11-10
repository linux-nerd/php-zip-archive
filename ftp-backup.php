<!DOCTYPE html>
<html>
<head>
  <title>Display Files</title>
</head>
<body>

<?php
require_once './path.php';
require_once './utility.php';

$utility = new Utility();


$submitBtnName = $_REQUEST['btn_submit'];

if($submitBtnName === "new_FTP") {
    $utility->expandDirectory($dir);
}

?>

</body>