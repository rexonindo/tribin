<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_DLVORDHEAD extends Model
{
    use HasFactory;
    protected $table = 'T_DLVORDHEAD';
    protected $fillable = [
        'TDLVORD_DLVCD', 'TDLVORD_BRANCH', 'TDLVORD_CUSCD', 'TDLVORD_LINE',
        'TDLVORD_ISSUDT', 'TDLVORD_REMARK', 'TDLVORD_INVCD', 'updated_by', 'TDLVORD_MEKANIK', 'TDLVORD_JALAN_COST',
        'TDLVORD_VEHICLE_REGNUM'
    ];
}
