<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class C_SPK extends Model
{
    use HasFactory;
    protected $table = 'C_SPK';
    protected $fillable = [
        'CSPK_BRANCH', 'CSPK_PIC_AS', 'CSPK_PIC_NAME', 'CSPK_REFF_DOC', 'CSPK_KM', 'CSPK_WHEELS', 'CSPK_UANG_JALAN', 'CSPK_SUPPLIER',
        'CSPK_LITER', 'CSPK_LITER_EXISTING', 'CSPK_UANG_SOLAR', 'CSPK_UANG_MAKAN', 'CSPK_UANG_MANDAH',
        'CSPK_UANG_PENGINAPAN', 'CSPK_UANG_PENGAWALAN', 'CSPK_UANG_LAIN2',
        'CSPK_DOCNO', 'CSPK_DOCNO_ORDER', 'CSPK_LEAVEDT', 'CSPK_BACKDT', 'CSPK_VEHICLE_TYPE', 'CSPK_VEHICLE_REGNUM', 'CSPK_JOBDESK',
        'closed_by', 'closed_at',
        'created_by', 'updated_by', 'deleted_at', 'deleted_by'
    ];
}
