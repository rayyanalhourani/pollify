<?php

use \Core\App;
use \Core\Database;
use Core\Session;

function vote($db, $poll_id, $option_id)
{
    $voteQuery = "INSERT INTO votes (poll_id, option_id,voter_id) VALUES (:poll_id, :option_id,:voter_id);";
    $db->query($voteQuery, [
        "poll_id" => $poll_id,
        "option_id" => $option_id,
        "voter_id" => $_SESSION["user"]["id"]
    ]);
}

$db = App::resolve(Database::class);

$poll_id = $_POST['poll_id'];
$option_id = $_POST['option'] ?? null;

//check if the poll ended or not
$selectQuery = "SELECT * from polls where  = :id";
$poll = $db->query($selectQuery, ["id" => $poll_id])->find();

$currentDateTime = date('Y-m-d H:i:s');
$error = null;

$selectQuery = "SELECT * FROM polls WHERE id = :id";
$poll = $db->query($selectQuery, ["id" => $poll_id])->find();

if ($poll && $poll['end_time'] <= $currentDateTime) {
    return;
}

//get the user submit a empty choise or submit a choosen choise before
$selectQuery = "SELECT * from votes where poll_id = :poll_id and voter_id=:voter_id;";
$vote = $db->query($selectQuery, ["poll_id" => $poll_id, "voter_id" => $_SESSION["user"]["id"]])->find();

if (!$_POST['option']) {
    $error = "You have choose at option";
} else if ($vote['option_id'] == $option_id) {
    $error = "You have choose this option before";
}

if ($error != null) {
    Session::flash('error', $error);
    redirect("/voting");
}

//remove old vote when change the vote
if ($vote && $vote['option_id'] != $option_id) {
    $deleteQuery = "DELETE FROM votes WHERE id = :id;";
    $db->query($deleteQuery, ["id" => $vote['id']]);
}
//add new vote
vote($db, $poll_id, $option_id);


redirect("/voting");
