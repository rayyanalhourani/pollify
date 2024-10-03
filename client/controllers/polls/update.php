<?php

use \Core\App;
use \Core\Database;
use Core\Session;
use \Core\Validator;

$id = $_POST["id"];
$title = $_POST["title"];
$description = $_POST["description"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$options = $_POST["options"] ?? [];
$deletedOptions = $_POST["deleted"] ?? [];
$addedOptions = $_POST["added"] ?? [];
$editedOptions = $_POST["edited"] ?? [];

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

if (empty($options) or in_array("", $options)) {
    $errors['options'] = "The options shouldn't be empty";
}

if (!empty($errors)) {
    Session::flash("errors", $errors);

    redirect("/polls/edit?id=$id");
}

$db = App::resolve(Database::class);

//update poll
$updateQuery = "UPDATE polls SET 
    title = :title, 
    description = :description,
    start_time = :start_time,
    end_time = :end_time 
    WHERE id = :id;";

$db->query($updateQuery, [
    "title" => $title,
    "description" => $description,
    "start_time" => $start_time,
    "end_time" => $end_time,
    "id" => $id
]);

//add options
$addQuery = "INSERT INTO options (poll_id, option_text) VALUES (:poll_id, :option_text);";
foreach ($addedOptions as $index) {
    $db->query($addQuery, [
        "poll_id" => $id,
        "option_text" => $options[$index]
    ]);
}

//edit options
$editQuery = "UPDATE options SET option_text = :option_text WHERE id = :id;";
foreach ($editedOptions as $index) {
    $db->query($editQuery, [
        "id" => $index,
        "option_text" => $options[$index]
    ]);
}

//delete options
$deleteQuery = "DELETE FROM options WHERE id = :id;";
foreach ($deletedOptions as $index) {
    $db->query($deleteQuery, [
        "id" => $index,
    ]);
}

redirect("/polls");
