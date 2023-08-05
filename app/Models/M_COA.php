<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class M_COA extends Model
{
    use HasFactory;
    protected $table = 'M_COA';
    protected $fillable = ['MCOA_COACD', 'MCOA_COANM', 'MCOA_BRANCH'];
}
