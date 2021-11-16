<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class Admin extends Model
{
    protected $primaryKey = 'id';
	protected $table = 'admin';
	protected $fillable = [
        'id','name','email','role_id','password','remember_token','created_at','updated_at','is_admin','userstatus'
    ];
}
