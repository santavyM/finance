<?php

namespace App\Controllers;


use App\Models\Model;
class Pokus extends BaseController
{
    public function pokus()
    {
        $model = new Model();
        $data['data'] = $model->getDVDs();
        $data["title"] = "Titulek";
        echo view('dvd', $data);
    }
}