<?php

use Core\App;
use Core\Container;
use Core\Database;

$container = new Container();

$container->bind('Core\Database', function () {
    $HOST = getenv("HOST");
    $DBNAME = getenv("DBNAME");
    $CHARSET = getenv("CHARSET");
    $USER = getenv("USER");
    $PASSWORD = getenv("PASSWORD");

    return new Database($HOST,$DBNAME,$CHARSET,$USER,$PASSWORD);
});

App::setContainer($container);
