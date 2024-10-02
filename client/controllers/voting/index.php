<?php


use \Core\App;
use \Core\Database;

$db = App::resolve(Database::class);

$options = $db->query("SELECT polls.*, (SELECT COUNT(*) FROM votes
 WHERE votes.poll_id = polls.id) AS voting_count from polls;")->get();

view("/voting/index.view.php",[
    "title"=>"Voting",
    "options"=>$options
]);