<?php

$router->get('/', 'index.php');


//authentication
$router->get('/login', 'auth/login/index.php')->only("guest");
$router->get('/signup', 'auth/signup/index.php')->only("guest");