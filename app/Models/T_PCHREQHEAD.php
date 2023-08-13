<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_PCHREQHEAD extends Model
{
    use HasFactory;
    protected $table = 'T_PCHREQHEAD';
    protected $fillable = [
        'TPCHREQ_PCHCD', 'TPCHREQ_PURPOSE', 'TPCHREQ_SUPCD', 'TPCHREQ_TYPE', 'TPCHREQ_LINE', 'TPCHREQ_REMARK',
        'TPCHREQ_ISSUDT', 'TPCHREQ_APPRVBY', 'TPCHREQ_APPRVDT', 'created_by', 'updated_by', 'TPCHREQ_REJCTBY',
        'TPCHREQ_REJCTDT', 'TPCHREQ_BRANCH'
    ];
}
