<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyGroup extends Model
{
    use HasFactory;
    protected $table = 'COMPANY_GROUPS';
    protected $fillable = ['name', 'connection', 'address', 'phone', 'fax', 'alias_code', 'alias_group_code', 'invoice_number_patter'];
}
