<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companyfunctionalarea extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'Company_functional_area';
	protected $fillable = [
        'id','company_id','functional_area_id','created_at','updated_at'
    ];
}
