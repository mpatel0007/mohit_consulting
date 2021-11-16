<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobfunctionalarea extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'Job_functionalarea';
	protected $fillable = [
        'id','job_id','functional_area_id','created_at','updated_at'
    ];
    protected $casts = [
        'id' => 'integer',
        'functional_area_id' => 'integer',
        'job_id' => 'integer',
        
    ];
}
   