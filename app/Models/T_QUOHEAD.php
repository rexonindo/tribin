<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_QUOHEAD extends Model
{
    use HasFactory;
    protected $table = 'T_QUOHEAD';
    protected $fillable = [
        'TQUO_QUOCD', 'TQUO_CUSCD', 'TQUO_LINE', 'TQUO_ATTN', 'TQUO_SBJCT', 'TQUO_ISSUDT',
        'TQUO_APPRVBY', 'TQUO_APPRVDT', 'created_by', 'updated_by', 'TQUO_BRANCH', 'TQUO_TYPE', 'TQUO_SERVTRANS_COST',
        'TQUO_APPROVAL_HIS', 'TQUO_PROJECT_LOCATION'
    ];
}
