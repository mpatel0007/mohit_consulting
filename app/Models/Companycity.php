<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Companycity extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'company_city';
	protected $fillable = [
        'job_id','city_id','created_at','updated_at'
    ];
}
