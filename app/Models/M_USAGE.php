<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_USAGE extends Model
{
    use HasFactory;
    protected $table = 'M_USAGE';
    protected $fillable = [
        'MUSAGE_CD', 'MUSAGE_DESCRIPTION', 'MUSAGE_ALIAS',
        'created_by', 'MUSAGE_BRANCH', 'deleted_at', 'deleted_by', 'updated_by'
    ];
}
