<?php

$router->get('/', 'index.php');


//authentication
$router->get('/login','auth/login/index.php')->only("guest");

$router->get('/signup','auth/signup/index.php')->only("guest");
$router->post('/signup','auth/signup/store.php')->only("guest");

$router->post('/logout','auth/logout/store.php')->only("auth");