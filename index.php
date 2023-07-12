<?php

spl_autoload_register(function ($class){
    require __DIR__ . "/src/$class.php";
});

set_error_handler("errorHandler::handleError");
set_exception_handler("errorHandler::handleException");

header("content-type: application/json; charset=UTF-8");

$parts = explode("/", $_SERVER["REQUEST_URI"]);

if($parts[1] != "products"){
    http_response_code(404);
    exit;
}

$id = $parts[2] ?? null;

$database = new database("localhost", "product_db", "root", "");

$gateway = new productGateway($database);

$controller = new productController($gateway);
$controller->processRequest($_SERVER["REQUES_METHOD"], $id);

?>