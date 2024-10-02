<?php

use \Core\App;
use Core\Authenticator;
use \Core\Database;

$db = App::resolve(Database::class);

//recieve email and password,
$email = $_POST['email'];
$password = $_POST['password'];

if((new Authenticator)->attempt($email,$password)){
    redirect("/");
}
else{
    return view("auth/login.view.php",[
        "title"=>"Login",
        "errors"=>[
            "auth"=>"Wronge email address or password"
        ]
    ]);
}


