<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_SLODETA extends Model
{
    use HasFactory;
    protected $table = 'T_SLODETA';
    protected $fillable = [
        'TSLODETA_SLOCD', 'TSLODETA_ITMCD', 'TSLODETA_ITMQT', 'TSLODETA_USAGE', 'TSLODETA_USAGE_DESCRIPTION', 'TSLODETA_OPRPRC',
        'TSLODETA_MOBDEMOB', 'TSLODETA_PRC', 'created_by', 'updated_by', 'deleted_at', 'deleted_by', 'TSLODETA_BRANCH'
    ];
}
