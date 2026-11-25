<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index(): string
    {
        if (! logged_in()) {
            return view('welcome_message');
        }

        return view('home');
    }
}
