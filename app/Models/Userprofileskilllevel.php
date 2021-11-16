<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userprofileskilllevel extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'userprofile_skilllevel';
	protected $fillable = [
        'id','userprofile_id','skill_id','level_id','created_at','updated_at'
    ];
}
