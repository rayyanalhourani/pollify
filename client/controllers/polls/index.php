<?php

use \Core\App;
use \Core\Database;

$db = App::resolve(Database::class);

//select polls with total number of votes
$selectQuery="SELECT polls.*,users.name as owner,
            (SELECT COUNT(*) FROM options WHERE options.poll_id = polls.id) AS option_count
            from polls,users where polls.created_by = users.id;";
            
$polls = $db->query($selectQuery)->get();

view("/polls/index.view.php", [
    'heading' => 'Polls',
    'polls' => $polls
]);
