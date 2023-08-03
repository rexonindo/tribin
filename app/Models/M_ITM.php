<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_ITM extends Model
{
    use HasFactory;
    protected $table = 'M_ITM';
    protected $fillable = ['MITM_ITMCD', 'MITM_ITMNM', 'MITM_ITMTYPE', 'MITM_STKUOM', 'MITM_BRAND', 'MITM_MODEL', 'MITM_SPEC', 'MITM_ITMCAT', 'MITM_COACD', 'MITM_BRANCH'];
}
