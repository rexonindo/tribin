<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class C_SPK extends Model
{
    use HasFactory;
    protected $table = 'C_SPK';
    protected $fillable = [
        'CSPK_BRANCH', 'CSPK_PIC_AS', 'CSPK_PIC_NAME', 'CSPK_REFF_DOC', 'CSPK_KM', 'CSPK_WHEELS', 'CSPK_UANG_JALAN', 'CSPK_SUPPLIER', 'CSPK_LITER', 'CSPK_UANG_SOLAR', 'CSPK_UANG_MAKAN',
        'CSPK_UANG_PENGINAPAN', 'CSPK_UANG_PENGAWALAN', 'CSPK_UANG_LAIN2',
        'created_by', 'updated_by', 'deleted_at', 'deleted_by'
    ];
}
