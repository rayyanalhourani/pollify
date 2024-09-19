<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

//authentication
$router->get('/login','auth/login/index.php')->only("guest");
$router->post('/login', 'auth/login/store.php')->only("guest");
$router->get('/signup','auth/signup/index.php')->only("guest");
$router->post('/signup','auth/signup/store.php')->only("guest");
$router->post('/logout','auth/logout/store.php')->only("auth");

//polls
$router->get('/polls', 'polls/index.php')->only("auth");