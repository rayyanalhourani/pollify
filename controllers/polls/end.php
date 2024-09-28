<?php

use \Core\App;
use \Core\Database;

$id = $_POST["id"];
$db = App::resolve(Database::class);

$end_time = date('Y-m-d\TH:i');

$updateQuery = "UPDATE polls SET 
    end_time = :end_time 
    WHERE id = :id;";

$db->query($updateQuery, [
    "end_time" => $end_time,
    "id" => $id
]);

redirect("/polls");