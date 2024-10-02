<?php

use Core\App;
use Core\Database;
use Core\Session;
use Core\Validator;

$title = $_POST["title"];
$description = $_POST["description"];
$start_time = $_POST["start_time"];
$end_time = $_POST["end_time"];
$options = $_POST["options"] ?? [];

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
    Session::flash("title",$title);
    Session::flash("description",$description);
    Session::flash("start_time",$start_time);
    Session::flash("end_time",$end_time);
    Session::flash("options",$options);

    return view("polls/create.view.php", [
        "title" => "Create poll",
        "errors" => $errors
    ]);
}

$db = App::resolve(Database::class);

$pollQuery = "INSERT INTO polls (title, description, start_time, end_time, created_by)
             VALUES (:title,:description,:start_time,:end_time,:created_by);";
$pollId = $db->query($pollQuery, [
    "title" => $title,
    "description" => $description,
    "start_time" => $start_time,
    "end_time" => $end_time,
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
