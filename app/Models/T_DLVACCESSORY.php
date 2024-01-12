<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_DLVACCESSORY extends Model
{
    use HasFactory;
    protected $table = 'T_DLVACCESSORY';
    protected $fillable = [
        'created_by', 'deleted_at', 'deleted_by', 'TDLVACCESSORY_DLVCD', 'TDLVACCESSORY_BRANCH',
        'TDLVACCESSORY_ITMCD', 'TDLVACCESSORY_ITMQT', 'updated_by'
    ];
}
