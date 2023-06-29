<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroupAccess extends Model
{
    use HasFactory;
    protected $fillable = [
        'nick_name', 'connection', 'created_by', 'deleted_at', 'deleted_by', 'updated_by'
    ];
}
