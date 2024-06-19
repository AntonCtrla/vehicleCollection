<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require __DIR__ . '/../config/bootstrap.php';

use VehicleCollection\Controllers\RouterController;

$router = new RouterController();
$router->main();
