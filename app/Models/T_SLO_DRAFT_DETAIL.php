<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_SLO_DRAFT_DETAIL extends Model
{
    use HasFactory;
    protected $table = 'T_SLO_DRAFT_DETAIL';
    protected $fillable = [
        'deleted_at', 'deleted_by',
        'TSLODRAFTDETA_SLOCD',  'TSLODRAFTDETA_ITMCD', 'TSLODRAFTDETA_ITMQT', 'TSLODRAFTDETA_ITMPRC_PER',
        'created_by', 'updated_by', 'TSLODRAFTDETA_BRANCH'
    ];
}
