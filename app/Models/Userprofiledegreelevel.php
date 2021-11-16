<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userprofiledegreelevel extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'userprofile_degreelevel';
	protected $fillable = [
        'id','userprofile_id','degreelevel_id','updated_at','updated_at'
    ];
}
