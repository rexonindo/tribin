<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_Condition extends Model
{
    use HasFactory;
    protected $table = 'M_CONDITIONS';
    protected $fillable = ['MCONDITION_DESCRIPTION'];
}
