<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        return view('welcome_message');
    }

    public function method1() {
        echo view('finance');
    }

    public function method2() {
        echo view('kalkulacka');
    }
}
