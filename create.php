<?php
require_once "Helpers/headers.php";
send_json_api_headers('POST');

require_once "Config/conn.php";
require_once "Helpers/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "POST") {
    response(405, "Only POST Method is allowed");
}
 
$input = json_decode(file_get_contents("php://input"));

try {

    if(!isset($input->level_number) || !isset($input->title) ||  !isset($input->descripition)){
        response(400, "Bad request: level_number, title, and descripition are required");
    }

    $level_number = $input->level_number;
    $title = $input->title;
    $descripition = $input->descripition;

    if(!is_numeric($level_number) || !is_string($title) ||  !is_string($descripition)){
        response(400, "Bad request: Invalid data formats.");
    }

    $create_query = "INSERT INTO level (level_number, title, descripition) VALUES (:level_number, :title, :descripition)";
    $create_stmnt = $pdo->prepare($create_query);
    
    $create_stmnt->bindParam(':level_number', $level_number, PDO::PARAM_INT);
    $create_stmnt->bindParam(':title', $title, PDO::PARAM_STR);
    $create_stmnt->bindParam(':descripition', $descripition, PDO::PARAM_STR);

    if($create_stmnt->execute()){
        response(201, "Level created successfully.");
    } else {
        response(503, "Unable to create the level");
    }
}
catch (Exception $e) {
    response(500, "Server error: " . $e->getMessage());
}