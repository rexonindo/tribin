<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_CUS extends Model
{
    use HasFactory;
    protected $table = 'M_CUS';
    protected $fillable = [
        'MCUS_CUSCD', 'MCUS_CUSNM', 'MCUS_CURCD', 'MCUS_TAXREG', 'MCUS_ADDR1', 'MCUS_TELNO',
        'MCUS_CGCON', 'created_by', 'MCUS_BRANCH', 'MCUS_TYPE', 'MCUS_KTP_FILE', 'MCUS_NPWP_FILE',
        'MCUS_NIB_FILE', 'MCUS_GROUP', 'MCUS_REFF_MKT', 'MCUS_PIC_NAME', 'MCUS_PIC_TELNO', 'MCUS_EMAIL',
        'MCUS_IDCARD', 'MCUS_GENID'
    ];
}
