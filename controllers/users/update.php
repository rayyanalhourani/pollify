<?php

use \Core\App;
use \Core\Database;
use \Core\Validator;

$db = App::resolve(Database::class);

$id = $_POST['id'];
$name = $_POST['name'];
$email = $_POST['email'];
$originalEmail = $_POST['originalEmail'];
$role = $_POST['role'];
$password = $_POST['password'] ?? "";
$cpassword = $_POST['cpassword'] ?? "";

$errors = [];
if (!Validator::string($name, 5)) {
    $errors['name'] = 'Please provide a name of at least five characters.';
}

if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 7, 255) && ($password != "")) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if ($password !== $cpassword) {
    $errors['cpassword'] = 'The password and confirmation password do not match.';
}

$user = $db->query("select * from users where email=:email", ["email" => $email])->find();

if ($user && ($email != $originalEmail)) {
    $errors['email'] = 'This email address is used before.';
}

if (!empty($errors)) {
    return view("users/edit.view.php", [
        "title" => "Edit",
        "errors" => $errors
    ]);
}

$updateQuery = "UPDATE users SET name = :name, email = :email, role = :role";
$params = [
    "id" => $id,
    "name" => $name,
    "email" => $email,
    "role" => $role,
];

if ($password != "") {
    $updateQuery .= ", password = :password";
    $params["password"] = password_hash($password, PASSWORD_BCRYPT);
}

$updateQuery .= " WHERE id = :id";

$db->query($updateQuery, $params);

redirect("/users");
