<?php

use \Core\App;
use \Core\Database;

$id = $_GET["id"];
$db = App::resolve(Database::class);

$poll = $db->query("SELECT * from polls where id=:id", [
    "id" => $id
])->findOrFail();

$options = $db->query("SELECT * from options where poll_id=:id", [
    "id" => $id
])->get();

view("/polls/edit.view.php", [
    'heading' => 'Edit Poll',
    'poll' => $poll,
    'options' => $options
]);
