<?php

use \Core\App;
use \Core\Database;

$db = App::resolve(Database::class);
            
$users = $db->query("SELECT * from users")->get();

view("/users/index.view.php", [
    'heading' => 'Users',
    'users' => $users
]);
