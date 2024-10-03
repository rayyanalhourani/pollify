<?php

use Core\Authenticator;
use \Core\Validator;
use \Core\App;
use \Core\Database;
use Core\Session;

$db = App::resolve(Database::class);

$name = $_POST['name'];
$email = $_POST['email'];
$password = $_POST['password'];
$cpassword = $_POST['cpassword'];
$captcha = $_POST['captcha'];

$errors = [];
if (!Validator::string($name, 5)) {
    $errors['name'] = 'Please provide a name of at least five characters.';
}

if (!Validator::email($email)) {
    $errors['email'] = 'Please provide a valid email address.';
}

if (!Validator::string($password, 7, 255)) {
    $errors['password'] = 'Please provide a password of at least seven characters.';
}

if ($password !== $cpassword) {
    $errors['cpassword'] = 'The password and confirmation password do not match.';
}

if ($captcha !== $_SESSION['captcha']['text']) {
    $errors['captcha'] = 'The CAPTCHA you entered is incorrect. Please try again.';
}

$user = $db->query("select * from users where email=:email", ["email" => $email])->find();

if ($user) {
    $errors['email'] = 'This email address is used before.';
}

if (!empty($errors)) {
    Session::flash('name',$name);
    Session::flash('email',$email);
    Session::flash('errors',$errors);

    redirect("/signup");
}

$db->query("INSERT INTO users (name, email, password) VALUES (:name, :email, :password);", [
    "name" => $name,
    "email" => $email,
    "password" => password_hash($password, PASSWORD_BCRYPT),
]);

$user = $db->query("select * from users where email=:email", ["email" => $email])->find();

(new Authenticator)->login($user);
redirect("/");
