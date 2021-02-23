<?php

use App\ProcessDataContainer;

require_once __DIR__ . './../vendor/autoload.php';
$tableContent = new ProcessDataContainer();
if(isset($_GET["id"]) ) {
    echo $tableContent->editData($_GET["id"]);
}
?>