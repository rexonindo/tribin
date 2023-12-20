<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_RCV_DETAIL extends Model
{
    use HasFactory;
    protected $table = 'T_RCV_DETAIL';
    protected $fillable = [
        'deleted_at', 'deleted_by',
        'id_header',  'branch', 'po_number', 'item_code', 'quantity', 'unit_price',
        'created_by', 'updated_by'
    ];
}
