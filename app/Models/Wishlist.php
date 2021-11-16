<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Wishlist extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'wishlist';
	protected $fillable = [
        'id','job_id','candidate_id','created_at','updated_at'
    ];
}
