<?php

namespace App\Models;

use CodeIgniter\Model;

class Theme extends Model
{
    protected $DBGroup          = 'default';
    protected $table            = 'themes';
    protected $primaryKey       = 'id';
    protected $allowedFields    = [
        'user_id',
        'theme_name',
        'theme_file',
        'active',
    ];

}
