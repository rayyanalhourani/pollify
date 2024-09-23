<?php

use \Core\App;
use \Core\Database;

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

$selectQuery = "SELECT * from votes where poll_id = :poll_id and voter_id=:voter_id;";
$vote = $db->query($selectQuery, ["poll_id" => $poll_id, "voter_id" => $_SESSION["user"]["id"]])->find();

$error = null;
if (!$_POST['option']) {
    $error = "You have choose at option";
} else if ($vote['option_id'] == $option_id) {
    $error = "You have choose this option before";
}

if ($error != null) {
    $poll = $db->query("SELECT polls.*,users.name as owner from polls,users where polls.id=:id", ["id" => $poll_id])->find();

    $options = $db->query("SELECT o.poll_id ,o.id AS id,o.option_text,COUNT(v.id) AS voting_count FROM options o
            LEFT JOIN votes v ON o.id = v.option_id WHERE o.poll_id = :id GROUP BY o.id, o.option_text;", ["id" => $poll_id])->get();

    $vottedOption = $db->query($selectQuery, ["poll_id" => $poll_id, "voter_id" => $_SESSION["user"]["id"]])->find();

    view("/voting/show.view.php", [
        "title" => "Vote",
        "poll" => $poll,
        "options" => $options,
        "error" => $error,
        "vottedOption" => $vottedOption["option_id"] ?? null
    ]);
    exit();
}

if ($vote) {
    if ($vote['option_id'] != $option_id) {
        $deleteQuery = "DELETE FROM votes WHERE id = :id;";
        $db->query($deleteQuery, ["id" => $vote['id']]);
        vote($db, $poll_id, $option_id);
    }
} else {
    vote($db, $poll_id, $option_id);
}

redirect("/voting");
