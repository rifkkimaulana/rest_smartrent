<?php

namespace App\Models;

use CodeIgniter\Model;

class ApikeyModel extends Model
{
    protected $table = 'tbl_apikey';
    protected $primaryKey = 'id_apikey';
    protected $allowedFields = [
        'user_id',
        'apikey'
    ];
}
