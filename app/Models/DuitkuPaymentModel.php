<?php

namespace App\Models;

use CodeIgniter\Model;

class DuitkuPaymentModel extends Model
{
    protected $table = 'tbl_duitku_payment';
    protected $primaryKey = 'id';
    protected $allowedFields = [
        'environment',
        'merchant_code',
        'apikey_duitku'
    ];
}
