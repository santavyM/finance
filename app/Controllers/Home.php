<?php

namespace App\Controllers;

class Home extends BaseController
{
    protected $helpers = ['url','form','CIMail','CIFunctions','text'];

    public function index()
    {
        return view('welcome_message');
    }

    public function method1() {
        echo view('finance');
    }

    public function method2() {
        echo view('kalkulacky/hypotecni-kalkulacka');
    }

    public function method3() {
        echo view('kalkulacky/investicni-kalkulacka');
    }

    public function method4() {
        echo view('example-auth');
    }
}
