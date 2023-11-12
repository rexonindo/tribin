<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class C_CASHIER extends Model
{
    use HasFactory;
    protected $table = 'C_CASHIER';
    protected $fillable = [
        'CCASHIER_BRANCH', 'CCASHIER_ISSUDT', 'CCASHIER_ITMCD', 'CCASHIER_LOCATION', 'CCASHIER_PRICE', 'CCASHIER_REFF_DOC', 'CCASHIER_REMARK', 'CCASHIER_USER',
        'created_by', 'updated_by', 'deleted_at', 'deleted_by'
    ];
}
