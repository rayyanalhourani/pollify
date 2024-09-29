<?php

use \Core\App;
use \Core\Database;
use \Core\Validator;

$db = App::resolve(Database::class);

$id = $_GET["id"];

$user = $db->query("SELECT * from users where id=:id", [
    "id" => $id
])->findOrFail();

view("/users/edit.view.php", [
    'heading' => 'Edit user',
    'user' => $user,
]);