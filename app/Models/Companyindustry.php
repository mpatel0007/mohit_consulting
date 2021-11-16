<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companyindustry extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'company_industry';
	protected $fillable = [
        'id','company_id','industry_id','created_at','updated_at'
    ];
}
