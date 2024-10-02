<?php

namespace Core\Middleware;

class Voter
{
    public function handle()
    {
        if ($_SESSION['user']["role"]!="voter") {
            redirect("/");
        }
    }
}