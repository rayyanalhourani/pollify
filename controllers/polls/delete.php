<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);
$db->query("DELETE FROM polls WHERE id = :id;", [
    "id" => $_POST['id']
]);
exit();
