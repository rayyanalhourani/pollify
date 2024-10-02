<?php


use \Core\App;
use \Core\Database;

$db = App::resolve(Database::class);

$currentDateTime = date('Y-m-d H:i:s');

$polls = $db->query("
    SELECT polls.*, 
           (SELECT COUNT(*) FROM votes WHERE votes.poll_id = polls.id) AS voting_count 
    FROM polls 
    WHERE end_time > :curDate
", ["curDate" => $currentDateTime])->get();

view("/voting/index.view.php", [
    "title" => "Voting",
    "polls" => $polls
]);
