<?php

namespace App\Models;

use CodeIgniter\Model;

class WhatsappModel extends Model
{
    protected $table = 'tbl_wablas_gateway';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'domain_api',
        'token_api'
    ];
}
