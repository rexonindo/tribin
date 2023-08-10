<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class T_SLO_DRAFT_HEAD extends Model
{
    use HasFactory;
    protected $table = 'T_SLO_DRAFT_HEAD';
    protected $fillable = [
        'TSLODRAFT_SLOCD', 'TSLODRAFT_CUSCD', 'TSLODRAFT_LINE', 'TSLODRAFT_ATTN', 'TSLODRAFT_POCD', 'TSLODRAFT_ISSUDT',
        'TSLODRAFT_APPRVBY', 'TSLODRAFT_APPRVDT', 'created_by', 'updated_by', 'TSLODRAFT_BRANCH'
    ];
}
