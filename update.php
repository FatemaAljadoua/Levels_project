<?php
require_once "Helpers/headers.php";
send_json_api_headers('PUT');

require_once "Config/conn.php";
require_once "Helpers/response.php";

if ($_SERVER["REQUEST_METHOD"] !== "PUT") {
    response(405, "Only POST Method is allowed");
}

$input = json_decode(file_get_contents("php://input"));


try {

    if (
        !isset($input->id) ||
        !isset($input->level_number) ||
        !isset($input->title) ||
        !isset($input->descripition)
    ) {
        response(400, "Bad request: 'id', 'level_number', 'title', and 'descripition' are required");
    }

    $id = $input->id;
    $level_number = $input->level_number;
    $title = $input->title;
    $descripition = $input->descripition;


    if (!is_numeric($id) || !is_numeric($level_number)) {
        response(400, "Bad request: id and level_number must be numeric.");
    }

    if (!is_string($title) || !is_string($descripition)) {
        response(400, "Bad request: title and descripition must be strings.");
    }

    
    $select_query = "SELECT id FROM level WHERE id = :id";
    $check = $pdo->prepare($select_query);
    $check->bindParam(":id", $id, PDO::PARAM_INT);
    $check->execute();

    if ($check->rowCount() === 0) {
        response(404, "Bad request: Level not found!");
    }

    $update_query = "UPDATE level SET level_number = :level_number, title = :title, descripition = :descripition WHERE id = :id";
    $update_stmnt = $pdo->prepare($update_query);
    
    $update_stmnt->bindParam(":id", $id, PDO::PARAM_INT);
    $update_stmnt->bindParam(":level_number", $level_number, PDO::PARAM_INT);
    $update_stmnt->bindParam(":title", $title, PDO::PARAM_STR);
    $update_stmnt->bindParam(":descripition", $descripition, PDO::PARAM_STR);

    if ($update_stmnt->execute()) {
        response(200, "Level updated successfully.");
    } else {
        response(503, "Unable to update the level");
    }
} catch (Exception $e) {
    response(500, "Server error: " . $e->getMessage());
}
