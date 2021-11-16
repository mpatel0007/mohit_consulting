<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Jobskill extends Model
{
    // protected $primaryKey = 'id';
	protected $table = 'jobskill';
	protected $fillable = [
        'id','jobskill','status','created_at','updated_at'
    ];
}
