<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_SLOHEAD extends Model
{
    use HasFactory;
    protected $table = 'T_SLOHEAD';
    protected $fillable = [
        'TSLO_SLOCD', 'TSLO_CUSCD', 'TSLO_LINE', 'TSLO_ATTN', 'TSLO_QUOCD',
        'TSLO_POCD', 'TSLO_ISSUDT', 'TSLO_PLAN_DLVDT', 'TSLO_APPRVBY', 'TSLO_APPRVDT', 'TSLO_ADDRESS_NAME', 'TSLO_ADDRESS_DESCRIPTION',
        'created_by', 'updated_by', 'TSLO_BRANCH', 'TSLO_TYPE', 'TSLO_SERVTRANS_COST', 'TSLO_PERIOD_FR', 'TSLO_PERIOD_TO', 'TSLO_USAGE_DESCRIPTION',
        'TSLO_MAP_URL'
    ];
}
