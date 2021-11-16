<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobdegreelevel extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'job_degreelevel';
	protected $fillable = [
        'job_id','degreelevel_id','updated_at','updated_at'
    ];
    protected $casts = [
        'id' => 'integer',
        'degreelevel_id' => 'integer',
        'job_id' => 'integer',
        
    ];
}
