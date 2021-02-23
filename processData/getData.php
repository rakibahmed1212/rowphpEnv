<?php

use App\ProcessDataContainer;

require_once __DIR__ . './../vendor/autoload.php';
$tableContent = new ProcessDataContainer();
if (isset($_GET["status"])) {
    $data=$tableContent->getData($_GET["status"]);
    echo json_encode( array (
        'data' => $data,
        'total_data'     =>count($data)
    ));
}

?>