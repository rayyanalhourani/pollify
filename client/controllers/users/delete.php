<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$db->query("DELETE FROM users WHERE id = :id;", [
    "id" => $_POST['id']
]);
exit();
