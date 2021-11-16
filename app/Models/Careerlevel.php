<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Careerlevel extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'careerlevel';
	protected $fillable = [
        'id','careerlevel','status','created_at','updated_at'
    ];
}
