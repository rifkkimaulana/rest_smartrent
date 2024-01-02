<?php

namespace App\Models;

use CodeIgniter\Model;

class LogModel extends Model
{
    protected $table = 'tbl_log';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'user_id',
        'aktivitas',
        'created_at'
    ];
}
