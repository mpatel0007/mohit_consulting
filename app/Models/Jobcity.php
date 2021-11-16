<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobcity extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'jobs_city';
	protected $fillable = [
        'job_id','city_id','created_at','updated_at'
    ];
    protected $casts = [
        'id' => 'integer',
        'city_id' => 'integer',
        'job_id' => 'integer',
        
    ];
}
