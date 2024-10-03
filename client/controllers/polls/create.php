<?php

use \Core\Session;

view("/polls/create.view.php", [
    'heading' => 'Create polls',
    "errors"=>Session::get('errors')
]);