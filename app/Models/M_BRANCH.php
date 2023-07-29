<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_BRANCH extends Model
{
    use HasFactory;
    protected $table = 'M_BRANCH';
    protected $fillable = ['MBRANCH_CD', 'MBRANCH_NM', 'created_by', 'updated_by'];
}
