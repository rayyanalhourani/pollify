<?php

namespace Core\Middleware;

class Admin
{
    public function handle()
    {
        if ($_SESSION['user']["role"]!="admin") {
            header('location: /');
            exit();
        }
    }
}