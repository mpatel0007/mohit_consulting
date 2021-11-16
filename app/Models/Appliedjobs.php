<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Appliedjobs extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'appliedjobs';
	protected $fillable = [
        'id','job_id','candidate_id','status','created_at','updated_at'
    ];
}
