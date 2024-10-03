<?php

use \Core\App;
use \Core\Database;
use Core\Session;

$id = $_GET['id'];

$db = App::resolve(Database::class);

//get poll
$poll = $db->query("SELECT polls.*,users.name as owner from polls,users where polls.id=:id", [
    "id" => $id
])->find();

//get poll options
$getOptions = "SELECT * from options WHERE poll_id=:id";
$options=$db->query($getOptions,["id"=>$id])->get();

//get choosen option if exist
$userVoteQuery = "SELECT * from votes where poll_id = :poll_id and voter_id=:voter_id;";
$vottedOption = $db->query($userVoteQuery, [
    "poll_id" => $id,
    "voter_id" => $_SESSION["user"]["id"]
])->find();

view("/voting/show.view.php", [
    "title" => "Vote",
    "poll" => $poll,
    "options" => $options,
    "vottedOption" => $vottedOption["option_id"] ?? null,
    "error"=>Session::get('error')
]);
