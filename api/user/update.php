<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Methods: POST");
header("Access-Control-Max-Age: 3600");
header("Access-Control-Allow-Headers: Content-Type, Access-Control-Allow-Headers, Authorization, X-Requested-With");

// include database and object files
include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$databaseObject = $database->initializeConnection();

$user = new User($databaseObject);
$data = json_decode(file_get_contents("php://input"));

if (isset($_GET['id'])) {

    $user->id = $_GET['id'];
    $user->name = $data->name;
    $user->email = $data->email;

    if ($data->password) {
        $user->password = base64_encode($data->password);
    }

    if ($user->update()) {
        http_response_code(200);
        echo json_encode(array("message" => "User was updated."));
    } else {
        http_response_code(503);
        echo json_encode(array("message" => "Unable to update User."));
    }
}
