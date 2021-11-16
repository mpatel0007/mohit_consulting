<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class State extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'state';
    protected $fillable = [
       'state_name','country_id','status','created_at','updated_at'
    ];

}
