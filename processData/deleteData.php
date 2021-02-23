<?php

use App\ProcessDataContainer;

require_once __DIR__ . './../vendor/autoload.php';
$tableContent = new ProcessDataContainer();
if( isset($_GET["id"]) ) {
    echo $tableContent->deleteData($_GET["id"]);
}
if( isset($_GET["status"] )) {
    echo $tableContent->deleteData(0,$_GET["status"]);
}
?>