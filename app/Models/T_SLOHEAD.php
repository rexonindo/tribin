<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_SLOHEAD extends Model
{
    use HasFactory;
    protected $table = 'T_SLOHEAD';
    protected $fillable = ['TSLO_SLOCD', 'TSLO_CUSCD', 'TSLO_LINE'
    ,'TSLO_ATTN','TSLO_QUOCD','TSLO_POCD','TSLO_ISSUDT','TSLO_APPRVBY','TSLO_APPRVDT'
    ,'created_by', 'updated_by'];
}
