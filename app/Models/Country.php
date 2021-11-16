<?php

namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class Country extends Model
{
    protected $primaryKey = 'id';
    protected $table = 'country';
    protected $fillable = [
        'country_name','sort_name','phone_code','currency','code','symbol','status','created_at','updated_at'
    ];

}
