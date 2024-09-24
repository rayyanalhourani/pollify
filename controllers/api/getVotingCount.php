<?php

use \Core\App;
use \Core\Database;

if (!isset($_GET['id'])) {
    header('Content-Type: application/json');
    http_response_code(403);
    echo json_encode("must pass poll id");
    die();
}

$id = $_GET['id'];

$db = App::resolve(Database::class);

$getVotes = "SELECT options.id as id,
    (SELECT COUNT(*) FROM votes WHERE votes.poll_id=:id and votes.option_id=options.id)
    as count from options WHERE poll_id=:id;";
$options = $db->query($getVotes, ["id" => $id])->get();

$response = [
    "options" => $options,
];

header('Content-Type: application/json');
http_response_code(200);
echo json_encode($response);
