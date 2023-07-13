<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_PCHREQTYPE extends Model
{
    use HasFactory;
    protected $table = 'M_PCHREQTYPE';
    protected $fillable = [
        'MPCHREQTYPE_ID', 'MPCHREQTYPE_NAME'
    ];
}
