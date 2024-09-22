<?php

use Core\App;
use Core\Database;

$db = App::resolve(Database::class);

$deleteQuery = "DELETE FROM polls WHERE id = :id;";
$db->query($deleteQuery,["id"=>$_POST['id']]);

exit();
