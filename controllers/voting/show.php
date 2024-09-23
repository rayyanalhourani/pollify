<?php

use \Core\App;
use \Core\Database;


$id = $_GET['id'];

$db = App::resolve(Database::class);

$poll = $db->query("SELECT polls.*,users.name as owner from polls,users where polls.id=:id", ["id" => $id])->find();

$options = $db->query("SELECT o.poll_id ,o.id AS id,o.option_text,COUNT(v.id) AS voting_count FROM options o
LEFT JOIN votes v ON o.id = v.option_id WHERE o.poll_id = :id GROUP BY o.id, o.option_text;", ["id" => $id])->get();

$selectQuery = "SELECT * from votes where poll_id = :poll_id and voter_id=:voter_id;";
$vottedOption = $db->query($selectQuery, ["poll_id" => $id, "voter_id" => $_SESSION["user"]["id"]])->find();

view("/voting/show.view.php", [
    "title" => "Vote",
    "poll" => $poll,
    "options" => $options,
    "vottedOption" => $vottedOption["option_id"] ?? null
]);
