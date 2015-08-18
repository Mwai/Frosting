<?php


require_once("../models/config.php");

set_error_handler('logAllErrors');

// Request method: GET
$ajax = checkRequestMode("get");

// User must be logged in
checkLoggedInUser($ajax);

$results = loadSecureFunctions();

echo json_encode($results);

?>