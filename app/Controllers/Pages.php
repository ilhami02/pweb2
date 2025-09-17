<?php

namespace App\Controllers;

class Pages extends BaseController
{
    public function index() 
    {
        echo view('layout/home');
    }
}
