<?php

namespace App\Models;


use Config\Database;

class Model
{
    var $db;
    function __construct()
    {
        $this->db = \Config\Database::connect();
    }


    function getDVDs()
    {

        $builder = $this->db->table('dvd');
        $builder->select('nazev, rok_vydani');

        $data = $builder->get()->getResult();
        return $data;
    }
}
