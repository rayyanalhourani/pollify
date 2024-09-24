<?php

use \Core\App;
use \Core\Database;


$id = $_GET['id'];

$db = App::resolve(Database::class);

$poll = $db->query("SELECT polls.*,users.name as owner from polls,users where polls.id=:id", [
    "id" => $id
])->find();

$getOptions = "SELECT * from options WHERE poll_id=:id";
$options=$db->query($getOptions,["id"=>$id])->get();

$userVoteQuery = "SELECT * from votes where poll_id = :poll_id and voter_id=:voter_id;";
$vottedOption = $db->query($userVoteQuery, [
    "poll_id" => $id,
    "voter_id" => $_SESSION["user"]["id"]
])->find();

view("/voting/show.view.php", [
    "title" => "Vote",
    "poll" => $poll,
    "options" => $options,
    "vottedOption" => $vottedOption["option_id"] ?? null
]);
