<?php

use Core\Session;

view("/users/create.view.php", [
    'heading' => 'Create users',
    'errors'=>Session::get("errors")
]);