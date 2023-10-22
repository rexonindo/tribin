<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_UOM extends Model
{
    use HasFactory;
    protected $table = 'M_UOM';
    protected $fillable = [
        'created_by', 'updated_by', 'deleted_at', 'deleted_by', 'MUOM_UOMCD', 'MUOM_UOMNM', 'MUOM_BRANCH'
    ];
}
