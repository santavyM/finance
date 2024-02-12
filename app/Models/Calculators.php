<?php

namespace App\Models;

use CodeIgniter\Model;

class Calculators extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'calculators';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'mortgage',
        'rent',
        'invest',
    ];



  
}
