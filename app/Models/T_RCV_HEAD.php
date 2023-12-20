<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_RCV_HEAD extends Model
{
    use HasFactory;
    protected $table = 'T_RCV_HEAD';
    protected $fillable = [
        'deleted_at', 'deleted_by',
        'TRCV_RCVCD',  'TRCV_BRANCH', 'TRCV_SUPCD', 'TRCV_ISSUDT',
        'created_by', 'updated_by'
    ];
}
