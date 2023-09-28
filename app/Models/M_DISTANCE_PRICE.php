<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_DISTANCE_PRICE extends Model
{
    use HasFactory;
    protected $table = 'M_DISTANCE_PRICE';
    protected $fillable = [
        'created_by', 'updated_by', 'deleted_at', 'deleted_by',
        'BRANCH', 'RANGE1', 'RANGE2', 'PRICE_WHEEL_4_AND_6', 'PRICE_WHEEL_10'
    ];
}
