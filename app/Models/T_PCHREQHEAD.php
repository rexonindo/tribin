<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_PCHREQHEAD extends Model
{
    use HasFactory;
    protected $table = 'T_PCHREQHEAD';
    protected $fillable = ['PCHREQ_PCHCD', 'PCHREQ_PURPOSE', 'PCHREQ_REMARK', 'PCHREQ_ISSUDT', 'PCHREQ_APPRVBY', 'PCHREQ_APPRVDT', 'created_by', 'updated_by'];
}
