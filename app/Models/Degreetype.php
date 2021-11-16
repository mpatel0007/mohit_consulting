<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degreetype extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'degreetype';
	protected $fillable = [
        'degreeleave_id','degreetype','status','created_at','updated_at'
    ];
}
