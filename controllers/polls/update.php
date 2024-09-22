<?php

use \Core\App;
use \Core\Database;
use \Core\Validator;

$id = $_POST["id"];
$title = $_POST["title"];
$description = $_POST["description"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];

$set = [$id, $title, $description, $start_time, $end_time];

$errors = [];
if (!Validator::string($title, 5, 100)) {
    $errors['title'] = "The title should be between 5 to 100 characters";
}

if (!Validator::string($description, 5, 255)) {
    $errors['description'] = "The description should be between 5 to 255 characters";
}

if ($start_time == null) {
    $errors['start_time'] = "The start Time shouldn't be empty";
}

if ($end_time == null) {
    $errors['end_time'] = "The end time shouldn't be empty";
} else if ($start_time >= $end_time) {
    $errors['end_time'] = "The end time should be greater than start time";
}

if (!empty($errors)) {
    $db = App::resolve(Database::class);
    $poll = $db->query("SELECT * from polls where id=:id", ["id" => $id])->findOrFail();
    $options = $db->query("SELECT * from options where poll_id=:id", ["id" => $id])->get();
    return view("polls/edit.view.php", [
        "title" => "Edit poll",
        "errors" => $errors,
        "poll" => $poll,
        "options" => $options
    ]);
}

$db = App::resolve(Database::class);

$updateQuery = "UPDATE polls SET title = :title, description = :description , start_time = :start_time, end_time = :end_time WHERE id = :id;";

$db->query($updateQuery, [
    "title" => $title,
    "description" => $description,
    "start_time" => $start_time,
    "end_time" => $end_time,
    "id" => $id
]);

redirect("/polls");
