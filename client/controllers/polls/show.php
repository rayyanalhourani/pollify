<?php

use \Core\App;
use \Core\Database;

$id = $_GET["id"];
$db = App::resolve(Database::class);

$poll = $db->query("SELECT polls.*,users.name as owner from polls,users where polls.id=:id", [
    "id" => $id
])->find();

$options = $db->query("SELECT o.id AS option_id,o.option_text,COUNT(v.id) AS vote_count FROM options o LEFT JOIN votes v ON o.id = v.option_id WHERE o.poll_id = :id GROUP BY o.id, o.option_text;", [
    "id" => $id
])->get();

$votes = $db->query("SELECT COUNT(id) as count from votes where poll_id=:id", ["id" => $id])->find();

view("/polls/show.view.php", [
    "title" => "Show Poll",
    "poll" => $poll,
    "options" => $options,
    "votes" => $votes
]);
