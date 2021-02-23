<?php

use App\ProcessDataContainer;

require_once __DIR__ . './../vendor/autoload.php';
$tableContent = new ProcessDataContainer();
if(isset($_GET["id"]) && isset($_GET["status"])&& $_GET["status"]>=0) {
    echo $tableContent->editData($_GET["id"],$_GET["status"]);
}
if (isset($_GET["id"]) && isset($_GET["value"]) && $_GET["status"] < 0) {
    echo $tableContent->editData($_GET["id"], -1,$_GET["value"]);
}
?>