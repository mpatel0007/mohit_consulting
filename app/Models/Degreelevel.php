<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Degreelevel extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'degreelevel';
	protected $fillable = [
        'degreelevel','status','created_at','updated_at'
    ];
}
