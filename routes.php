<?php

$router->get('/', 'index.php');
$router->get('/about', 'about.php');
$router->get('/contact', 'contact.php');

//authentication
$router->get('/login', 'auth/login/index.php')->only(["guest"]);
$router->post('/login', 'auth/login/store.php')->only(["guest"]);
$router->get('/signup', 'auth/signup/index.php')->only(["guest"]);
$router->post('/signup', 'auth/signup/store.php')->only(["guest"]);
$router->post('/logout', 'auth/logout/store.php')->only(["auth"]);

//polls
$router->get('/polls', 'polls/index.php')->only(["auth", "admin"]);
$router->get('/polls/create', 'polls/create.php')->only(["auth", "admin"]);
$router->get('/polls/edit', 'polls/edit.php')->only(["auth", "admin"]);
$router->post('/polls/create', 'polls/store.php')->only(["auth", "admin"]);
$router->put('/polls/update', 'polls/update.php')->only(["auth", "admin"]);
$router->delete('/polls', 'polls/delete.php')->only(["auth", "admin"]);
$router->get('/polls/show', 'polls/show.php')->only(["auth", "admin"]);
$router->put('/polls/end', 'polls/end.php')->only(["auth", "admin"]);


//voting
$router->get('/voting', 'voting/index.php')->only(["auth"]);
$router->get('/voting/vote', 'voting/show.php')->only(["auth"]);
$router->post('/voting/vote', 'voting/store.php')->only(["auth"]);

//api
$router->get('/api/voting-count', 'api/getVotingCount.php');