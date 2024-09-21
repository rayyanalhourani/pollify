<?php

use Core\App;
use Core\Database;
use Core\Validator;

$title = $_POST["title"];
$description = $_POST["description"];
$startTime = $_POST["startTime"];
$endTime = $_POST["endTime"];
$options = $_POST["options"] ?? [];

$errors = [];
if (!Validator::string($title, 5, 100)) {
    $errors['title'] = "The title should be between 5 to 100 characters";
}

if (!Validator::string($description, 5, 255)) {
    $errors['description'] = "The description should be between 5 to 255 characters";
}

if ($startTime == null) {
    $errors['startTime'] = "The start Time shouldn't be empty";
}

if ($endTime == null) {
    $errors['endTime'] = "The end time shouldn't be empty";
} else if ($startTime >= $endTime) {
    $errors['endTime'] = "The end time should be greater than start time";
}

if (empty($options) or in_array("", $options)) {
    $errors['options'] = "The options shouldn't be empty";
}

if (!empty($errors)) {
    return view("polls/create.view.php", [
        "title" => "Create poll",
        "errors" => $errors
    ]);
}

$pollQuery = "INSERT INTO polls (title, description, start_time, end_time, created_by)
             VALUES (:title,:description,:start_time,:end_time,:created_by);";

$db = App::resolve(Database::class);
$pollId = $db->query($pollQuery, [
    "title" => $title,
    "description" => $description,
    "start_time" => $startTime,
    "end_time" => $endTime,
    "created_by" => $_SESSION['user']['id']
]);

$optionQuery = "INSERT INTO options (poll_id, option_text) 
                VALUES (:poll_id, :option_text);";

foreach ($options as $option) {
    $db->query($optionQuery, [
        "poll_id" => $pollId,
        "option_text" => $option
    ]);
}

redirect("/polls");
