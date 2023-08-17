<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class C_ITRN extends Model
{
    use HasFactory;
    protected $table = 'C_ITRN';
    protected $fillable = [
        'CITRN_BRANCH', 'CITRN_LOCCD', 'CITRN_DOCNO', 'CITRN_ISSUDT', 'CITRN_FORM', 'CITRN_ITMCD', 'CITRN_ITMQT', 'CITRN_PRCPER',
        'CITRN_PRCAMT', 'created_by', 'updated_by', 'deleted_at', 'deleted_by'
    ];
}
