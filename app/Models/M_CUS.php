<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_CUS extends Model
{
    use HasFactory;
    protected $table = 'M_CUS';
    protected $fillable = ['MCUS_CUSCD', 'MCUS_CUSNM', 'MCUS_CURCD', 'MCUS_TAXREG', 'MCUS_ADDR1', 'MCUS_TELNO', 'created_by'];
}
