<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_PCHORDHEAD extends Model
{
    use HasFactory;
    protected $table = 'T_PCHORDHEAD';
    protected $fillable = [
        'TPCHORD_PCHCD', 'TPCHORD_ATTN', 'TPCHORD_SUPCD', 'TPCHORD_TYPE', 'TPCHORD_LINE', 'TPCHORD_REMARK',
        'TPCHORD_ISSUDT', 'TPCHORD_DLVDT', 'TPCHORD_APPRVBY', 'TPCHORD_APPRVDT', 'created_by', 'updated_by',
        'TPCHORD_REJCTBY', 'TPCHORD_REJCTDT', 'TPCHORD_REQCD', 'TPCHORD_BRANCH'
    ];
}
