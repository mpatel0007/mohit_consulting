<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class City extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'city';
    protected $fillable = [
       'city_name','state_id','status','created_at','updated_at'
    ];

}
