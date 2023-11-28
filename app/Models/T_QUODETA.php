<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_QUODETA extends Model
{
    use HasFactory;
    protected $table = 'T_QUODETA';
    protected $fillable = [
        'TQUODETA_QUOCD', 'TQUODETA_ITMCD', 'TQUODETA_ITMQT', 'TQUODETA_USAGE', 'TQUODETA_OPRPRC',
        'TQUODETA_MOBDEMOB', 'TQUODETA_PRC', 'created_by', 'updated_by', 'deleted_at', 'deleted_by', 'TQUODETA_BRANCH',
        'TQUODETA_PERIOD_FR', 'TQUODETA_PERIOD_TO', 'TQUODETA_USAGE_DESCRIPTION', 'TQUODETA_ELECTRICITY'
    ];
}
