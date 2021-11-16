<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobskilllevel extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'job_skill_level';
	protected $fillable = [
        'job_id','skill_id','level_id','created_at','updated_at'
    ];
    protected $casts = [
        'id' => 'integer',
        'skill_id' => 'integer',
        'level_id' => 'integer',
        'job_id' => 'integer',
        
    ];
}
