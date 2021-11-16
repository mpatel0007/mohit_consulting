<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Userprofilefunctionalarea extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'userprofile_functionalarea';
	protected $fillable = [
        'id','userprofile_id','functional_area_id','updated_at','updated_at'
    ];
}
