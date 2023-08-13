<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_PCHREQDETA extends Model
{
    use HasFactory;
    protected $table = 'T_PCHREQDETA';
    protected $fillable = [
        'deleted_at', 'deleted_by', 'TPCHREQDETA_PCHCD', 'TPCHREQDETA_ITMCD', 'TPCHREQDETA_ITMQT',
        'TPCHREQDETA_REQDT', 'TPCHREQDETA_REMARK', 'created_by', 'updated_by', 'TPCHREQDETA_BRANCH'
    ];
}
