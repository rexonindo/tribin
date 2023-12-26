<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class COMPANY_BRANCH extends Model
{
    use HasFactory;
    protected $table = 'COMPANY_BRANCHES';
    protected $fillable = [
        'name', 'address', 'connection', 'phone', 'fax', 'invoice_letter_id', 'created_by', 'updated_by',
        'BRANCH', 'letter_head', 'quotation_letter_id'
    ];
}
