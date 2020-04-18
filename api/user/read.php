<?php

header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: access");
header("Access-Control-Allow-Methods: GET");
header("Access-Control-Allow-Credentials: true");
header('Content-Type: application/json');

include_once '../config/database.php';
include_once '../objects/user.php';

$database = new Database();
$databaseObject = $database->initializeConnection();

$user = new User($databaseObject);

$statement = $user->read();
$numberCount = $statement->rowCount();

if (isset($_GET['id'])) {
    $user->id = $_GET['id'];
    $user->userById();

    if ($user->name != null) {

        $user = array(
            "id" => $user->id,
            "name" => $user->name,
            "email" => $user->email
        );

        http_response_code(200);
        echo json_encode($user);

    } else {
        http_response_code(404);
        echo json_encode(array("message" => "User does not exist."));
    }
} else {

    $id = '';
    $name = '';
    $email = '';
    $password = '';

    if($numberCount>0){

        $users = array();
        $users["records"] = array();

        // retrieve our table contents
        // fetch() is faster than fetchAll()
        // http://stackoverflow.com/questions/2770630/pdofetchall-vs-pdofetch-in-a-loop

        while ($row = $statement->fetch(PDO::FETCH_ASSOC)){
            // extract row
            // this will make $row['name'] to
            // just $name only
            extract($row);

            $user = array(
                "id" => $id,
                "name" => $name,
                "email" => $email,
                "password" => $password
            );
            array_push($users["records"], $user);
        }

        http_response_code(200);
        echo json_encode($users);

    } else{

        http_response_code(404);
        echo json_encode(
            array("message" => "No users found.")
        );
    }
}
