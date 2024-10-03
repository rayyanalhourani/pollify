<?php

use Core\Session;

(new \Core\Captcha)->generateCaptcha();

view("auth/signup.view.php",[
    "title"=>"Sign up",
    "errors"=>Session::get("errors")
]);