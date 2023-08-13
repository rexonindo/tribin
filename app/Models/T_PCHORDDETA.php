<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_PCHORDDETA extends Model
{
    use HasFactory;
    protected $table = 'T_PCHORDDETA';
    protected $fillable = [
        'deleted_at', 'deleted_by', 'TPCHORDDETA_PCHCD', 'TPCHORDDETA_ITMCD', 'TPCHORDDETA_ITMQT',
        'TPCHORDDETA_ITMPRC_PER', 'created_by', 'updated_by', 'TPCHORDDETA_BRANCH'
    ];
}
