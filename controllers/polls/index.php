<?php

use \Core\App;
use \Core\Database;

$db = App::resolve(Database::class);
$polls = $db->query("SELECT polls.*,users.name as owner,
            (SELECT COUNT(*) FROM options WHERE options.poll_id = polls.id) AS option_count
            from polls,users;")->get(); 

view("/polls/index.view.php", [
    'heading' => 'Polls',
    'polls'=>$polls
]);
