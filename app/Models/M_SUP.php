<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_SUP extends Model
{
    use HasFactory;
    protected $table = 'M_SUP';
    protected $fillable = [
        'MSUP_SUPCD', 'MSUP_SUPNM', 'MSUP_CURCD', 'MSUP_TAXREG', 'MSUP_ADDR1', 'MSUP_TELNO',
        'MSUP_CGCON', 'created_by', 'MSUP_BRANCH'
    ];
}
