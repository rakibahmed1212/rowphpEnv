<?php

use App\ProcessDataContainer;

require_once __DIR__ . './../vendor/autoload.php';
$tableContent = new ProcessDataContainer();
if( $_GET["data"] ) {
    echo $tableContent->addData($_GET["data"]);
}
?>