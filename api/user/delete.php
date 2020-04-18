<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$databaseObject = $database->initializeConnection();
$user = new User($databaseObject);

$user->id = $_GET['id'];

if ($user->delete()) {
    http_response_code(200);
    echo json_encode(array("message" => "User was deleted."));
} else {
    http_response_code(503);
    echo json_encode(array("message" => "Unable to delete product."));
}